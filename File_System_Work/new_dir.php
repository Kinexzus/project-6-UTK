<?php
/**
 * Скрипт создает новую директорию
 * $_REQUEST['dir'] - имя новой директории
 * $_REQUEST['upath'] - текущая директория
 * $_REQUEST['user'] - ник пользователя
 */
require_once 'this_and_that.php';

$file_system = '..\File_System';
$upath = $_REQUEST['upath'];
$dir_name = $_REQUEST['dir'];
//$user = $_REQUEST['user'];
$user = 'KiselFool';

$new_dir_path = $file_system.$upath.'\\'.$dir_name;

if(!check_access_right($upath, $user))
{
    echo 'Недостаточно прав';
    exit;
}

if(file_exists($new_dir_path))
{
    echo 'Директория с таким именем уже сущетвует';
    exit;
}

change_access_rights($new_dir_path, [$user]);
if(!@mkdir($new_dir_path))
{
    echo 'Ошибка создания директории';
    exit;
}

echo 'Директория успешно создана';
exit;
