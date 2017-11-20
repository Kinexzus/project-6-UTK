<?php

/**
 * Функция возваращает данные о содержимом директории
 * @param string $__upath - путь к директории формата '\user\folder\...\otherfolder'
 * @return array
 */
function in_dir($__upath)
{
    $fspath = '..\File_System';

    $path_arr = glob($fspath . $__upath . '\*');

    $files_arr = [];    //массив файлов
    $files_arr[0] = $__upath;
    foreach($path_arr as $path)
    {
        $file_info = [];                        //данные о файле:
        $file_info['type'] = filetype($path);   //тип файла
        $file_info['name'] = basename($path);   //имя файла
        $file_info['size'] = filesize($path);   //размер файла
        $file_info['chdate'] = filemtime($path);//время последней модификации
        //права дотупа

        $files_arr[] = $file_info;
    }

    return $files_arr;
}