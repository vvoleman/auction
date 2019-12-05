@extends('mains.main')
@section('title','Vaše nabídky | ')
@section('content')
    @component('partials._breadcrumbs')
        <li><a class="current">Vaše nabídky</a></li>
    @endcomponent
	<show-myoffers></show-myoffers>
@stop
