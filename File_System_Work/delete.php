<?php

if(!isset($_REQUEST['file']) || !file_exists('..\File_System'.$_REQUEST['file']))
    //обработка ошибки
    exit();

$filename = '..\File_System'.$_REQUEST['file'];

(is_dir($filename))
    ?removeDir($filename)
    :unlink($filename);



function removeDir($dir)
{
    if ($files_arr = glob($dir."/*"))
    {
        foreach($files_arr as $file)
        {
            is_dir($file)
                ? rmDir($file)
                : unlink($file);
        }
    }

    rmdir($dir);
}