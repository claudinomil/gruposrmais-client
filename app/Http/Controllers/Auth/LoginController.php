<?php

namespace App\Http\Controllers\Auth;

use App\Facades\SuporteFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    public function login()
    {
        $empresas = Http::get(env('PASSPORT_API_URL') . 'empresas_grupo_srmais')->json();

        return view('auth.login', compact('empresas'));
    }

    public function loginApi(Request $request)
    {
        //Validando dados
        $request->validate(
            [
                'empresa_id' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'empresa_id.required' => 'Escolha a Empresa.',
                'email.required' => 'Digite seu E-mail.',
                'email.email' => 'E-mail inválido',
                'password.required' => 'Digite sua Senha.'
            ]
        );

        //Buscando dados Api_Data() - Verificar se email já foi confirmado
        $this->responseApi(1, 10, 'users/confirm/' . $request->email, '', '', '', '');

        if ($this->code == 2000) {
            //CHAMADA DO PASSPORT COM 'grant_type' => 'password'''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            /*
             * Criar Client na API: php artisan passport:client --password
             * Não precisa de Authorization, envia direto as credenciais
             * Vai na API e retorna o Access Token
             */

            $response = Http::post(env('PASSPORT_API_URL') . 'oauth/token', [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'username' => $request['email'],
                'password' => $request['password'],
                'scope' => 'claudino',
            ]);
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //dd($response->json());

            //Se o retorno for um Error
            if (isset($response['error'])) {
                $error = $response['message'];
                $empresas = Http::get(env('PASSPORT_API_URL') . 'empresas_grupo_srmais')->json();

                return view('auth.login', compact('error', 'empresas'));
            }

            //Gravar access_token em ums session
            session(['access_token' => $response['access_token']]);

            //Ver de onde está acessando 'access_device' (mobile, tablet, desktop)
            SuporteFacade::setUserAcessDevice();

            //Buscar dados de Configuração do Usuário logado (Conforme Empresa escolhida)
            if (!SuporteFacade::setUserConfiguracao($request['empresa_id'])) {
                abort(500, 'Erro Interno => Acesso/Configuração.');
            } else {
                //Verificar sistema_acesso_id do Usuário que acabou de se logar para redirecionar versão do Sistema (DESKTOP / MOBILE)
                //1: Somente Desktop
                if (session('userLogged_sistema_acesso_id') == 1) {return redirect('dashboards');}

                //2: Somente Mobile
                if (session('userLogged_sistema_acesso_id') == 2) {
                    if (session('access_device') == 'mobile') {return redirect('Mobile');}
                    if (session('access_device') == 'tablet') {return redirect('Mobile');}
                    if (session('access_device') == 'desktop') {abort(500, 'Erro Interno => Acesso somente Mobile.');}
                }

                //3: Desktop & Mobile
                if (session('userLogged_sistema_acesso_id') == 3) {
                    if (session('access_device') == 'mobile') {return redirect('Mobile');}
                    if (session('access_device') == 'tablet') {return redirect('dashboards');}
                    if (session('access_device') == 'desktop') {return redirect('dashboards');}
                }
            }
        }

        //E-mail não confirmado
        if ($this->code == 2004) {
            $email = $request->email;

            //Ir para a view de confirmação
            return redirect('/confirm-email')->with('email', $email);
        }

        //E-mail não encontrado
        if ($this->code == 2005) {
            $error = 'E-mail não encontrado!';

            //Retorno para a view
            $empresas = Http::get(env('PASSPORT_API_URL') . 'empresas_grupo_srmais')->json();
            return view('auth.login', compact('error', 'empresas'));
        }
    }

    public function logout()
    {
        //Buscando dados Api_Data() - Fazer Logout
        $this->responseApi(1, 7, '', '', '', '', '');

        return view('welcome');
    }
}
