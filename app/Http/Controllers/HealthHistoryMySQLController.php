<?php

namespace App\Http\Controllers;

use App\Models\HealthHistoryMySQL;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthHistoryMySQLController extends Controller
{
    

    public function showHealthHistory($id) {
        try {
            $animal = Animal::with('species')->findOrFail($id);
    
            // Fetch health histories without eager loading veterinarian relationship
            $healthHistories = HealthHistoryMySQL::where('animal_id', $id)->get();
    
            // Check if any health history records were found
            if ($healthHistories->isEmpty()) {
                return redirect()->back()->with('message', 'No Health history');
            }
    
            // Pass the health history to the view
            return view('animals.health_history', compact('animal', 'healthHistories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching health history.');
        }
    }
    

}
