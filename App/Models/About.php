<?php
namespace App\Models;

use Foundation\Database\Model;

class About extends Model
{

    public function getAllContent(){
        $query = 'SELECT * FROM tb_sobre_site';
        return $this->db->select($query);
    }

    public function getContentPrincipal(){
        $query = 'SELECT conteudo, url_img, nome, legenda, titulo, descricao FROM tb_sobre_site';
        return $this->db->select($query);
    }

    public function getEquipeGenetica(){
        $query = 'SELECT * FROM tb_equipe_geral';
        return $this->db->select($query);
    }

    protected function getTableName()
    {
        return 'tb_sobre_site';
    }
}