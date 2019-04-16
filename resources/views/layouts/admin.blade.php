<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/images/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icon/favicon-16x16.png">
    <link rel="manifest" href="/images/icon/site.webmanifest">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<div id="app">
    <app-init></app-init>
</div>

<script src="/js/bootscript.js"></script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
