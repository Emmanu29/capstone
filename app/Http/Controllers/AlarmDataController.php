<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlarmData;
use Illuminate\Support\Facades\Log; // Import Log facade
use Carbon\Carbon; // Import Carbon library

class AlarmDataController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log the received request data
            Log::info('Received alarm data:', $request->all());

            $data = $request->validate([
                'animal_id' => 'required|integer',
                'name' => 'required|string',
                'type' => 'required|string',
                'value' => 'required|string',
                'timestamp' => 'required|date',
            ]);

            // Convert timestamp to MySQL datetime format
            $data['timestamp'] = Carbon::parse($data['timestamp'])->format('Y-m-d H:i:s');

            // Create a new instance of the AlarmData model with the validated data
            $alarmData = AlarmData::create($data);

            return response()->json(['message' => 'Alarm data stored successfully', 'alarmData' => $alarmData], 201);
        } catch (\Exception $e) {
            // Handle any exceptions
            Log::error('Error storing alarm data:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error storing alarm data', 'error' => $e->getMessage()], 500);
        }
    }
}
