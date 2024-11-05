!
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>

    <style>
        /* CSS styles for the PDF table */
        table.table-bordered>tbody>tr>td,
        table.table-bordered>thead>tr>th,
        table.table-bordered>tfoot>tr>th,
        table.table-bordered>tfoot>tr {
            border: 1px solid #dee !important;
            /* Adjust the border color as needed */
            border-bottom: 2px solid #dee !important;

        }

        /* Add any additional CSS styles here */
    </style>
    <link rel="shortcut icon" href="{{ asset($siteSetting->site_favicon ?? '') }}">
    <meta name="theme-color" content="{{ asset($siteSetting->site_color ?? '') }}" />
    <meta name="description" content="{{ $siteSetting->site_description ?? '' }}">

    <!--  Essential META Tags -->
    <meta property="og:title" content="{{ $siteSetting->site_description ?? '' }}">
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset($siteSetting->site_color ?? '') }}">
    <meta property="og:url" content="https://stcharlesborromeocon.com/">
    <meta name="twitter:card" content="summary_large_image" />

    <!--  Non-Essential, But Recommended -->
    <meta property="og:description" content="{{ $siteSetting->site_description ?? '' }}">
    <meta property="og:site_name" content="{{ $siteSetting->site_title ?? '' }}">
    <meta name="twitter:image:alt" content="{{ $siteSetting->site_title ?? '' }}">

</head>

<body>

    @yield('pdf_view')

</body>

</html>
