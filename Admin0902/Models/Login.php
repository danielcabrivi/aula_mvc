<?php
namespace Admin0902\Models;

use Foundation\Database\Model;

class Login extends Model
{
    public function getUserAtivo($login, $senha){
        $sql = "SELECT * FROM tb_user WHERE  login = :login_user and senha = :senha_user and ativo = 1 LIMIT 1";
        $where = ['login_user' => $login, 'senha_user' => $senha];
        return $this->db->select($sql, $where);
    }

    protected function getTableName() {
        return 'tb_user';
    }
}