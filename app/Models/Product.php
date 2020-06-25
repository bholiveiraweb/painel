<?php

namespace App\Models;

use App\Core\Database;

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function create(object $data)
    {
        $stmt = $this->db->prepare("INSERT INTO tb_products (id_department, title, description, price, image, link, slug, created_at, updated_at) 
                                    VALUES (:id_department, :title, :description, :price, :image, :link, :slug, NOW(), NOW())");

        $stmt->bindValue(':id_department', $data->department);
        $stmt->bindValue(':title', $data->title);
        $stmt->bindValue(':description', $data->description);
        $stmt->bindValue(':price', $data->price);
        $stmt->bindValue(':image', $data->image);
        $stmt->bindValue(':link', $data->link);
        $stmt->bindValue(':slug', $data->slug);

        return $stmt->execute();
    }

    public function getAllProducts()
    {
        $stmt = $this->db->query("SELECT tb_products.*, tb_departments.title as department_title FROM tb_products 
                                INNER JOIN tb_departments ON tb_departments.id = tb_products.id_department");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductFromId(int $id)
    {
        $stmt = $this->db->prepare("SELECT tb_products.*, tb_departments.title as department_title FROM tb_products 
                                    INNER JOIN tb_departments ON tb_departments.id = tb_products.id_department
                                    WHERE tb_products.id = ?");

        $stmt->bindValue(1, $id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getProductsByDepartment($slug)
    {
        $stmt = $this->db->prepare("SELECT tb_products.*, tb_departments.title as department_title FROM tb_products
                                    INNER JOIN tb_departments ON tb_departments.id = tb_products.id_department 
                                    WHERE tb_departments.slug = ?", [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);

        $stmt->bindValue(1, $slug);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update(object $data)
    {
        $stmt = $this->db->prepare("UPDATE tb_products 
                                    SET id_department = :id_department, title = :title, description = :description, price = :price, link = :link, slug = :slug, updated_at = NOW()
                                    WHERE id = :id");

        $stmt->bindValue(':id_department', $data->department);
        $stmt->bindValue(':title', $data->title);
        // $stmt->bindValue(':description', $data->description);
        $stmt->bindValue(':description', null);
        $stmt->bindValue(':price', $data->price);
        $stmt->bindValue(':link', $data->link);
        // $stmt->bindValue(':slug', $data->slug);
        $stmt->bindValue(':slug', null);
        $stmt->bindValue(':id', $data->id);

        if ($stmt->execute()) {

            if (!is_null($data->image)) {

                $stmt = $this->db->query("SELECT image FROM tb_products WHERE id = {$data->id}");
                $product_image = $stmt->fetch(\PDO::FETCH_OBJ);

                if (is_file(PUBLIC_PATH . "/uploads/images/{$product_image->image}"))
                    unlink(PUBLIC_PATH . "/uploads/images/{$product_image->image}");

                $stmt = $this->db->prepare("UPDATE tb_products SET image = :image WHERE id = :id");

                $stmt->bindValue(':image', $data->image);
                $stmt->bindValue(':id', $data->id);

                $stmt->execute();
            }

            return $this->getProductFromId($data->id);
        } else {
            return false;
        }
    }

    public function delete(int $id)
    {
        $stmt = $this->db->query("SELECT image FROM tb_products WHERE id = {$id}");
        $product_image = $stmt->fetch(\PDO::FETCH_OBJ);

        $stmt = $this->db->prepare("DELETE FROM tb_products WHERE id = ?");
        $stmt->bindValue(1, $id);

        if (is_file(PUBLIC_PATH . "/uploads/images/{$product_image->image}"))
            unlink(PUBLIC_PATH . "/uploads/images/{$product_image->image}");

        return $stmt->execute();
    }
}
