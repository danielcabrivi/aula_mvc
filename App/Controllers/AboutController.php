<?php
namespace App\Controllers;

use App\Models\Dadosprincipais;
use Foundation\Controller;
use App\Models\About;

class AboutController extends Controller
{ 
    protected $about;
    protected $sitesrelacionados;
    protected $configprincipais;

    public function __construct() {
        $this->about = new About();
        $this->configprincipais = new Dadosprincipais();
    }

    public function index()
    {
        $dados_about = $this->about->getAllContent();
        $dados_equipe_geral = $this->about->getEquipeGenetica();
        $dados_sitesrelacionados = $this->sitesrelacionados->getAllSites();
        $dados_configprincipais = $this->configprincipais->getAllDadosprincipais();

        return $this->render('about/index', [
            'dados_about' => $dados_about,
            'dados_equipe_geral' =>  $dados_equipe_geral,
            'dados_sitesrelacionados' => $dados_sitesrelacionados,
            'dados_configprincipais' => $dados_configprincipais
        ]);
    }
}