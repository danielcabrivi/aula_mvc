<?php
namespace AdminApp\Controllers;

use AdminFoundation\Controller;
use AdminApp\Models\Configuracoes;

class ConfiguracoesController extends Controller
{
    public function index()
    {
        $dados_artigos = (new Configuracoes)->getAll();
        return $this->render('configuracoes/index', [
            'dados_artigos' => $dados_artigos
        ]);
    }
}