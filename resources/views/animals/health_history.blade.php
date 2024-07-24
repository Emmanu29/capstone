@include('partials.header')
<?php $array = array('title' => 'Student System'); ?>
<x-nav :data="$array" />

<div class="max-w-lg mx-auto mt-32 sm:mt-25 md:mt-32 lg:mt-32">
    <a href="#">
        <h1 class="text-4xl font-bold text-green-900 dark:text-gray-900 text-center">{{ $animal->name }}'s Main History</h1>
    </a>
</div>

<div class="relative overflow-x-auto shadow-2xl sm:rounded-lg mt-20 bg-blue-100 dark:bg-gray-800 max-w-6xl mx-auto mb-10"> <!--Table Bottom-->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-6 py-3">Animal Name</th>
                <th scope="col" class="px-6 py-3">Species</th>
                <th scope="col" class="px-6 py-3">Owner Name</th>
                <th scope="col" class="px-6 py-3">Date of Birth</th>
                <th scope="col" class="px-6 py-3">Sex</th>
                <th scope="col" class="px-6 py-3">Health Issue</th>
                <th scope="col" class="px-6 py-3">Diagnosis</th>
                <th scope="col" class="px-6 py-3">Date and Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($healthHistories as $history)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:hover:text-white hover:bg-gray-600 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">{{ $animal->name }}</td>
                    <td class="px-6 py-4">{{ $animal->species->name }}</td>
                    <td class="px-6 py-4">{{ $animal->owner_name }}</td>
                    <td class="px-6 py-4">{{ $animal->birthDate }}</td>
                    <td class="px-6 py-4">{{ $animal->sex }}</td>
                    <td class="px-6 py-4">{{ $history->health_issue }}</td>
                    <td class="px-6 py-4">{{ $history->adminDiagnosis }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($history->created_at)->format('F d, Y h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>

@include('partials.footer')
