<?php
namespace App\Controllers;

use App\Models\Dadosprincipais;
use Foundation\Controller;
use App\Models\Texto;

class NovidadesController extends Controller 
{
    protected $novidades;
    protected $redes_sociais;
    
    public function __construct() {
        $this->novidades = new Texto();
        $this->redes_sociais = new Dadosprincipais();
    }

    public function index()
    {
        $id = $this->getParamText('id');
        $dadosNovidades = $this->novidades->getAllNovidades();
        $dadosNovidadesDestaque  = $this->novidades->getNovidadesDestaque();
        $dadosRedesSociais = $this->redes_sociais->getAllDadosprincipais();

        if ($id >= 1) {
            return $this->render('novidades/visualizar', [
                'dados_novidades' => $this->novidades->getById($id),
                'dados_redes_sociais' => $dadosRedesSociais
            ]);
        }else {
        return $this->render('novidades/index', [
            'dados_novidades' => $dadosNovidades,
            'dados_novidades_destaque' => $dadosNovidadesDestaque,
            'dados_redes_sociais' => $dadosRedesSociais
        ]);
        }
    }
}