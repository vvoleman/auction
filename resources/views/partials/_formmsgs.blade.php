@foreach($errors->all() as $msg)
    <div class="alert alert-danger form-error">
        {{$msg}}
    </div>
@endforeach
