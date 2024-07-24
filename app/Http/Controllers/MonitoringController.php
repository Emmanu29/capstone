<?php

namespace App\Http\Controllers;
use App\Models\Animal;
use App\Models\Monitoring;
use App\Models\Species;
use App\Models\Consultation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Helpers\HashHelper;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
public function tracking(Request $request){
    // Check if there are already three connected records
    $connectedCount = Monitoring::where('connected', true)->count();
    
    if ($connectedCount >= 3) {
        // Redirect back with a message indicating that the limit is reached
        return back()->with('message', 'You cannot add more than three connected records.');
    }

    $validatedData = $request->validate([
        "name"      => 'required',
        "card_id"   => 'required',
        "animal_id" => 'required|exists:animals,id',
    ]);

    // Find the animal
    $animalId = $validatedData['animal_id'];

    // Check if the card already has an animal being monitored
    $existingMonitoring = Monitoring::where('card', $validatedData['card_id'])
        ->where('connected', true)
        ->exists();

    if ($existingMonitoring) {
        // Redirect back with a message indicating that the card already has an animal being monitored
        return back()->with('message', 'The card already has an animal being monitored.');
    }

    // Check if the animal is already being monitored
    $existingMonitoring = Monitoring::where('animal_id', $animalId)
        ->where('connected', true)
        ->exists();

    if ($existingMonitoring) {
        // Redirect back with a message indicating that the animal is already being monitored
        return back()->with('message', 'The animal is already being monitored.');
    }

    // Create a new Monitoring instance
    $monitoring = new Monitoring();
    $monitoring->name = $validatedData['name'];
    $monitoring->card = $validatedData['card_id'];
    $monitoring->animal_id = $animalId;
    $monitoring->connected = true; // Set connected to true

    // Set the esp32 value based on card_id
    if ($validatedData['card_id'] == 1) {
        $monitoring->esp32 = 'esp32_1';
    } elseif ($validatedData['card_id'] == 2) {
        $monitoring->esp32 = 'esp32_2';
    } elseif ($validatedData['card_id'] == 3) {
        $monitoring->esp32 = 'esp32_3';
    }

    $monitoring->save(); // Save the monitoring data

    // Update the animals table with the esp32 value
    Animal::where('id', $animalId)->update(['esp32' => $monitoring->esp32]);

    // Get monitoring data where connected is true for cards 1, 2, and 3
    $monitorings = Monitoring::where('connected', true)
        ->whereIn('card', [1, 2, 3])
        ->get();

    // Separate monitoring data for each card and remove duplicates based on animal details
    $monitoringsCard1 = $monitorings->where('card', 1)->unique('details');
    $monitoringsCard2 = $monitorings->where('card', 2)->unique('details');
    $monitoringsCard3 = $monitorings->where('card', 3)->unique('details');
    
    session()->flash('message', 'New Animal Successfully Monitored');

     // Update the reason field for the animal
     $validatedData = $request->validate([
        "reason" => 'required',
    ]);

    Animal::where('id', $animalId)->update([
        'reason' => $validatedData['reason'],
    ]);

    // Pass both the animal and monitoring details to the view
    return view('animals.monitoring', compact('monitoring', 'monitoringsCard1', 'monitoringsCard2', 'monitoringsCard3'));
}

    
    public function showTracking(){
        // Get monitoring data where connected is true for cards 1, 2, and 3
        $monitorings = Monitoring::where('connected', true)
            ->whereIn('card', [1, 2, 3])
            ->get();

        // Separate monitoring data for each card and remove duplicates based on animal details
        $monitoringsCard1 = $monitorings->where('card', 1)->unique('details');
        $monitoringsCard2 = $monitorings->where('card', 2)->unique('details');
        $monitoringsCard3 = $monitorings->where('card', 3)->unique('details');

        return view('animals.monitoring', compact('monitoringsCard1', 'monitoringsCard2', 'monitoringsCard3'));
    }

