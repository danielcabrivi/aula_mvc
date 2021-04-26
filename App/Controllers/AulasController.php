<?php
namespace App\Controllers;

use App\Models\Dadosprincipais;
use Foundation\Controller;
use App\Models\Texto;

class AulasController extends Controller 
{
    protected $aulas;
    protected $redes_sociais;
    
    public function __construct() {
        $this->aulas = new Texto();
        $this->redes_sociais = new Dadosprincipais();
    }

    public function index()
    {
        $id = $this->getParamText('id');
        $dadosAulas = $this->aulas->getAllAulas();
        $dadosAulasDestaque  = $this->aulas->getAulasDestaque();
        $dadosRedesSociais = $this->redes_sociais->getAllDadosprincipais();

        // new
        if ($id >= 1) {
            return $this->render('aulas/visualizar', [
                'dados_aulas' => $this->aulas->getById($id),
                'dados_redes_sociais' => $dadosRedesSociais
            ]);
        }else {
            return $this->render('aulas/index', [
                'dados_aulas' => $dadosAulas,
                'dados_aulas_destaque' => $dadosAulasDestaque,
                'dados_redes_sociais' => $dadosRedesSociais
            ]);
        }
    }
} 