<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $siteSetting->site_title ??config('app.name') }} | @yield('title')</title>


  <meta name="description" content="{{ $siteSetting->site_description ?? '' }}">


  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/modules/jquery-selectric/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/css/style.css">
  <link rel="stylesheet" href="{{ asset("") }}admin/assets/css/components.css">

  <link rel="shortcut icon" href="{{ asset($sitesetting->site_favicon ?? '') }}">
  @yield('css')
</head>

<body>
  <div id="app">
    @yield('guest')
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset("") }}admin/assets/modules/jquery.min.js"></script>
  <script src="{{ asset("") }}admin/assets/modules/popper.js"></script>
  <script src="{{ asset("") }}admin/assets/modules/tooltip.js"></script>
  <script src="{{ asset("") }}admin/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="{{ asset("") }}admin/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="{{ asset("") }}admin/assets/modules/moment.min.js"></script>
  <script src="{{ asset("") }}admin/assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="{{ asset("") }}admin/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="{{ asset("") }}admin/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset("") }}admin/assets/js/page/auth-register.js"></script>

  <!-- Template JS File -->
  <script src="{{ asset("") }}admin/assets/js/scripts.js"></script>
  <script src="{{ asset("") }}admin/assets/js/custom.js"></script>
  @yield('js')
</body>
</html>
