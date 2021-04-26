<?php
namespace App\Controllers;

use Foundation\Controller;
use App\Models\Texto;

class TextoController extends Controller
{
    private $texto;
    public function __construct() {
        $this->texto = new Texto;
    }

    public function index()
    {

    }
    
    public function artigos(){
        $dados_artigos = $this->texto->getArtigosAll();
        return $this->render('texto/artigos',[
            'dados_artigos' => $dados_artigos
        ]);
    }

    public function estetica(){
        $dados_estetica = $this->texto->getEsteticaAll();
        return $this->render('texto/estetica',[
            'dados_estetica' => $dados_estetica
        ]);
    }

    public function tratamentos(){
        $dados_tratamentos = $this->texto->getTratamentosAll();
        return $this->render('texto/tratamentos', [
            'dados_tratamentos' => $dados_tratamentos
        ]);
    }

    public function nutricaoFitness(){
        $dados_nutricaoFitness = $this->texto->getNutricaoFitnessAll();
        return $this->render('texto/nutricaoFitness', [
            'dados_nutricaoFitness' => $dados_nutricaoFitness
        ]);
    }

    public function exibeTexto(){
        $id = input()->get('textoid');

        $dados_texto = $this->texto->getTexto($id);
        return $this->render('texto/exibeTexto',[
            'dados_texto' => $dados_texto
        ]);
    }
}