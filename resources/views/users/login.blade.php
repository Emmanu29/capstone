@include('partials.header')

<style>
    .custom-border {
        border: 20px solid #111827; /* Adjust thickness and color as needed */
    }
</style>

<div class="container mx-auto flex justify-center items-center h-screen mt-5">
    <div class="bg-gray-600 md:flex md:flex-row md:justify-center md:items-center rounded-lg shadow-md custom-border">
        <!-- Dog Image (hidden on small screens) -->
        <img src="{{ asset('images/Dog.png') }}" alt="Dog" class="hidden md:block object-cover h-auto md:h-full md:w-1/2 rounded-lg">
        <div class="md:w-1/2 md:pl-8 py-8 px-4">
            <div class="text-center mb-8">
                <h1><strong>Welcome!</strong></h1>
                <h2 class="text-lg font-bold">Dapper Animal Patient Monitoring System</h2>
                <h3 class="text-lg font-bold">Login</h3>
            </div>
            <form action="/login/process" method="POST" class="mt-4">
                @csrf
                @error('email')
                    <p class="text-red-500 text-xs mt-2 p-1">{{$message}}</p> 
                @enderror
                <div class="mb-4">
                    <label for="email" class="block mb-1 font-bold">Username</label>
                    <input type="text" placeholder="Enter Email" name="email" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400">
                </div>
                <div class="mb-4">
                    <label for="password" class="block mb-1 font-bold">Password</label>
                    <input type="password" id="myInput" placeholder="Enter Password" name="password" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-400">
                    <input type="checkbox" onclick="myFunction()" class="mt-4">Show Password
                </div>
                <button id="log" type="submit" class="w-full py-2 bg-gray-900 text-white rounded-md hover:bg-gray-800 transition duration-200">Login</button>
            </form>
            <script>
                function myFunction() {
                    var x = document.getElementById("myInput");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }
            </script>
        </div>
    </div>
</div>

@include('partials.footer')
