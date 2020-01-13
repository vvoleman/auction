@extends('mains.main')
@section('title','Seznam žádostí | ')
@section('content')
@component('partials._breadcrumbs')
		<li><a>Nabídka</a></li>
        <li><a class="current">Správa žádostí</a></li>
    @endcomponent
	@if(!$sold)
		<confirm-offer-list dat="{{$sells->toJson(JSON_UNESCAPED_UNICODE)}}"></confirm-offer-list>
	@else
		<div class="alert alert-danger m-top3 mx-auto col-md-6">Nabídka je již byla potvrzena!</div>
		<div class="m-top white_box col-md-4 mx-auto">
			<div class="d-flex justify-content-between align-items-start mx-auto">
                    <div class="d-flex align-items-start">
                        <h5>{{$sold->buyer->fullname}}</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <span style="margin-right:15px">{{$sold->created_at->format("d. m. y H:i:s")}}</span>
                        <span style="margin-right:15px">/</span>
                        <span>{{$sold->buyer->review_score()}} <i class="fas fa-star text-danger"></i></span>
                    </div>
                </div>
		</div>
	@endif
@stop