@extends('mains.main')
@section('title','Vyhledávání | ')
@section('styles')
    <link rel="stylesheet" href="{{URL::asset("assets/css/animations.css")}}">
@stop
@section('content')
	<div id="app">
        <search-page boot='{!! $boot->toJson(JSON_UNESCAPED_UNICODE) !!}' url='{!! $urls->toJson(JSON_UNESCAPED_UNICODE) !!}'></search-page>
    </div>
@stop
@section('scripts')
    <script type="text/javascript" src="{{URL::asset("/js/app.js")}}"></script>
@stop
