@include('partials.header', [$title])

<?php $array = array('title' => 'Student System') ;?>
<x-nav :data="$array"/>

<form action="/add/animal" method="POST">
@csrf
    <div class="max-w-2xl mx-auto py-12 mt-10">
        <div class="bg-gray-500 shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4 flex flex-col border-4 border-gray-900">
            <h2 class="text-lg font-bold mb-4 text-center">Add New Patient</h2>
            <div class="grid grid-cols-2 gap-4">

            <div class="mb-4">
                <label for="species" class="block text-gray-700 text-sm font-bold mb-2">Species</label>
                <select id="species" name="species" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Species</option>
                        @foreach($species as $specie)
                    <option value="{{ $specie->id }}">{{ $specie->name }}</option>
                @endforeach
                </select>
                @error('species')
                    <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="breed" class="block text-gray-700 text-sm font-bold mb-2">Breed</label>
                <select id="breed" name="breed" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Breed</option>
                </select>
                @error('breed')
                    <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" id="name" name="name" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{old('name')}}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs mt-2 p-1">{{ $errors->first('name') }}</p>
                @endif
            </div>
        
            <div class="mb-4">
                <label for="birthDate" class="block text-gray-700 text-sm font-bold mb-2">Date of Birth</label>
                <input type="date" id="birthDate" name="birthDate" placeholder="Date of Birth" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('birthDate') }}">
                @error('birthDate')
                    <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="sex" class="block text-gray-700 text-sm font-bold mb-2">Sex</label>
                <select id="sex" name="sex" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach(['', 'Male', 'Female'] as $optionValue)
                        <option value="{{ $optionValue }}" {{ old('sex') == $optionValue ? 'selected' : '' }}>
                            {{ $optionValue ?: 'Select Sex' }}
                        </option>
                    @endforeach
                </select>
                @error('sex')
                    <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                @enderror
            </div> 

            <!-- <div class="mb-4" id="dateTimeField">
                <label for="dateTime" class="block text-gray-700 text-sm font-bold mb-2" id="dateTimeLabel">Date and Time:</label>
                <input type="datetime-local" id="dateTime" name="dateTime" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('dateTime') }}">
                @error('dateTime')
                    <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                @enderror
            </div> -->

            <div class="mb-6">
                <label for="healthHistory" class="block text-gray-700 text-sm font-bold mb-2">Health Issue</label>
                <textarea id="healthHistory" name="health_issue" placeholder="Health Issue" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('health_issue') }}</textarea>
                @error('healthHistory')
                    <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- <div class="mb-4">
                <label for="diagnosis" class="block text-gray-700 text-sm font-bold mb-2">Diagnosis</label>
                <input type="text" id="diagnosis" name="diagnosis" placeholder="Diagnosis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('diagnosis') }}">
                @error('diagnosis')
                    <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                @enderror
            </div> -->

            <div class="mb-4">
                <label for="owner_name" class="block text-gray-700 text-sm font-bold mb-2">Owner Name</label>
                <input type="text" id="owner_name" name="owner_name" placeholder="Owner Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('owner_name') }}">
                @error('owner_name')
                    <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="owner_number" class="block text-gray-700 text-sm font-bold mb-2">Owner Number</label>
                <input type="number" id="owner_number" name="owner_number" placeholder="Owner Number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('owner_number') }}">
                @error('owner_number')
                    <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                @enderror
            </div>
                <!-- Add more fields here -->
            </div>
            <div class="mt-4">
            <button type="submit" class="w-full py-2 bg-gray-900 text-white rounded-md hover:bg-gray-700 transition duration-200">Add New</button>
            </div>
        </div>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#species').on('change', function() {
            var speciesId = $(this).val();
            if(speciesId) {
                $.ajax({
                    url: '{{ route('get.breeds') }}',
                    type: 'GET',
                    data: { species_id: speciesId },
                    success: function(data) {
                        $('#breed').empty();
                        $('#breed').append('<option value="">Select Breed</option>');
                        $.each(data, function(key, value) {
                            $('#breed').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('#breed').empty();
                $('#breed').append('<option value="">Select Breed</option>');
            }
        });
    });
</script>
@include('partials.footer')