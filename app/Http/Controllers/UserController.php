<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    //Variaveis de Retorno da API
    public $message;
    public $code;
    public $validation;
    public $content;

    //Dados Auxiliares
    public $empresas;
    public $grupos;
    public $situacoes;
    public $funcionarios;
    public $sistema_acessos;

    public function __construct()
    {
        $this->middleware('check-permissao:users_list', ['only' => ['index', 'search']]);
        $this->middleware('check-permissao:users_create', ['only' => ['create', 'store']]);
        $this->middleware('check-permissao:users_show', ['only' => ['show']]);
        $this->middleware('check-permissao:users_edit', ['only' => ['edit', 'update']]);
        $this->middleware('check-permissao:users_destroy', ['only' => ['destroy']]);

        $this->middleware('check-permissao:users_list|users_perfil_show', ['only' => ['profiledata']]);
        $this->middleware('check-permissao:users_perfil_edit', ['only' => ['uploadavatar', 'editpassword', 'editemail', 'editmodestyle']]);
    }

    public function index(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Lista de Registros
            $this->responseApi(1, 1, 'users', '', '', '', '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('avatar', function ($row) {
                        $retorno = "<div class='text-center'>";
                        $retorno .= "<img src='".asset($row['avatar'])."' alt='' class='img-thumbnail rounded-circle avatar-sm'>";
                        $retorno .= "<br>";
                        $retorno .= "<a href='#' data-bs-toggle='modal' data-bs-target='.modal-profile' onclick='userProfileData(1, ".$row['id'].");'><span class='bg-success badge'><i class='bx bx-user font-size-16 align-middle me-1'></i>Perfil</span></a>";
                        $retorno .= "</div>";

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes']);
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno User');
            }
        } else {
            //pegando o empresa_id
            $empresa_id = session('userLogged_empresa_id');

            //Buscando dados Api_Data() - Auxiliary Tables (Combobox)
            $this->responseApi(2, 10, 'users/auxiliary/tables/'.$empresa_id, '', '', '', '');

            return view('users.index', [
                'empresas' => $this->empresas,
                'grupos' => $this->grupos,
                'situacoes' => $this->situacoes,
                'funcionarios' => $this->funcionarios,
                'sistema_acessos' => $this->sistema_acessos
            ]);
        }
    }

    public function create(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
    }

    public function store(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Incluir Registro
            $this->responseApi(1, 4, 'users', '', '', '', $request->all());

            //Registro criado com sucesso
            if ($this->code == 2010) {
                return response()->json(['success' => $this->message, 'content' => $this->content]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4060) { //Error
                return response()->json(['error' => $this->message]);
            } else {
                abort(500, 'Erro Interno User');
            }
        }
    }

    public function show(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'users', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno User');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'users', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->content]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else {
                abort(500, 'Erro Interno User');
            }
        }
    }

    public function update(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 5, 'users', $id, '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2020) { //Falha na validação dos dados
                return response()->json(['error_validation' => $this->validation]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error_not_found' => $this->message]);
            } else if ($this->code == 4060) { //Error
                return response()->json(['error' => $this->message]);
            } else {
                abort(500, 'Erro Interno User');
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Pegar email para deletar na Api (API Admin)'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 2, 'users', $id, '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                $email = $this->content['email'];
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error' => $this->message]);
            } else {
                abort(500, 'Erro Interno User');
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Buscando dados Api_Data() - Deletar Registro
            $this->responseApi(1, 6, 'users', $id, '', '', '');

            //Registro deletado com sucesso
            if ($this->code == 2000) {
                return response()->json(['success' => $this->message]);
            } else if ($this->code == 2040) { //Registro não excluído - pertence a relacionamento com outra(s) tabela(s)
                return response()->json(['error' => $this->message]);
            } else if ($this->code == 4040) { //Registro não encontrado
                return response()->json(['error' => $this->message]);
            } else {
                abort(500, 'Erro Interno User');
            }
        }
    }

    public function search(Request $request, $field = '', $value = '')
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Buscando dados Api_Data() - Pesquisar Registros
            $this->responseApi(1, 3, 'users', '', $field, $value, '');

            //Dados recebidos com sucesso
            if ($this->code == 2000) {
                $allData = DataTables::of($this->content)
                    ->addIndexColumn()
                    ->editColumn('avatar', function ($row) {
                        $retorno = "<div class='text-center'>";
                        $retorno .= "<img src='".asset($row['avatar'])."' alt='' class='img-thumbnail rounded-circle avatar-sm'>";
                        $retorno .= "<br>";
                        $retorno .= "<a href='#' data-bs-toggle='modal' data-bs-target='.modal-profile' onclick='userProfileData(1, ".$row['id'].");'><span class='bg-success badge'><i class='bx bx-user font-size-16 align-middle me-1'></i>Perfil</span></a>";
                        $retorno .= "</div>";

                        return $retorno;
                    })
                    ->addColumn('action', function ($row, Request $request) {
                        return $this->columnAction($row['id'], $request['ajaxPrefixPermissaoSubmodulo'], $request['userLoggedPermissoes']);
                    })
                    ->rawColumns(['action'])
                    ->escapeColumns([])
                    ->make(true);

                return $allData;
            } else {
                abort(500, 'Erro Interno User');
            }
        } else {
            return view('users.index');
        }
    }

    public function profiledata(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $id = $_GET['id'];

            //Buscando dados Api_Data() - Registro pelo id
            $this->responseApi(1, 10, 'users/profiledata/' . $id, '', '', '', '');

            //Registro recebido com sucesso
            if ($this->code == 2000) {
                return json_encode($this->content);
            } else if ($this->code == 4040) { //Registro não encontrado
                echo 'Registro não encontrado.';
            } else {
                echo 'Erro Interno User.';
            }
        }
    }

    public function uploadavatar(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Variavel controle
            $error = false;

            //Avatar padrão do Sistema
            $avatar = "build/assets/images/users/avatar-0.png";

            //Verificando e fazendo Upload do Avatar novo
            if ($request->hasFile('avatar_file')) {
                //user_id
                $id = $request['upload_avatar_user_id'];

                //buscar dados formulario
                $arquivo_tmp = $_FILES["avatar_file"]["tmp_name"];
                $arquivo_real = $_FILES["avatar_file"]["name"];
                $arquivo_real = utf8_decode($arquivo_real);
                $arquivo_type = $_FILES["avatar_file"]["type"];
                $arquivo_size = $_FILES['avatar_file']['size'];

                if ($arquivo_type == 'image/jpg' or $arquivo_type == 'image/jpeg' or $arquivo_type == 'image/png') {
                    if (copy($arquivo_tmp, "build/assets/images/users/$arquivo_real")) {
                        if (file_exists("build/assets/images/users/" . $arquivo_real)) {
                            //apagar foto no diretorio
                            if (file_exists('build/assets/images/users/avatar-' . $id . '.png')) {
                                unlink('build/assets/images/users/avatar-' . $id . '.png');
                            }
                            if (file_exists('build/assets/images/users/avatar-' . $id . '.jpg')) {
                                unlink('build/assets/images/users/avatar-' . $id . '.jpg');
                            }
                            if (file_exists('build/assets/images/users/avatar-' . $id . '.jpeg')) {
                                unlink('build/assets/images/users/avatar-' . $id . '.jpeg');
                            }

                            //Gravar novo
                            $avatar = "build/assets/images/users/avatar-" . $id . '.' . pathinfo($arquivo_real, PATHINFO_EXTENSION);
                            $de = "build/assets/images/users/$arquivo_real";
                            $pa = $avatar;

                            try {
                                rename($de, $pa);
                            } catch (\Exception $e) {
                                $error = true;
                            }
                        }
                    }
                }
            }

            if (!$error) {
                //Buscando dados Api_Data() - Alterar Registro
                $data = array();
                $data['avatar'] = $avatar;
                $this->responseApi(1, 11, 'users/updateavatar/' . $id, '', '', '', $data);

                echo $this->message;
            } else {
                echo 'Imagem (Nome, Tamanho ou Tipo) inválida.';
            }
        }
    }

    public function editpassword(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //user_id
            $id = $request['edit_password_user_id'];

            //password
            $request['password'] = Hash::make($request['new_password']);

            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 11, 'users/editpassword/' . $id, '', '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                $message = $this->message;
            } else if ($this->code == 2020) { //Falha na validação dos dados
                $message = $this->message;
            } else if ($this->code == 4040) { //Registro não encontrado
                $message = $this->message;
            } else {
                $message = 'Erro Interno User';
            }

            echo $message;
        }
    }

    public function editemail(Request $request)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //user_id
            $id = $request['edit_email_user_id'];

            //email
            $request['email'] = $request['new_email'];

            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 11, 'users/editemail/' . $id, '', '', '', $request->all());

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                $message = $this->message;
            } else if ($this->code == 2020) { //Falha na validação dos dados
                $message = $this->message;
            } else if ($this->code == 4040) { //Registro não encontrado
                $message = $this->message;
            } else {
                $message = 'Erro Interno User';
            }

            echo $message;
        }
    }

    public function editmodestyle(Request $request, $mode, $style, $id)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            //Data
            $data = array();
            $data['layout_mode'] = $mode;
            $data['layout_style'] = $style;

            //Buscando dados Api_Data() - Alterar Registro
            $this->responseApi(1, 11, 'users/editmodestyle/'.$id.'/'.session('userLogged_empresa_id'), '', '', '', $data);

            //Registro alterado com sucesso
            if ($this->code == 2000) {
                $message = $this->message;
            } else if ($this->code == 2020) { //Falha na validação dos dados
                $message = $this->message;
            } else if ($this->code == 4040) { //Registro não encontrado
                $message = $this->message;
            } else {
                $message = 'Erro Interno User';
            }

            echo $message;
        }
    }

    public function escolher_empresa($empresa_id)
    {
        if (!SuporteFacade::setUserConfiguracao($empresa_id)) {
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
}
