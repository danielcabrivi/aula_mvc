<?php
namespace App\Controllers;

use App\Models\Dadosprincipais;
use App\Models\Objetivossite;
use App\Models\Sitesrelacionados;
use App\Models\Texto;
use Foundation\Controller;


class TelegeneticaController extends Controller
{

    protected $definicaoTG;
    protected $servicosTG;
    protected $objetivosTG;

    protected $sitesrelacionados;
    protected $configprincipais;


    public function __construct() {
        $this->definicaoTG = new Texto();
        $this->servicosTG = new Texto();
        $this->objetivosTG = new Objetivossite();

        $this->sitesrelacionados = new Sitesrelacionados();
        $this->configprincipais = new Dadosprincipais();
    }

    public function index()
    {
        $dados_definicaoTG = $this->definicaoTG->getDefinicaoTG();
        $dados_servicosTG = $this->servicosTG->getServicoTG();
        $dados_objetivosTG = $this->objetivosTG->getAllObjetivossite();

        $dados_sitesrelacionados = $this->sitesrelacionados->getAllSites();
        $dados_configprincipais = $this->configprincipais->getAllDadosprincipais();

        return $this->render('telegenetica/index', [
            'dados_definicaoTG' => $dados_definicaoTG,
            'dados_servicosTG' => $dados_servicosTG,
            'dados_objetivosaboutus' => $dados_objetivosTG,

            'dados_sitesrelacionados' => $dados_sitesrelacionados,
            'dados_configprincipais' => $dados_configprincipais
        ]);
    }
}