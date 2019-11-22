<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include("partials/_head")
    <title>@yield('title')Auctions</title>
    @yield("styles")
</head>
<body>
    @include("partials/_nav")
    @include('partials/_flashmessages')
    @yield('content')
    @include("partials/_scripts")
    @yield("scripts")
</body>
</html>
