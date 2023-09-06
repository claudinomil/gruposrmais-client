<?php

namespace App\Services;

use App\Facades\ApiData;
use App\Facades\QRCodeFacade;

class SuporteService
{
    /*
     * Gravar Sessão de onde o Usuário está acessando 'access_device' (mobile, tablet, desktop)
     */
    public function setUserAcessDevice()
    {
        try {
            $acess_device = $this->getDevice();
            session(['access_device' => $acess_device]);
        } catch (\Exception $e) {
            session(['access_device' => 'desktop']);
        }
    }

    /*
     * Retornar de onde está vindo o acesso (mobile, tablet, desktop)
     */
    public function getDevice()
    {
        $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
        $isTab = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet"));
        $isDesk = !$isMob && !$isTab;

        if ($isMob) {return 'mobile';}
        if ($isTab) {return 'tablet';}
        if ($isDesk) {return 'desktop';}
    }

    /*
     * Buscar dados de Configuração do Usuário logado (Conforme Empresa escolhida)
     */
    public function setUserConfiguracao($empresa_id)
    {
        try {
            //Buscando dados Api_Data() - UsuárioLogado
            $response = ApiData::getData(10, 'users/user/logged/data/'.$empresa_id, '', '', '', '');

            //Gravar Session com dados de Configuração
            session(['userLogged_empresa_id' => $response['content']['userData']['empresa_id']]);
            session(['userLogged_empresa' => $response['content']['userData']['empresa']]);
            session(['userLogged_grupo_id' => $response['content']['userData']['grupo_id']]);
            session(['userLogged_situacao_id' => $response['content']['userData']['situacao_id']]);
            session(['userLogged_sistema_acesso_id' => $response['content']['userData']['sistema_acesso_id']]);
            session(['userLogged_layout_mode' => $response['content']['userData']['layout_mode']]);
            session(['userLogged_layout_style' => $response['content']['userData']['layout_style']]);

            //Verificar Dado de Configuração do Usuário - empresa_id=0: Usuário sem Configurações de Empresa
            if (session('userLogged_empresa_id') == 0) {abort(500, 'Permissão Negada.<br>Usuário sem acesso para essa Empresa.');}

            //Verificar Dado de Configuração do Usuário - grupo_id=0: Usuário sem Grupo
            if (session('userLogged_grupo_id') == 0) {abort(500, 'Permissão Negada.<br>Usuário sem Grupo de Acesso.');}

            //Verificar Dado de Configuração do Usuário - situacao_id=0: Usuário sem Situação
            if (session('userLogged_situacao_id') == 0) {abort(500, 'Permissão Negada.<br>Usuário sem Situação.');}

            //Verificar Dado de Configuração do Usuário - situacao_id=2: Usuário Bloqueado
            if (session('userLogged_situacao_id') == 2) {abort(500, 'Permissão Negada.<br>Usuário Bloqueado.');}

            //Verificar Dado de Configuração do Usuário - sistema_acesso_id=0: Usuário sem Sistema de Acesso
            if (session('userLogged_sistema_acesso_id') == 0) {abort(500, 'Permissão Negada.<br>Usuário sem Sistema de Acesso.');}

            //Verificar Dado de Configuração do Usuário - layout_mode=0: Usuário sem Layout Mode
            if (session('userLogged_layout_mode') == 0) {abort(500, 'Permissão Negada.<br>Usuário sem Layout Mode.');}

            //Verificar Dado de Configuração do Usuário - layout_style=0: Usuário sem Layout Style
            if (session('userLogged_layout_style') == 0) {abort(500, 'Permissão Negada.<br>Usuário sem Layout Style.');}

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /*
     * Gerar QRCode para Cliente Serviço
     * Mostra dados do Cliente Serviço, Escala e Rondas
     */
    public function getClienteServicoQRCodeInformacoes($cliente_servico_id)
    {
        //Buscando dados Api_Data() - Dados para o QRCode
        $response = ApiData::getData(10, 'qrcodes/clientes_servicos/qrcode_dados/'.$cliente_servico_id, '', '', '', '');

        if ($response['content'] !== null) {
            $data = $response['content'][0];

            $label_text = 'Informações';
            $code_content = env('APP_URL') . '/qrcodes/clientes_servicos/qrcode_informacoes/' . $data['id'];
            $save_destino = 'build/assets/qrcodes/clientes_servicos/';
            $save_name = 'qrcode_informacoes_' . $data['id'] . '.png';

            QRCodeFacade::label($label_text)->logo()->code($code_content)->save($save_destino, $save_name);
        }
    }

    /*
     * Gerar QRCode para Cliente Serviço
     * Registra Presença do Brigadista no local
     */
    public function getClienteServicoQRCodeBrigadaPresenca($cliente_servico_id)
    {
        //Buscando dados Api_Data() - Dados para o QRCode
        $response = ApiData::getData(10, 'qrcodes/clientes_servicos/qrcode_dados/'.$cliente_servico_id, '', '', '', '');

        if ($response['content'] !== null) {
            $data = $response['content'][0];

            $label_text = 'Presença';
            $code_content = env('APP_URL') . '/qrcodes/clientes_servicos/qrcode_brigada_presenca/' . $data['id'];
            $save_destino = 'build/assets/qrcodes/clientes_servicos/';
            $save_name = 'qrcode_brigada_presenca_' . $data['id'] . '.png';

            QRCodeFacade::label($label_text)->logo()->code($code_content)->save($save_destino, $save_name);
        }
    }
}
