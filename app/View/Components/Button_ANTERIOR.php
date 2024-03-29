<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button_ANTERIOR extends Component
{
    public $op;
    public $type;
    public $btnCor;
    public $class;
    public $dataBsToggle;
    public $dataBsPlacement;
    public $dataId;
    public $title;
    public $imageAwesome;
    public $label;

    public function __construct($op = NULL, $type = NULL, $btnCor = NULL, $class = NULL, $dataBsToggle = NULL, $dataBsPlacement = NULL, $dataId = NULL, $title = NULL, $imageAwesome = NULL, $label = NULL)
    {
        $this->op = $op;
        $this->type = $type;
        $this->btnCor = $btnCor;
        $this->class = $class;
        $this->dataBsToggle = $dataBsToggle;
        $this->dataBsPlacement = $dataBsPlacement;
        $this->dataId = $dataId;
        $this->title = $title;
        $this->imageAwesome = $imageAwesome;
        $this->label = $label;
    }

    public function render()
    {





//        FAZER COMPARAÇÃO EM TODOS
//
//    EX.: if ($this->type !== NULL) {$this->type = "button";}
//
//
//    DEIXAR OS PADRÕES COMO ESTÃO RETIRANDO APENAS AS CLASSES DE EDIÇÃO (ENVIANDO PELO BOTAO)
//
//        crudAlterarRegistro
//        crudExcluirRegistro
//        crudCancelarOperacao
//        crudConfirmarOperacao





        //Botão Custom
        if ($this->op == 0) {}

        //Botão Adicionar Registro (CRUD)
        if ($this->op == 1) {
            $this->type = "button";
            $this->btnCor = "success";
            $this->class = "btn btn-".$this->btnCor." waves-effect btn-label waves-light";
            $this->dataBsToggle = "tooltip";
            $this->dataBsPlacement = "top";
            $this->dataId = "0";
            $this->title = 'Adicionar Registro';
            $this->imageAwesome = "bx bx-plus label-icon";
            $this->label = 'Adicionar';
        }

        //Botão Alterar Registro (CRUD)
        if ($this->op == 2) {
            $this->type = "button";
            $this->btnCor = "primary";
            $this->class = "btn btn-".$this->btnCor." waves-effect btn-label waves-light crudAlterarRegistro";
            $this->dataBsToggle = "tooltip";
            $this->dataBsPlacement = "top";
            $this->dataId = "0";
            $this->title = 'Alterar Registro';
            $this->imageAwesome = "fas fa-pencil-alt label-icon";
            $this->label = 'Alterar';
        }

        //Botão Excluir Registro (CRUD)
        if ($this->op == 3) {
            $this->type = "button";
            $this->btnCor = "danger";
            $this->class = "btn btn-".$this->btnCor." waves-effect btn-label waves-light crudExcluirRegistro";
            $this->dataBsToggle = "tooltip";
            $this->dataBsPlacement = "top";
            $this->dataId = "0";
            $this->title = 'Excluir Registro';
            $this->imageAwesome = "fa fa-trash-alt label-icon";
            $this->label = 'Excluir';
        }

        //Botão Cancelar Operação (CRUD)
        if ($this->op == 4) {
            $this->type = "button";
            $this->btnCor = "secondary";
            $this->class = "btn btn-".$this->btnCor." waves-effect btn-label waves-light crudCancelarOperacao";
            $this->dataBsToggle = "tooltip";
            $this->dataBsPlacement = "top";
            $this->dataId = "0";
            $this->title = 'Cancelar Operação';
            $this->imageAwesome = "fa fa-arrow-left label-icon";
            $this->label = 'Cancelar';
        }

        //Botão Confirmar Operação (CRUD)
        if ($this->op == 5) {
            $this->type = "button";
            $this->btnCor = "success";
            $this->class = "btn btn-".$this->btnCor." waves-effect btn-label waves-light crudConfirmarOperacao";
            $this->dataBsToggle = "tooltip";
            $this->dataBsPlacement = "top";
            $this->dataId = "0";
            $this->title = 'Confirmar Operação';
            $this->imageAwesome = "fa fa-save label-icon";
            $this->label = 'Confirmar';
        }

        //Botão Pesquisar no Banco (CRUD) - min
        if ($this->op == 6) {
            $this->type = "submit";
            $this->btnCor = "success";
            $this->class = "btn btn-".$this->btnCor." text-white text-center";
            $this->dataBsToggle = "tooltip";
            $this->dataBsPlacement = "top";
            $this->dataId = "0";
            $this->title = 'Pesquisar no Banco de Dados';
            $this->imageAwesome = "fa fa-arrow-right";
            $this->label = "";
        }







//        //Botão Confirmar Alteração (CRUD)
//        if ($this->op == 6) {
//            $this->type = "button";
//            $this->class = "btn btn-primary waves-effect btn-label waves-light";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Confirmar Alteração';
//            $this->imageAwesome = "bx bx-save label-icon";
//            $this->label = 'Confirmar';
//        }
//
//        //Botão Visualizar Registro (CRUD) - min
//        if ($this->op == 7) {
//            $this->type = "button";
//            $this->class = "btn btn-info text-white text-center";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Visualizar Registro';
//            $this->imageAwesome = "fa fa-eye";
//            $this->label = "";
//        }
//
//        //Botão Alterar Registro (CRUD) - min
//        if ($this->op == 8) {
//            $this->type = "button";
//            $this->class = "btn btn-primary text-white text-center btn-alterar-registro-min";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Alterar Registro';
//            $this->imageAwesome = "fa fa-edit";
//            $this->label = "";
//        }
//
//        //Botão Excluir Registro (CRUD) - min
//        if ($this->op == 9) {
//            $this->type = "button";
//            $this->class = "btn btn-danger text-white text-center";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Excluir Registro';
//            $this->imageAwesome = "fa fa-trash-alt";
//            $this->label = "";
//        }
//
//        //Botão Enviar
//        if ($this->op == 10) {
//            $this->type = "button";
//            $this->class = "btn btn-success waves-effect btn-label waves-light";
//            $this->dataBsToggle = "";
//            $this->dataBsPlacement = "";
//            $this->title = "";
//            $this->imageAwesome = "bx bx-send label-icon";
//            $this->label = 'Enviar';
//        }
//
//        //Botão Visualizar Registro (CRUD) - min2 - sem background - sem borda
//        if ($this->op == 11) {
//            $this->type = "button";
//            $this->class = "btn text-info text-center";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Visualizar Registro';
//            $this->imageAwesome = "fa fa-eye";
//            $this->label = "";
//        }
//
//        //Botão Alterar Registro (CRUD) - min2 - sem background - sem borda
//        if ($this->op == 12) {
//            $this->type = "button";
//            $this->class = "btn text-primary text-center";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Alterar Registro';
//            $this->imageAwesome = "fa fa-edit";
//            $this->label = "";
//        }
//
//        //Botão Excluir Registro (CRUD) - min2 - sem background - sem borda
//        if ($this->op == 13) {
//            $this->type = "button";
//            $this->class = "btn text-danger text-center";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Excluir Registro';
//            $this->imageAwesome = "fa fa-trash-alt";
//            $this->label = "";
//        }
//
//        //Botão Visualizar Registro (CRUD) - min2 - sem background
//        if ($this->op == 14) {
//            $this->type = "button";
//            //$this->class = "btn text-center border border-dark";
//            $this->class = "btn btn-outline-secondary btn-sm";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Visualizar Registro';
//            $this->imageAwesome = "fa fa-eye";
//            $this->label = "";
//        }
//
//        //Botão Alterar Registro (CRUD) - min2 - sem background
//        if ($this->op == 15) {
//            $this->type = "button";
//            //$this->class = "btn text-center border border-dark";
//            $this->class = "btn btn-outline-secondary btn-sm";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Alterar Registro';
//            $this->imageAwesome = "fas fa-pencil-alt";
//            $this->label = "";
//        }
//
//        //Botão Excluir Registro (CRUD) - min2 - sem background
//        if ($this->op == 16) {
//            $this->type = "button";
//            //$this->class = "btn text-center border border-dark";
//            $this->class = "btn btn-outline-secondary btn-sm";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Excluir Registro';
//            $this->imageAwesome = "fa fa-trash-alt";
//            $this->label = "";
//        }
//
//        //Botão Pesquisar no Banco (CRUD) - min
//        if ($this->op == 17) {
//            $this->type = "submit";
//            $this->class = "btn btn-success text-white text-center";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Pesquisar no Banco de Dados';
//            $this->imageAwesome = "fa fa-arrow-right";
//            $this->label = "";
//        }
//
//        //Botão Repeat Telefone
//        if ($this->op == 18) {
//            $this->type = "button";
//            $this->class = "btn btn-primary btn-sm waves-effect waves-light";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Adicionar outro Telefone';
//            $this->imageAwesome = "bx bx-plus font-size-16 align-middle me-2";
//            $this->label = 'Telefone';
//        }
//
//        //Botão Repeat Endereços
//        if ($this->op == 19) {
//            $this->type = "button";
//            $this->class = "btn btn-primary btn-sm waves-effect waves-light";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Adicionar outro Telefone';
//            $this->imageAwesome = "bx bx-plus font-size-16 align-middle me-2";
//            $this->label = 'Endereço';
//        }
//
//        //Botão Repeat Informações Profissionais
//        if ($this->op == 20) {
//            $this->type = "button";
//            $this->class = "btn btn-primary btn-sm waves-effect waves-light";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Adicionar outro Telefone';
//            $this->imageAwesome = "bx bx-plus font-size-16 align-middle me-2";
//            $this->label = 'Informação Profissional';
//        }
//
//        //Botão Alterar Fotografia Funcionário (CRUD)
//        if ($this->op == 21) {
//            $this->type = "button";
//            $this->class = "btn btn-warning waves-effect btn-label waves-light";
//            $this->dataBsToggle = "tooltip";
//            $this->dataBsPlacement = "top";
//            $this->title = 'Foto';
//            $this->imageAwesome = "bx bx-photo-album label-icon";
//            $this->label = 'Foto';
//        }

        return view('components.button');
    }
}
