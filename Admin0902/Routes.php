<?php 
return [
    /*
     * Aqui pode-se documentar as páginas do sistema, para facilitar
     * a escrita dos redirecionamentos. Exemplo:
     *
     * return Redirect::route('index');
     *
     * Sintaxe:
     *
     * 'nome' => ['controlador', 'método']
     */

    'index' => ['index', 'index'],

    'aulas.index' => ['aulas', 'index'],
    'aulas.salvar' => ['aulas', 'salvar'],
    'aulas.cadastrar' => ['aulas', 'cadastrar'],
    'aulas.fileupload'=> ['aulas', 'fileupload'],
    'aulas.saveupload' => ['aulas', 'saveupload'],
    'aulas.imagens' => ['aulas', 'imagens'],
    'aulas.deleteupload' => ['aulas', 'deleteupload'],
    'aulas.excluir' => ['aulas', 'excluir'],

    'login.index' => ['login', 'index'],
    'login.validar' => ['login', 'validar'],
    'login.logout' => ['login', 'logout']
];
