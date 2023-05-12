<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="index" class="logo" id="aLogoDark">
                    <span class="logo-sm">
                        <img src="{{ asset('build/assets/images/image_logo_layout_dark_menu_min.png') }}" alt="" height="70" id="appImgLogoLayoutDarkMenuMin">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('build/assets/images/image_logo_layout_dark_menu.png') }}" alt="" height="35" id="appImgLogoLayoutDarkMenu">
                    </span>
                </a>

                <a href="index" class="logo" id="aLogoLight">
                    <span class="logo-sm">
                        <img src="{{ asset('build/assets/images/image_logo_layout_light_menu_min.png') }}" alt="" height="70" id="appImgLogoLayoutLightMenuMin">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('build/assets/images/image_logo_layout_light_menu.png') }}" alt="" height="35" id="appImgLogoLayoutLightMenu">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                    <span key="t-megamenu">Mega Menu</span>
                    <i class="mdi mdi-chevron-down"></i>
                </button>
                <div class="dropdown-menu dropdown-megamenu">
                    <div class="row">
                        <div class="col-sm-10">@php echo \App\Facades\Menu::getMenu(3, $userLoggedPermissoes, $userLoggedMenuModulos, $userLoggedMenuSubmodulos) @endphp</div>
                        <div class="col-sm-2">
                            <img src="{{ asset('build/assets/images/megamenu-img.png') }}" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex">
            @if (\App\Facades\Permissoes::permissao(['ferramentas_list'], $userLoggedPermissoes))
                @include('layouts.ferramentas')
            @endif

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            @if (\App\Facades\Permissoes::permissao(['notificacoes_list'], $userLoggedPermissoes))
                @include('layouts.notificacoes')
            @endif

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ isset($userLoggedData['avatar']) ? asset($userLoggedData['avatar']) : asset('build/assets/images/users/avatar-0.png') }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ucfirst($userLoggedData['name'])}}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target=".modal-profile" onclick="userProfileData(2,{{$userLoggedData['id']}});"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Perfil</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            @if(session('access_device') == 'desktop')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="bx bx-cog bx-spin"></i>
                    </button>
                </div>
            @endif

        </div>
    </div>
</header>
