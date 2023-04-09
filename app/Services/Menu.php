<?php

namespace App\Services;

use App\Facades\Permissoes;

class Menu
{
    public function getMenu($tp, $userLoggedPermissoes, $userLoggedMenuModulos, $userLoggedMenuSubmodulos)
    {
        $menu = '';

        //Pegar Id do Modulo Ativo
        $moduloIdActive = 0;

        foreach ($userLoggedMenuSubmodulos as $key => $dado) {
            if ($dado['menu_route'].'.index' == session('breadcrumbCurrentPageRoute')) {$moduloIdActive = $dado['modulo_id'];}
        }

        //Menu Verticarl
        if ($tp == 1) {
            $menu .= "<ul class='metismenu list-unstyled' id='side-menu'>
                            <li class='menu-title' key='t-menu'>Menu</li>";
        }

        //Menu Horizontal
        if ($tp == 2) {
            $menu .= "<ul class='navbar-nav'>";
        }

        //Mega Menu
        if ($tp == 3) {
            $menu .= "<ul class='list-unstyled megamenu-list'>
                        <div class='row'>";
        }

        foreach ($userLoggedMenuModulos as $key2 => $modulo) {
            $modOk = 1;

            foreach ($userLoggedMenuSubmodulos as $key3 => $submodulo) {
                if ($modulo['id'] == $submodulo['modulo_id']) {
                    if (Permissoes::permissao([$submodulo['prefix_permissao'] . '_list'], $userLoggedPermissoes)) {
                        if ($modOk == 1) {
                            $modOk = 0;

                            //li_active
                            $li_active = '';
                            if ($modulo['id'] == $moduloIdActive) {
                                $li_active = 'mm-active';
                            }

                            //Menu Verticarl
                            if ($tp == 1) {
                                $menu .= "<li class='" . $li_active . "'>
                                        <a href='javascript: void(0);' class='has-arrow waves-effect'>
                                            <i class='" . $modulo['menu_icon'] . "' style='font-size:16px;'></i><span key='t-" . $modulo['menu_route'] . "'>" . $modulo['menu_text'] . "</span>
                                        </a>
                                        <ul class='sub-menu' aria-expanded='true'>";
                            }

                            //Menu Horizontal
                            if ($tp == 2) {
                                $menu .= "<li class='nav-item dropdown " . $li_active . "'>
                                            <a class='nav-link dropdown-toggle arrow-none' href='#' id='topnav-layout' role='button'>
                                                <i class='" . $modulo['menu_icon'] . " me-2'></i><span key='t-" . $modulo['menu_route'] . "'>" . $modulo['menu_text'] . "</span> <div class='arrow-down'></div>
                                            </a>
                                            <div class='dropdown-menu' aria-labelledby='topnav-layout'>
                                                <div class='dropdown'>";
                            }
                        }

                        //Menu Verticarl
                        if ($tp == 1) {
                            $active = '';

                            if ($submodulo['menu_route'] . '.index' == session('breadcrumbCurrentPageRoute')) {
                                $active = 'active';
                            }

                            $menu .= "<li><a href='" . route($submodulo['menu_route'] . '.index') . "' class='" . $active . "' key='t-" . $submodulo['menu_route'] . "'><i class='" . $submodulo['menu_icon'] . "'></i>" . $submodulo['menu_text'] . "</a></li>";
                        }

                        //Menu Horizontal
                        if ($tp == 2) {
                            $menu .= "<a href='" . route($submodulo['menu_route'] . '.index') . "' class='dropdown-item' key='t-" . $submodulo['menu_route'] . "'><i class='" . $submodulo['menu_icon'] . " me-1'></i>" . $submodulo['menu_text'] . "</a>";
                        }

                        //Mega Menu
                        if ($tp == 3) {
                            $menu .= "<div class='col-md-2'>
                                        <li>
                                            <a href='" . route($submodulo['menu_route'] . '.index') . "' key='t-" . $submodulo['menu_route'] . "'><i class='" . $submodulo['menu_icon'] . " me-1'></i>" . $submodulo['menu_text'] . "</a>
                                        </li>
                                    </div>";
                        }
                    }
                }
            }

            if ($modOk == 0) {
                //Menu Verticarl
                if ($tp == 1) {
                    $menu .= "</ul></li>";
                }

                //Menu Horizontal
                if ($tp == 2) {
                    $menu .= "</div></div></li>";
                }
            }
        }

        //Menu Verticarl
        if ($tp == 1) {
            $menu .= "</ul>";
        }

        //Menu Horizontal
        if ($tp == 2) {
            $menu .= "</ul>";
        }

        //Mega Menu
        if ($tp == 3) {
            $menu .= "</div></ul>";
        }

        return $menu;
    }
}
