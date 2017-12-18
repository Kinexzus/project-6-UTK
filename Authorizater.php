<?php

class Authorizater
{
    private $users_path;

    function __construct($__users_path)
    {
        $this->users_path = $__users_path;
    }


    function register($__login, $__password, $__mail)
    {
        $file = fopen($this->users_path, 'a');
        if ($file)
        {
            $hash = md5($__password);
            $rights = "$__login::$hash::$__mail\n";
            if (fputs($file, $rights))
                if (fclose($file))
                    return true;
        }

        return false;
    }

    function loginExists($__login)
    {
        $file = fopen($this->users_path, 'r');
        while(!feof($file)) {
            $str = trim(fgets($file), "\n");
            if(!$str)
                continue;
            $data = explode('::', $str);
            if ($data[0] == $__login)
                return true;
        }

        return false;
    }

    function mailExists($__mail)
    {
        $file = fopen($this->users_path, 'r');
        while(!feof($file)) {
            $str = trim(fgets($file), "\n");
            if(!$str)
                continue;
            $data = explode('::', $str);
            if ($data[2] == $__mail)
                return true;
        }

        return false;
    }

    function loginCheck($__login, $__password)
    {
        $file = fopen($this->users_path, 'r');
        while(!feof($file)) {
            $str = trim(fgets($file), "\n");
            $data = explode('::', $str);
            if ($data[0] == $__login)
                if($data[1] == md5($__password))
                    return true;
        }

        return false;
    }

    function login($__login)
    {
        setcookie('login', $__login);
    }

    function logout()
    {
        setcookie('login', '', time());
    }

    function getLogin()
    {
        if(!isset($_COOKIE['login']))
            return false;

        return $_COOKIE['login'];
    }

    function getUsers()
    {
        $users = [];
        $user = $this->getLogin();
        $file = fopen($this->users_path, 'r');
        while(!feof($file)) {
            $str = trim(fgets($file), "\n");
            if(!$str)
                continue;
            $data = explode('::', $str);
            if(isset($data[0]) && $data[0] != $user)
                $users[] = $data[0];
        }

        return $users;
    }
}