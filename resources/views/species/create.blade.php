@include('partials.header')
<?php $array = array('title' => 'Animal System') ;?>
<x-nav :data="$array"/>
<form action="/add/species" method="POST">
@csrf
    <div class="max-w-2xl mx-auto py-12 mt-10">
        <div class="bg-gray-500 shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4 flex flex-col border-4 border-gray-900">
            <h2 class="text-lg font-bold mb-4 text-center">Add New Species</h2>
            <div class="grid grid-cols-2 gap-4">

            <div class="mb-4">
                <label for="name" class="block mb-1">Name:</label>
                <input type="text" id="name" name="name" 
                placeholder="Name"class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{old('name')}}">
                @error('name')
                <p class="text-red-500 text-xs mt-2 p-1">
                    {{$message}}            
                </p>
                @enderror
            </div>

    

 

       

       

                <!-- Add more fields here -->
            </div>
            <div class="mt-4">
            <button type="submit" class="w-full py-2 bg-gray-900 text-white rounded-md hover:bg-gray-700 transition duration-200">Submit</button>
            </div>
        </div>
    </div>
</form>
@include('partials.footer')





