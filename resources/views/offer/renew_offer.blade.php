@extends("mains.main")
@section('title',"Nabídka '".$offer->name."' vypršela | ")
@section('content')
    <form method="post" action="{{route("offers.postRenew",["id"=>$offer->uuid])}}">
        @csrf
        <div class="col-md-4 mx-auto white_box m-top3">
            <div class="alert-danger alert"><b>Pozor!</b> Nabídka vypršela!</div>
            <div>
                <ul>
                    <li><b>Nabídka:</b> {{$offer->name}}</li>
                    <li><b>Vytvořeno:</b> {{$offer->created_at->format("d. m. Y H:i")}}</li>
                    <li><b>Vypršelo:</b> <span
                                class="text-danger">{{\Carbon\Carbon::parse($offer->end_date)->format("d. m. Y H:i")}}</span>
                    </li>
                    @if(sizeof($offer->tags) > 0)
                        <li><b>Tagy:</b>
                            <ul>
                                @foreach($offer->tags as $t)
                                    <li>{{$t->name}}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            @if(Auth::user()->hasPermission("offers.renew"))
                <h5 class="text-center">Přejete si nabídku prodloužit?</h5>
                <div class="small text-center">Doba prodloužení: 30 dní</div>
                <button class="btn btn-block btn-blue m-top col-8 mx-auto">Prodloužit nabídku</button>
            @endif
        </div>
    </form>
@stop
