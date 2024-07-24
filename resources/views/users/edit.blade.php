@include('partials.header')
<?php $array = array('title' => 'Student System') ;?>
<x-nav :data="$array"/>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to toggle the display of the time field based on the selected category
        function toggleTimeField() {
            var category = document.getElementById("category").value;
            var dateTimeField = document.getElementById("dateTimeField");
            var dateTimeLabel = document.getElementById("dateTimeLabel");

            if (category === "Temporary User") {
                dateTimeField.style.display = "block";
                dateTimeLabel.style.display = "block";
            } else {
                dateTimeField.style.display = "none";
                dateTimeLabel.style.display = "none";
            }
        }

        function validateDateTime() {
            var selectedDateTime = new Date(document.getElementById('dateTime').value);
            var currentDateTime = new Date();

            if (selectedDateTime < currentDateTime) {
                alert('Please select a date and time in the future.');
                document.getElementById('dateTime').value = currentDateTime.toISOString().slice(0,16);
                return false;
            } else {
                return true;
            }
        }

        // Add event listener to the category select element
        document.getElementById("category").addEventListener("change", toggleTimeField);

        // Add event listener to the datetime input field to validate date and time when it changes
        document.getElementById("dateTime").addEventListener("change", validateDateTime);

        // Call toggleTimeField initially to set the initial display
        toggleTimeField();
    });
</script>

<div class="max-w-2xl mx-auto py-12 mt-10">
    <div class="bg-gray-500 shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4 flex flex-col border-4 border-gray-900">
        <form action="/user/{{$user->id}}" method="POST">
            @method('PUT')
            @csrf
            <h1 class="text-4xl font-bold text-black text-center mb-5">Edit {{$user->firstName}} {{$user->lastName}}</h1>
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="username" class="block mb-1">Username:</label>
                    <input type="text" id="username" name="username" 
                    placeholder="Username" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{$user->username}}">
                        @error('username')
                        <p class="text-red-500 text-xs mt-2 p-1">
                            {{$message}}            
                        </p>
                        @enderror
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select id="category" name="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="toggleTimeField()">
                        <option value="" {{$user->category == "" ? 'selected' : ''}}>Select Category</option>
                        <option value="Temporary User" {{$user->category == "Temporary User" ? 'selected' : ''}}>Temporary User</option>
                        <option value="Admin User" {{$user->category == "Admin User" ? 'selected' : ''}}>Admin User</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="firstName" class="block mb-1">First Name:</label>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{$user->firstName}}">
                        @error('firstName')
                        <p class="text-red-500 text-xs mt-2 p-1">
                            {{$message}}            
                        </p>
                        @enderror
                </div>

                <div class="mb-4" id="dateTimeField" style="display: none;">
                    <label for="dateTime" class="block text-gray-700 text-sm font-bold mb-2" id="dateTimeLabel" style="display: none;">Date and Time:</label>
                    <input type="datetime-local" id="dateTime" name="dateTime" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ date('Y-m-d\TH:i', strtotime($user->dateTime)) }}">
                        @error('dateTime')
                            <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                        @enderror
                </div>

                <div class="mb-4">
                    <label for="lastName" class="block mb-1">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{$user->lastName}}">
                        @error('lastName')
                        <p class="text-red-500 text-xs mt-2 p-1">
                            {{$message}}            
                        </p>
                        @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block mb-1">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400">
                        @error('password')
                        <p class="text-red-500 text-xs mt-2 p-1">
                            {{$message}}            
                        </p>
                        @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block mb-1">Email:</label>
                    <input type="email" id="email" name="email"  placeholder="Email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{$user->email}}">
                        @error('email')
                        <p class="text-red-500 text-xs mt-2 p-1">
                            {{$message}}            
                        </p>
                        @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block mb-1">Confirm Password:</label>
                    <input type="password" id="password" name="password_confirmation" placeholder="Confirm Password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400">
                        @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-2 p-1">
                            {{$message}}            
                        </p>
                        @enderror
                </div>
            </div>
            <div class="mt-4 mx-auto">
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Update
                </button>
            </div>
        </form>

        <form action="{{ route('user.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{$user->firstName}} {{$user->lastName}}')">   
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