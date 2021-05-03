<?php
namespace Admin0902\Models;

use Foundation\Database\Model;

class Textopacientes extends Model
{
    public function getTextopublicoAll(){
        $query = 'SELECT * FROM tb_texto WHERE id in (9,10,11,12,13)';
        return $this->db->select($query);
    }
    
    public function getTratamentosImgByIdMax($id, $tipo){
        $query = 'select max(cd_img) as max_id_img from tb_texto_img where cd_texto = '.$id.' and tipo_texto_img = '.$tipo;
        return $this->db->select($query);
    }
    
    public function getTratamentosImgG($id){
        $query = 'select * from tb_texto_img where cd_texto = '.$id.' and tipo_texto_img = 3';
        return $this->db->select($query);
    }
    
    public function deleteImgById($id){
        $where = sprintf('cd_texto_img = %s', (int) $id);
        $this->db->delete('tb_texto_img', $where);
        $where2 = sprintf('cd_texto_img = %s', (int) $id-1);
        return $this->db->delete('tb_texto_img', $where2);
    }
    
    public function setTratamentosImgById($tabela, array $data = []){
        return $this->db->insert($tabela, $data);
    }

    protected function getTableName()
    {
        return "tb_texto";
    }
}