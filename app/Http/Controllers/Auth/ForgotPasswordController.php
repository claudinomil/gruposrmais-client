<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    /**
     * Visualizar view forgot-password
     */
    public function showForgetPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Enviar link para redefinir senha por e-mail
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $token = Str::random(64);

        //Buscando dados Api_Data() - Verificar se Usuário existe
        $this->responseApi(1, 10, 'users/exist/'.$request->email, '', '', '');

        if ($this->content == 1) {
            //Buscando dados Api_Data() - Gravar operação na tabela password_resets
            $this->responseApi(1, 4, 'password_resets/' . $token, '', '', $request->all());

            //Registro criado com sucesso
            if ($this->code == 2010) {
                //Enviando e-mail
                Mail::send('auth.email-forgot-password', ['token' => $token], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });

                //Retorno para a view
                return back()->with('message', 'Enviamos o link de redefinição de senha por e-mail!');
            } else {
                abort(500, 'Erro Interno Group');
            }
        } else {
            //Retorno para a view
            return back()->with('error', 'E-mail não encontrado!');
        }
    }

    /**
     * Visualizar view reset-password
     */
    public function showResetPasswordForm($token) {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Resetar senha no banco
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        //Buscando dados Api_Data() - Fazer verificação na tabela password_resets
        $this->responseApi(1, 4, 'password_resets_confirm', '', '', $request->all());

        //Registro confirmado
        if ($this->code == 2000) {
            //Buscando dados Api_Data() - Alterar tabela users & Deletar registro na tabela password_resets
            $this->responseApi(1, 4, 'password_resets_update_delete', '', '', $request->all());

            //Operações realizadas com sucesso
            if ($this->code == 2000) {
                //Redirecionar para fazer Login
                return redirect('/login')->with('message', 'Sua senha foi mudada!');
            } else {
                return back()->withInput()->with('error', 'Operação não concluída. Tente novamente!');
            }
        } else {
            return back()->withInput()->with('error', 'Token inválido!');
        }
    }
}
