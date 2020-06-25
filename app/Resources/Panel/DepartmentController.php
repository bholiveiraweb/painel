<?php

namespace App\Resources\Panel;

use App\Core\Router;
use App\Core\View;
use App\Helpers\Session;
use App\Helpers\ValidationForm;
use App\Models\Department;
use App\Models\User;
use \stdClass;

class DepartmentController
{
    public function index()
    {
        (new User)->verifyLogin();

        $data['departments'] = (new Department)->getAllDepartments();

        View::render('panel/departments/index.twig', $data);
    }

    public function new()
    {
        (new User)->verifyLogin();

        View::render('panel/departments/form.twig');
    }

    public function edit($id)
    {
        (new User)->verifyLogin();

        $id = (int) $id;

        $data['department'] = (new Department)->getDepartmentFromId($id);

        View::render('panel/departments/form.twig', $data);
    }

    public function store($id = null)
    {
        (new User)->verifyLogin();

        $validation = new ValidationForm;

        $title = $validation->setField('title', 'Título')->required()->sanitize()->trim();
        $slug  = $validation->setField('slug', 'Slug')->required()->sanitize()->trim();

        if ($validation->hasError()) {

            if ($title->getError('title'))
                $data['title_error'] = $title->getError('title');

            if ($title->getError('slug'))
                $data['slug_error'] = $title->getError('slug');
        } else {

            $field = new stdClass;

            $field->title = $title->getValue('title');
            $field->slug  = $title->getValue('slug');

            if ($id) {

                $field->id = (int) $id;

                $department = (new Department)->update($field);

                if ($department) {
                    $data['department'] = $department;
                    (new Session)->setSession('success_message', 'Departamento atualizado com sucesso!');
                } else {
                    (new Session)->setSession('error_message', 'Houve um erro ao atualizar, tente novamente!');
                }

                (new Router)->redirect("/painel/departamentos/edit/{$id}");
            } else {

                $department = (new Department)->create($field);

                if ($department) {
                    (new Session)->setSession('success_message', 'Departamento cadastrado com sucesso!');
                } else {
                    (new Session)->setSession('error_message', 'Houve um erro ao cadastrar, tente novamente!');
                }

                (new Router)->redirect("/painel/departamentos/novo");
            }
        }

        View::render('panel/departments/form.twig', $data);
    }

    public function delete($id)
    {
        (new User)->verifyLogin();

        $id = (int) $id;

        if ((new Department)->delete($id)) {
            header('Location: ' . BASE_URL . '/painel/departamentos');
        }
    }
}
