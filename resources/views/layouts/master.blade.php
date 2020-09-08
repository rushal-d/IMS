<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('layouts.header')
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('layouts.navbar')
        <div class="app-body">
{{--            @include('layouts.sidebar')--}}
            <main class="main">
                @include('layouts.breadcrumb')
                @include('layouts.notification')
                    @yield('content')
            </main>
        </div>
    @include('layouts.footer')
    </body>
</html>
