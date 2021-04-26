<?php
namespace App\Controllers;

use App\Models\Dadosprincipais;
use Foundation\Controller;

class ElementsController extends Controller // mesmo nome do arq
{
    protected $redes_sociais;

    public function __construct() {
        $this->redes_sociais = new Dadosprincipais();
    }

    public function index()
    {
        $dadosRedesSociais = $this->redes_sociais->getAllDadosprincipais();

        return $this->render('elements/index', [
            'dados_definicaodr' => '',
            'dados_redes_sociais' => $dadosRedesSociais
        ]);
    }
}