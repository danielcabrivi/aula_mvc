<?php
namespace AdminApp\Models;

use AdminFoundation\Database\Model;

class Equipe extends Model
{
    protected function getTableName()
    {
        return 'tb_membro';
    }
    
    public function getEquipeImgByIdMax($id, $tipo){
        $query = 'select max(cd_img) as max_id_img from tb_membro_img where cd_membro = '.$id.' and tipo_texto_img = '.$tipo;
        return $this->db->select($query);
    }
    
    public function getEquipeImgM($id){
        $query = 'select foto_membro from tb_membro where cd_membro = '.$id;
        return $this->db->select($query);
    }
    
    public function deleteImgById($id){
        $where = sprintf('cd_membro_img = %s', (int) $id);
        $this->db->delete('tb_membro_img', $where);
        $where2 = sprintf('cd_membro_img = %s', (int) $id-1);
        return $this->db->delete('tb_membro_img', $where2);
    }
    
    public function setEquipeImgById($tabela, array $data = []){
        return $this->db->insert($tabela, $data);
    }
}