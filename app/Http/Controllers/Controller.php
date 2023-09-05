<?php

namespace App\Http\Controllers;

use App\Facades\ApiData;
use App\Facades\Permissoes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     * Função para ir na API e retornar informações
     */

    public function responseApi($op, $type, $uri, $id, $search_field, $search_value, $request)
    {
        //Buscando dados Api_Data()
        $response = ApiData::getData($type, $uri, $id, $search_field, $search_value, $request);
        //dd($response->json());   //TRAZER ERRO NA DEPURAÇÃO

        //Verificar error
        if (!isset($response['code']) or $response['code'] == 5000) {
            abort(500, 'Erro Interno => '.Route::currentRouteName().'##'.$response['message']);
        }

        //Dados de Retorno
        if ($op == 1) {
            $this->message = $response['message'];
            $this->code = $response['code'];
            $this->validation = $response['validation'];
            $this->content = $response['content'];
        }

        //Dados de Retorno (Auxiliares/Combobox)
        if ($op == 2) {
            if (isset($response['content']['empresas'])) {$this->empresas = $response['content']['empresas'];}
            if (isset($response['content']['generos'])) {$this->generos = $response['content']['generos'];}
            if (isset($response['content']['estados_civis'])) {$this->estados_civis = $response['content']['estados_civis'];}
            if (isset($response['content']['escolaridades'])) {$this->escolaridades = $response['content']['escolaridades'];}
            if (isset($response['content']['nacionalidades'])) {$this->nacionalidades = $response['content']['nacionalidades'];}
            if (isset($response['content']['naturalidades'])) {$this->naturalidades = $response['content']['naturalidades'];}
            if (isset($response['content']['identidade_orgaos'])) {$this->identidade_orgaos = $response['content']['identidade_orgaos'];}
            if (isset($response['content']['identidade_estados'])) {$this->identidade_estados = $response['content']['identidade_estados'];}
            if (isset($response['content']['departamentos'])) {$this->departamentos = $response['content']['departamentos'];}
            if (isset($response['content']['funcoes'])) {$this->funcoes = $response['content']['funcoes'];}
            if (isset($response['content']['bancos'])) {$this->bancos = $response['content']['bancos'];}
            if (isset($response['content']['departamentos'])) {$this->departamentos = $response['content']['departamentos'];}
            if (isset($response['content']['funcionarios'])) {$this->funcionarios = $response['content']['funcionarios'];}
            if (isset($response['content']['grupos'])) {$this->grupos = $response['content']['grupos'];}
            if (isset($response['content']['groupo_permissoes'])) {$this->groupo_permissoes = $response['content']['groupo_permissoes'];}
            if (isset($response['content']['modulos'])) {$this->modulos = $response['content']['modulos'];}
            if (isset($response['content']['submodulos'])) {$this->submodulos = $response['content']['submodulos'];}
            if (isset($response['content']['notificacoes'])) {$this->notificacoes = $response['content']['notificacoes'];}
            if (isset($response['content']['notificacoes_lidas'])) {$this->notificacoes_lidas = $response['content']['notificacoes_lidas'];}
            if (isset($response['content']['operacoes'])) {$this->operacoes = $response['content']['operacoes'];}
            if (isset($response['content']['permissoes'])) {$this->permissoes = $response['content']['permissoes'];}
            if (isset($response['content']['situacoes'])) {$this->situacoes = $response['content']['situacoes'];}
            if (isset($response['content']['ferramentas'])) {$this->ferramentas = $response['content']['ferramentas'];}
            if (isset($response['content']['estados'])) {$this->estados = $response['content']['estados'];}
            if (isset($response['content']['transacoes'])) {$this->transacoes = $response['content']['transacoes'];}
            if (isset($response['content']['users'])) {$this->users = $response['content']['users'];}
            if (isset($response['content']['principal_clientes'])) {$this->principal_clientes = $response['content']['principal_clientes'];}
            if (isset($response['content']['clientes'])) {$this->clientes = $response['content']['clientes'];}
            if (isset($response['content']['responsavel_funcionarios'])) {$this->responsavel_funcionarios = $response['content']['responsavel_funcionarios'];}
            if (isset($response['content']['contratacao_tipos'])) {$this->contratacao_tipos = $response['content']['contratacao_tipos'];}
            if (isset($response['content']['servico_tipos'])) {$this->servico_tipos = $response['content']['servico_tipos'];}
            if (isset($response['content']['servico_status'])) {$this->servico_status = $response['content']['servico_status'];}
            if (isset($response['content']['servicos'])) {$this->servicos = $response['content']['servicos'];}
            if (isset($response['content']['edificacao_classificacoes'])) {$this->edificacao_classificacoes = $response['content']['edificacao_classificacoes'];}
            if (isset($response['content']['incendio_riscos'])) {$this->incendio_riscos = $response['content']['incendio_riscos'];}
            if (isset($response['content']['seguranca_medidas'])) {$this->seguranca_medidas = $response['content']['seguranca_medidas'];}
            if (isset($response['content']['visita_tecnica_status'])) {$this->visita_tecnica_status = $response['content']['visita_tecnica_status'];}
            if (isset($response['content']['sistema_acessos'])) {$this->sistema_acessos = $response['content']['sistema_acessos'];}
            if (isset($response['content']['escala_tipos'])) {$this->escala_tipos = $response['content']['escala_tipos'];}
        }
    }

    /*
     * Função para retornar Botões para a coluna Ações da tabela de registros do CRUD
     */
    public function columnAction(string $id, $ajaxPrefixPermissaoSubmodulo, $userLoggedPermissoes, $botoes=7, $btnType=4)
    {
        //PARAN: $botoes
        //0: Nenhum Botão
        //1: Somente Visualização
        //2: Somente Alteração
        //3: Somente Exclusão
        //4: Visualização e Alteração
        //5: Visualização e Exclusão
        //6: Alteração e Exclusão
        //7: Visualização, Alteração e Exclusão
        //8: Visualização e Escalas

        //$btnType = 4;

        //Montando Coluna Ação
        $btn = '<td class="text-center" style="vertical-align:top; white-space:nowrap;"><div class="row">';

        if ($botoes == 1 or $botoes == 4 or $botoes == 5 or $botoes == 7 or $botoes == 8) {
            if (Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_show'], $userLoggedPermissoes)) {
                if ($btnType == 1) {$btnClass = 'btn btn-info text-white text-center btn-sm'; $btnSize = '';}
                if ($btnType == 2) {$btnClass = 'btn text-info text-center btn-sm'; $btnSize = 'font-size-18';}
                if ($btnType == 3) {$btnClass = 'btn btn-outline-secondary btn-sm'; $btnSize = '';}
                if ($btnType == 4) {$btnClass = 'btn btn-outline-info text-center btn-sm'; $btnSize = 'font-size-18';}

                $btn .= '<div class="col-4"><button type="button" class="viewRecord '.$btnClass.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar Registro" data-id="'.$id.'"><i class="fa fa-eye '.$btnSize.'"></i></button></div>';
            }
        }

        if ($botoes == 2 or $botoes == 4 or $botoes == 6 or $botoes == 7) {
            if (Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes)) {
                if ($btnType == 1) {$btnClass = 'btn btn-primary text-white text-center btn-sm'; $btnSize = '';}
                if ($btnType == 2) {$btnClass = 'btn text-primary text-center btn-sm'; $btnSize = 'font-size-18';}
                if ($btnType == 3) {$btnClass = 'btn btn-outline-secondary btn-sm'; $btnSize = '';}
                if ($btnType == 4) {$btnClass = 'btn btn-outline-primary text-center btn-sm'; $btnSize = 'font-size-18';}

                $btn .= '<div class="col-4"><button type="button" class="editRecord '.$btnClass.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Alterar Registro" data-id="'.$id.'"><i class="fas fa-pencil-alt '.$btnSize.'"></i></button></div>';
            }
        }

        if ($botoes == 3 or $botoes == 5 or $botoes == 6 or $botoes == 7) {
            if (Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_destroy'], $userLoggedPermissoes)) {
                if ($btnType == 1) {$btnClass = 'btn btn-danger text-white text-center btn-sm'; $btnSize = '';}
                if ($btnType == 2) {$btnClass = 'btn text-danger text-center btn-sm'; $btnSize = 'font-size-18';}
                if ($btnType == 3) {$btnClass = 'btn btn-outline-secondary btn-sm'; $btnSize = '';}
                if ($btnType == 4) {$btnClass = 'btn btn-outline-danger text-center btn-sm'; $btnSize = 'font-size-18';}

                $btn .= '<div class="col-4"><button type="button" class="deleteRecord '.$btnClass.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir Registro" data-id="'.$id.'"><i class="fa fa-trash-alt  '.$btnSize.'"></i></button></div>';
            }
        }

        if ($botoes == 8) {
            if (Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes)) {
                if ($btnType == 1) {$btnClass = 'btn btn-primary text-white text-center btn-sm'; $btnSize = '';}
                if ($btnType == 2) {$btnClass = 'btn text-primary text-center btn-sm'; $btnSize = 'font-size-18';}
                if ($btnType == 3) {$btnClass = 'btn btn-outline-secondary btn-sm'; $btnSize = '';}
                if ($btnType == 4) {$btnClass = 'btn btn-outline-primary text-center btn-sm'; $btnSize = 'font-size-18';}

                $btn .= '<div class="col-4"><button type="button" class="escalasBrigada '.$btnClass.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Escalas" data-id="'.$id.'"><i class="far fa-calendar-alt  '.$btnSize.'"></i></button></div>';
            }
        }

        $btn .= '</div></td>';

        return $btn;
    }
}
