@include('partials.header', [$title])
<?php $array = array('title' => 'Veterinary Dashboard') ;?>
<x-nav :data="$array"/>
<div class="max-w-2xl mx-auto py-12 mt-10">
    <div class="bg-gray-500 shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4 flex flex-col border-4 border-gray-900">
    <h1 class="text-4xl font-bold text-black text-center mb-5 uppercase">{{$animal->name}}</h1>

    <div class="mb-8">
    <form action="{{ route('monitoring.tracking') }}" method="post" class="flex flex-col" id="patientForm">
        @csrf
        <div class="mb-4">
            <input type="hidden" id="animal_id" name="animal_id" value="{{$animal->id}}">
            <input type="hidden" id="name" name="name" value="{{$animal->name}}">
        </div>
        <div class="mb-4">
            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Reason for Appointment:</label>
            <textarea id="reason" name="reason" placeholder="Enter reason for appointment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" oninput="toggleDropdown()"></textarea>
        </div>

        <div class="mb-4">
            <label for="card_id" class="block text-gray-700 text-sm font-bold mb-2">Monitor this patient:</label>
            <select id="card_id" name="card_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled onchange="toggleButton()">
                <option value="">Select Card</option>
                <option value="1">Card 1</option>
                <option value="2">Card 2</option>
                <option value="3">Card 3</option>
                <!-- Add more options as needed -->
            </select>
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" id="addPatientButton" class="mt-10 w-3/4 bg-sky-900 hover:bg-sky-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" style="display: none;">Monitor Patient</button>
        </div>
    </form>
</div>

        <form action="/animal/{{$animal->id}}" method="POST">
            @method('PUT')
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="species" class="block text-gray-700 text-sm font-bold mb-2">Species</label>
                    <select id="species" name="species" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select Species</option>
                        @foreach ($speciesList as $species)
                            <option value="{{ $species }}" {{ $animal->species->name == $species ? 'selected' : '' }}>{{ $species }}</option>
                        @endforeach
                    </select>
                    @error('species')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$animal->name}}">
                    @error('name')
                        <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                    @enderror
                </div>

            
                <div class="mb-4" id="dateTimeField">
                    <label for="birthDate" class="block text-gray-700 text-sm font-bold mb-2" id="dateTimeLabel">Date of Birth:</label>
                    <input type="date" id="birthDate" name="birthDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('birthDate', date('Y-m-d', strtotime($animal->birthDate))) }}">
                    @error('birthDate')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="sex" class="block text-gray-700 text-sm font-bold mb-2">Sex</label>
                    <select id="sex" name="sex" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" {{$animal->sex == "" ? 'selected' : ''}}>Select Sex</option>
                        <option value="Male" {{$animal->sex == "Male" ? 'selected' : ''}}>Male</option>
                        <option value="Female" {{$animal->sex == "Female" ? 'selected' : ''}}>Female</option>
                    </select>
                    @error('sex')
                        <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="owner_name" class="block text-gray-700 text-sm font-bold mb-2">Owner Name</label>
                    <input type="text" id="owner_name" name="owner_name" placeholder="Owner Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$animal->owner_name}}">
                    @error('owner_name')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                    @enderror
                </div>
                
                <div class="mb-4" id="dateTimeField">
                    <label for="dateTime" class="block text-gray-700 text-sm font-bold mb-2" id="dateTimeLabel">Date and Time:</label>
                    <input type="datetime-local" id="dateTime" name="dateTime" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ date('Y-m-d\TH:i', strtotime($animal->created_at)) }}">
                    @error('dateTime')
                        <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                    @enderror
                </div>

                <div class="">
                    <label for="health_issue" class="block text-gray-700 text-sm font-bold mb-2">Health Issue</label>
                    <textarea id="health_issue" name="health_issue" placeholder="Health Issue" style="height: 200px; resize: none;" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    @error('health_issue')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="">
                    <label for="diagnosis" class="block text-gray-700 text-sm font-bold mb-2">Diagnosis</label>
                    <textarea id="diagnosis" name="diagnosis" placeholder="Diagnosis" style="height: 200px; resize: none;" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    @error('diagnosis')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                    @enderror
                </div>

                

                <div class="mb-8">
                    <label for="owner_number" class="block text-gray-700 text-sm font-bold mb-2">Owner Number</label>
                    <input type="number" id="owner_number" name="owner_number" placeholder="Owner Number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$animal->owner_number}}">
                    @error('owner_number')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="mb-8">
                    <input type="hidden" id="owner_number" name="owner_number" placeholder="Owner Number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$animal->owner_number}}">
                    @error('owner_number')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                    @enderror
                </div>
                
                <!-- Add more fields here -->

            <div class="flex items-center justify-center">
                <button type="button" onclick="window.location.href='/consultation/{{ $animal->id }}'" class="w-3/4 bg-emerald-800 hover:bg-emerald-700 text-white font-bold py-2 mb-4 px-4 rounded focus:outline-none focus:shadow-outline">
                    Expert Review
                </button>
            </div>

            <div class="flex items-center justify-center">
                <button type="submit" class="w-3/4 bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 mb-4 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update
                </button>
            </div>
        </form>

          <div class="flex items-center justify-center">
      <div class="flex items-center justify-center">
                <a href="{{ route('animal.detail', ['animal' => $animal->id]) }}" class="w-full bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 mb-4 px-4 rounded focus:outline-none focus:shadow-outline">Prior Second Opinion</a>
            </div>
            </div> 

        <div class="flex items-center justify-center text-center">
            <a href="/showpdf/{{ $animal->id }}" target="_blank" class="w-3/4 bg-sky-900 hover:bg-sky-800 text-white font-bold py-2 mb-4 px-4 rounded focus:outline-none focus:shadow-outline">
                Print to pdf
            </a>
        </div>
</div>

<div class="flex items-center justify-center">
        <a href="{{ route('animal.health-history', ['animal' => $animal->id]) }}" class="mt-10 w-3/4 bg-emerald-800 hover:bg-emerald-700 text-white font-bold py-2 mb-4 px-4 rounded focus:outline-none focus:shadow-outline text-center">
            View Health History
        </a>
    </div>

    <form action="{{ route('animal.destroy', $animal) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{$animal->name}}')">   
            @csrf
            @method('delete')
            <div class="flex items-center justify-center">
                <button type="submit" class="w-3/4 bg-red-600 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Delete
                </button>
            </div>
        </form>


<script>
    function toggleDropdown() {
        var reasonTextarea = document.getElementById("reason");
        var patientSelect = document.getElementById("card_id");

        if (reasonTextarea.value.trim() !== "") {
            patientSelect.disabled = false;
        } else {
            patientSelect.disabled = true;
            patientSelect.value = ""; // Reset dropdown if textarea is empty
            toggleButton(); // Disable the submit button as well
        }
    }

    function toggleButton() {
        var patientSelect = document.getElementById("card_id");
        var addButton = document.getElementById("addPatientButton");

        if (patientSelect.value !== "") {
            addButton.style.display = "block";
        } else {
            addButton.style.display = "none";
        }
    }
</script>

@include('partials.footer')