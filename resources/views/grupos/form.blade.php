<!-- Formulario -->
<div id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_create', $ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Confirnar Operação -->
                                <button type="button" class="btn btn-success waves-effect btn-label waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmar Operação" id="crudFormConfirmOperacao"><i class="fa fa-save label-icon"></i> Confirmar</button>
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <button type="button" class="btn btn-secondary waves-effect btn-label waves-light crudFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Alterar Registro -->
                                <button type="button" class="btn btn-primary waves-effect btn-label waves-light editRecord" data-bs-toggle="tooltip" data-bs-placement="top" data-id="0" title="Alterar Registro"><i class="fas fa-pencil-alt label-icon"></i> Alterar</button>
                        @endif

                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_destroy'], $userLoggedPermissoes))
                            <!-- Botão Excluir Registro -->
                                <button type="button" class="btn btn-danger waves-effect btn-label waves-light deleteRecord" data-bs-toggle="tooltip" data-bs-placement="top" data-id="0" title="Excluir Registro"><i class="fa fa-trash-alt label-icon"></i> Excluir</button>
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <button type="button" class="btn btn-secondary waves-effect btn-label waves-light crudFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                    </div>
                    <div class="modal-loading" id="crudFormAjaxLoading" style="display: none;">
                        <div class="spinner-chase">
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                        </div>
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{$ajaxNameFormSubmodulo}}" name="{{$ajaxNameFormSubmodulo}}">
                        <fieldset disabled id="fieldsetForm">
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">

                            <div class="row mt-4">
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="name" name="name" required="required">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-12 col-md-12 pb-3">
                                    {{-- tabela submodulos x permissoes --}}
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Submódulo</th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-primary mb-3 markUnmarkAll" style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="todos_listar" name="todos_listar" onchange="checkedPermissaoTable(1);">
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-info mb-3 markUnmarkAll" style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="todos_mostrar" name="todos_mostrar" onchange="checkedPermissaoTable(2);">
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-success mb-3 markUnmarkAll" style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="todos_criar" name="todos_criar" onchange="checkedPermissaoTable(3);">
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-warning mb-3 markUnmarkAll" style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="todos_editar" name="todos_editar" onchange="checkedPermissaoTable(4);">
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-danger mb-3 markUnmarkAll" style="display: none;">
                                                        <input class="form-check-input" type="checkbox" id="todos_deletar" name="todos_deletar" onchange="checkedPermissaoTable(5);">
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @php $num = 0; @endphp

                                        @foreach ($submodulos as $key => $submodulo)
                                            @php $num++; @endphp

                                            <tr>
                                                <td>{{ $num }}</td>
                                                <td>{{ $submodulo['name'] }}</td>

                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-primary mb-3 tdShow {{'show_'.$submodulo['prefix_permissao'].'_list'}}" style="display: none;">
                                                        <label class="form-check-label"><i class="fa fa-check text-primary"></i> Listar</label>
                                                    </div>
                                                    <div class="form-check form-checkbox-outline form-check-primary mb-3 tdCreateEdit" style="display: none;">
                                                        <input class="form-check-input {{'create_edit_'.$submodulo['prefix_permissao'].'_list'}}" type="checkbox" id="listar_{{$submodulo['id']}}" name="listar_{{$submodulo['id']}}" value="{{$submodulo['prefix_permissao']}}_list" onchange="checkedPermissaoTable(6, {{$submodulo['id']}});">
                                                        <label class="form-check-label" for="listar_{{$submodulo['id']}}">Listar</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-info mb-3 tdShow {{'show_'.$submodulo['prefix_permissao'].'_show'}}" style="display: none;">
                                                        <label class="form-check-label"><i class="fa fa-check text-info"></i> Mostrar</label>
                                                    </div>
                                                    <div class="form-check form-checkbox-outline form-check-info mb-3 tdCreateEdit" style="display: none;">
                                                        <input class="form-check-input {{'create_edit_'.$submodulo['prefix_permissao'].'_show'}}" type="checkbox" id="mostrar_{{$submodulo['id']}}" name="mostrar_{{$submodulo['id']}}" value="{{$submodulo['prefix_permissao']}}_show" onchange="checkedPermissaoTable(7, {{$submodulo['id']}});">
                                                        <label class="form-check-label" for="mostrar_{{$submodulo['id']}}">Mostrar</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-success mb-3 tdShow {{'show_'.$submodulo['prefix_permissao'].'_create'}}" style="display: none;">
                                                        <label class="form-check-label"><i class="fa fa-check text-success"></i> Criar</label>
                                                    </div>
                                                    <div class="form-check form-checkbox-outline form-check-success mb-3 tdCreateEdit" style="display: none;">
                                                        <input class="form-check-input {{'create_edit_'.$submodulo['prefix_permissao'].'_create'}}" type="checkbox" id="criar_{{$submodulo['id']}}" name="criar_{{$submodulo['id']}}" value="{{$submodulo['prefix_permissao']}}_create" onchange="checkedPermissaoTable(8, {{$submodulo['id']}});">
                                                        <label class="form-check-label" for="criar_{{$submodulo['id']}}">Criar</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-warning mb-3 tdShow {{'show_'.$submodulo['prefix_permissao'].'_edit'}}" style="display: none;">
                                                        <label class="form-check-label"><i class="fa fa-check text-warning"></i> Editar</label>
                                                    </div>
                                                    <div class="form-check form-checkbox-outline form-check-warning mb-3 tdCreateEdit" style="display: none;">
                                                        <input class="form-check-input {{'create_edit_'.$submodulo['prefix_permissao'].'_edit'}}" type="checkbox" id="editar_{{$submodulo['id']}}" name="editar_{{$submodulo['id']}}" value="{{$submodulo['prefix_permissao']}}_edit" onchange="checkedPermissaoTable(9, {{$submodulo['id']}});">
                                                        <label class="form-check-label" for="editar_{{$submodulo['id']}}">Editar</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-danger mb-3 tdShow {{'show_'.$submodulo['prefix_permissao'].'_destroy'}}" style="display: none;">
                                                        <label class="form-check-label"><i class="fa fa-check text-danger"></i> Deletar</label>
                                                    </div>
                                                    <div class="form-check form-checkbox-outline form-check-danger mb-3 tdCreateEdit" style="display: none;">
                                                        <input class="form-check-input {{'create_edit_'.$submodulo['prefix_permissao'].'_destroy'}}" type="checkbox" id="deletar_{{$submodulo['id']}}" name="deletar_{{$submodulo['id']}}" value="{{$submodulo['prefix_permissao']}}_destroy" onchange="checkedPermissaoTable(10, {{$submodulo['id']}});">
                                                        <label class="form-check-label" for="deletar_{{$submodulo['id']}}">Deletar</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
