<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ $siteSetting->site_title ??config('app.name') }} | @yield('title')</title>

  <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

  <meta name="csrf-token" content="{{ csrf_token() }}">


  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/fontawesome/css/all.min.css">
  <!-- DataTables -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("") }}student/plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="{{ asset("") }}student/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset("") }}student/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset("") }}student/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/codemirror/theme/duotone-dark.css">
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet"
    href="{{ asset("") }}admin/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet"
    href="{{ asset("") }}admin/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

  <meta name="description" content="{{ $siteSetting->site_description ?? '' }}">
  <meta name="theme-color" content="{{ asset($siteSetting->site_color ?? '') }}" />

  <style>
    *{
        font-weight: bold !important;
    }
  </style>

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/css/style.css">
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/css/components.css">

  <link rel="icon" href="{{ asset($siteSetting->site_favicon ?? '') }}" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <style>
    #example1_paginate{
      display: none !important;
    }
    .active{
      background-color: #007bff!important;
      color: #fff !important;
      border-radius: 20px !important;
      margin: 0 10px 0 10px !important;
    }
    .parent{
      border: 2px solid #6777f0 !important;
      border-radius: 20px !important
    }
  </style>

</head>
@yield('css')
@livewireStyles

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      @include('admin.layouts.partials.navbar')

      @include('admin.layouts.partials.sidebar')
      <!-- Main Content -->
      @yield('admin')
      @include('admin.layouts.partials.footer')
    </div>
  </div>

  @include('admin.layouts.partials.scripts')

  @livewireScripts

  <!-- DataTables  & Plugins -->
  {{-- <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script> --}}
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
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,

      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  @yield('js')
</body>

</html>
