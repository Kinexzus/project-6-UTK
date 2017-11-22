<?php
/**
 * Скрипт удаления файла или директори
 * $_REQUEST['file'] - путь внутри файловой системы к удаляемому файлу
 */

if(!isset($_REQUEST['file']) || !file_exists('..\File_System'.$_REQUEST['file']))
    //обработка ошибки
    exit();

$file_path = '..\File_System'.$_REQUEST['file'];    //путь на сервере к удаляемому файлу

is_dir($file_path)
    ?removeDir($file_path)
    :unlink($file_path);




/**
 * Функция производит рекурсивное удаление директории
 * @param string $__dir_path - путь к директории
 */
function removeDir($__dir_path)
{
    if ($files_arr = glob($__dir_path."/*"))
    {
        foreach($files_arr as $file)
        {
            is_dir($file)
                ? rmDir($file)
                : unlink($file);
        }
    }

    rmdir($__dir_path);
}