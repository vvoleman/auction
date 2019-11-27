@extends('mains.main')
@section('title','Správa skupin | ')
@section('content')
    @component('admin.components._bread')
        <li><a class="current">Správa skupin</a></li>
    @endcomponent
    <config-groups></config-groups>
@stop
@section('scripts')
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.core.min.js"></script>!-->
@stop

