<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ $title ?? __('Download video mp3 from YouTube') }}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
        <script src="{{asset('js/jquery-ui.min.js')}}"></script>
        <script src="{{asset('js/jquery.timepicker.min.js')}}"></script>
        <script src="{{asset('js/jquery-ui-timepicker-addon.js')}}"></script>
        <script src="{{asset('js/i18n/jquery.ui.timepicker-ru.js')}}"></script>

        <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery-ui-timepicker-addon.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery.timepicker.min.css') }}" rel="stylesheet">

    </head>
    <body class="bg-slate-100">
    <div class="container w-full md:w-2/4 mx-auto my-4 text-right">

        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-black focus:outline-none font-medium rounded-lg text-sm text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            @if (App::currentLocale() == 'ru')
                RU
            @else
                EN
            @endif
            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>

        <!-- Dropdown menu -->
        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-20 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a href="{{route('locale', ['locale' => 'ru'])}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Русский</a>
                </li>
                <li>
                    <a href="{{route('locale', ['locale' => 'en'])}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">English</a>
                </li>
            </ul>
        </div>


    </div>
      @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    </body>
</html>
