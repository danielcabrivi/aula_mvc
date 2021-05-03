<?php
namespace AdminApp\Controllers;

use AdminFoundation\Controller;
use AdminApp\Models\Equipe;

class EquipeController extends Controller
{
    protected $equipe;

    public function __construct() {
        $this->equipe = new Equipe;
    }

    public function index() {
        $dados_equipe = $this->equipe->getAll();
        return $this->render('equipe/index', [
            'dados_equipe' => $dados_equipe
        ]);
    }

    public function cadastrar() {
        $idEquipe = input()->get('id', false);

        $dados_equipe = null;

        if ($idEquipe) {
            $dados_equipe = $this->equipe->getById('cd_membro', $idEquipe);
        }

        return $this->render('equipe/cadastrar', [
                    'dados_equipe' => $dados_equipe
        ]);
    }

    public function salvar() {
        $idEquipe = input()->get('id');

        $dados = [
            'nm_membro' => input()->get('nm_membro'),
            'legenda_membro' => input()->get('legenda_membro'),
            'curriculo_membro' => input()->get('curriculo_membro'),
            'dt_cadastro_membro' => date('Y-m-d'),
            'dt_exibe_membro' => date('Y-m-d'),
            'cd_user_cad' => 1,
            'destaque_membro' => 0,
            'ativo_membro' => input()->get('ativo_membro'),
            'foto_membro' => input()->get('foto_membro')
        ];
        var_dump($dados);

        // Atualizar
        if ($idEquipe) {
            $this->equipe->updateById('cd_membro', $idEquipe, $dados);

            session()->put('_sucesso', 'Registro atualizado com sucesso');

            return redirect()->route('equipe.index');
        }

        $statusSalvar = $this->equipe->insert($dados);
        if ($statusSalvar == 0) {
            session()->put('_erro', 'Erro ao salvar o registro! Entre em contato com o desenvolvedor');
        } else {
            session()->put('_sucesso', 'Registro cadastrado com sucesso');
        }
        return redirect()->route('equipe.index');
    }

    public function excluir() {
        $idEquipe = input()->get('id');

        $this->equipe->deleteById('cd_membro', $idEquipe);
        session()->put('_sucesso', 'Registro excluído com sucesso');
        return redirect()->route('equipe.index');
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