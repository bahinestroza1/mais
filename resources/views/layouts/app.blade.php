<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials.htmlheader')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('partials.navbar')      
        @include('partials.sidebar')

        <div class="content-wrapper">
            @include('partials.contentheader')
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
       

        @include('partials.footer')
    </div>
    @include('partials.scripts')
</body>
</html>
