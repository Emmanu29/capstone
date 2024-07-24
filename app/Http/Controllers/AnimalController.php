<?php

namespace App\Http\Controllers;
use App\Models\Species;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\HealthHistoryMySQL;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
    // Retrieve animals data along with their associated species
    $animals = Animal::with('species') // Eager loading the 'species' relationship to avoid N+1 query issue
                    ->orderByDesc('created_at') // Order animals by their creation date in descending order
                    ->simplePaginate(10); // Paginate the results with 10 animals per page

    // Pass the animals data to the 'animals.patient' view
    return view('animals.patient', compact('animals'));
    }

    public function showDashboard(){
        $temporaryUsersCount = User::where('category', 'Temporary User')->where('isDeleted', false)->count();
        $adminUsersCount = User::where('category', 'Admin User')->where('isDeleted', false)->count();

        $appointmentsByMonth = Animal::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderByRaw('MONTH(created_at)')
        ->get()
        ->pluck('count', 'month');

        // Count species based on animals records and retrieve species names
        $speciesCounts = Animal::select('species_id', DB::raw('COUNT(*) as count'))
        ->with('species:id,name') // Eager load species names
        ->groupBy('species_id')
        ->get();

        $animals = Animal::with('species')->orderByDesc('created_at');
        // Set the timezone to Manila
        $manilaTime = Carbon::now('Asia/Manila');

        // Count appointments created today in Manila timezone
        $appointmentsCountToday = DB::table('animals')
            ->whereDate('created_at', $manilaTime->toDateString())
            ->count();

        $patientCount = Animal::count();
        // Pass the animals data to the 'animals.index' view
        return view('animals.index', compact('animals','appointmentsCountToday','patientCount','speciesCounts','appointmentsByMonth', 'temporaryUsersCount', 'adminUsersCount'));
    }

    
public function getBreeds(Request $request)
{
    $speciesId = $request->get('species_id');
    if (!$speciesId) {
        return response()->json(['error' => 'Species ID is required'], 400);
    }

    // Enable query logging
    DB::enableQueryLog();

    // Retrieve breeds for the specified species ID
    $breeds = Breed::where('species_id', $speciesId)->pluck('breeds', 'id');

    // Get the logged queries
    $queries = DB::getQueryLog();

    // Log the queries (for debugging purposes)
    foreach ($queries as $query) {
        Log::info($query['query']);
        Log::info($query['bindings']);
        Log::info($query['time']);
    }

    // Return breeds as JSON response
    return response()->json($breeds);
}

public function create() {
    $species = Species::with('breeds')->get(); // Eager load breeds with species
    return view('animals.create', compact('species'))->with('title', 'Add New');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){

        // Validate the incoming request data
        $validatedData = $request->validate([
            "species"        => 'required',
            "name"           => 'required|min:4',
           "breed"           => 'required',
            "birthDate"      => 'required',
            "sex"            => 'required',
            // "dateTime"       => ['required', 'date_format:Y-m-d\TH:i'],
            "health_issue" => 'required',
            "diagnosis"      => 'nullable',
            "owner_name"     => 'required',
            "owner_number"   => 'required',
        ]);
    
        // Fetch the species ID based on the selected species name
        $speciesName = $request->input('species');
    
        $speciesId = Species::where('name', $speciesName)->value('id');
        
        // Create a new Animal using the validated data
        Animal::create([
            'species_id'     =>  $validatedData['species'],
            'name'           => $validatedData['name'],
            'breed_id'           => $validatedData['breed'],
            'birthDate'      => $validatedData['birthDate'],
            'sex'            => $validatedData['sex'],
            // 'dateTime'       => $validatedData['dateTime'],
            'health_issue' => $validatedData['health_issue'],
            // 'diagnosis'      => $validatedData['diagnosis'],
            'owner_name'     => $validatedData['owner_name'],
            'owner_number'   => $validatedData['owner_number'],
        ]);
    
        // Redirect back with a success message
        return redirect('/patients')->with('message', 'New Animal was added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
        $speciesList = Species::pluck('name');
        $animal = Animal::with('species')->findOrFail($id);

        return view('animals.edit', ['animal' => $animal, 'speciesList' => $speciesList]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal){
        $validated = $request->validate([
            "species"        => 'required',
            "name"           => 'required',
            "birthDate"      => 'required',
            "sex"            => 'required',
            "dateTime"       => ['required', 'date_format:Y-m-d\TH:i'],
            "health_issue"   => 'nullable',
            "diagnosis"      => 'nullable',
            "owner_name"     => 'required',
            "owner_number"   => 'required'
        ]);

        $speciesId = Species::where('name', $request->species)->value('id');

        // Remove 'species' from the validated data
        unset($validated['species']);

        // Add 'species_id' to the validated data
        $validated['species_id'] = $speciesId;

        // Convert dateTime to Carbon instance and assign to created_at
        $validated['created_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['dateTime']);

        // Remove 'dateTime' from the validated data
        unset($validated['dateTime']);

        // Update the animal with the validated data
        $animal->update($validated);

        // Store the health_issue in MySQL
        HealthHistoryMySQL::create([
            'animal_id'      => $animal->id,
            'health_issue'   => $validated['health_issue'],
            'adminDiagnosis' => $validated['diagnosis'],
            'created_at'     => $validated['created_at'], // Add created_at field
        ]);

        return back()->with('message', 'Data was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal){
        $animal->delete();

        return redirect('/patients')->with('message', 'Data was successfully deleted');
    }
public function showDetail($id){
    // Find the animal by ID
    $animal = Animal::with('species')->findOrFail($id);

    // Find alarm logs for the animal
    $alarmLogs = DB::table('alarms_log')
        ->where('animal_id', $id)
        ->get();

    // Find all consultation details for the animal
    $consultations = DB::table('consultations')
        ->where('animal_id', $id)
        ->select('name','diagnosis', 'recommendation')
        ->get();

    // Pass the data to the view
    return view('animals.show', compact('animal', 'alarmLogs', 'consultations'));
}

    public function search(Request $request){
        //return Animal::where('name', 'like', '%'.$name.'%')->get();

        $searchName = $request->input('name');
        $animals = Animal::where('name', 'like', '%' . $searchName . '%')->paginate(10); ;
        
        return view('animals.patient', ['animals' => $animals]);
    }

    public function showPdf(string $id){
        // Find the animal by ID
        $animal = Animal::with('species')->findOrFail($id);
    
        // Check if the animal exists
        if (!$animal) {
            // Handle the case where the animal does not exist, such as redirecting or showing an error message
            // For now, I'm just redirecting back
            return redirect()->back()->with('error', 'Animal not found.');
        }
    
        // Get the list of all species
        $speciesList = Species::pluck('name');

         // Find alarm logs for the animal
        $alarmLogs = DB::table('alarms_log')
        ->where('animal_id', $id)
        ->get();

        // Find all consultation details for the animal
        $consultations = DB::table('consultations')
            ->where('animal_id', $id)
            ->select('name', 'diagnosis', 'recommendation', 'created_at')
            ->get();
    
        // Pass the variables to the view
        return view('animals.pdf', compact('animal', 'alarmLogs', 'consultations', 'speciesList'));
        
    }
}
