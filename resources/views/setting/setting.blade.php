@extends('mains/main')
@section('title','Nastavení profilu | ')
@section('content')
    <div class="col-md-4 mx-auto white_box m-top3">
        <h3>Nastavení</h3>
    </div>
    <div class="col-md-4 mx-auto white_box m-top">
        <h5>E-mail</h5>
        <form>
            <div class="form">
                <div class="form-group">
                    <input type="email" name="email" value="{{$email}}" class="form-control">
                </div>
                <input type="submit" class="btn btn-block btn-blue" value="Změnit">
            </div>
        </form>
    </div>
    <div class="col-md-4 mx-auto white_box m-top">
        <form>
            <div class="form">
                <div class="form-group">
                    <h5>Jméno</h5>
                    <input type="text" value="{{$firstname}}" class="form-control">
                </div>
                <div class="form-group">
                    <h5>Příjmení</h5>
                    <input type="text" value="{{$surname}}" class="form-control">
                </div>
                <input type="submit" class="btn btn-block btn-blue" value="Změnit">
            </div>
        </form>
    </div>
@stop
