<?php
namespace Admin0902\Controllers;

use Foundation\Controller;
use Admin0902\Models\Banner;

class BannerController extends Controller
{
    protected $banner;

    public function __construct() {
        $this->banner = new Banner();
    }

    public function index() {
        $dados = $this->banner->getAll();
        return $this->render('banner/index', [
            'dados' => $dados
        ]);
    }

    public function cadastrar() {
        $id = $this->getParam('id');

        $dados = null;

        if ($id) {
            $dados = $this->banner->getById($id);
        }

        return $this->render('banner/cadastrar', [
                    'dados' => $dados
        ]);
    }

    public function salvar() {
        $id = input()->get('id', false);

        $dados = [
            'titulo' => input()->get('titulo'),
            'subtitulo' => input()->get('subtitulo'),
            'descricao' => input()->get('descricao'),
            'link' => input()->get('link'),
            'localizacao' => 1,
            'dt_cadastro' => date('Y-m-d'),
            'id_user' => 1,
            'ativo' => 1
        ];

        // Atualizar
        if ($id) {
            $this->banner->updateById($id, $dados);

            session()->put('_sucesso', 'Registro atualizado com sucesso');

            return redirect()->route('banner.index');
        }

        $statusSalvar = $this->banner->insert($dados);
        if ($statusSalvar == 0) {
            session()->put('_erro', 'Erro ao salvar o registro! Entre em contato com o desenvolvedor');
        } else {
            session()->put('_sucesso', 'Registro cadastrado com sucesso');
        }
        return redirect()->route('banner.index');
    }

    public function excluir() {
        $id = $this->getParam('id');
        if ($id){
            $statusTransaction = $this->banner->deleteById($id);
            if ($statusTransaction == 0){
                session()->put('_erro', 'Erro ao excluir o registro! Entre em contato com o desenvolvedor');
                return redirect()->route('banner.index');
            }else{
                session()->put('_sucesso', 'Registro excluído com sucesso');
                return redirect()->route('banner.index');
            }
        }else{
            session()->put('_erro', 'Erro ao excluir o registro! Entre em contato com o desenvolvedor');
        }

    }
    
    public function imagens() {
        $id = input()->get('id');
        $dados_equipe = $this->equipe->getById('cd_membro',$id);
        
        return $this->render('equipe/imagens', [
            'dados_equipe' => $dados_equipe
        ]);
    }
    
    public function fileupload() {
        return $this->render('equipe/fileupload');
    }

    public function deleteupload() {
        $id = input()->get('id');
        
        $dados = ['foto_membro' => null];                    

        $idDelete = $this->equipe->updateById('cd_membro', $id, $dados);
        if ($idDelete) {
            session()->put('_sucesso', 'Registro excluído com sucesso');
        } else {
            session()->put('_erro', 'Erro ao excluir o registro');
        }

        return redirect()->route('equipe.imagens', ['id' => $id]);
    }

    public function criaDir($dir, $recursive = TRUE, $mode = 0777) {
        if (!preg_match("/\/$/", $dir)) {
            $dir .= "/";
        }

        if (!is_dir($dir)) {
            $create = mkdir($dir, $mode, $recursive);
            if ($create) {
                return TRUE;
            } else {
                throw new Exception("O diret&oacute;rio n&atilde;o p&ocirc;de ser criado!");
            }
        }
    }

    public function validaExtensaoUpload($ext) {
        $extensaoValida = array('gif', 'jpeg', 'jpg', 'png');
        if (in_array($ext, $extensaoValida)) {
            return true;
        } else {
            return false;
        }
    }

    public function getDiretorioImg($idTexto){
        $dir = PATH_IMG_PUBLIC . "conteudo\\equipe\\" . $idTexto . "\\";

        if (!file_exists($dir)) {
            $this->criaDir($dir);
            $this->criaDir($dir . 'm\\');
            $this->criaDir($dir . 'o\\');
        }
        
        return $dir;
    }

    public function saveupload() {
        $id = input()->get('id');
        $dir = $this->getDiretorioImg($id);

        foreach ($_FILES['file']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $novoNome = 'equipe-clinica-nucleo-vivendi-01';
                $extensao = explode('.', $_FILES['file']['name'][$key]);
                
                $statusExtensao = $this->validaExtensaoUpload(strtolower(end($extensao)));
                if ($statusExtensao) {
                    $extensao = '.' . strtolower(end($extensao));
                    $destino = $dir . 'o\\' . $novoNome . $extensao;
                    
                    move_uploaded_file($_FILES['file']['tmp_name'][$key], $destino);

                    $dados = ['foto_membro' => 'equipe/' . $id . '/m/' . $novoNome . $extensao];                    
                    $this->equipe->updateById('cd_membro', $id, $dados);
                    copy($destino, $dir . 'm\\' . $novoNome . $extensao);
                }
            }
        }
        return redirect()->route('equipe.imagens', ['id' => $id]);
    }
}