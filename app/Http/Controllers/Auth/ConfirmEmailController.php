<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ConfirmEmailController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    /**
     * Visualizar view confirm-email
     */
    public function showConfirmEmailForm()
    {
        return view('auth.confirm-email');
    }

    /**
     * Enviar código para confirmar email por e-mail
     */
    public function submitConfirmEmailForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $token1 = Str::random(4);
        session(['token1' => $token1]);

        $token2 = Str::random(4);
        session(['token2' => $token2]);

        $token3 = Str::random(4);
        session(['token3' => $token3]);

        $token4 = Str::random(4);
        session(['token4' => $token4]);

        //Enviando e-mail
        Mail::send('auth.email-confirm-email', ['email' => $request->email, 'token1' => $token1, 'token2' => $token2, 'token3' => $token3, 'token4' => $token4], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Confirm E-mail');
        });

        //Retorno para a view
        return back()->with("message", "Enviamos o código de confirmação e o link por e-mail!");
    }

    /**
     * Visualizar view code-confirm-email
     */
    public function showCodeConfirmEmaildForm($email) {
        return view('auth.code-confirm-email', ['email' => $email, 'token1' => session('token1'), 'token2' => session('token2'), 'token3' => session('token3'), 'token4' => session('token4')]);
    }

    /**
     * Resetar senha no banco
     */
    public function submitCodeConfirmEmailForm(Request $request)
    {
        $request->validate(
            [
                'token1' => 'required',
                'token2' => 'required',
                'token3' => 'required',
                'token4' => 'required'
            ],
            [
                'token1.required' => 'Requerido',
                'token2.required' => 'Requerido',
                'token3.required' => 'Requerido',
                'token4.required' => 'Requerido'
            ]
        );

        //Verificar digitação
        if (($request['token1'] == session('token1')) and ($request['token2'] == session('token2')) and ($request['token3'] == session('token3')) and ($request['token4'] == session('token4'))) {
            //Buscando dados Api_Data() - Alterar tabela users (campo user_confirmed_at)
            $this->responseApi(1, 12, 'users/confirmupdate', '', '', $request->all());

            //Operação realizada com sucesso
            if ($this->code == 2000) {
                //Redirecionar para fazer Login
                return redirect('/login')->with('message', 'Confirmação realizada com sucesso!');
            } else {
                return back()->withInput()->with('error', 'Operação não concluída. Tente novamente!');
            }
        } else {
            return back()->withInput()->with('error', 'Operação não concluída. Código inválido!');
        }
    }
}
