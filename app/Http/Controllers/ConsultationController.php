<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ConsultationController extends Controller
{
    //
public function showReview(string $id)
{
    // Retrieve the animal details along with its species
    $animal = Animal::with('species')->findOrFail($id);

    // Retrieve the consultation details associated with the provided animal ID where isHistory is 0
    $consultation = Consultation::where('animal_id', $id)
                                  ->where('isHistory', 0)
                                  ->select('name', 'diagnosis', 'recommendation')
                                  ->first();

    // If no consultation is found, create a new consultation with the provided animal ID
    if (!$consultation) {
        $consultation = new Consultation(['animal_id' => $id]); // Create a new consultation instance with the provided ID
    }

    // Get the authenticated user if available
    $user = auth()->user();

    // Return the view with the animal and consultation details
    return view('animals.consultation', compact('animal', 'consultation', 'user'));
}


    //Store Second Opinion
public function storeExpertReview(Request $request)
{
    $validatedData = $request->validate([
        "user_name"      => 'required',
        "diagnosis"      => 'nullable',
        "recommendation" => 'nullable',
        "animal_id"      => 'required|exists:animals,id',
    ]);

    // Check if there's an existing consultation for the animal
    $existingConsultations = Consultation::where('animal_id', $validatedData['animal_id'])->get();

    // Flag to check if there's any active consultation (isHistory = 0)
    $activeConsultationExists = false;

    // Iterate through existing consultations
    foreach ($existingConsultations as $consultation) {
        if ($consultation->isHistory == 0) {
            // If an active consultation exists, update it
            $activeConsultationExists = true;
            $this->updateConsultation($consultation, $validatedData);
            break; // No need to continue loop once an active consultation is found
        }
    }

    // If there's no active consultation, insert a new one
    if (!$activeConsultationExists) {
        $this->createConsultation($validatedData);
    }

    return redirect('/patients')->with('message', 'Consultation successfully concluded');
}



    
    private function updateConsultation($consultation, $validatedData) {
        $consultation->update([
            'name'           => $validatedData['user_name'],
            'diagnosis'      => $validatedData['diagnosis'],
            'recommendation' => $validatedData['recommendation'],
        ]);
    }
    
    private function createConsultation($validatedData) {
        Consultation::create([
            'animal_id'      => $validatedData['animal_id'],
            'name'           => $validatedData['user_name'],
            'diagnosis'      => $validatedData['diagnosis'],
            'recommendation' => $validatedData['recommendation'],
        ]);
    }

}
