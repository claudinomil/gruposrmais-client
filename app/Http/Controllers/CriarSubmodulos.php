<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CriarSubmodulos extends Controller
{
    public $error = '';

    public function index($password)
    {
        if ($password == 'claudino1971') {
            return $this->create('', '');
        } else {
            return 'Acesso Negado!!!';
        }
    }

    public function create($success='', $errors='')
    {
        return view('criarsubmodulos.create', compact('success', 'errors'));
    }

    public function store(Request $request)
    {
        $referenciaNomePlural = '';
        $referenciaNomeSingular = '';

        $submoduloNomePlural = '';
        $submoduloNomeSingular = '';

        if (isset($request['referencia_name_plural'])) {
            $referenciaNomePlural = $request['referencia_name_plural'];
        }
        if (isset($request['referencia_name_singular'])) {
            $referenciaNomeSingular = $request['referencia_name_singular'];
        }
        if (isset($request['submodulo_name_plural'])) {
            $submoduloNomePlural = $request['submodulo_name_plural'];
        }
        if (isset($request['submodulo_name_singular'])) {
            $submoduloNomeSingular = $request['submodulo_name_singular'];
        }

        //Verificar errors''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //campos vazios
        if ($referenciaNomePlural == '') {
            $this->error = 'SIM';

            return $this->create('', 'Nome Referência - Plural (Não pode ficar em branco)');
        }

        if ($referenciaNomeSingular == '') {
            $this->error = 'SIM';

            return $this->create('', 'Nome Referência - Singular (Não pode ficar em branco)');
        }

        if ($submoduloNomePlural == '') {
            $this->error = 'SIM';

            return $this->create('', 'Nome Submódulo - Plural (Não pode ficar em branco)');
        }

        if ($submoduloNomeSingular == '') {
            $this->error = 'SIM';

            return $this->create('', 'Nome Submódulo - Singular (Não pode ficar em branco)');
        }

        //Verificar se já existe o Controller
        if (file_exists('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php')) {
            $this->error = 'SIM';

            return $this->create('', $submoduloNomeSingular . 'Controller já Existe.');
        }

        if ($this->error == '') {
            //CONTROLLER''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Criando Controller igual ao ReferenciaController
            copy('../app/Http/Controllers/'.$referenciaNomeSingular.'Controller.php', '../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php');

            //Substituindo no Controller novo
            if (file_exists('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php')) {
                $this->substituir('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //VIEWS'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Criando Pasta para views
            if (!is_dir('../resources/views/' . strtolower($submoduloNomePlural))) {
                mkdir(strtolower('../resources/views/' . strtolower($submoduloNomePlural)));
            }


            if (is_dir('../resources/views/' . strtolower($submoduloNomePlural))) {
                //Criando Views igual as views do Referencia
                copy('../resources/views/'.strtolower($referenciaNomePlural).'/form.blade.php', '../resources/views/' . strtolower($submoduloNomePlural) . '/form.blade.php');
                copy('../resources/views/'.strtolower($referenciaNomePlural).'/index.blade.php', '../resources/views/' . strtolower($submoduloNomePlural) . '/index.blade.php');
            }

            //Substituindo nas Views novas
            if (file_exists('../resources/views/' . strtolower($submoduloNomePlural) . '/form.blade.php')) {
                $this->substituir('../resources/views/' . strtolower($submoduloNomePlural) . '/form.blade.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../resources/views/' . strtolower($submoduloNomePlural) . '/form.blade.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../resources/views/' . strtolower($submoduloNomePlural) . '/form.blade.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../resources/views/' . strtolower($submoduloNomePlural) . '/form.blade.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }

            if (file_exists('../resources/views/' . strtolower($submoduloNomePlural) . '/index.blade.php')) {
                $this->substituir('../resources/views/' . strtolower($submoduloNomePlural) . '/index.blade.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../resources/views/' . strtolower($submoduloNomePlural) . '/index.blade.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../resources/views/' . strtolower($submoduloNomePlural) . '/index.blade.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../resources/views/' . strtolower($submoduloNomePlural) . '/index.blade.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //SCRIPTS'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Criando js igual ao js do Referencia
            copy('../resources/assets_template/js/scripts_'.strtolower($referenciaNomePlural).'.js', '../resources/assets_template/js/scripts_' . strtolower($submoduloNomePlural) . '.js');

            //Substituindo no Script novo
            if (file_exists('../resources/assets_template/js/scripts_' . strtolower($submoduloNomePlural) . '.js')) {
                $this->substituir('../resources/assets_template/js/scripts_' . strtolower($submoduloNomePlural) . '.js', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../resources/assets_template/js/scripts_' . strtolower($submoduloNomePlural) . '.js', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../resources/assets_template/js/scripts_' . strtolower($submoduloNomePlural) . '.js', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../resources/assets_template/js/scripts_' . strtolower($submoduloNomePlural) . '.js', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //ROUTE'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Criando Route igual ao routes_referencia
            copy('../routes/routes_'.strtolower($referenciaNomePlural).'.php', '../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php');

            //Substituindo no route novo
            if (file_exists('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php')) {
                $this->substituir('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return $this->create('Criado com sucesso!!!', '');
        }
    }

    public function substituir($file, $stringSearch, $stringReplace)
    {
        //Open para ler e modificar
        $fh = fopen($file, 'r+');
        $dados = fread($fh, filesize($file));
        $new_data = str_replace($stringSearch, $stringReplace, $dados);
        fclose($fh);

        //Open de escrever
        $fh = fopen($file, 'r+');
        fwrite($fh, $new_data);
        fclose($fh);
    }
}
