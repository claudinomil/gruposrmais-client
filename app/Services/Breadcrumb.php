<?php

namespace App\Services;

use App\Facades\ApiData;
use Illuminate\Support\Facades\Route;

class Breadcrumb
{
    public function getPreviousPageTitle()
    {
        if (session()->exists('breadcrumbPreviousPageTitle')) {return session('breadcrumbPreviousPageTitle');}

        return 'Previous Title';
    }

    public function getPreviousPageRoute()
    {
        if (session()->exists('breadcrumbPreviousPageRoute')) {return session('breadcrumbPreviousPageRoute');}

        return 'Previous Route';
    }

    public function getCurrentPageTitle()
    {
        if (session()->exists('breadcrumbCurrentPageTitle')) {return session('breadcrumbCurrentPageTitle');}

        return 'Current Title';
    }

    public function getCurrentPageRoute()
    {
        if (session()->exists('breadcrumbCurrentPageRoute')) {return session('breadcrumbCurrentPageRoute');}

        return 'Current Route';
    }

    public function sessionsBreadcrumb()
    {
        //Se já passou por aqui e guardou a session('breadcrumbCurrentPageTitle'), então colocar os valores Current como Previous
        if (session()->exists('breadcrumbCurrentPageTitle')) {
            session(['breadcrumbPreviousPageTitle' => session('breadcrumbCurrentPageTitle')]);
            session(['breadcrumbPreviousPageRoute' => session('breadcrumbCurrentPageRoute')]);
        } else {
            session(['breadcrumbPreviousPageTitle' => '']);
            session(['breadcrumbPreviousPageRoute' => '']);
        }

        //Buscando dados na Api (Pegar nome do Submódulo enviando a URI da Rota que entrou)
        //@param $fieldSearch   : campo para ser pesquisado
        //@param $fieldValue    : valor para pesquisar
        //@param $fieldReturn   : campo para retornar

        $fieldSearch = 'menu_route';

        $fieldValue = Route::getFacadeRoot()->current()->uri();
        if (strpos($fieldValue, '/')) {
            $fieldValue = explode('/', $fieldValue);
            $fieldValue = $fieldValue[0];
        }

        $fieldReturn = 'name';

        $response = ApiData::getData(10, 'submodulos/research/'.$fieldSearch.'/'.$fieldValue.'/'.$fieldReturn, '', '', '', '');
        //dd($response->json());   //TRAZER ERRO NA DEPURAÇÃO

        if (isset($response['content'][0]['name'])) {

            $submodulo_nome = $response['content'][0]['name'];

            //Current Page Route
            session(['breadcrumbCurrentPageRoute' => $fieldValue.'.index']);

            //Gravar dados
            if ($submodulo_nome != '') {
                session(['breadcrumbCurrentPageTitle' => $submodulo_nome]);
            } else {
                session(['breadcrumbCurrentPageTitle' => '']);
            }

            //Se foi a primeira entrada aqui e a session('breadcrumbPreviousPageTitle') for vazio, então gravar os Previous igual aos Current
            if (session('breadcrumbPreviousPageTitle') == '') {
                session(['breadcrumbPreviousPageTitle' => session('breadcrumbCurrentPageTitle')]);
                session(['breadcrumbPreviousPageRoute' => session('breadcrumbCurrentPageRoute')]);
            }
        }
    }
}
