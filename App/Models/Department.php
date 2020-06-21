<?php

namespace App\Models;

use App\Core\Database;

class Department
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function store(object $data)
    {
        $stmt = $this->db->prepare("INSERT INTO tb_departments VALUES (NULL, ?, ?, NOW(), NOW())");

        $stmt->bindValue(1, $data->title);
        $stmt->bindValue(2, $data->slug);

        return $stmt->execute();
    }

    public function getAllDepartments()
    {
        $stmt = $this->db->query("SELECT * FROM tb_departments");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDepartmentFromId(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tb_departments WHERE id = ?");

        $stmt->bindValue(1, $id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function update(object $data)
    {
        $stmt = $this->db->prepare("UPDATE tb_departments SET title = ?, slug = ?, updated_at = NOW() WHERE id = ?");

        $stmt->bindValue(1, $data->title);
        $stmt->bindValue(2, $data->slug);
        $stmt->bindValue(3, $data->id);

        if ($stmt->execute()) {
            return $this->getDepartmentFromId($data->id);
        } else {
            return false;
        }
    }

    public function delete(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM tb_departments WHERE id = ?");
        $stmt->bindValue(1, $id);

        return $stmt->execute();
    }
}
