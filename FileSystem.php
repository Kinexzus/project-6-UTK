<?php
/**
 * Class FileSystem - Класс для работы с файловой системой облачного хранилища и правами доступа к файлам
 */
class FileSystem
{
    private $cloud_path;    //путь к файловой системе облака
    private $rights_path;   //путь к файлу, содержащему права доступа к файлам


    function __construct($__cloud_path, $__rights_path)
    {
        //Проверка и иницализация пути к файловой системе облака
        if (!(is_writable($__cloud_path) && is_readable($__cloud_path)))
            throw new Exception("Incorrect path to the file system: $__cloud_path");
        $this->cloud_path = $__cloud_path;
        ////////////////////////////////////
        ////___ПРОВЕРКА НА ВСЕ ДЕРЕВО___////
        ////////////////////////////////////


        //Проверка и иницализация пути к файлу прав доступа
        if (!(is_writable($__rights_path) && is_readable($__rights_path)))
            throw new Exception("Incorrect path to the access rights file : $__rights_path");
        $this->rights_path = $__rights_path;


        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //!!!!___СИНХРОНИЗАЦИЯ___!!!!!!
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    }


    /**
     * Метод конвертирует представление пути к файлу в файловой системе облака
     * в представление пути к файлу в файловой системе сервера
     * @param $__clpath
     * @return string
     */
    function cl2fs($__clpath)
    {
        $__clpath = str_replace('\\', '/', $__clpath);
        return $this->cloud_path . $__clpath;
    }


    /**
     * Метод конвертирует представление пути к файлу в файловой системе сервера
     * в представление пути к файлу в файловой системе облака
     * @param $__fspath
     * @return string
     */
    function fs2cl($__fspath)
    {
        $__fspath = str_replace('\\', '/', $__fspath);
        return str_replace($this->cloud_path, '', $__fspath);
    }


    /**
     * Метод возвращает тип прав пользователя на файл.
     * @param string $__clpath - путь к файлу внутри файловой системы облака
     * @param string $__user - логин пользователя
     * @return string
     */
    function getRight($__clpath, $__user)
    {
        $file = fopen($this->rights_path, 'r');
        while(!feof($file))
        {
            $str = trim(fgets($file), "\n");
            $rights = explode('::', $str);
            if ($rights[0] == $__clpath)
            {
                if ($rights[1] == $__user)
                {
                    fclose($file);
                    return 'rw';            //пользователь имеет право на чтение и запись
                }


                $users = explode(',', $rights[2]);
                foreach ($users as $user)
                    if ($user == $__user) {
                        fclose($file);
                        return 'r-';         //пользователь имеет право на чтение
                    }
            }
        }

        fclose($file);
        return '--';                          //пользователь не имеет никаких прав на файл
    }


    /**
     * Метод возвращает права на файл.
     * @param string $__clpath - путь к файлу внутри файловой системы облака
     * @return array
     */
    function getRights($__clpath)
    {
        $rights = array();

        $file = fopen($this->rights_path, 'r');
        while(!feof($file))
        {
            $str = trim(fgets($file), "\n");
            $rights_tmp = explode('::', $str);
            if(isset($rights_tmp[0]) && $rights_tmp[0] == $__clpath)
            {
                $rights['owner'] = $rights_tmp[1];
                $rights['readers'] = explode(',', $rights_tmp[2]);
                fclose($file);
                return $rights;
            }
        }

        fclose($file);
        return $rights;
    }


    /**
     * Устанавливает владельца и права пользователей на файл таким образом,
     * что права на чтение будут иметь только указанные пользователи.
     * @param string $__clpath - путь к файлу в файловой системе облака
     * @param string $__owner - логин владельца
     * @param array $__users - массив логинов пользователей
     * @return bool
     */
    function setRights($__clpath, $__owner, $__users)
    {
        $file = fopen($this->rights_path, 'a');
        if ($file)
        {
            $readers = implode(',', $__users);
            $rights = "$__clpath::$__owner::$readers\n";
            if (fputs($file, $rights))
                if (fclose($file))
                    return true;
        }

        return false;
    }

