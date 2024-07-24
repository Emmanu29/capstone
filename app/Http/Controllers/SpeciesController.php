<?php


namespace App\Http\Controllers;

use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class SpeciesController extends Controller
{
 public function showSpecies() {
    // Fetch species with their associated breeds
    $species = Species::with('breeds')->orderByDesc('created_at')->simplePaginate(10);
    return view('species.species', compact('species'));
}
    
    public function show(string $id) {
        // Fetch species along with its breeds by ID
        $species = Species::with('breeds')->findOrFail($id);
        return view('species.edit', ['species' => $species]);
    }
public function showBreeds(Species $species) {
    // Fetch the species along with its breeds
    $speciesWithBreeds = Species::with('breeds')->find($species->id);

    // Check if the species with breeds was found
    if (!$speciesWithBreeds) {
        // Handle the case where the species was not found
        return redirect()->back()->with('error', 'Species not found');
    }

    // Check if the species has breeds
    if (!$speciesWithBreeds->relationLoaded('breeds')) {
        // If the breeds relation is not loaded, eager load it
        $speciesWithBreeds->load('breeds');
    }

    // Pass the species data to the view
    return view('species.breed', ['species' => $speciesWithBreeds]);
}

public function showBreedDetails(Species $species, $breedId) {
    // Fetch the specific breed by ID within the given species
    $breed = $species->breeds()->find($breedId);

    // Check if the breed was found
    if (!$breed) {
        return redirect()->back()->with('error', 'Breed not found');
    }

    // Pass the breed data to the view
    return view('species.edit', ['species' => $species, 'breed' => $breed]);
}


    public function create() {
        return view('species.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "name"                      => ['required', 'min:4'],
        ]);
        
        $species = Species::create($validated);
        return redirect('/species')->with('message', 'New Species has been successfully created');
    }

    public function update(Request $request, Species $species) {
        $validated = $request->validate([
            "name"                       => ['required', 'min:4'],
   
        ]);
    
        $species->update($validated);
    
        if ($species->wasChanged()) {
            return back()->with('message', 'Species information updated successfully');
        } else {
            return back()->with('error', 'Failed to update species information');
        }
    }

    public function destroy(Species $species) {
        $species->delete();
        return redirect('/species')->with('message', 'Species was successfully deleted');
    }

    public function search(Request $request) {
        $searchTerm = $request->input('name');
        $species = Species::with('breeds')
            ->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('breeds', function ($query) use ($searchTerm) {
                $query->where('breeds', 'like', '%' . $searchTerm . '%');
            })
            ->paginate(10);
    
        return view('species.species', ['species' => $species]);
    }
}

