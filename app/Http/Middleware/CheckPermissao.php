<?php

namespace App\Http\Middleware;

use App\Facades\ApiData;
use App\Facades\Breadcrumb;
use App\Facades\Permissoes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CheckPermissao
{
    /*
     * Checa se o usuário tem as permissões necessárias para o método
     * Grava os dados do Usuário logado (somente ao entrar no método "index" para evitar que faça várias vezes)
     * Aproveitando e gravar od dados para Breadcrumb (somente ao entrar no método "index" para evitar que faça várias vezes)
     */
    public function handle(Request $request, Closure $next, $permissoes)
    {
        //Metodo do Controller de onde foi chamado
        $controllerMethod = $request->route()->getActionMethod();

        //Recebe permissoes que são necessarias para acesso
        $permissoes = explode('|', $permissoes);

        //Monta array com permissões
        $arrayPermissoes = array();
        foreach ($permissoes as $permissao) {
            $arrayPermissoes[] = $permissao;
        }

        //Submodulo (Usado para comparação na busca na API do Submódulo que o Usuário entrou)
        $searchSubmodulo = substr($request->route()->getPrefix(), 1);

        //Se $searchSubmodulo for vazio buscamos o último submodulo que entrou pelo Breadcrumb
        //Pode ser vazio por alguma rota ajax. Ex.: profiledata
        if ($searchSubmodulo == '') {
            $ultSubmodulo = Breadcrumb::getPreviousPageRoute();
            $ultSubmodulo = explode('.', $ultSubmodulo);
            $searchSubmodulo = $ultSubmodulo[0];
        }

        //Buscando dados Usuario/Permissões/Configurações/Ajax CRUD
        $response = ApiData::getData(0, $searchSubmodulo, '', '', '', '');
        //dd($response->json());   //TRAZER ERRO NA DEPURAÇÃO

        if (isset($response['content'])) {
            $userLoggedData = $response['content']['userData']; //Dados do Usuário Logado
            $userLoggedEmpresas = $response['content']['userEmpresas']; //Empresas do Usuário Logado
            $userLoggedPermissoes = $response['content']['userPermissoes']; //Permissões do Usuário Logado
            $userLoggedMenuModulos = $response['content']['menuModulos']; //Módulos Menu
            $userLoggedMenuSubmodulos = $response['content']['menuSubmodulos']; // Submódulos Menu
            $userLoggedFerramentas = $response['content']['ferramentas']; //Ferramentas
            $userLoggedUnreadNotificacoes = $response['content']['notificacoes']; //Notificações não lidas pelo Usuário logado
            $ajaxPrefixPermissaoSubmodulo = $response['content']['ajaxPrefixPermissaoSubmodulo'][0]['prefix_permissao']; //Variavel prefix_permissao do Submodulo
            $ajaxNameSubmodulo = $response['content']['ajaxNameSubmodulo'][0]['name']; //Variavel name do Submodulo
            $ajaxNameFormSubmodulo = 'frm_' . $ajaxPrefixPermissaoSubmodulo;
            $ajaxNamesFieldsSubmodulo = $response['content']['ajaxNamesFieldsSubmodulo']; //Array com os nomes dos campos da tabela
            $layouts_modes = $response['content']['layouts_modes']; //Layouts Modes
            $layouts_styles = $response['content']['layouts_styles']; //Layouts Styles
        } else {
            if ($request->ajax()) {
                return response()->json(['error_permissao' => 'Permissão Negada']);
            } else {
                abort(403, 'Permissão Negada');
            }
        }

        //Verificar Permissao
        if (!Permissoes::permissao($arrayPermissoes, $userLoggedPermissoes)) {
            if ($request->ajax()) {
                return response()->json(['error_permissao' => 'Permissão Negada']);
            } else {
                abort(403, 'Permissão Negada');
            }
        }

        //Colocando dados no Request
        $request['userLoggedData'] = $userLoggedData;
        $request['userLoggedPermissoes'] = $userLoggedPermissoes;
        $request['ajaxPrefixPermissaoSubmodulo'] = $ajaxPrefixPermissaoSubmodulo;

        //Gravar as Sessões de Breadcrumb
        Breadcrumb::sessionsBreadcrumb();

        //Passando variaveis para todas as views
        View::share([
            'controllerMethod' => $controllerMethod,
            'userLoggedData' => $userLoggedData,
            'userLoggedEmpresas' => $userLoggedEmpresas,
            'userLoggedPermissoes' => $userLoggedPermissoes,
            'userLoggedMenuModulos' => $userLoggedMenuModulos,
            'userLoggedMenuSubmodulos' => $userLoggedMenuSubmodulos,
            'userLoggedFerramentas' => $userLoggedFerramentas,
            'userLoggedUnreadNotificacoes' => $userLoggedUnreadNotificacoes,
            'ajaxPrefixPermissaoSubmodulo' => $ajaxPrefixPermissaoSubmodulo,
            'ajaxNameSubmodulo' => $ajaxNameSubmodulo,
            'ajaxNameFormSubmodulo' => $ajaxNameFormSubmodulo,
            'ajaxNamesFieldsSubmodulo' => $ajaxNamesFieldsSubmodulo,
            'layouts_modes' => $layouts_modes,
            'layouts_styles' => $layouts_styles
        ]);

        //Retornando
        return $next($request);
    }
}
