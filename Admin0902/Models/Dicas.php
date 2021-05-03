<?php
namespace Admin0902\Models;

use Foundation\Database\Model;

class Dicas extends Model
{
    public function getAllDicas(){
        $query = 'SELECT * FROM tb_texto WHERE id_categ_texto = 1';
        return $this->db->select($query);  
    }

    public function getAllAtivos(){
        $query = 'SELECT * FROM tb_texto WHERE id_categ_texto = 1 AND ativo = 1';
        return $this->db->select($query);
    }
    
    public function getDicasImgByIdMax($id, $tipo){
        $query = 'select max(id_img) as max_id_img from tb_texto_img where id_texto = '.$id.' and tipo = '.$tipo;
        return $this->db->select($query);
    }
    
    public function getDicasImgP($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 1';
        return $this->db->select($query);
    }

    public function getDicasImgM($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 2';
        return $this->db->select($query);
    }
    
    public function getDicasImgG($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 3';
        return $this->db->select($query);
    }
    
    public function getDicasImgO($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 4';
        return $this->db->select($query);
    }

    public function getDicasImgDestaque($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 5';
        return $this->db->select($query);
    }

    public function deleteImgById($id){
        $where = sprintf('id = %s', (int) $id);
        return $this->db->delete('tb_texto_img', $where);
        $where2 = sprintf('id = %s', (int) $id-1);
        return $this->db->delete('tb_texto_img', $where2);
    }
    
    public function setDicaImgById($tabela, array $data = []){
        return $this->db->insert($tabela, $data);
    }

    protected function getTableName()
    {
        return "tb_texto";
    }
}