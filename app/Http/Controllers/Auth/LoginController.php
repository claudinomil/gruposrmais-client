<?php

namespace App\Http\Controllers\Auth;

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

    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function loginApi(Request $request)
    {
        //Validando dados
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
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

            //Se o retorno for um Error
            if (isset($response['error'])) {
                $error = $response['message'];
                return view('auth.login', compact('error'));
            }

            //Gravar access_token em ums session
            session(['access_token' => $response['access_token']]);

            //Gravar dispositivo que usuário acessou de MOBILE TABLE DESKTOP
            $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "Mobile"));
            $isTab = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet"));
            $isDesk = !$isMob && !$isTab;

            if ($isMob) {session(['access_device' => 'mobile']);}
            if ($isTab) {session(['access_device' => 'tablet']);}
            if ($isDesk) {session(['access_device' => 'desktop']);}

            //Buscar sistema_acesso_id do Usuário que acabou de se logar para redirecionar versão do Sistema (DESKTOP / MOBILE)
            //Buscando dados Api_Data() - UsuárioLogado
            $this->responseApi(1, 10, 'users/user/logged/data', '', '', '', '');

            $sistema_acesso_id = $this->content['userData']['sistema_acesso_id'];

            //FORÇANDO MOBILE PARA FAZER O CODIGODESENVOLVIMENTO''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //FORÇANDO MOBILE PARA FAZER O CODIGODESENVOLVIMENTO''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //FORÇANDO MOBILE PARA FAZER O CODIGODESENVOLVIMENTO''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //session(['access_device' => 'mobile']);
            //return redirect('mobile');
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //1: Somente Desktop
            if ($sistema_acesso_id == 1) {return redirect('dashboards');}

            //2: Somente Mobile
            if ($sistema_acesso_id == 2) {
                if ($isMob) {return redirect('Mobile');}
                if ($isTab) {return redirect('Mobile');}
                if ($isDesk) {abort(500, 'Erro Interno => Acesso somente Mobile.');}
            }

            //3: Desktop & Mobile
            if ($sistema_acesso_id == 3) {
                if ($isMob) {return redirect('Mobile');}
                if ($isTab) {return redirect('dashboards');}
                if ($isDesk) {return redirect('dashboards');}
            }
        }

        if ($this->code == 2004) {
            $email = $request->email;

            //Ir para a view de confirmação
            return redirect('/confirm-email')->with('email', $email);
        }

        if ($this->code == 2005) {
            $error = 'E-mail não encontrado!';

            //Retorno para a view
            return view('auth.login', compact('error'));
        }
    }

    public function logout()
    {
        //Buscando dados Api_Data() - Fazer Logout
        $this->responseApi(1, 7, '', '', '', '', '');

        return view('welcome');
    }
}
