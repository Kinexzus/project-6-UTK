<?php
/**
 * Скрипт создает новую директорию
 * $_REQUEST['dir'] - имя новой директории
 * $_REQUEST['upath'] - где создавать новую директорию
 * $_REQUEST['user'] - ник пользователя
 */

require_once 'this_and_that.php';


$user = $_REQUEST['user'];
$dir_name = $_REQUEST['dir'];
$upath = $_REQUEST['upath'];
$file_system = '..\File_System';

$new_dir_path = $file_system.$upath.'\\'.$dir_name;

if(file_exists($new_dir_path))
{
    echo 'Директория с таким именем уже сущетвует';
    exit;
}

change_access_rights($new_dir_path, [$user]);
mkdir($new_dir_path);