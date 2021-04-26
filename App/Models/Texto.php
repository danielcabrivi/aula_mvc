<?php
namespace App\Models;

use Foundation\Database\Model;

/*
LISTA DE IDS E SUAS CATEGORIAS
 1 dicas
 2 tutoriais
 3 novidades
*/

class Texto extends Model
{
    // toda vez que acessar a tabela de texto do BD

    public function getAllDicas(){
        $query = 'select txt.id, txt.titulo, txt.chamada, dt_exibe, txt.url_img_destaque from tb_texto as txt inner join tb_categ_texto as ctxt on txt.id_categ_texto= ctxt.id where ctxt.id = 1 and txt.ativo = 1 and txt.destaque = 0';
        return $this->db->select($query);
    }

    public function getDicasDestaque(){
        $query = 'select txt.id, txt.titulo, txt.chamada, dt_exibe, txt.url_img_destaque from tb_texto as txt inner join tb_categ_texto as ctxt on txt.id_categ_texto = ctxt.id where ctxt.id = 1 and txt.ativo = 1 and txt.destaque = 1';
        return $this->db->select($query);
    }

    public function getAllAulas() {
        $query = 'select txt.id, txt.titulo, txt.chamada, dt_exibe, txt.url_img_destaque from tb_texto as txt inner join tb_categ_texto as ctxt on txt.id_categ_texto= ctxt.id where ctxt.id = 2 and txt.ativo = 1 and txt.destaque = 0';
        return $this->db->select($query);
    }

    public function getAulasDestaque() {
        $query = 'select txt.id, txt.titulo, txt.chamada, dt_exibe, txt.url_img_destaque from tb_texto as txt inner join tb_categ_texto as ctxt on txt.id_categ_texto= ctxt.id where ctxt.id = 2 and txt.ativo = 1 and txt.destaque = 1';
        return $this->db->select($query);
    }

    public function getAllNovidades() {
        $query = 'select txt.id, txt.titulo, txt.chamada, dt_exibe, txt.url_img_destaque from tb_texto as txt inner join tb_categ_texto as ctxt on txt.id_categ_texto= ctxt.id where ctxt.id = 3 and txt.ativo = 1 and txt.destaque = 0';
        return $this->db->select($query);
    }

    public function getNovidadesDestaque() {
        $query = 'select txt.id, txt.titulo, txt.chamada, dt_exibe, txt.url_img_destaque from tb_texto as txt inner join tb_categ_texto as ctxt on txt.id_categ_texto= ctxt.id where ctxt.id = 3 and txt.ativo = 1 and txt.destaque = 1';
        return $this->db->select($query);
    }

    public function getAllDicionario() {
        $query = 'select txt.id, txt.titulo, txt.chamada, dt_exibe, txt.url_img_destaque from tb_texto as txt inner join tb_categ_texto as ctxt on txt.id_categ_texto= ctxt.id where ctxt.id = 4 and txt.ativo = 1 and txt.destaque = 0';
        return $this->db->select($query);
    }

    public function getDicionarioDestaque() {
        $query = 'select txt.id, txt.titulo, txt.chamada, dt_exibe, txt.url_img_destaque from tb_texto as txt inner join tb_categ_texto as ctxt on txt.id_categ_texto= ctxt.id where ctxt.id = 4 and txt.ativo = 1 and txt.destaque = 1';
        return $this->db->select($query);
    }
 

    protected function getTableName()
    {
        return 'tb_texto';
    }
}