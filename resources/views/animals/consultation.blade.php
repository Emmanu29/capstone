@include('partials.header', [$title])
<?php $array = array('title' => 'Veterinary Dashboard') ;?>
<x-nav :data="$array"/>

<div class="max-w-2xl mx-auto py-12 mt-12">
    <div class="bg-gray-500 shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4 flex flex-col border-4 border-gray-900">
        <h1 class="text-4xl font-bold text-black text-center mb-5">Second Opinion</h1>
        <form action="/add/review" method="POST">
            @csrf
                <div class="mb-4">
                    <input type="hidden" id="animal_id" name="animal_id" value="{{$animal->id}}">
                </div>

            <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="user_name" class="block text-gray-700 text-sm font-bold mb-2">Veterinarian</label>
                <input type="text" id="user_name" name="user_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $user->username }}" readonly>
            </div>

                <div class="mb-4">
                    <label for="patientName" class="block text-gray-700 text-sm font-bold mb-2">Patient Name</label>
                    <input type="text" id="patientName" name="patientName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$animal->name}}" readonly>
                </div>
            
                <div class="mb-4">
                    <label for="birthDate" class="block text-gray-700 text-sm font-bold mb-2">Birth Date</label>
                    <input type="date" id="birthDate" name="birthDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $animal->birthDate }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="sex" class="block text-gray-700 text-sm font-bold mb-2">Sex</label>
                    <select id="sex" name="sex" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                        <option value="" {{$animal->sex == "" ? 'selected' : ''}}>Select Sex</option>
                        <option value="Male" {{$animal->sex == "Male" ? 'selected' : ''}}>Male</option>
                        <option value="Female" {{$animal->sex == "Female" ? 'selected' : ''}}>Female</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="diagnosis" class="block text-gray-700 text-sm font-bold mb-2">Diagnosis</label>
                    <textarea type="text" id="diagnosis" name="diagnosis" placeholder="Diagnosis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if(Auth::user()->category === 'Admin User') readonly @endif>{{ $consultation->diagnosis }}</textarea>
                    @error('diagnosis')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="recommendation" class="block text-gray-700 text-sm font-bold mb-2">Recommendation</label>
                    <textarea type="text" id="recommendation" name="recommendation" placeholder="Recommendation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if(Auth::user()->category === 'Admin User') readonly @endif>{{ $consultation->recommendation }}</textarea>
                    @error('recommendation')
                        <p class="text-red-500 text-xs mt-2 p-1">{{ $message }}</p> 
                    @enderror
                </div>

             
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" class="w-full bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 mb-4 px-4 rounded focus:outline-none focus:shadow-outline" @if(Auth::user()->category === 'Admin User') hidden @endif>
                    Submit
                </button>
            </div>
             <div class="flex items-center justify-center">
                <a href="{{ route('animal.detail', ['animal' => $animal->id]) }}" class="w-full bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 mb-4 px-4 rounded focus:outline-none focus:shadow-outline">Patient History</a>
            </div>
    </form>
@include('partials.footer')
