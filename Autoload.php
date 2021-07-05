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
            return self::require_file([$class, $namespace, $dir]);
        }
    }

    private static function require_file($file_info)
    {
        $file = self::$root . str_replace("\\", "/", $file_info[2] . self::mb_str_right($file_info[0], $file_info[1])) . ".php";
        if (is_file($file)) {
            require_once $file;
            return true;
        }
        if (self::$error) {
            trigger_error("got an error while trying to load class [{$file_info[0]}] and couldn't find [{$file}] file.", 1024);
        }
        return false;
    }

    private static function mb_str_right($str, $q, $off = 0)
    {
        return mb_substr($str, mb_strpos($str, $q, $off) + mb_strlen($q), mb_strlen($str));
    }
}