    /**
     * Изменяет права пользователей на файл таким образом,
     * что права на чтение будут иметь только указанные пользователи.
     * Игнорирует владельца файла.
     * @param string $__clpath - путь к файлу в файловой системе облака
     * @param array $__users - массив логинов пользователей
     * @return bool
     */
    function changeRights($__clpath, $__users)
    {
        $text = explode("\n", file_get_contents($this->rights_path));
        array_pop($text);
        if ($text)
        {
            foreach ($text as $str_key => $str)
            {
                $rights = explode('::', $str);

                if ($rights[0] == $__clpath)
                {
                    $new_readers = array();
                    foreach ($__users as $user)
                        if($user != $rights[1])
                            $new_readers[] = $user;

                    $rights[2] = implode(',', $new_readers);
                    $text[$str_key] = implode('::', $rights);
                    break;
                }
            }

            $fp = fopen($this->rights_path, 'w');
            if ($fp)
                if (fputs($fp, implode("\n", $text)))
                    if (fclose($fp))
                        return true;
        }

        return false;
    }


//      ///////////////////////////////////////
//      ////????ЭТОТ МЕТОТ ВООБЩЕ НУЖЕН????////
//      ///////////////////////////////////////
//    /**
//     * Метод лишает пользователей прав на файл. Игнорирует владельца файла.
//     * Лучше воспользуйтесь методом changeRights. Все равно этот метод недоступен :P
//     * @param string $__clpath - путь к файлу в файловой системе облака
//     * @param array $__users - массив логинов пользователей
//     * @return bool
//     */
//    function delRight($__clpath, $__users)
//    {
//        //////////////////////////////////////////////////////////
//        ////___ИСКЛЮЧЕНИЕ ДЛЯ НЕСТРОКОВЫХ ЭЛЕМЕНТОВ МАССИВА___////
//        //////////////////////////////////////////////////////////
//
//        $text = file($this->rights_path);
//        if ($text) {
//            foreach ($text as $str_key => $str) {
//                $rights = explode('::', $str);
//                if ($rights[0] == $__clpath) {
//                    $readers = explode(',', $rights[2]);
//
//                    foreach ($readers as $reader_key => $reader)
//                        foreach ($__users as $user_key => $user)
//                            if ($reader == $user)
//                                unset($readers[$reader_key]);
//
//                    $rights[2] = implode(',', $readers);
//                    $text[$str_key] = implode('::', $rights);
//                    break;
//                }
//
//
//            }
//
//            $fp = fopen($this->rights_path, 'w');
//            if ($fp)
//                if (fputs($fp, $text))
//                    if (fclose($fp))
//                        return true;
//        }
//
//        return false;
//    }


    /**
     * Метод удаляет все права на файл. Если это директория, то рекурсивно удаляет права файлов в этой директории
     * @param string $__clpath - путь к файлу в файловой системе облака
     * @return bool
     */
    function delFileRights($__clpath)
    {
        $text = file($this->rights_path);
        if ($text) {
            $new_text = '';

            if(is_dir($this->cl2fs($__clpath)))
                foreach ($text as $str)
                    $new_text .= preg_replace("@".$__clpath."[^:]*::[^\n]*\n@", "", $str);

            foreach ($text as $str)
                $new_text .= preg_replace("@".$__clpath."::[^\n]*\n@", "", $str);

            $fp = fopen($this->rights_path, 'w');
            if ($fp)
                if (fputs($fp, $new_text))
                    if (fclose($fp))
                        return true;
        }

        return false;
    }

    /**
     * Метод лишает пользователя прав на все файлы.
     * и удаляет все права на файлы, владельцем которых он является.
     * @param string $__user - логин пользователя
     * @return bool
     */
    function delUserRights($__user)
    {
        $text = file($this->rights_path);
        if ($text) {
            foreach ($text as $str_key => $str) {
                $rights = explode('::', $str);
                if ($rights[1] == $__user) {
                    unset($text[$str_key]);
                    continue;
                }

                $readers = explode(',', $rights[2]);

                foreach ($readers as $reader_key => $reader)
                    if ($reader == $__user)
                        unset($readers[$reader_key]);

                $rights[2] = implode(',', $readers);

                $text[$str_key] = implode('::', $rights);
            }

            $fp = fopen($this->rights_path, 'w');
            if ($fp)
                if (fputs($fp, $text))
                    if (fclose($fp))
                        return true;

            return true;
        }

        return false;
    }