public function dataHashApi($esp32)
{
    $monitorings = Monitoring::where('esp32', $esp32)
        ->orderBy('created_at', 'desc')
        ->get(['hashValue']);

    $hashValues = $monitorings->pluck('hashValue');

    Log::debug('Hash values retrieved', $hashValues->toArray());

    return $hashValues; 
}

public function dataFetchApi($esp32)
{
    Log::info('Fetching monitoring data', ['esp32' => $esp32]);

    $monitorings = Monitoring::where('esp32', $esp32)
                              ->orderBy('created_at', 'desc')
                              ->get();

    $hashValues = $this->dataHashApi($esp32); 

    if ($hashValues->isEmpty()) {
        return response()->json(['error' => 'No hash values found.'], 404);
    }

 
    if ($hashValues->contains($monitorings->pluck('hashValue')->first())) {
        return response()->json($monitorings);
    } else {
        session()->flash('message', 'data inconsistency detected');
    }
    
}


    /*code not working
    public function dataFetchApi($esp32) { 
            $monitorings = Monitoring::where('esp32', $esp32)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
            $monitorings->each(function ($monitoring) {
                $dataToHash = implode(',', [$monitoring->esp32, $monitoring->ecg_bpm, $monitoring->respiratoryRate, $monitoring->coreTemp]);
                $monitoring->calculatedhash = msha1($dataToHash);
            });
            return response()->json($monitorings);
         }*/
  public function show(string $id){
        $animal = Animal::with('species')->findOrFail($id);
        $monitoring = Monitoring::where('animal_id', $id)->first(); // Adjust this based on your actual logic

        return view('animals.edit', ['animal' => $animal, 'monitoring' => $monitoring]);
    }


   public function disconnect(Request $request)
    {
        // Get the animal ID from the request
        $animalId = $request->input('animal_id');

        $monitorings = Monitoring::where('animal_id', $animalId)->get();

        if ($monitorings->isNotEmpty()) {
            foreach ($monitorings as $monitoring) {
                $monitoring->delete();
            }

            // Update the animals table esp32 field to NULL
            Animal::where('id', $animalId)->update(['esp32' => null]);

            // Update the isHistory field to 1 in the consultation table
            Consultation::where('animal_id', $animalId)->update(['isHistory' => 1]);

            // Redirect back or return a response as needed
            return redirect()->back()->with('message', 'All monitoring records for the animal have been deleted successfully.');
        } else {
            // If no monitoring records are found, handle the error (e.g., display a message)
            return redirect()->back()->with('message', 'No monitoring records found for the specified animal.');
        }
    }
    
public function vitals(Request $request)
{
    // Get the animal ID from the request
    $animalId = $request->input('animal_id');

    // Retrieve the animal details along with its breed from the database
   $animal = Animal::with('breed')->find($animalId);


    // Check if the animal exists
    if (!$animal) {
        // Handle the case where the animal does not exist
        return back()->with('message', 'Animal not found');
    }

    // Get the breed of the animal
    $breed = $animal->breed;

    // Check if the breed exists
    if (!$breed) {
        // Handle the case where the breed does not exist
        return back()->with('message', 'Breed not found');
    }

    // Pass the animal details, animal ID, and breed thresholds to the view
    return view('animals.ongoingPatient', [
        'animal' => $animal,
        'animal_id' => $animalId,
        'thresholds' => [
            'heartRateLowAlarm' => $breed->heartRateLowAlarm,
            'heartRateHighAlarm' => $breed->heartRateHighAlarm,
            'respiratoryRateLowAlarm' => $breed->respiratoryRateLowAlarm,
            'respiratoryRateHighAlarm' => $breed->respiratoryRateHighAlarm,
            'coreTempLowAlarm' => $breed->coreTempLowAlarm,
            'coreTempHighAlarm' => $breed->coreTempHighAlarm,
        ]
    ]);
}






}
