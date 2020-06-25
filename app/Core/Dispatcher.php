<?php

namespace App\Core;

class Dispatcher
{
    private static $namespace = null;
    private static $error;

    public static function setNamespace($namespace)
    {
        self::$namespace = $namespace;
    }

    public static function getNamespace()
    {
        return self::$namespace;
    }

    public static function getError()
    {
        return self::$error;
    }

    public static function dispatch($route, $callback)
    {
        self::$error = true;

        $_uri = strtok($_SERVER['REQUEST_URI'], '?');
        $args = [];

        $pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $route);

        if (preg_match("#^({$pattern})*$#i", $_uri, $match) === 1) {

            self::$error = false;

            $route = current($match);
            $args = array_slice($match, 2);

            $callbackSplit = explode('::', $callback);
            $controller    = ucfirst(current($callbackSplit)) ?? ucfirst(current($callbackSplit));
            $action        = implode(array_slice($callbackSplit, 1, 1));

            $controller = self::getNamespace() . '\\' . $controller;

            if (class_exists($controller) && method_exists($controller, $action)) {
                call_user_func_array([$controller, $action], $args);
                exit;
            }
        }
    }
}
