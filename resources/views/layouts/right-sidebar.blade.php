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
            @foreach ($layouts_modes as $key => $layout_mode)
                @if($layout_mode['ativo'] == 1)
                    @if($layout_mode['name'] == 'layout_mode_light')
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input theme-choice" type="radio" name="choose_layout_mode" id="layout_mode_light" checked>
                            <label class="form-check-label" for="layout_mode_light">Modo Claro</label>
                        </div>
                    @endif

                    @if($layout_mode['name'] == 'layout_mode_dark')
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input theme-choice" type="radio" name="choose_layout_mode" id="layout_mode_dark" data-bsStyle="build/assets/bootstrap-dark.min.css" data-appStyle="build/assets/app-dark.min.css">
                            <label class="form-check-label" for="layout_mode_dark">Modo Escuro</label>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>

        <h6 class="ps-4 mb-0">Estilo de Layout</h6>

        <div class="p-4">
            @foreach ($layouts_styles as $key => $layout_style)
                @if($layout_style['ativo'] == 1)
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="radio" name="choose_layout_menu" id="{{ $layout_style['name'] }}">
                        <label class="form-check-label" for="{{ $layout_style['name'] }}">{{ $layout_style['descricao'] }}</label>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
