<?php
/**
 * Скрипт для скачивания файла с сервера
 * $_REQUEST['file'] - путь внутри файловой систмы к скачиваемому файлу
 */


if(!isset($_REQUEST['file']) || !file_exists('..\File_System'.$_REQUEST['file']))
    //обработка ошибки
    exit();

$filename = '..\File_System'.$_REQUEST['file'];

if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');

$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch( $file_extension )
{
    case "pdf": $ctype="application/pdf"; break;
    case "exe": $ctype="application/octet-stream"; break;
    case "zip": $ctype="application/zip"; break;
    case "doc": $ctype="application/msword"; break;
    case "xls": $ctype="application/vnd.ms-excel"; break;
    case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
    case "mp3": $ctype="audio/mp3"; break;
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpg"; break;
    default: $ctype="application/force-download";
}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // нужен для Explorer
header('Content-Type: '.$ctype.'; charset=utf-8');
header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));

exit();