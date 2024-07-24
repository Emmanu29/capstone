@include('partials.header')
<?php $array = array('title' => 'Student System'); ?>
<x-nav :data="$array"/>
<div class="relative overflow-x-auto shadow-2xl sm:rounded-lg mt-5 bg-blue-100 dark:bg-gray-800 max-w-screen-xl mx-auto mb-10 z-0" >
<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="margin-top:100px">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
        <tr>
            <th scope="col" class="px-6 py-3">Breeds</th>
            <th scope="col" class="px-6 py-3">Heart Rate Low Alarm</th>
            <th scope="col" class="px-6 py-3">Heart Rate High Alarm</th>
            <th scope="col" class="px-6 py-3">Respiratory Rate Low Alarm</th>
            <th scope="col" class="px-6 py-3">Respiratory Rate High Alarm</th>
            <th scope="col" class="px-6 py-3">Core Temp Low Alarm</th>
            <th scope="col" class="px-6 py-3">Core Temp High Alarm</th>
            <th scope="col" class="px-6 py-3">Created At</th>
            <th scope="col" class="px-6 py-3">Updated At</th>
            <th scope="col" class="px-6 py-3"><span class="sr-only">View Details</span></th>
        </tr>
    </thead>
    <tbody>
        @foreach($species->breeds as $breed)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:hover:text-white hover:bg-gray-600 dark:hover:bg-gray-600">
            <td class="px-3 py-4">
                {{ $breed->breeds }}
            </td>
            <td class="px-3 py-4">{{ $breed->heartRateLowAlarm }}</td>
            <td class="px-3 py-4">{{ $breed->heartRateHighAlarm }}</td>
            <td class="px-3 py-4">{{ $breed->respiratoryRateLowAlarm }}</td>
            <td class="px-3 py-4">{{ $breed->respiratoryRateHighAlarm }}</td>
            <td class="px-3 py-4">{{ $breed->coreTempLowAlarm }}</td>
            <td class="px-3 py-4">{{ $breed->coreTempHighAlarm }}</td>
            <td class="px-3 py-4">{{ $breed->created_at }}</td>
            <td class="px-3 py-4">{{ $breed->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


</div>
@include('partials.footer')