@extends('mains/main')
@section('title','Nová nabídka | ')
@section('content')
    <div class="col-md-8 mx-auto white_box m-top3 d-flex justify-content-between align-items-stretch">
        <div class="col-md-6">
            <div class="form-group">
                <label>Název</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label>Typ</label>
                <select class="form-control" name="type">
                    @foreach($types as $t)
                        <option value="{{$t->id_t}}">{{$t->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Cena</label>
                <input type="number" min="0.01" class="form-control" name="price">
            </div>
            <div class="form-group">
                <label>Měna</label>
                <select class="form-control" name="currency">
                    @foreach($curr["all"] as $c)
                        <option value="{{$c->id_c}}" @if($curr["selected"]->id_c == $c->id_c) selected @endif>{{$c->short}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Název</label>
                <input type="text" class="form-control">
            </div>
        </div>
    </div>
@stop
