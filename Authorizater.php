<?php

class Authorizater
{
    private $users_path;    //путь до файла с информацией о пользователях


    function __construct($__users_path)
    {
        $this->users_path = $__users_path;
    }


    /**
     * Метод регистрирует пользователя (заносит информацию о нем в файл)
     * @param string $__login
     * @param string $__password
     * @param string $__mail
     * @return bool
     */
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

    /**
     * Метод проверяет, занят ли логин
     * @param $__login
     * @return bool
     */
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


    /**
     * Метод проверяет, занят ли адрес почты
     * @param $__mail
     * @return bool
     */
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


    /**
     * Метод проверяет наличие пользователя с данным логином и паролем
     * @param $__login
     * @param $__password
     * @return bool
     */
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


    /**
     * Метод производит вход пользователя в систему
     * @param $__login
     */
    function login($__login)
    {
        setcookie('login', $__login);
    }


    /**
     * Метод производит выход текущего пользователя из системы
     */
    function logout()
    {
        setcookie('login', '', time());
    }


    /**
     * Метод возвращает логин текущего пользователя
     * @return bool
     */
    function getLogin()
    {
        if(!isset($_COOKIE['login']))
            return false;

        return $_COOKIE['login'];
    }


    /**
     * Метод возвращает список всех пользователей, зарегестрированных в системе
     * @return array
     */
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