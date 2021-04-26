<?php

namespace App\Controllers;

use App\Models\Dadosprincipais;
use Foundation\Controller;
use App\Models\Texto;

class DicasController extends Controller
{
    protected $dicas;
    protected $redes_sociais;

    public function __construct()
    {
        $this->dicas = new Texto();
        $this->redes_sociais = new Dadosprincipais();
    }

    public function index()
    {
        $id = $this->getParamText('id');
        $dadosDicas = $this->dicas->getAllDicas();
        $dadosDicasDestaque  = $this->dicas->getDicasDestaque();
        $dadosRedesSociais = $this->redes_sociais->getAllDadosprincipais();

        // new
        if ($id >= 1) {
            return $this->render('dicas/visualizar', [
                'dados_dicas' => $this->dicas->getById($id),
                'dados_redes_sociais' => $dadosRedesSociais
            ]);
        } else {
            return $this->render('dicas/index', [
                'dados_dicas' => $dadosDicas,
                'dados_dicas_destaque' => $dadosDicasDestaque,
                'dados_redes_sociais' => $dadosRedesSociais
            ]);
        }
    }
}