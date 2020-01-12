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
        @include("partials/_nav")
        <transition name="fade">
        <div v-cloak>
        @include("partials._categories")
        @include('partials/_flashmessages')
        @yield('content')
        </div>
        </transition>
    </div>
    @include("partials/_scripts")
    @yield("scripts")
</body>
</html>
