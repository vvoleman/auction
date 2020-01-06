<div class="navi col-12 d-flex">
    <div class="col-md-5 justify-content-start d-flex align-items-center">
        <a href="{{route('home.home')}}" class="letter-logo"><span class="letter-logo col-1">B</span></a>
        <div class="search d-none d-md-block offset-md-5 col-md-7">
            <form method="get" action="{{route('search.search')}}">
                <input type="search" class="col-10" name="q">
                <!--<i class="fa fa-search" type="button"></i>!-->
            </form>
        </div>
    </div>
    <div class="col-md-7 d-flex justify-content-end align-items-center">
        <span>Obchod</span>
        @if(Auth::check())
        <div class="user-nav d-flex justify-content-between align-items-center">
            <notifications notifications="{{$notifications->toJson()}}" url="{{Auth::user()->profpic_path()}}"></notifications>
            <div class="btn-group">
                <button type="button" class="dd-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-caret-down"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('profile.profile')}}">Profil</a>
                    <a class="dropdown-item" href="{{route('profile.myOffers')}}">Moje nabídky</a>
                    <a class="dropdown-item" href="{{route('setting.setting')}}">Nastavení</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('login.logout')}}">Odhlásit se</a>
                </div>
            </div>
        </div>
        @else
        <a href="{{route('login.login')}}"><span class="m-left">Přihlášení</span></a>
        @endif
    </div>
</div>
