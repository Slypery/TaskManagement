<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_name }}</title>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    </style>
</head>
@yield('body')
</html>