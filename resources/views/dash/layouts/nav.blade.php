<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('dash.index')}}"><img class="brand-logo" alt="modern admin logo" src="/logo.png" style=" border-radius: 4px; background: #fff; padding: 3px; ">
                        <h3 class="brand-text">وزارة التنمية</h3>
                    </a></li>
                <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
                <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700">{{auth()->user()->name}}</span><span class="avatar avatar-online"><img src="/user.png" alt="avatar"><i></i></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="user-profile.html"><i class="ft-user"></i> Edit Profile</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{route('auth.logout')}}"><i class="ft-power"></i>تسجيل الخروج</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>