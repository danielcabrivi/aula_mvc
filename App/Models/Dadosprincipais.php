<?php
namespace App\Models;

use Foundation\Database\Model;
 
class Dadosprincipais extends Model
{
    public function getAllDadosprincipais(){
        $query = 'select * from tb_config';
        return $this->db->select($query);
    }

    protected function getTableName()
    {
        return 'tb_config';
    }
}