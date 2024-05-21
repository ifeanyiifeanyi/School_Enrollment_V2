<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteSetting->site_title ??config('app.name') }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <meta name="description" content="{{ $siteSetting->site_description ?? '' }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset("") }}student/plugins/fontawesome-free/css/all.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset("") }}student/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- In the <head> section -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("") }}student/dist/css/adminlte.min.css">
    <link rel="icon" href="{{ asset($siteSetting->site_favicon ?? '') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    @yield('css')
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">


        <!-- Navbar -->
        @include("student.layouts.partials.navbar")
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include("student.layouts.partials.sidebar")

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="mb-2 row">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield("title")</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route("student.dashboard") }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield("title")</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-4 w-50" role="alert">
                <strong>Error!</strong>
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <!-- Main content -->
            @yield("student")
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        @include('student.layouts.partials.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset("") }}student/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset("") }}student/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset("") }}student/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("") }}student/dist/js/adminlte.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset("") }}student/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset("") }}student/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset("") }}student/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <!-- PAGE {{ asset("") }}student/PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset("") }}student/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="{{ asset("") }}student/plugins/raphael/raphael.min.js"></script>
    <script src="{{ asset("") }}student/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="{{ asset("") }}student/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="{{ asset("") }}student/plugins/chart.js/Chart.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset("") }}student/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset("") }}student/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset("") }}student/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset("") }}student/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset("") }}student/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset("") }}student/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset("") }}student/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset("") }}student/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset("") }}student/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset("") }}student/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset("") }}student/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset("") }}student/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>






    <script>
        @if(Session::has('message'))
          var type = "{{ Session::get('alert-type','info') }}"
      
          switch(type){
          case 'info':
          toastr.info(" {{ Session::get('message') }} ");
          break;
      
          case 'success':
          toastr.success(" {{ Session::get('message') }} ");
          break;
      
          case 'warning':
          toastr.warning(" {{ Session::get('message') }} ");
          break;
      
          case 'error':
          toastr.error(" {{ Session::get('message') }} ");
          break;
        }
      @endif
    </script>

    @yield('js')
    <script>
        $(document).ready(function() {
            $('#department_id').select2();
            $('#state').select2();
            $('#localGovernment').select2();
        });
    </script>





    @livewireScripts
</body>

</html>