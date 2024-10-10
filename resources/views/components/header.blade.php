<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user text-uppercase">
                <i class="fas fa-globe mr-1"></i>
                {{ app()->getLocale() }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('site.language') }}</div>
                <a href="{{ route('localization', ['lang' => 'id']) }}" class="dropdown-item has-icon {{ app()->getLocale() == 'id' ? ' active' : '' }}">
                    ID (Bahasa)
                </a>
                <a href="{{ route('localization', ['lang' => 'en']) }}" class="dropdown-item has-icon {{ app()->getLocale() == 'en' ? ' active' : '' }}">
                    EN (English)
                </a>
                <a href="{{ route('localization', ['lang' => 'ko']) }}" class="dropdown-item has-icon {{ app()->getLocale() == 'ko' ? ' active' : '' }}">
                    KO (Korea)
                </a>
                <a href="{{ route('localization', ['lang' => 'zh']) }}" class="dropdown-item has-icon {{ app()->getLocale() == 'zh' ? ' active' : '' }}">
                    ZH (Chinese)
                </a>
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ __('site.hello') }}, {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('site.role') }} : {{ Auth::user()->roles->first()->name }}</div>
                <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('site.profile') }}
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> {{ __('site.logout') }}
                </a>
            </div>
        </li>
    </ul>
</nav>
