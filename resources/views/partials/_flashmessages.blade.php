<div class="flash-message position-absolute col-12" style="padding:0;border-radius:0;z-index:999">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has($msg))
            <h1>{{Session::get($msg)}}</h1>
        @endif
    @endforeach
</div>
