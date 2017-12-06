<?php
/**
 * Скрипт загрузки файла на сервер
 * $_FILES['FILE'] - загружаемый файл
 * $_REQUEST['upath'] - текущая директория
 * $_REQUEST['user'] - ник пользователя
 */
require_once 'this_and_that.php';

$file_system = '..\File_System';
$upath = $_REQUEST['upath'];
$file_name = basename($_FILES['FILE']['name']);
//$user = $_REQUEST['user'];
$user = 'KiselFool';

$new_file_path = $file_system.$upath.'\\'.$file_name;

if(!check_access_right($upath, $user))
{
    echo 'Недостаточно прав';
    exit;
}

if(file_exists($new_file_path))
{
    echo 'Файл с таким именем уже существует';
    exit;
}

// Копируем файл из каталога для временного хранения файлов:
if (move_uploaded_file($_FILES['FILE']['tmp_name'], $new_file_path))
{
    change_access_rights($new_file_path, [$user]);
    echo "Файл успешно загружен на сервер";
    exit;
}

echo "Ошибка! Не удалось загрузить файл на сервер!";
exit;