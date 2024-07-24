<nav x-data="{open : false}" class="fixed top-0 left-0 right-0 w-full border-gray-200 bg-green-50 dark:bg-gray-900 dark:border-gray-700 z-50">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="{{ Auth::user()->category !== 'Temporary User' ? '/' : '/monitoring' }}" class="flex items-center space-x-3 rtl:space-x-reverse">
    <img src="{{ asset('images/apms.jpg') }}" class="h-8 rounded-full" alt="Flowbite Logo" />
    <span class="font-bold self-center text-2xl whitespace-nowrap dark:text-white dark:hover:text-gray-500">
        @if(Request::is('/'))
            Veterinary Clinic Dashboard
        @else
            APMS
        @endif
    </span>
</a>
    <button id="menu-toggle" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-solid-bg" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
      </svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
      @auth
          <ul class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-900 md:dark:bg-transparent dark:border-gray-700">
          @if(Auth::user()->category !== 'Temporary User')
          <li>
            <a href="/" target="_parent" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-900 md:hover:bg-transparent md:border-0 md:hover:text-gray-700 dark:text-white md:dark:hover:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                <span class="text-sm">Home</span>
                <span class="float-left mt-0 mr-1 inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                  </svg>
                </span>
            </a>
        </li>
        @endif
        <li>
            <a href="/monitoring" target="_parent	" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-900 md:hover:bg-transparent md:border-0 md:hover:text-gray-700 dark:text-white md:dark:hover:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
            <span class="text-sm">Monitoring</span>
            <span class="float-left mt-0 mr-1 inline-block">
            <svg class="w-4 h-6 text-white-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />  <line x1="8" y1="21" x2="16" y2="21" />  <line x1="12" y1="17" x2="12" y2="21" /></svg>
            </span>
            </a>
        </li>
        <li>
            <a href="/patients" target="_parent	" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-900 md:hover:bg-transparent md:border-0 md:hover:text-gray-700 dark:text-white md:dark:hover:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
            <span class="text-sm">Patients</span>
            <span class="float-left mt-0 mr-1 inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
              </svg>
            </span>
            </a>
        </li>
        @if(Auth::user()->category !== 'Temporary User')
        <li>
            <a href="/species" target="_parent	" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-900 md:hover:bg-transparent md:border-0 md:hover:text-gray-700 dark:text-white md:dark:hover:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
            <span class="text-sm">Species</span>
            <span class="float-left mt-0 mr-1 inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0 1 12 12.75Zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 0 1-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 0 0 2.248-2.354M12 12.75a2.25 2.25 0 0 1-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 0 0-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 0 1 .4-2.253M12 8.25a2.25 2.25 0 0 0-2.248 2.146M12 8.25a2.25 2.25 0 0 1 2.248 2.146M8.683 5a6.032 6.032 0 0 1-1.155-1.002c.07-.63.27-1.222.574-1.747m.581 2.749A3.75 3.75 0 0 1 15.318 5m0 0c.427-.283.815-.62 1.155-.999a4.471 4.471 0 0 0-.575-1.752M4.921 6a24.048 24.048 0 0 0-.392 3.314c1.668.546 3.416.914 5.223 1.082M19.08 6c.205 1.08.337 2.187.392 3.314a23.882 23.882 0 0 1-5.223 1.082" />
            </svg>

            </span>
            </a>
        </li>
        <li>
            <a href="/users" target="_parent	" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-900 md:hover:bg-transparent md:border-0 md:hover:text-gray-700 dark:text-white md:dark:hover:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
            <span class="text-sm">Users</span>
              <span class="float-left mt-0 mr-1 inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
              </span>
            </a>
        </li>
        <li id="add-new-link">
            <a href="#" target="_parent	" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-900 md:hover:bg-transparent md:border-0 md:hover:text-gray-700 dark:text-white md:dark:hover:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
            <span class="text-sm">Add New</span>
              <span class="inline-block mr-1 mt-0 float-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
              </span>
            </a>
        </li>
        @endif
        <li>
            <form action="/logout" method="POST" class="inline">
                @csrf
                <button type="submit" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-900 md:hover:bg-transparent md:border-0 md:hover:text-gray-700 dark:text-white md:dark:hover:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                <span class="text-sm">Logout</span>
                <span class="inline-block float-left mt-0 mr-1">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                  </svg>
                </span>
                </button>
            </form>
        </li>
    </ul>
      @endauth
    </div>
  </div>
</nav>

<script>
  document.getElementById("menu-toggle").addEventListener("click", function() {
    var menu = document.getElementById("navbar-solid-bg");
    menu.classList.toggle("hidden");
  });

  // Check the current URL and hide the "Add New" link if needed
  document.addEventListener("DOMContentLoaded", function() {
    var addNewLink = document.getElementById("add-new-link");

    var currentUrl = window.location.pathname;

    // Regular expression pattern to match /user/{id}
    var userPattern = /^\/user\/\d+$/;
    var animalPattern = /^\/animal\/\d+$/;
    var consultationPattern = /^\/consultation\/\d+$/;
    var speciesBreedsPattern = /^\/species\/breeds\/\d+$/;

    if (currentUrl === '/'|| currentUrl === '/species'|| currentUrl === '/monitoring' || currentUrl === '/register' || currentUrl === '/add/species' || currentUrl === '/add/animal' || userPattern.test(currentUrl ) || animalPattern.test(currentUrl ) || consultationPattern.test(currentUrl ) || speciesBreedsPattern.test(currentUrl )) {
      // Hide the "Add New" link
      addNewLink.style.display = "none";
    }

  });

  // Check the current URL and set the href of Add New link accordingly
  document.addEventListener("DOMContentLoaded", function() {
    var addNewLink = document.getElementById("add-new-link").querySelector("a");
    var currentUrl = window.location.pathname;

    if (currentUrl === '/patients') {
      addNewLink.href = '/add/animal';
    } else if (currentUrl === '/users') {
      addNewLink.href = '/register';
    }
    else if(currentUrl ==='/species'){
      addNewLink.href = '/add/species';
    }
  });
</script>