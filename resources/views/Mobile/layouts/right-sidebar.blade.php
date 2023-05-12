<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100 small">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">
            <h5 class="m-0 me-2">Configurações</h5>
            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Campo layout_user_id com o id do Usuário Logado -->
        <!-- Vai ser usado para atualização do layout na função updateRegisterUser() -->
        <input type="hidden" id="layout_user_id" name="layout_user_id" value="{{$userLoggedData['id']}}">

        <!-- Settings -->
        <hr class="mt-0" />

        <h6 class="ps-4 mb-0">Modo de layout</h6>

        <div class="p-4">
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_mode" id="layout_mode_light" checked>
                <label class="form-check-label" for="layout_mode_light">Modo Claro</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_mode" id="layout_mode_dark" data-bsStyle="build/assets/bootstrap-dark.min.css" data-appStyle="build/assets/app-dark.min.css">
                <label class="form-check-label" for="layout_mode_dark">Modo Escuro</label>
            </div>
        </div>

        <h6 class="ps-4 mb-0">Estilo de Layout</h6>

        <div class="p-4">
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_vertical_light_sidebar">
                <label class="form-check-label" for="layout_style_vertical_light_sidebar">Vertical - Barra Lateral Leve</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_vertical_compact_sidebar">
                <label class="form-check-label" for="layout_style_vertical_compact_sidebar">Vertical - Barra Lateral Compacta</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_vertical_icon_sidebar">
                <label class="form-check-label" for="layout_style_vertical_icon_sidebar">Vertical - Barra lateral de ícones</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_vertical_boxed_width">
                <label class="form-check-label" for="layout_style_vertical_boxed_width">Vertical - Largura da Caixa</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_vertical_colored_sidebar">
                <label class="form-check-label" for="layout_style_vertical_colored_sidebar">Vertical - Barra Lateral Colorida</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_vertical_scrollable">
                <label class="form-check-label" for="layout_style_vertical_scrollable">Vertical - Rolável</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_horizontal_horizontal">
                <label class="form-check-label" for="layout_style_horizontal_horizontal">Horizontal - Horizontal</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_horizontal_topbar_light">
                <label class="form-check-label" for="layout_style_horizontal_topbar_light">Horizontal - Luz da Barra Superior</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_horizontal_boxed_width">
                <label class="form-check-label" for="layout_style_horizontal_boxed_width">Horizontal - Largura da Caixa</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_horizontal_colored_header">
                <label class="form-check-label" for="layout_style_horizontal_colored_header">Horizontal - Cabeçalho Colorido</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="layout_style_horizontal_scrollable">
                <label class="form-check-label" for="layout_style_horizontal_scrollable">Horizontal - Rolável</label>
            </div>
        </div>
    </div>
</div>

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
