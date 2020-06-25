<?php

namespace App\Core;

use App\Helpers\Session;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    public static function render($view, $vars = [])
    {
        $loader = new FilesystemLoader(VIEW_PATH);
        $twig = new Environment($loader, [
            'debug' => true,
            //'cache' => CACHE_PATH,
        ]);
        $twig->addGlobal('session', new Session);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        echo $twig->render($view, $vars);
    }
}
