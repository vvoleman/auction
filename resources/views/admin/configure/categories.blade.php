@extends('mains.main')
@section('title','Správa kategorií | ')
@section('content')
    @component('admin.components._bread')
        <li><a class="current">Správa kategorií</a></li>
    @endcomponent
    <config-categories></config-categories>
@stop
