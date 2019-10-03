@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has($msg))
        <div class="position-absolute w-100 alert alert-{{$msg}} alert-dismissible fade show" role="alert" style="z-index: 5">
            <strong>{{Session::get($msg)}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endforeach

