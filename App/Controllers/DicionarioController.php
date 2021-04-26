<?php
namespace App\Controllers;

use App\Models\Dadosprincipais;
use Foundation\Controller;
use App\Models\Texto;

class DicionarioController extends Controller
{
    protected $dicionario;
    protected $redes_sociais;
    
    public function __construct() {
        $this->dicionario = new Texto();
        $this->redes_sociais = new Dadosprincipais();
    }

    public function index()
    {
        $id = $this->getParamText('id');
        $dadosDicionario = $this->dicionario->getAllDicionario();
        $dadosDicionarioDestaque  = $this->dicionario->getDicionarioDestaque();
        $dadosRedesSociais = $this->redes_sociais->getAllDadosprincipais();

        if($id >= 1) {
            return $this->render('dicionario/visualizar', [
                'dados_dicionario' => $this->dicionario->getById($id),
                'dados_redes_sociais' => $dadosRedesSociais
            ]);
        }else {
        return $this->render('dicionario/index', [
            'dados_dicionario' => $dadosDicionario,
            'dados_dicionario_destaque' => $dadosDicionarioDestaque,
            'dados_redes_sociais' => $dadosRedesSociais
        ]);
        }
    }
}