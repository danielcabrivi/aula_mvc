<?php

namespace Admin0902\Controllers;

use Admin0902\Models\Dicas; 
use Foundation\Controller;

class DicasController extends Controller {

    protected $dicas;

    public function __construct() {
        $this->dicas = new dicas();
    }

    public function index() {
        $dados_dicas = $this->dicas->getAllDicas();
        return $this->render('dicas/index', [
                    'dados_dicas' => $dados_dicas
        ]);
    }

    public function cadastrar() {
        $id = $this->getParam('id');

        $dados_dicas = null;

        if ($id) {
            $dados_dicas = $this->dicas->getById($id);
        }

        return $this->render('dicas/cadastrar', [
            'dados_dicas' => $dados_dicas
        ]);
    }

    public function salvar() {
        $id = $this->getParam('id');
        
        $dados = [
            'titulo' => input()->get('titulo'),
            'chamada' => input()->get('chamada'),
            'conteudo' => input()->get('conteudo'),
            'keywords' => empty(input()->get('keywords')) ? NULL : input()->get('keywords'),
            'dt_cadastro' => date('Y-m-d'),
            'id_user' => 1,
            'destaque' => !is_null(input()->get('destaque')) ? input()->get('destaque') : 0,
            'ativo' => !is_null(input()->get('ativo')) ? input()->get('ativo') : 0,
            'id_categ_texto' => 1,
            'descricao' => empty(input()->get('descricao')) ? NULL : input()->get('descricao'),
            'fonte' => empty(input()->get('fonte')) ? NULL : input()->get('fonte'),
            'linkfonte' => empty(input()->get('linkfonte')) ? NULL : input()->get('linkfonte'),
            'dt_exibe' => date('Y-m-d')
        ]; 

        // Atualizar
        if ($id) {
            if ($this-> dicas-> updateById($id, $dados)) {
                session()-> put('_sucesso', 'Registro aualizado com sucesso!');
            }else {
                session()-> put('_erro', 'Erro ao atualizar o registro!');
            }
        }else {
            if ($this-> dicas-> insert($dados)){
                session()-> put('_sucesso', 'Registro cadastrado com sucesso!');
            }else {
                session()-> put('_erro', 'Erro ao cadastrar o registro!');
            }
        }
        return redirect()-> route('dicas.index');
    }

    public function excluir() { 
        $idFix = $this->getParam('id');
        if($this->dicas->deleteById($idFix)){
            session()->put('_sucesso', 'Registro excluído com sucesso');
        }else{
            session()->put('_erro', 'Erro ao excluir o registro');
        }

        return redirect()->route('dicas.index');
    }

    public function imagens() {
        $id = $this->getParam('id');
        $dados_img_o = $this->dicas->getDicasImgO($id);
        $dados_img_destaque = $this->dicas->getDicasImgDestaque($id);
        $dados_img_g = $this->dicas->getDicasImgG($id);
        $dados_img_m = $this->dicas->getDicasImgM($id);
        $dados_img_p = $this->dicas->getDicasImgP($id);

        return $this->render('dicas/imagens', [
            'dados_img_o' => $dados_img_o,
            'dados_img_destaque' => $dados_img_destaque,
            'dados_img_g' => $dados_img_g,
            'dados_img_m' => $dados_img_m,
            'dados_img_p' => $dados_img_p,
        ]);
    }

    public function fileupload() {
        return $this->render('dicas/fileupload');
    }

    public function deleteupload() {
        $idDica = $this->getParam('id');
        $idImg = $this->getParam('idimg');

        $idDelete = $this->dicas->deleteImgById($idImg);
        if ($idDelete) {
            session()->put('_sucesso', 'Registro excluído com sucesso');
        } else {
            session()->put('_erro', 'Erro ao excluir o registro');
        }

        return  redirect()->route('dicas.imagens', ['id' => $idDica]);
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
                return FALSE;
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

    public function getDadosUpload($idTexto, $tipoImg, $tipoImgChar, $cdImg, $novoNome, $extensao) {
        $dados = [
            'url' => 'dica/' . $idTexto . '/' . $tipoImgChar . '/' . $novoNome . $extensao,
            'dt_cadastro' => date('Y-m-d'),
            'ativo' => 1, 
            'tipo' => (int) $tipoImg,
            'id_texto' => (int) $idTexto,
            'id_img' => (int) $cdImg
        ];

        return $dados;
    }

    public function getImgIdMax($id) {
        $dadosDicasImg = $this->dicas->getDicasImgByIdMax($id, 4);
        $cdImg = $dadosDicasImg[0]->max_id_img;

        if (is_null($cdImg)) { 
            $cdImg = 0;
        } else {
            $cdImg = (int) $cdImg;
        }

        return $cdImg;
    }

    public function saveImgTexto($idTexto, $tipoImg, $tipoImgChar, $cdImg, $novoNome, $extensao, $origemImg, $dirImg) {

        $dados = $this->getDadosUpload($idTexto, $tipoImg, $tipoImgChar, $cdImg, $novoNome, $extensao);

        $this->dicas->setDicaImgById('tb_texto_img', $dados);

        copy($origemImg, $dirImg . $tipoImgChar . '/' . $novoNome . $extensao);
    }

    public function getDiretorioImg($idTexto){
        $dir = PATH_IMG_PUBLIC . "dica/" . $idTexto . "/";

        if (!file_exists($dir)) {
            $this->criaDir($dir);
            $this->criaDir($dir . 'o/');
            $this->criaDir($dir . 'destaque/');
            $this->criaDir($dir . 'g/');
            $this->criaDir($dir . 'm/');
            $this->criaDir($dir . 'p/');
        }
        
        return $dir;
    }

    public function saveupload() {
        $id = $this->getParam('id');
        $tipoimg = $this->getParam('tipoimg');
        
        $cdImg = $this->getImgIdMax($id);        
        $dir = $this->getDiretorioImg($id);

        foreach ($_FILES['file']['error'] as $key => $error) { 
            if ($error == UPLOAD_ERR_OK) {
                $cdImg++;
                $novoNome = 'dica-blog-cabrivi' . str_pad($cdImg, 4, "0", STR_PAD_LEFT);
                $extensao = explode('.', $_FILES['file']['name'][$key]);
                
                $statusExtensao = $this->validaExtensaoUpload(strtolower(end($extensao)));

                if ($statusExtensao) {
                    $extensao = '.' . strtolower(end($extensao));
                    $destino = $dir . 'o/' . $novoNome . $extensao;
                    
                    move_uploaded_file($_FILES['file']['tmp_name'][$key], $destino);

                    $dados = $this->getDadosUpload($id, 4, 'o', $cdImg, $novoNome, $extensao);

                    $this->dicas->setDicaImgById('tb_texto_img', $dados);

                    if ($tipoimg == 1) {
                        $this->saveImgTexto($id, 1, 'p', $cdImg, $novoNome, $extensao, $destino, $dir);
                    } else if ($tipoimg == 2) {
                        $this->saveImgTexto($id, 2, 'm', $cdImg, $novoNome, $extensao, $destino, $dir);
                    } else if ($tipoimg == 3) {                        
                        $this->saveImgTexto($id, 3, 'g', $cdImg, $novoNome, $extensao, $destino, $dir);
                    } else if ($tipoimg == 5) {                        
                        $this->saveImgTexto($id, 5, 'destaque', $cdImg, $novoNome, $extensao, $destino, $dir);
                    }
                }
            }
        }
       return  redirect()->route('dicas.imagens', ['id' => $id]);
    }
}