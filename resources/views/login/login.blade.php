@extends("mains/main")
@section('title',"Test")
@section('content')
    <div class="col-md-4 col-10 mx-auto white_box m-top login">
        <h3>Přihlášení</h3>
        <hr>
        <div class="form">
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Heslo</label>
                <input type="password" class="form-control">
            </div>
            <input class="btn-block" type="submit" value="Přihlásit se">
        </div>
    </div>
@stop
