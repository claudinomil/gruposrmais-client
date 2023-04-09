<html>
    <head>
        <meta charset="utf-8" />
        <title>Artisan Desenvolvedor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @include('layouts.head-css')
    </head>

    <body>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Mensagem -->
                    @if (isset($success))
                        @if ($success != '')
                            <div class="alert alert-success mt-1">{{ $success }}</div>
                        @endif
                    @endif

                    <!-- Erros -->
                    @if (isset($errors))
                        @if ($errors != '')
                            <div class="alert alert-danger mt-1">{{ $errors }}</div>
                        @endif
                    @endif

                    <form id="frm_criarsubmodulos" method="post" action="{{ route('criarsubmodulos.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <x-button op="5" onClick="alertSwalConfirmacaoSubmit('frm_criarsubmodulos')" />
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="form-group col-12 col-md-4 pb-3">
                                <label class="form-label">Nome Referência - Plural</label>
                                <select class="form-control select2" name="referencia_name_plural" id="referencia_name_plural" required="required">
                                    <option value="">Selecione...</option>
                                    <option value="Departamentos">Departamentos</option>
                                    <option value="Funcionarios">Funcionários</option>
                                    <option value="Clientes">Clientes</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-4 pb-3">
                                <label class="form-label">Nome Referência - Singular</label>
                                <select class="form-control select2" name="referencia_name_singular" id="referencia_name_singular" required="required">
                                    <option value="">Selecione...</option>
                                    <option value="Departamento">Departamento</option>
                                    <option value="Funcionario">Funcionário</option>
                                    <option value="Cliente">Cliente</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="form-group col-12 col-md-4 pb-3">
                                <label class="form-label">Nome Submódulo - Plural</label>
                                <input type="text" class="form-control" id="submodulo_name_plural" name="submodulo_name_plural" required="required">
                            </div>
                            <div class="form-group col-12 col-md-4 pb-3">
                                <label class="form-label">Nome Submódulo - Singular</label>
                                <input type="text" class="form-control" id="submodulo_name_singular" name="submodulo_name_singular" required="required">
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="text-success">
                            <p><b>1. Será criado: Controller/Views/Js/Routes.</b></p>
                            <p><b>2. É preciso alterar o Código nos arquivos:</b></p>
                            <p>&nbsp;&nbsp;&nbsp;a. View index.php - Campos para a Table;</p>
                            <p>&nbsp;&nbsp;&nbsp;b. View form.php - Campos no Formulário;</p>
                            <p>&nbsp;&nbsp;&nbsp;c. Js - Campos da Validação;</p>
                            <p><b>3. É preciso criar Código para os arquivos:</b></p>
                            <p>&nbsp;&nbsp;&nbsp;a. Web.php Route - Require para as rotas;</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('layouts.scripts')
    </body>
</html>
