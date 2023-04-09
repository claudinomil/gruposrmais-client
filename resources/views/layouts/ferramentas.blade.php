<div class="dropdown d-none d-lg-inline-block ms-1">
    <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-customize"></i>
        <span class="badge bg-primary rounded-pill">@if(isset($userLoggedFerramentas)){{ count($userLoggedFerramentas) }}@else{{ 0 }}@endif</span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <div class="px-lg-2">
            <div class="row">

                @if(isset($userLoggedFerramentas))
                    @if(count($userLoggedFerramentas) > 0)
                        @foreach($userLoggedFerramentas as $key => $ferramenta)
                            <div class="col-4 pb-2">
                                <a class="dropdown-icon-item border border-4" href="{{ $ferramenta['url'] }}" dataBsToggle="tooltip" dataBsPlacement="top" title="{{ $ferramenta['descricao'] }}" target="_blank"><i class="{{ $ferramenta['icon'] }} fa-2x"></i><span class="px-2">{{ $ferramenta['name'] }}</span></a>
                            </div>
                        @endforeach
                    @endif
                @else
                    <div class="col">Nenhuma Ferramenta encontrada.</div>
                @endif

            </div>
        </div>
    </div>
</div>
