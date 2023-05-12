<?php

namespace App\Http\Controllers;

use App\Facades\Permissoes;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    //Variáveis de dashboards
    public $dashboardsUsers = 0;
    public $dashboardsFuncionarios = 0;
    public $dashboardsClientes = 0;
    public $dashboardsPropostas = 0;
    public $dashboardsVisitasTecnicas = 0;

    public function __construct()
    {
        $this->middleware('check-permissao:dashboards_list', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        //Versão Desktop
        if (session('access_device') == 'desktop') {
            //Alterar variaveis de dashboards para visualização de acordo com a permissão
            if (Permissoes::permissao(['users_list'], $request['userLoggedPermissoes'])) {
                $this->dashboardsUsers = 1;
            }
            if (Permissoes::permissao(['funcionarios_list'], $request['userLoggedPermissoes'])) {
                $this->dashboardsFuncionarios = 1;
            }
            if (Permissoes::permissao(['clientes_list'], $request['userLoggedPermissoes'])) {
                $this->dashboardsClientes = 1;
            }

            //Montando $id (Mandar os acessos aos dashboards no lugar do id separados por "_")
            $id = $this->dashboardsUsers . '_' . $this->dashboardsFuncionarios . '_' . $this->dashboardsClientes;

            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 8, 'dashboards', $id, '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                //chamar view
                return view('dashboards.index', [
                    'content' => $this->content,
                    'dashboardsUsers' => $this->dashboardsUsers,
                    'dashboardsFuncionarios' => $this->dashboardsFuncionarios,
                    'dashboardsClientes' => $this->dashboardsClientes
                ]);
            } else {
                abort(500, 'Erro Interno Dashboard');
            }
        }

        //Versão Mobile
        if (session('access_device') != 'desktop') {
            //Alterar variaveis de dashboards para visualização de acordo com a permissão
            if (Permissoes::permissao(['clientes_list'], $request['userLoggedPermissoes'])) {
                $this->dashboardsClientes = 1;
            }
            if (Permissoes::permissao(['propostas_list'], $request['userLoggedPermissoes'])) {
                $this->dashboardsPropostas = 1;
            }
            if (Permissoes::permissao(['visitas_tecnicas_list'], $request['userLoggedPermissoes'])) {
                $this->dashboardsVisitasTecnicas = 1;
            }

            //Montando $id (Mandar os acessos aos dashboards no lugar do id separados por "_")
            $id = $this->dashboardsClientes . '_' . $this->dashboardsPropostas . '_' . $this->dashboardsVisitasTecnicas;

            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 8, 'dashboards/Mobile', $id, '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                //chamar view
                return view('Mobile.Mobile-dashboards', [
                    'content' => $this->content,
                    'dashboardsClientes' => $this->dashboardsClientes,
                    'dashboardsPropostas' => $this->dashboardsPropostas,
                    'dashboardsVisitasTecnicas' => $this->dashboardsVisitasTecnicas
                ]);
            } else {
                abort(500, 'Erro Interno Dashboard');
            }
        }
    }
}
