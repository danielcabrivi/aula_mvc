<?php
namespace AdminApp\Controllers;

use AdminFoundation\Controller;

class ContatoController extends Controller
{
    public function index()
    {
        return $this->render('contato/index');
    }
}