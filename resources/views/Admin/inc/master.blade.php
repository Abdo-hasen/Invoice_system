<!DOCTYPE html>
<html lang="en">

{{-- head --}}
@include('Admin.inc.head')


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('AdminAssets') }}/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('Admin.inc.nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('Admin/inc/sidebar')

        {{-- content --}}
        @yield('content')


        {{-- footer --}}
        @include('Admin.inc.footer')

    </div>
    <!-- ./wrapper -->

    {{-- scripts --}}
    @include('Admin.inc.scripts')




</body>

</html>
