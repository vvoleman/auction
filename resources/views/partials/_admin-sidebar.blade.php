<div class="col-md-3 col-lg-2 asidebar" style="margin-top:-25px">
    <div class="name" style="padding-top:10px">
        <h3>Administrace</h3>
    </div>
    <hr>
    <div class="m-top-2 list">
        <a href="{{route('admin.panel')}}">
            <div class="d-flex align-items-center box">
                <div class="col-3 d-flex justify-content-center">
                    <i class="fas fa-home "></i>
                </div>
                <span class="offset-0">Dashboard</span>
            </div>
        </a>
        <a href="{{route('admin.adminCategories')}}">
            <div class="d-flex align-items-center box">
                <div class="col-3 d-flex justify-content-center">
                    <i class="fas fa-heart"></i>
                </div>
                <span class="offset-0">Správa kategorií</span>
            </div>
        </a>
        <a href="{{route('admin.groups')}}">
            <div class="d-flex align-items-center box">
                <div class="col-3 d-flex justify-content-center">
                    <i class="fas fa-users-cog"></i>
                </div>
                <span class="offset-0">Správa skupin</span>
            </div>
        </a>
        <a href="{{route('admin.users')}}">
            <div class="d-flex align-items-center box">
                <div class="col-3 d-flex justify-content-center">
                    <i class="fas fa-users "></i>
                </div>
                <span class="offset-0">Správa uživatelů</span>
            </div>
        </a>
    </div>
</div>
