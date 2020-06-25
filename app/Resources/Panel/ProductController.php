<?php

namespace App\Resources\Panel;

use App\Core\Router;
use App\Core\View;
use App\Helpers\Session;
use App\Helpers\ValidationForm;
use App\Models\Department;
use App\Models\Product;
use App\Models\User;
use \stdClass;

class ProductController
{
    public function index()
    {
        (new User)->verifyLogin();

        $data['products'] = (new Product)->getAllProducts();

        View::render('panel/products/index.twig', $data);
    }

    public function new()
    {
        (new User)->verifyLogin();

        $data['departments'] = (new Department)->getAllDepartments();

        View::render('panel/products/form.twig', $data);
    }

    public function edit($id)
    {
        (new User)->verifyLogin();

        $id = (int) $id;

        $data['departments'] = (new Department)->getAllDepartments();
        $data['product'] = (new Product)->getProductFromId($id);

        View::render('panel/products/form.twig', $data);
    }

    public function store($id = null)
    {
        (new User)->verifyLogin();

        $validation = new ValidationForm;

        $title = $validation->setField('title', 'Título')->required()->sanitize()->trim();
        $department = $validation->setField('id_department', 'Departamento')->required();
        // $description = $validation->setField('description', 'Descrição')->required()->sanitize()->trim();
        $price = $validation->setField('price', 'Preço')->required();
        $link = $validation->setField('link', 'Link')->required();
        // $slug = $validation->setField('slug', 'Slug')->required();

        $data['departments'] = (new Department)->getAllDepartments();

        if ($validation->hasError()) {
            if ($title->getError('title'))
                $data['title_error'] = $title->getError('title');

            if ($title->getError('id_department'))
                $data['department_error'] = $department->getError('id_department');

            /* if ($title->getError('description'))
                $data['description_error'] = $description->getError('description'); */

            if ($title->getError('price'))
                $data['price_error'] = $price->getError('price');

            if ($title->getError('link'))
                $data['link_error'] = $link->getError('link');

            /* if ($title->getError('slug'))
                $data['slug_error'] = $slug->getError('slug'); */
        } else {

            $upload_error = false;

            $field = new stdClass;

            $field->title = $title->getValue('title');
            $field->department = $department->getValue('id_department');
            // $field->description = $description->getValue('description');
            $field->price = $price->getValue('price');
            $field->image = null;
            $field->link = $link->getValue('link');
            // $field->slug = $slug->getValue('slug');

            if ($_FILES['image']['error'] != 4) {

                $allowed_extensions = ['jpg', 'jpeg', 'pjpeg', 'png', 'gif'];
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                if (!in_array($extension, $allowed_extensions)) {
                    $upload_error = true;
                    (new Session)->setSession('error_message', 'Desculpe, extensão não permitida, tente novamente! :(');
                } else {

                    $dir = PUBLIC_PATH . '/uploads/images/';
                    $temp = $_FILES['image']['tmp_name'];
                    $filename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_FILES['image']['name']), '-')) . uniqid('_') . ".{$extension}";

                    if (!is_dir($dir))
                        mkdir($dir);

                    if (!move_uploaded_file($temp, $dir . $filename)) {
                        $upload_error = true;
                        (new Session)->setSession('error_message', 'Desculpe, houve um erro ao fazer upload do arquivo, tente novamente! :(');
                    } else {
                        $field->image = $filename;
                    }
                }
            }

            if (!$upload_error) {

                if ($id) {

                    $field->id = (int) $id;

                    $product = (new Product)->update($field);

                    if ($product) {
                        $data['product'] = $product;
                        (new Session)->setSession('success_message', 'Produto atualizado com sucesso!');
                    } else {
                        (new Session)->setSession('error_message', 'Houve um erro ao atualizar, tente novamente!');
                    }

                    (new Router)->redirect("/painel/produtos/edit/{$id}");
                } else {

                    $product = (new Product)->create($field);

                    if ($product) {
                        (new Session)->setSession('success_message', 'Produto cadastrado com sucesso!');
                    } else {
                        (new Session)->setSession('error_message', 'Houve um erro ao cadastrar, tente novamente!');
                    }

                    (new Router)->redirect("/painel/produtos/novo");
                }
            }
        }

        View::render('panel/products/form.twig', $data);
    }

    public function delete($id)
    {
        (new User)->verifyLogin();

        $id = (int) $id;

        if ((new Product)->delete($id)) {
            header('Location: ' . BASE_URL . '/painel/produtos');
        }
    }
}
