@extends('mains.main')
@section('title','Moje objednávky | ')
@section('content')
    @component('partials._breadcrumbs')
        <li><a class="current">Vaše objednávky</a></li>
    @endcomponent
    <show-myorders></show-myorders>
@stop
