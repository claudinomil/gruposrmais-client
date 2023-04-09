<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notificacoes-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-bell bx-tada"></i>
        <span class="badge bg-danger rounded-pill">@if(isset($userLoggedUnreadNotificacoes)){{ count($userLoggedUnreadNotificacoes) }}@else{{ 0 }}@endif</span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notificacoes-dropdown">
        <div data-simplebar style="max-height: 230px;">

            @if(isset($userLoggedUnreadNotificacoes))
                @if(count($userLoggedUnreadNotificacoes) > 0)
                    @foreach($userLoggedUnreadNotificacoes as $key => $notificacao)
                        @php
                            //dias do envio da notificacao
                            $firstDate = $notificacao['date'];
                            $secondDate = date("Y-m-d");
                            $segundos = strtotime($secondDate) - strtotime($firstDate);
                            $dias = floor($segundos / (60 * 60 * 24));

                            //Dados da Notificação
                            $id = $notificacao['id'];
                            $avatar = $notificacao['userAvatar'];
                            $name = $notificacao['userName'];
                            $title = $notificacao['title'];
                            $notificacaoText = $notificacao['notificacao'];

                            if (strlen($notificacaoText) > 35) {$notificacaoText = substr($notificacaoText, 0, 50).'...';}
                        @endphp

                        <div class="px-2 py-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target=".modal-notificacao-ler" onclick="notificacaoLerData('{{$id}}');" class="text-reset notificacao-item">
                                <div class="d-flex">
                                    <img src="{{ Vite::asset('resources/assets_template/'.$avatar) }}" class="me-3 rounded-circle avatar-xs" alt="user-pic" title="{{ $name }}">
                                    <div class="flex-grow-1">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="mt-0 mb-1">{{ $title }}</h6>
                                            </div>
                                            <div class="col-auto">
                                                <p class="mb-0 small text-warning">{{ $dias }} dia(s)</p>
                                            </div>
                                        </div>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1" key="t-simplified">{{ $notificacaoText }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-divider"></div>
                    @endforeach
                @endif
            @else
                <div class="col">Nenhuma Notificação encontrada.</div>
            @endif

        </div>
        <div class="p-2 border-top d-grid">
            <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('notificacoes.index') }}">
                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">Notificações</span>
            </a>
        </div>
    </div>
</div>
