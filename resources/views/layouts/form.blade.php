<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

        @livewireStyles
        @wireUiScripts

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-notifications />
        <x-jet-banner />

        <div class="min-h-screen bg-white">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-gradient-to-r from-green-600 to-emerald-700 shadow-lg">
                    <div class="px-4 py-8 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
                        <h1 class="text-3xl font-bold text-white tracking-tight sm:text-4xl">
                            {{ $header }}
                        </h1>
                        <p class="mt-2 text-green-100 text-lg">
                            Business Model Evidence Assessment
                        </p>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        @stack('scripts')

    </body>
</html>
