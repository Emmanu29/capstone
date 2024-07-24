@include('partials.header')

<div class="max-w-2xl mx-auto py-12 mt-10">
    <div class="bg-gray-500 shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4 flex flex-col border-4 border-gray-900">
        <form action="/edit/{{$species->id}}" method="POST">
            @method('PUT')
            @csrf
            <h1 class="text-4xl font-bold text-black text-center mb-5">
                @if(isset($breed))
                    Edit Breed: {{$breed->breeds}}
                @else
                    Edit Species: {{$species->name}}
                @endif
            </h1>
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="name" class="block mb-1">Breed:  </label>
                    <input type="text" id="name" name="name" placeholder="Name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{ isset($breed) ? $breed->breeds : $species->name }}">
                    @error('breeds')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                    @enderror
                </div>
                
                @if(isset($breed))
                    <!-- Additional breed-specific fields -->
                    <div class="mb-4">
                        <label for="heartRateLowAlarm" class="block mb-1">Heart Rate Low Alarm:</label>
                        <input type="text" id="heartRateLowAlarm" name="heartRateLowAlarm" placeholder="Heart Rate Low Alarm" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{ $breed->heartRateLowAlarm }}">
                        @error('heartRateLowAlarm')
                            <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="heartRateHighAlarm" class="block mb-1">Heart Rate High Alarm:</label>
                        <input type="text" id="heartRateHighAlarm" name="heartRateHighAlarm" placeholder="Heart Rate High Alarm" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{ $breed->heartRateHighAlarm }}">
                        @error('heartRateHighAlarm')
                            <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="respiratoryRateLowAlarm" class="block mb-1">Respiratory Rate Low Alarm:</label>
                        <input type="text" id="respiratoryRateLowAlarm" name="respiratoryRateLowAlarm" placeholder="Respiratory Rate Low Alarm" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{ $breed->respiratoryRateLowAlarm }}">
                        @error('respiratoryRateLowAlarm')
                            <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="respiratoryRateHighAlarm" class="block mb-1">Respiratory Rate High Alarm:</label>
                        <input type="text" id="respiratoryRateHighAlarm" name="respiratoryRateHighAlarm" placeholder="Respiratory Rate High Alarm" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{ $breed->respiratoryRateHighAlarm }}">
                        @error('respiratoryRateHighAlarm')
                            <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="coreTempLowAlarm" class="block mb-1">Core Temp Low Alarm:</label>
                        <input type="text" id="coreTempLowAlarm" name="coreTempLowAlarm" placeholder="Core Temp Low Alarm" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{ $breed->coreTempLowAlarm }}">
                        @error('coreTempLowAlarm')
                            <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="coreTempHighAlarm" class="block mb-1">Core Temp High Alarm:</label>
                        <input type="text" id="coreTempHighAlarm" name="coreTempHighAlarm" placeholder="Core Temp High Alarm" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{ $breed->coreTempHighAlarm }}">
                        @error('coreTempHighAlarm')
                            <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Add more fields for species if needed -->
            </div>
            <div class="mt-4">
                <button type="submit" class="w-full py-2 bg-gray-900 text-white rounded-md hover:bg-gray-700 transition duration-200">Update</button>
            </div>
        </form>
        
        <form action="{{ route('species.destroy', $species) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $species->name }}?')">   
            @csrf
            @method('delete')
            <div class="mt-5 mx-auto">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

@include('partials.footer')
