<?php

namespace App\Http\Controllers;
use App\Models\WebsocketLogs;
use Illuminate\Http\Request;

class WebSocketController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'ECG' => 'required|numeric',
            'temperature' => 'required|numeric',
        ]);

        // Store the data in the database
        $ecgData = new WebsocketLogs();
        $ecgData->Ecg = $request->input('ECG');
        $ecgData->CoreTemp = $request->input('temperature');
        $ecgData->save();

        return response()->json(['message' => 'Data stored successfully'], 200);
    }
}
