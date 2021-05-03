<?php

namespace Admin0902\Controllers;

use Admin0902\Models\Relatoriopacfam;
use Foundation\Controller;

class RelatoriopacfamController extends Controller {

    protected $modelInstance;

    public function __construct() {
        $this->modelInstance = new Relatoriopacfam();
    }

    public function index() {
        $dados_model = $this->modelInstance->getAll();
        return $this->render('relatoriopacfam/index', [
                    'dados_model' => $dados_model
        ]);
    }
}