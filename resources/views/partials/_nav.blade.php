<div class="navi col-12 d-flex">
    <div class="col-md-5 justify-content-start d-flex align-items-center">
        <span class="letter-logo col-1">B</span>
        <div class="search d-none d-md-block offset-md-5 col-md-7">
            <input type="search" class="col-10">
            <i class="fa fa-search"></i>
        </div>
    </div>
    <div class="col-md-7 d-flex justify-content-end align-items-center">
        <span>Obchod</span>
        @if(Auth::check())
        <div class="user-nav d-flex justify-content-between align-items-center">
            <div class="picture-nav"></div>
            <div class="btn-group">
                <button type="button" class="dd-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-caret-down"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>
        </div>
        @else
        <a href="{{route('login.create')}}"><span class="m-left">Přihlášení</span></a>
        @endif
    </div>
</div>
