<?php

namespace Admin0902\Controllers;

use Admin0902\Models\Textopacientes;
use Foundation\Controller;

class TextopacientesController extends Controller {

    protected $textopublico;

    public function __construct() {
        $this->textopublico = new Textopacientes();
    }

    public function index() {
        $dados_textopublico = $this->textopublico->getTextopublicoAll();
        return $this->render('textopacientes/index', [
                    'dados_textopublico' => $dados_textopublico
        ]);
    }

    public function imagens() {
        $id = input()->get('id');
        $dados_img_g = $this->textopublico->getTratamentosImgG($id);

        return $this->render('textopacientes/imagens', [
                    'dados_img_g' => $dados_img_g
        ]);
    }

    public function cadastrar() {
        $idTextopublico = $this->getParam('id');

        $dados_textopublico = null;

        if ($idTextopublico) {
            $dados_textopublico = $this->textopublico->getById($idTextopublico);
        }

        return $this->render('textopacientes/cadastrar', [
                    'dados_textopublico' => $dados_textopublico
        ]);
    }

    public function salvar() {
        $idTextopublico = $this->getParam('id');

        $dados = [
            'titulo' => input()->get('nm_texto'),
            'chamada' => input()->get('chamada_texto'),
            'conteudo' => input()->get('txt_texto'),
            'keywords' => input()->get('keywords_texto'),
            'dt_cadastro' => date('Y-m-d'),
            'dt_exibe' => date('Y-m-d'),
            'id_user' => 1,
            'destaque' => input()->get('destaque_texto'),
            'ativo' => input()->get('ativo_texto'),
            'id_categ_texto' => 1,
            'descricao' => input()->get('descricao_texto')
        ];

        // Atualizar
        if ($idTextopublico) {
            $this->textopublico->updateById($idTextopublico, $dados);

            session()->put('_sucesso', 'Registro atualizado com sucesso');

            return redirect()->route('textopacientes.index');
        }

        $this->textopublico->insert($dados);
        session()->put('_sucesso', 'Registro cadastrado com sucesso');
        return redirect()->route('textopacientes.index');
    }

    public function excluir() {
        $idTratamento = input()->get('id');

        $this->textopublico->deleteById('cd_texto', $idTratamento);
        session()->put('_sucesso', 'Registro excluído com sucesso');
        return redirect()->route('textopacientes.index');
    }

    public function fileupload() {
        return $this->render('textopacientes/fileupload');
    }

    public function deleteupload() {
        $idTratamento = input()->get('id');
        $idTextoImg = input()->get('idtextoimg');

        $idDelete = $this->textopublico->deleteImgById($idTextoImg);
        if ($idDelete) {
            session()->put('_sucesso', 'Registro excluído com sucesso');
        } else {
            session()->put('_erro', 'Erro ao excluir o registro');
        }

        return redirect()->route('tratamentos.imagens', ['id' => $idTratamento]);
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

    public function getDadosUpload($idTexto, $tipoImg, $tipoImgChar, $cdImg, $novoNome, $extensao) {
        $dados = [
            'cd_img' => (int) $cdImg,
            'url_texto_img' => 'texto/' . $idTexto . '/' . $tipoImgChar . '/' . $novoNome . $extensao,
            'dt_cadastro_texto_img' => date('Y-m-d'),
            'ativo_texto_img' => 1,
            'tipo_texto_img' => (int) $tipoImg,
            'cd_texto' => (int) $idTexto
        ];

        return $dados;
    }

    public function getImgIdMax($id) {
        $dadosTratamentosImg = $this->textopublico->getTratamentosImgByIdMax($id, 4);
        $cdImg = $dadosTratamentosImg[0]->max_id_img;

        if (is_null($cdImg)) {
            $cdImg = 0;
        } else {
            $cdImg = (int) $cdImg;
        }

        return $cdImg;
    }

    public function saveImgTexto($idTexto, $tipoImg, $tipoImgChar, $cdImg, $novoNome, $extensao, $origemImg, $dirImg) {
        $dados = $this->getDadosUpload($idTexto, $tipoImg, $tipoImgChar, $cdImg, $novoNome, $extensao);
        $this->textopublico->setTratamentosImgById('tb_texto_img', $dados);
        copy($origemImg, $dirImg . $tipoImgChar . '\\' . $novoNome . $extensao);
    }
    
    public function getDiretorioImg($idTexto){
        $dir = PATH_IMG_PUBLIC . "conteudo\\texto\\" . $idTexto . "\\";

        if (!file_exists($dir)) {
            $this->criaDir($dir);
            $this->criaDir($dir . 'o\\');
            $this->criaDir($dir . 'p\\');
            $this->criaDir($dir . 'm\\');
            $this->criaDir($dir . 'g\\');
        }
        
        return $dir;
    }

    public function saveupload() {
        $id = input()->get('id');
        $tipoimg = input()->get('tipoimg');        
        $cdImg = $this->getImgIdMax($id);        
        $dir = $this->getDiretorioImg($id);

        foreach ($_FILES['file']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $cdImg++;
                $novoNome = 'tratamentos-clinica-nucleo-vivendi-' . str_pad($cdImg, 4, "0", STR_PAD_LEFT);
                $extensao = explode('.', $_FILES['file']['name'][$key]);
                
                $statusExtensao = $this->validaExtensaoUpload(strtolower(end($extensao)));
                if ($statusExtensao) {
                    $extensao = '.' . strtolower(end($extensao));
                    $destino = $dir . 'o\\' . $novoNome . $extensao;
                    
                    move_uploaded_file($_FILES['file']['tmp_name'][$key], $destino);

                    $dados = $this->getDadosUpload($id, 4, 'o', $cdImg, $novoNome, $extensao);
                    $this->textopublico->setTratamentosImgById('tb_texto_img', $dados);

                    if ($tipoimg == 1) {
                        $this->saveImgTexto($id, 1, 'p', $cdImg, $novoNome, $extensao, $destino, $dir);
                    } else if ($tipoimg == 2) {
                        $this->saveImgTexto($id, 2, 'm', $cdImg, $novoNome, $extensao, $destino, $dir);
                    } else if ($tipoimg == 3) {                        
                        $this->saveImgTexto($id, 3, 'g', $cdImg, $novoNome, $extensao, $destino, $dir);
                    }
                }
            }
        }
        return redirect()->route('tratamentos.imagens', ['id' => $id]);
    }
}