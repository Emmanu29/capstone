@include('partials.header')
<?php $array = array('title' => 'Animal System') ;?>
<x-nav :data="$array"/>

<!-- <form action="{{ route('users.search') }}" method="GET" class="sm:mb-10 sm:w-w-2/12 md:w-1/8 lg:w-1/4 absolute top-12 right-12 mt-7">
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </div>
        <input type="search" name="name" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Name" required value="{{ old('name') }}" />
        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg    text-sm px-4 py-2 dark:bg-gray-800 dark:hover:bg-gray-500 dark:focus:ring-blue-800">Search</button>
    </div>
</form> -->

<form action="{{ route('users.search') }}" method="GET" class="sm:mb-10 sm:w-w-2/12 md:w-1/8 lg:w-1/4 absolute top-12 right-12 mt-7">
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </div>
        <input type="search" name="name" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Name" required value="{{ old('name') }}" />
        <button type="submit" class="text-white absolute end-2.5 bottom-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-gray-800 dark:hover:bg-gray-500 dark:focus:ring-blue-800">Search</button>
    </div>
</form>

<div class="max-w-4xl mx-auto mt-20">
    <a href="#">
        <h1 class="text-4xl font-bold text-gray-900 text-center">Users' List</h1>
    </a>
</div>

<div class="relative overflow-x-auto shadow-2xl sm:rounded-lg mt-5 bg-blue-100 dark:bg-gray-800 max-w-6xl mx-auto mb-10">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-6 py-3">
                    User Name
                </th>
                <th scope="col" class="px-6 py-3">
                    First Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Last Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Expiration Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">View</span>
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4">{{ $user->username }}</td>
            <td class="px-6 py-4">{{ $user->firstName }}</td>
            <td class="px-6 py-4">{{ $user->lastName }}</td>
            <td class="px-6 py-4">{{ $user->category }}</td>
            <td class="px-6 py-4">
                @if($user->dateTime)
                    {{ \Carbon\Carbon::parse($user->dateTime)->formatLocalized('%B %d, %Y %I:%M %p') }}
                @endif
            </td>
            <td class="px-6 py-4">{{ $user->email }}</td>
            <td class="px-6 py-4 text-right">
                <a href="/user/{{ $user->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
            </td>
        </tr>
    @endforeach
        </tbody>
    </table>
    <div class="mx-auto max-w-lg pt-6 p-4 flex justify-center">
        <nav role="navigation" aria-label="Pagination">
            <ul class="flex list-none">
                {{-- Previous Page Link --}}
                @if ($users->onFirstPage())
                    <li class="mr-2 disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="bg-gray-300 text-gray-600 px-3 py-2 rounded-md cursor-not-allowed">&laquo; Previous</span>
                    </li>
                @else
                    <li class="mr-2">
                        <a href="{{ $users->previousPageUrl() }}" rel="prev" class="bg-gray-900 hover:bg-blue-600 text-white px-3 py-2 rounded-md">&laquo; Previous</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($users->hasMorePages())
                    <li class="mr-2">
                        <a href="{{ $users->nextPageUrl() }}" rel="next" class="bg-gray-900 hover:bg-gray-600 text-white px-3 py-2 rounded-md">Next &raquo;</a>
                    </li>
                @else
                    <li class="mr-2 disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="bg-gray-300 text-gray-600 px-3 py-2 rounded-md cursor-not-allowed">Next &raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

</div>

@include('partials.footer')
