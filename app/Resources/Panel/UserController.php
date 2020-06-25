<?php

namespace App\Resources\Panel;

use App\Helpers\ValidationForm;
use App\Core\View;
use App\Helpers\Session;
use App\Models\User;
use stdClass;

class UserController
{
    public function login()
    {
        View::render('panel/login/form.twig');
    }

    public function signin()
    {
        $validation = new ValidationForm;

        $email = $validation->setField('email', 'E-mail')->isEmail();
        $password = $validation->setField('password', 'Senha')->required()->sanitize()->trim();

        if ($validation->hasError()) {

            if ($email->getError('email'))
                $data['email_error'] = $email->getError('email');

            if ($password->getError('password'))
                $data['password_error'] = $email->getError('password');

            View::render('panel/login/form.twig', $data);
        } else {

            $field = new stdClass;
            $field->email = $email->getValue('email');
            $field->password = $password->getValue('password');

            $user = (new User)->doLogin($field);

            if ($user) {
                (new Session)->setSession('logged_in', true);
                (new Session)->setSession('user_data', $user);

                header('Location: ' . BASE_URL . '/painel');
            } else {
                $data['loggin_error'] = 'Não foi possível fazer login, tente novamente!';
                View::render('panel/login/form.twig', $data);
            }
        }
    }

    public function signout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/acessar');
    }
}
