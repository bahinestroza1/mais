<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
@include('partials.htmlheader')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('partials.navbar')      
        @include('partials.sidebar')

        <div 
            class="content-wrapper" 
            style="background-repeat: no-repeat; background-position: center bottom; background-size: 100%; min-height: 430px;"
        >
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
