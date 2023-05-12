<div class="vertical-menu" id="div_menu_vertical">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">@php echo \App\Facades\Menu::getMenu(1, $userLoggedPermissoes, $userLoggedMenuModulos, $userLoggedMenuSubmodulos) @endphp</div>
    </div>
</div>
