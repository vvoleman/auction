@extends('mains.main')
@section('title','Vyhledávání | ')
@section('content')
    @component('partials._breadcrumbs')
        <li><a class="current">Vyhledávání</a></li>
    @endcomponent
    <search-page q="{{$q}}" boot='{!! $boot->toJson(JSON_UNESCAPED_UNICODE) !!}' url='{!! $urls->toJson(JSON_UNESCAPED_UNICODE) !!}'></search-page>
@stop
