<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('TELOFFICE', 'TELOFFICE') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/heading.css') }}">
        <link rel="stylesheet" href="{{ asset('css/body.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet"/>
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="{{ asset('assets/mail/jqBootstrapValidation.js') }}"></script>
        <script src="{{ asset('assets/mail/contact_me.js') }}"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
        
    </head>
    <body id="page-top">
        
            @livewire('navigation-menu')
            <!-- Page Content -->
            <main style="margin-top:140px">
            @yield('content')
            </main>

        @stack('modals')

        @livewireScripts
    </body>
</html>
