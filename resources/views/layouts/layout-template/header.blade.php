<div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route("dashboard.index") }}">
            <img src="{{ asset("images/logo.svg") }}" alt="logo">
        </a>
    </div>
    <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">
        <li class="nav-item nav-search d-none d-lg-flex">
            <h5>{{ env('APP_NAME') }}</h5>
        </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item dropdown">
            {{--<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
               data-toggle="dropdown">
                <i class="mdi mdi-bell-outline mx-0"></i>
                <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                 aria-labelledby="notificationDropdown">
                <a class="dropdown-item">
                    <p class="mb-0 font-weight-normal float-left">您目前沒有新的通知。</p>
                </a>
                <div class="dropdown-divider"></div>
            </div>--}}
        </li>
        <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                <span class="nav-profile-name">帳號管理</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="{{ route("users.edit",[Auth::user()->id]) }}">
                    <i class="mdi mdi-settings text-primary"></i>
                    帳號設定
                </a>
                <div class="dropdown-divider"></div>
                <form method="post" action="{{ route("logout") }}">
                    @csrf
                    <button type="submit" class="dropdown-item"><i class="mdi mdi-logout text-primary"></i>會員登出</button>
                </form>
            </div>
        </li>
        <li class="nav-item nav-toggler-item-right d-lg-none">
            <button class="navbar-toggler align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                <span class="mdi mdi-menu"></span>
            </button>
        </li>
    </ul>
</div>
