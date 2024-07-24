@include('partials.header')
<?php $array = array('title' => 'Animal System') ;?>
<x-nav :data="$array"/>
<form action="/store" method="POST">
@csrf
    <div class="max-w-2xl mx-auto py-12 mt-10">
        <div class="bg-gray-500 shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4 flex flex-col border-4 border-gray-900">
            <h2 class="text-lg font-bold mb-4 text-center">Add New User</h2>
            <div class="grid grid-cols-2 gap-4">

            <div class="mb-4">
                <label for="username" class="block mb-1">Username:</label>
                <input type="text" id="username" name="username" 
                placeholder="Username"class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{old('username')}}">
                @error('username')
                <p class="text-red-500 text-xs mt-2 p-1">
                    {{$message}}            
                </p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <select id="category" name="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach(['', 'Temporary User', 'Admin User'] as $optionValue)
                        <option value="{{ $optionValue }}" {{ old('category') == $optionValue ? 'selected' : '' }}>
                            {{ $optionValue ?: 'Select Category' }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="firstName" class="block mb-1">First Name:</label>
                <input type="text" id="firstName" name="firstName" placeholder="First Name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{old('firstName')}}">
                @error('firstName')
                <p class="text-red-500 text-xs mt-2 p-1">
                    {{$message}}            
                </p>
                @enderror
            </div>
        
            <div class="mb-4" id="dateTimeField">
                <label for="dateTime" class="block text-gray-700 text-sm font-bold mb-2" id="dateTimeLabel">Date and Time:</label>
                <input type="datetime-local" id="dateTime" name="dateTime" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $user->dateTime ?? old('dateTime') }}">
                <p id="datetimeError" class="text-red-500 text-xs mt-2 p-1" style="display: none;">Please select a date and time in the future.</p>
                @error('dateTime')
                    <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="lastName" class="block mb-1">Last Name:</label>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{old('lastName')}}">
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
                <input type="email" id="email" name="email"  placeholder="Email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400" value="{{old('email')}}">
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
                <!-- Add more fields here -->
            </div>
            <div class="mt-4">
            <button type="submit" class="w-full py-2 bg-gray-900 text-white rounded-md hover:bg-gray-700 transition duration-200">Submit</button>
            </div>
        </div>
    </div>
</form>
@include('partials.footer')
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




