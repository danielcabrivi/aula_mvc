<?php

return  [
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
    'contact' => ['contact', 'index'],
    'generic' => ['generic', 'index'],
    'elements' => ['elements', 'index'],
    'dicas' => ['dicas', 'index'],
    'aulas' => ['aulas', 'index'],
    'novidades' => ['novidades', 'index'],
    'dicionario' => ['dicionario', 'index']
    //'about' => ['about', 'index'] 
];