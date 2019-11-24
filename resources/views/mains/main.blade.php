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
    <div id="app">
        <vue-snotify></vue-snotify>
        <div class="topbar d-flex justify-content-around">
            <div>
                <a href="#"><div>Novinky</div></a>
                <a href="#"><div>Slevy</div></a>
            </div>
            <div>
                <a href="#"><div>O nás</div></a>
                <a href="#"><div>O nás</div></a>
            </div>
        </div>
        @include("partials/_nav")
        @include("partials._categories")
        @include('partials/_flashmessages')
        @yield('content')
    </div>
    @include("partials/_scripts")
    @yield("scripts")
</body>
</html>
