<?php

class FileSystem
{
    private $cloud_path;    //путь к файловой системе облака
    private $rights_path;   //путь к файлу, содержащему права доступа к файлам


    function __construct($__cloud_path, $__rights_path)
    {
        //Проверка и иницализация пути к файловой системе облака
        if(!(is_writable($__cloud_path) && is_readable($__cloud_path)))
            throw new Exception("Incorrect path to the file system: $__cloud_path");
        $this->cloud_path = $__cloud_path;

        //Проверка и иницализация пути к файлу прав доступа
        if(!(is_writable($__rights_path) && is_readable($__rights_path)))
            throw new Exception("Incorrect path to the access rights file : $__rights_path");

        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //!!!!___СИНХРОНИЗАЦИЯ___!!!!!!
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    }

    /**
     * @param $__clpath
     * @return string
     */
    function cl2fs($__clpath)
    {
        return $this->cloud_path.$__clpath;
    }


    function fs2cl($__fspath)
    {
        //////////////////////
        ////___ДОДЕЛАТЬ___////
        //////////////////////
    }

    /**
     * Метод возвращает тип прав пользователя на файл.
     * @param string $__clpath - путь к файлу внутри файловой системы облака
     * @param string $__user - логин пользователя
     * @return string
     */
    function getRight($__clpath, $__user)
    {
        //////////////////////
        ////___ДОДЕЛАТЬ___////
        //////////////////////

        $file = file($this->rights_path);
        foreach ($file as $str)
        {

        }

        return '';  //пользователь не имеет никаких прав на файл
    }

    function getRights($__clpath)
    {
        //////////////////////
        ////___ДОДЕЛАТЬ___////
        //////////////////////
    }

    /**
     * Метод лишает пользователя прав на файл.
     * @param $__clpath
     * @param string $__user
     * @return bool
     */
    function delRight($__clpath, $__user)
    {
        //////////////////////
        ////___ДОДЕЛАТЬ___////
        //////////////////////

        //////////////////////////////////////
        ////___ИСКЛЮЧЕНИЕ ДЛЯ ВЛАДЕЛЬЦА___////
        //////////////////////////////////////

        return true;
    }

    /**
     * Метод удаляет все права на файл.
     * @param $__clpath
     * @return bool
     */
    function delFileRights($__clpath)
    {
        //////////////////////
        ////___ДОДЕЛАТЬ___////
        //////////////////////

        return true;
    }

    /**
     * Метод лишает пользователя прав на все файлы
     * и удаляет все права на файлы, владельцем которых он является.
     * @param $__user
     * @return bool
     */
    function delUserRights($__user)
    {
        //////////////////////
        ////___ДОДЕЛАТЬ___////
        //////////////////////

        return true;
    }

    function removeFile($__clpath)
    {
        ///////////////////////////////////////////////////////////////
        ////___ДОБАВИТЬ РЕКУРСИВНОЕ УДАЛЕНИЕ ПРАВ ДЛЯ ДИРЕКТОРИЙ___////
        ///////////////////////////////////////////////////////////////

        $fspath = $this->cl2fs($__clpath);

        $remove = false;
        if(is_dir($fspath))
        {
            $files_arr = glob($fspath."/*");
            foreach($files_arr as $file)
                $remove &= remove($file);

            $remove &= rmdir($fspath);
        }
        else
            $remove = unlink($fspath);

        if($remove)
            $remove = $this->delFileRights($__clpath);

        return $remove;
    }


    function getInfo($__clpath)
    {
        //////////////////////
        ////___ДОДЕЛАТЬ___////
        //////////////////////

        $fspath = $this->cl2fs($__clpath);

        $info = [];                        //данные о файле:
        if(is_dir($fspath))
        {
            $path_arr = glob($fspath . '\*');

            foreach($path_arr as $path)
                $path =
                $info[] = $this->getInfo($path);
        }
        else
        {
            $file_info['type'] = filetype($fspath);   //тип файла
            $file_info['name'] = basename($fspath);   //имя файла
            $file_info['size'] = (is_dir($fspath))    //размер файла
                ?dirsize($fspath)
                :filesize($fspath);
            $file_info['chdate'] = filemtime($fspath);//время последней модификации

            $access_rights = [];
            $file_info['access_rights'] = $access_rights;   //права дотупа
        }

        return $info;
    }
}