@include('partials.header')
<?php $array = array('title' => 'Student System'); ?>
<x-nav :data="$array" />

<div class="max-w-lg mx-auto mt-32 sm:mt-25 md:mt-32 lg:mt-32">
    <a href="#">
        <h1 class="text-4xl font-bold text-green-900 dark:text-gray-900 text-center">{{ $animal->name }}'s Prior Second Opinions</h1>
    </a>
</div>


<div class="relative overflow-x-auto shadow-2xl sm:rounded-lg mt-5 bg-blue-100 dark:bg-gray-800 max-w-6xl mx-auto mb-10"> <!--Table Bottom-->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-6 py-3">Veterinarian</th>
                <th scope="col" class="px-6 py-3">Recommendation</th>
                <th scope="col" class="px-6 py-3">Diagnosis</th>
                <th scope="col" class="px-6 py-3">Date and Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultations as $consultation)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:hover:text-white hover:bg-gray-600 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $consultation->name }}</td>
                <td class="px-6 py-4">{{ $consultation->recommendation }}</td>
                <td class="px-6 py-4">{{ $consultation->diagnosis }}</td>
                <td class="px-6 py-4">
                    @if($animal->created_at)
                        {{ \Carbon\Carbon::parse($animal->created_at)->formatLocalized('%B %d, %Y %I:%M %p') }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Display Alarm Logs -->

<div class="mt-5">
    <h2 class="text-2xl font-semibold mb-2 text-white-800 dark:text-white-200" style="color:aliceblue;margin:auto;text-align:center">Alarm Logs</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Value</th>
                    <th scope="col" class="px-6 py-3">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alarmLogs as $log)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:hover:text-white hover:bg-gray-600 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">{{ $log->name }}</td>
                    <td class="px-6 py-4">{{ $log->type }}</td>
                    <td class="px-6 py-4">{{ $log->value }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($log->timestamp)->format('F d, Y h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>

@include('partials.footer')
