<?php

namespace App\Lib;


class Session
{
    public static function init() {

        session_start();
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function all() {
        return $_SESSION;
    }

    public static function destroy() {
        //unset($_SESSION);
        session_destroy();
    }

    public static function unsetSession($key) {
        unset($_SESSION[$key]);
    }
}