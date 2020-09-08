<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>

    <link rel="shortcut icon" href="{{{ asset('favicon.ico') }}}">
    <!-- CSS Styles -->
    <link href="{{asset('assets/@coreui/icons/css/coreui-icons.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/simple-line-icons/css/simple-line-icons.css')}}" rel="stylesheet">
    <link href="{{asset('css/nepali.datepicker.v2.2.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{asset('css/flatpickr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{asset('js/selectize/dist/css/selectize.bootstrap3.css') }}" type="text/css" rel="stylesheet"/>
    <!-- Main styles for this application-->
    <link href="{{asset('css/pace.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/theme-default.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/customstyle.css?v=') . rand(88986,9988797)}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vex.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vex-theme-default.css">
    @yield('styles')
</head>
