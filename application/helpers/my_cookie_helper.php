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
        $cookie = array(
            'name'      => $name,
            'value'     => $value,
            'expire'    => My_cookie_helper::EXPIRE,
            'host'      => My_cookie_helper::HOST,
            'path'      => My_cookie_helper::PATH,
            'secure'    => FALSE
        );

        $ci =& get_instance();
        $ci->input->set_cookie($cookie);
    }


    public static function getCookie($name)
    {
        $ci =& get_instance();
        $ci->input->cookie($name);
    }


    public static function deleteCookie($name)
    {
        Debug::log("Removing cookie - $name");
        My_cookie_helper::setCookie($name, '');
    }
}