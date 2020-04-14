@extends('mains.main')
@section('title','Info k nabídce | ')
@section('content')
    <show-offersell datas="{{json_encode($os,JSON_UNESCAPED_UNICODE)}}"></show-offersell>
@stop
