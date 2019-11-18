@extends('mains.main')
@section('title','Vyhledávání | ')
@section('content')
	<div id="app">
        <search-page></search-page>
    </div>
@stop
@section('scripts')
    <script type="text/javascript" src="{{URL::asset("/js/app.js")}}"></script>
@stop
