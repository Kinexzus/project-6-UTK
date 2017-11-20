<?php

$login = $_REQUEST['login'];
//прверка наличия такого логина в бд
//вывод ошибки при отсутствии пользователя с таким логином
$user = ['login' => 'логин', 'saltpassword' => 'соленый пароль', 'salt' => 'соль'];

$password = $_REQUEST['password'];
$salt = $user['salt'];
$saltpassword = md5($password.$user['salt']);
if ($user['saltpassword'] != $saltpassword)
    return 'ошибка пароля';

//стартуем сессию и заполняем cookies
//переход к представлению корневой папки пользователя