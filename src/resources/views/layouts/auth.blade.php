<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    @yield('css')

    <title>@yield('title')</title>
</head>
<body>
    @yield('content')
</body>
</html>