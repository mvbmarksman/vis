<?php
class My_cookie_helper
{
    const EXPIRE = 604800; // 1 week
    const HOST = 'local.vis.com';
    const PATH = '/';
    const SECURE = false;

    public static function setCookie($name, $value)
    {
        Debug::log("Creating cookie with name:[$name] value:[$value] expire:[" . My_cookie_helper::EXPIRE . '] path:[' . My_cookie_helper::PATH
                . '] host: [' . My_cookie_helper::HOST . '] secure: [' . My_cookie_helper::SECURE . ']');
        setcookie($name, $value, My_cookie_helper::EXPIRE, My_cookie_helper::PATH, My_cookie_helper::HOST, My_cookie_helper::SECURE);
    }


    public static function getCookie($name)
    {
        if (!empty($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
    }


    public static function deleteCookie($name)
    {
        setcookie($name, '', time() - 3600, My_cookie_helper::PATH, My_cookie_helper::HOST, My_cookie_helper::SECURE);
    }
}