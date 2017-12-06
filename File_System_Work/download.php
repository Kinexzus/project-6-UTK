<?php
/**
 * Скрипт для скачивания файла с сервера
 * $_REQUEST['upath'] - путь к запрашиваемому файла
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

// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
// если этого не сделать файл будет читаться в память полностью!
if (ob_get_level())
    ob_end_clean();

if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');

// заставляем браузер показать окно сохранения файла
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($file_path));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));
// читаем файл и отправляем его пользователю
readfile($file_path);

exit;
