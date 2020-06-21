<?php

namespace App\Models;

use App\Core\Database;
use App\Helpers\Session;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function verifyLogin()
    {
        $session = new Session;

        if (
            !$session->getSession('logged_in') ||
            !$session->getSession('user_data')
        ) {
            $session->destroySessions();
            header('Location: ' . BASE_URL . '/acessar');
        }
    }

    public function doLogin(object $data)
    {
        $stmt = $this->db->prepare("SELECT * FROM tb_users WHERE email = ?");
        $stmt->bindValue(1, $data->email);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        if (!password_verify($data->password, $result->password)) {
            return false;
        }

        unset($result->password);
        return $result;
    }
}
