<?php

use App\Facades\QRCodeFacade;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CriarSubmodulos;

//Rota inicial
Route::get('/', function () {
    return view('welcome');
});

//Rotas de auth
require __DIR__.'/routes_auth.php';

//Rotas Language Translation
require __DIR__ . '/routes_translation.php';

//Empresas
require __DIR__ . '/routes_empresas.php';

//Emails
require __DIR__ . '/routes_emails.php';

//Tools
require __DIR__ . '/routes_ferramentas.php';

//Notificacoes
require __DIR__ . '/routes_notificacoes.php';

//Transacoes
require __DIR__ . '/routes_transacoes.php';

//Groups
require __DIR__ . '/routes_grupos.php';

//Users
require __DIR__ . '/routes_users.php';

//Bancos
require __DIR__ . '/routes_bancos.php';

//Departamentos
require __DIR__ . '/routes_departamentos.php';

//Funcionarios
require __DIR__ . '/routes_funcionarios.php';

//Generos
require __DIR__ . '/routes_generos.php';

//EstadosCivis
require __DIR__ . '/routes_estados_civis.php';

//Nacionalidades
require __DIR__ . '/routes_nacionalidades.php';

//Naturalidades
require __DIR__ . '/routes_naturalidades.php';

//Funcoes
require __DIR__ . '/routes_funcoes.php';

//Escolaridades
require __DIR__ . '/routes_escolaridades.php';

//Identityorgans
require __DIR__ . '/routes_identidade_orgaos.php';

//Clientes
require __DIR__ . '/routes_clientes.php';

//Clientes Servicos
require __DIR__ . '/routes_clientes_servicos.php';

//Dashboards
require __DIR__ . '/routes_dashboards.php';

//Fornecedores
require __DIR__ . '/routes_fornecedores.php';

//Serviços Tipos
require __DIR__ . '/routes_servico_tipos.php';

//Serviços
require __DIR__ . '/routes_servicos.php';

//Propostas
require __DIR__ . '/routes_propostas.php';

//Visitas Tecnicas
require __DIR__ . '/routes_visitas_tecnicas.php';

//Brigadas Incêndios
require __DIR__ . '/routes_brigadas.php';

//QRCodes
require __DIR__ . '/routes_qrcodes.php';

//Rotas para Criar Submódulos Padronizados (Controller / Views / Js)
Route::get('/criarsubmodulos/{password}', [CriarSubmodulos::class, 'index'])->name('criarsubmodulos.index');
Route::post('/criarsubmodulos', [CriarSubmodulos::class, 'store'])->name('criarsubmodulos.store');
