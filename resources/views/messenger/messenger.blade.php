@extends('mains.main')
@section('title','Zprávy | ')
@section('content')
    <messenger y_uuid="{{Auth::user()->uuid}}"></messenger>
@stop
