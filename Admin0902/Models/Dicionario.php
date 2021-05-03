<?php
namespace Admin0902\Models;

use Foundation\Database\Model;
 
class Dicionario extends Model 
{
    public function getAllDicionario(){
        $query = 'SELECT * FROM tb_texto WHERE id_categ_texto = 4';
        return $this->db->select($query); 
    }

    public function getAllAtivos(){
        $query = 'SELECT * FROM tb_texto WHERE ativo = 1 AND id_categ_texto = 4';
        return $this->db->select($query);
    } 

    public function getDicionarioImgByIdMax($id, $tipo){
        $query = 'select max(id_img) as max_id_img from tb_texto_img where id_texto = '.$id.' and tipo = '.$tipo;
        return $this->db->select($query);
    }
    
    public function getDicionarioImgP($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 1';
        return $this->db->select($query);
    }

    public function getDicionarioImgM($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 2';
        return $this->db->select($query);
    }

    public function getDicionarioImgG($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 3';
        return $this->db->select($query);
    }

    public function getDicionarioImgO($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 4';
        return $this->db->select($query);
    }

    public function getDicionarioImgDestaque($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 5';
        return $this->db->select($query);
    }
    
    public function deleteImgById($id){
        $where = sprintf('id = %s', (int) $id);
        return $this->db->delete('tb_texto_img', $where);
        $where2 = sprintf('id = %s', (int) $id-1);
        return $this->db->delete('tb_texto_img', $where2);
    }
    
    public function setDicionarioImgById($tabela, array $data = []){
        return $this->db->insert($tabela, $data);
    }

    protected function getTableName()
    {
        return "tb_texto";
    }
}