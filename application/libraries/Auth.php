<?php

/**
 * Class responsible for managing auth data.
 *
 * @author mark
 */
class Auth
{

    private $_username;
    private $_password;
    private $_isAdmin;
    private $_instance;

    public static function getInstance()
    {
        if ($this->_instance == null) {
            $this->_instance = $this->__construct();
        }
        return $this->_instance;
    }


    private function __construct()
    {
        Debug::log('Constructing auth.');
    }


    public function register()
    {

    }


    public function unregister()
    {

    }

    public function login()
    {

    }

    public function logout()
    {

    }

    public function isAdmin()
    {

    }


    public function getUsername()
    {

    }

}
