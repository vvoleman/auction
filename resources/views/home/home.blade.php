@extends('mains/main')
@section('title','Úvod | ')
@section('content')
	<div class="col-md-8 col-11 mx-auto white_box m-top3">
           <h3 class="text-center">Úvod</h3>
           <hr>
           <div class="">
               <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
               tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
               quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
               consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
               cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
               proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
           </div>
    </div>
@stop
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        $("form");
        $.get("http://api.lolesports.com/api/v1/scheduleItems?leagueId=9",(data)=>{
            console.log(data);
        })
    </script>
@stop
