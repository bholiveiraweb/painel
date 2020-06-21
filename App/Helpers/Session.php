<?php

namespace App\Helpers;

class Session
{
    public function setSession(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function getSession(string $name)
    {
        return $_SESSION[$name];
    }

    public function getAllSessions()
    {
        return $_SESSION;
    }

    public function unsetSession(string $name)
    {
        unset($_SESSION[$name]);
    }

    public function destroySessions()
    {
        session_destroy();
    }
}
