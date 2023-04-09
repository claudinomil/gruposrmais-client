<div class="topnav" id="div_menu_horizontal">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">@php echo \App\Facades\Menu::getMenu(2, $userLoggedPermissoes, $userLoggedMenuModulos, $userLoggedMenuSubmodulos) @endphp</div>
        </nav>
    </div>
</div>
