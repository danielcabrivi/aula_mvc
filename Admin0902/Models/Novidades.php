<?php
namespace Admin0902\Models;

use Foundation\Database\Model;
 
class Novidades extends Model 
{
    public function getAllNovidades(){
        $query = 'SELECT * FROM tb_texto WHERE id_categ_texto = 3';
        return $this->db->select($query); 
    }

    public function getAllAtivos(){ 
        $query = 'SELECT * FROM tb_texto WHERE ativo = 1 AND id_categ_texto = 3';
        return $this->db->select($query);
    }
    
    public function getNovidadesImgByIdMax($id, $tipo){
        $query = 'select max(id_img) as max_id_img from tb_texto_img where id_texto = '.$id.' and tipo = '.$tipo;
        return $this->db->select($query);
    }
    
    public function getNovidadesImgP($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 1';
        return $this->db->select($query);
    }
    
    public function getNovidadesImgM($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 2';
        return $this->db->select($query);
    }
    
    public function getNovidadesImgG($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 3';
        return $this->db->select($query);
    }

    public function getNovidadesImgO($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 4';
        return $this->db->select($query);
    } 

    public function getNovidadesImgDestaque($id){
        $query = 'select * from tb_texto_img where id_texto = '.$id.' and tipo = 5';
        return $this->db->select($query);
    }
    
    public function deleteImgById($id){
        $where = sprintf('id = %s', (int) $id);
        return $this->db->delete('tb_texto_img', $where);
        $where2 = sprintf('id = %s', (int) $id-1);
        return $this->db->delete('tb_texto_img', $where2);
    }
    
    public function setNovidadeImgById($tabela, array $data = []){
        return $this->db->insert($tabela, $data);
    }

    protected function getTableName()
    {
        return "tb_texto";
    }
}