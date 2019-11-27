@extends('mains.main')
@section('title','Správa uživatelů | ')
@section('content')
    @component('admin.components._bread')
        <li><a class="current">Správa uživatelů</a></li>
    @endcomponent
    <config-users></config-users>
@stop
