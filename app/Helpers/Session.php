<?php

namespace App\Helpers;

class Session
{
    public function setSession(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession(string $key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
    }

    public function getAllSessions()
    {
        return $_SESSION;
    }

    public function unsetSession(string $key)
    {
        if (isset($_SESSION[$key]))
            unset($_SESSION[$key]);
    }

    public function destroySessions()
    {
        session_destroy();
    }
}
