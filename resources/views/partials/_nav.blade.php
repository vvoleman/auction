<div class="navi col-12 d-flex">
    <div class="col-md-3">
        <a href="{{route('home.home')}}" class="justify-content-start d-flex align-items-center logo">
        <img src="{{URL::asset('/assets/images/logo.png')}}"><!--<span class="letter-logo col-1">B</span>!-->
        <div class="logo-text">
            <span class="main-text">Auction</span>
            <span class="second-text">protože proč ne</span>
        </div>
        </a>
    </div>
    <div class="col-md-9 d-flex justify-content-end align-items-center">
        <form method="get" action="{{route('search.search')}}">
            <searchbar></searchbar>
        </form>
        <a href="{{route('search.search')}}"><span>Nabídky</span></a>
        @if(Auth::check())
        <div class="user-nav d-flex justify-content-between align-items-center">
            <message-indicator messages="{{$messages->toJson()}}" notify="{{!request()->routeIs("message.message")}}" y_uuid="{{Auth::user()->uuid}}"></message-indicator>
            <notifications you="{{Auth::user()->uuid}}" notifications="{{$notifications->toJson()}}" url="{{Auth::user()->profpic_path()}}"></notifications>
            <div class="name">
                <span class="name-first">{{Auth::user()->surname}}</span>
                <span class="name-sur">{{Auth::user()->firstname}}</span>
            </div>
            <div class="btn-group">
                <button type="button" class="dd-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-caret-down"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('profile.profile')}}">Profil</a>
                    <a class="dropdown-item" href="{{route('message.message')}}">Chat</a>
                    <a class="dropdown-item" href="{{route('profile.myOffers')}}">Moje nabídky</a>
                    <a class="dropdown-item" href="{{route('profile.myOrders')}}">Moje objednávky</a>
                    <a class="dropdown-item" href="{{route('setting.setting')}}">Nastavení</a>
                    @if(Auth::user()->hasPermission('admin.dashboard'))
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('admin.panel')}}">Administrace</a>
                    @endif
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
