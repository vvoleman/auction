@extends('mains.main')
@section('title','Správa skupin | ')
@section('content')
    @component('admin.components._bread')
        <li><a class="current">Správa skupin</a></li>
    @endcomponent
    <config-groups></config-groups>
@stop

