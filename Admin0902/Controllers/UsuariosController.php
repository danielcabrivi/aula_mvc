<?php
namespace AdminApp\Controllers;

use AdminFoundation\Controller;
use AdminApp\Models\Usuarios;

class UsuariosController extends Controller
{
    public function index()
    {
        $dados_artigos = (new Usuarios)->getAll();
        return $this->render('usuarios/index', [
            'dados_artigos' => $dados_artigos
        ]);
    }
}