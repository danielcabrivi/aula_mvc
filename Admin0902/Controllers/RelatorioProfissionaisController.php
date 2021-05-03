<?php

namespace Admin0902\Controllers;

use Admin0902\Models\Relatorioprofissionais;
use Foundation\Controller;

class RelatorioProfissionaisController extends Controller {

    protected $modelInstance;

    public function __construct() {
        $this->modelInstance = new Relatorioprofissionais();
    }

    public function index() {
        $dados_model = $this->modelInstance->getAll();
        return $this->render('relatorioprofissionais/index', [
                    'dados_model' => $dados_model
        ]);
    }
}