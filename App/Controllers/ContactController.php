<?php
namespace App\Controllers;

use App\Models\Dadosprincipais;
use Foundation\Controller;

class ContactController extends Controller // mesmo nome do arq
{
    protected $redes_sociais;
    
    public function __construct() {
        $this->redes_sociais = new Dadosprincipais();
    }

    public function index()
    {
        $dadosRedesSociais = $this->redes_sociais->getAllDadosprincipais();

        return $this->render('contact/index', [
            'dados_definicaodr' => '',
            'dados_redes_sociais' => $dadosRedesSociais
        ]);
    }
}