<?php

/**
 * php Autoload 
 * 
 * @github  https://github.com/GeniusLe/PHP-Autoloader
 * @package Autoload
 */

class Autoload
{
    private static $auto_load = [];
    private static $root  = __DIR__ . "/";
    private static $error = false;

    public static function set_error($bool)
    {
        self::$error = $bool;
    }

    public static function set_root_dir($root)
    {
        self::$root = $root;
    }

    public static function add($namespace, $dir)
    {
        self::$auto_load[$namespace] = $dir;
    }

    public static function add_common($file)
    {
        if (is_file(self::$root . $file)) {
            require_once self::$root . $file;
        }
    }

    public static function remove($namespace)
    {
        unset(self::$auto_load[$namespace]);
    }

    public static function autoloader($class)
    {
        foreach (self::$auto_load as $namespace => $dir) {
            if (mb_substr($class, 0, mb_strlen($namespace)) != $namespace) continue;
            self::require_file($dir . self::take_str_right($class, $namespace));
        }
    }

    private static function require_file($file)
    {
        $file = self::$root . str_replace("\\", "/", $file) . ".php";
        if (is_file($file)) {
            require_once $file;
            return;
        }
        if (self::$error) {
            trigger_error("I got an error while trying to load [{$file}] and couldn't find this file.", 1024);
        }
    }

    private static function take_str_right($str, $q, $off = 0)
    {
        return mb_substr($str, mb_strpos($str, $q, $off) + mb_strlen($q), mb_strlen($str));
    }
}
