<html>
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include("partials/_head")
    <title>@yield('title')Auctions</title>
</head>
<body>
    @include("partials/_nav")
    @include('partials/_flashmessages')
    @yield('content')
    @include("partials/_scripts")
    @yield("scripts")
</body>
</html>
