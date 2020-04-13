@extends('mains/main')
@section('title','Administrace | ')
@section('content')
    @include('partials._admin-sidebar')
    <div class="offset-md-2">
        <admin-dashboard></admin-dashboard>
    </div>
@stop
