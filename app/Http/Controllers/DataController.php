<?php

namespace App\Http\Controllers;
use App\Models\Data;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function store(Request $request){
        // Validate incoming request if necessary
    
        // Store or process the received data
        $monitorId = $request->input('monitor_id');
        $ecg = $request->input('ecg');
        $bpm = $request->input('bpm');
        $respiratoryRate = $request->input('respiratory_rate');
        $coreTemp = $request->input('core_temp');
    
        // Pass the received data to the view
        return view('animals.ongoingPatient', [
            'monitorId' => $monitorId,
            'ecg' => $ecg,
            'bpm' => $bpm,
            'respiratoryRate' => $respiratoryRate,
            'coreTemp' => $coreTemp
        ]);
    }
    
}

