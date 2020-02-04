@extends('mains.main')
@section('title','Vyhledávání | ')
@section('content')
    @component('partials._breadcrumbs')
        <li><a class="current">Vyhledávání</a></li>
    @endcomponent
    <div class="d-flex justify-content-end col-md-10">
    	<a href="{{route('offers.new')}}">
    		<button class="btn btn-success">Nová nabídka</button>
    	</a>
    </div>
    <search-page q="{{$q}}" boot='{!! $boot->toJson(JSON_UNESCAPED_UNICODE) !!}' url='{!! $urls->toJson(JSON_UNESCAPED_UNICODE) !!}'></search-page>
@stop
