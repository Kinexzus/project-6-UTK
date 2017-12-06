<?php
/**
 * Скрипт удаления файла или директори
 * $_REQUEST['upath'] - путь к удаляемому файлу
 * $_REQUEST['user'] - ник пользователя
 */
require_once 'this_and_that.php';

$file_system = '..\File_System';
$upath = $_REQUEST['upath'];
//$user = $_REQUEST['user'];
$user = 'KiselFool';

$file_path = $file_system.$upath;

if(!check_access_right($upath, $user))
{
    echo 'Недостаточно прав';
    exit;
}

if (!file_exists($file_path))
{
    echo 'Файл не найден';
    exit;
}

if(!remove($file_path))
{
    echo 'Не удалось удалить файл';
    exit;
}

delete_access_rights($file_path);
echo 'Файл успешно удален';
exit;
