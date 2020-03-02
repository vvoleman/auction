@extends('mains.main')
@section('title','Zprávy | ')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <messenger y_uuid="{{Auth::user()->uuid}}"></messenger>
@stop
