<?php


namespace App\Services;

class Permissoes
{
    /*
     * Função para saber se o usuário logado tem acesso
     * @param $permissoesCtrl : Permissões necessárias para ter acesso
     * @param $userPermissoes : Permissões do usuário
     */
    public function permissao($permissoesCtrl, $userPermissoes)
    {
        foreach ($userPermissoes as $userPermissao) {
            foreach ($permissoesCtrl as $permissaoCtrl) {
                if ($userPermissao['permissao'] == $permissaoCtrl) {return true;}
            }
        }

        return false;
    }
}
