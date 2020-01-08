@extends('mains/main')
@section('title','Nová nabídka | ')
@section('content')
    <form method="post" action="{{route('offers.postNew')}}" enctype="multipart/form-data">
        @csrf
        @include('partials._formmsgs')
        <add-offer dat="{{$data->toJson(JSON_UNESCAPED_UNICODE)}}"></add-offer>
    </form>
@stop
@section('scripts')
@stop