    function fileExists($__clpath)
    {
        return file_exists($this->cl2fs($__clpath));
    }

    /**
     * Метод добавляет файл в облако.
     * @param string $__clpath - путь к директории в файловой системе облака, в которую добавляется файл
     * @param string $__file_name - имя файла
     * @param string $__tmp_name - временное имя файла на сервере
     * @return bool
     */
    function addFile($__clpath, $__file_name, $__tmp_name = NULL)
    {
        $fspath = $this->cl2fs($__clpath);

        $file_path = $fspath . '/' . $__file_name;
        $i = 0;
        while(file_exists($file_path))
        {
            ++$i;
            $name_parts = explode('.', $__file_name);
            if(count($name_parts) > 1)
                $name_parts[count($name_parts) - 2] .= "($i)";
            else
                $name_parts[0] .= "($i)";
            $file_path = $fspath . '/' . implode('.', $name_parts);
        }

        if ($__tmp_name)
        {
            if (move_uploaded_file($__tmp_name, $file_path))
                return $this->fs2cl($file_path);
        } else
            if (mkdir($file_path))
                return $this->fs2cl($file_path);

        return false;
    }


    function giveFile($__clpath)
    {
        $fspath = $this->cl2fs($__clpath);

        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
// если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level())
            ob_end_clean();
        if(ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');
// заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($fspath));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fspath));
// читаем файл и отправляем его пользователю
        readfile($fspath);
    }


    /**
     * Метод удаляет файл из облака.
     * @param string $__clpath - путь к файлу в файловой системе облака
     * @return bool
     */
    function removeFile($__clpath)
    {
        $fspath = $this->cl2fs($__clpath);

        $remove = false;
        if(is_dir($fspath))
        {
            $files_arr = glob($fspath."/*");
            foreach($files_arr as $file)
                $remove &= $this->removeFile($this->fs2cl($file));

            $remove &= @rmdir($fspath);
        }
        else
            $remove = @unlink($fspath);

        return $remove;
    }

    /**
     * Метод возвращает основную информацию о файле.
     * @param string $__clpath - путь к файлу в файловой системе облака
     * @return array
     */
    function getInfo($__clpath)
    {
        $fspath = $this->cl2fs($__clpath);

        $info = [];                                             //данные о файле:
        $info['name'] = basename($fspath);                      //имя файла
        $info['type'] = filetype($fspath);                      //тип файла
        $info['size'] = (is_dir($fspath))                       //размер файла
            ? dirsize($fspath)
            : filesize($fspath);
        $info['chdate'] = filemtime($fspath);                   //время последней модификации
        $info['access_rights'] = $this->getRights($__clpath);   //права дотупа

        return $info;
    }


    /**
     * Метод возвращает список файлов в директории
     * @param string $__clpath - путь к директории в файловой системе облака
     * @return array
     */
    function getList($__clpath)
    {
        $fspath = $this->cl2fs($__clpath);

        $paths = glob("$fspath/*");

        $info = array();
        $info[0] = $__clpath;
        foreach ($paths as $path)
            $info[] = $this->getInfo($this->fs2cl($path));

        return $info;
    }


//    /**
//     * Метод проверки существования файла по заданному пути.
//     * @param string $__clpath - путь к файлу в файловой системе облака
//     * @return bool
//     */
//    function exists($__clpath)
//    {
//        $fspath = $this->cl2fs($__clpath);
//        return file_exists($fspath);
//    }
//
//
//    function isFile($__clpath)
//    {
//        $fspath = $this->cl2fs($__clpath);
//        return is_file($fspath);
//    }
//    function isDir($__clpath)
//    {
//        $fspath = $this->cl2fs($__clpath);
//        return is_dir($fspath);
//    }


}


/**
 * Функция вычисления размера директори
 * @param string $fspath
 * @return int
 */
function dirsize($fspath)
{
    $totalsize=0;
    if ($dirstream = @opendir($fspath)) {
        while (false !== ($filename = readdir($dirstream))) {
            if ($filename!="." && $filename!="..")
            {
                if (is_file($fspath."/".$filename))
                    $totalsize+=filesize($fspath."/".$filename);

                if (is_dir($fspath."/".$filename))
                    $totalsize+=dirsize($fspath."/".$filename);
            }
        }
    }
    closedir($dirstream);
    return $totalsize;
}