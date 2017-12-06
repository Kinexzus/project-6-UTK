<?php
/**
 * Функция возваращает данные о содержимом директории
 * @param string $__upath - путь к директории формата '\user\folder\...\otherfolder'
 * @return array
 */
function in_dir($__upath)
{
    $file_system = '..\File_System';

    $path_arr = glob($file_system . $__upath . '\*');

    $files_arr = [];    //массив файлов
    $files_arr[0] = $__upath;
    foreach($path_arr as $path)
    {
        $file_info = [];                        //данные о файле:
        $file_info['type'] = filetype($path);   //тип файла
        $file_info['name'] = basename($path);   //имя файла
        $file_info['size'] = (is_dir($path))    //размер файла
            ?dirsize($path)
            :filesize($path);
        $file_info['chdate'] = filemtime($path);//время последней модификации

        $access_rights = [];
        @mysql_connect("localhost", "root") or die("ERROR " . mysql_errno() . " " . mysql_error() . "</br>");
        @mysql_select_db("cloud") or die("ERROR " . mysql_errno() . " " . mysql_error() . "</br>");

        $sql_path = "'".@mysql_real_escape_string($path)."'";
        $result = @mysql_query("SELECT * FROM access_rights WHERE path = $sql_path");

        $users_count = ($result)
            ? mysql_num_rows($result)
            : 0;
        for($i = 0; $i < $users_count; ++$i)
            $access_rights[] = @mysql_fetch_assoc($result);

        $file_info['access_rights'] = $access_rights;   //права дотупа

        $files_arr[] = $file_info;
    }

    return $files_arr;
}

/**
 * Функция вычисления размера директори
 * @param $dir
 * @return int
 */
function dirsize($dir) {
    $totalsize=0;
    if ($dirstream = @opendir($dir)) {
        while (false !== ($filename = readdir($dirstream))) {
            if ($filename!="." && $filename!="..")
            {
                if (is_file($dir."/".$filename))
                    $totalsize+=filesize($dir."/".$filename);

                if (is_dir($dir."/".$filename))
                    $totalsize+=dirsize($dir."/".$filename);
            }
        }
    }
    closedir($dirstream);
    return $totalsize;
}

/**
 * Функция производит удаление файла / рекурсивное удаление директории
 * @param string $__file_path - путь к удаляемому объекту
 * @return bool
 */
function remove($__file_path)
{
    if(is_dir($__file_path))
    {
        $files_arr = glob($__file_path."/*");
        foreach($files_arr as $file)
            remove($file);

        return rmdir($__file_path);
    }

    return unlink($__file_path);
}


function check_access_right($__path, $__user_name)
{
    @mysql_connect("localhost", "root") or die("ERROR " . mysql_errno() . " " . mysql_error() . "</br>");
    @mysql_select_db("cloud") or die("ERROR " . mysql_errno() . " " . mysql_error() . "</br>");

    $sql_path = "'".@mysql_real_escape_string($__path)."'";

    $result = @mysql_query("SELECT * FROM access_rights WHERE path = $sql_path");

    $users_count = ($result)
        ? mysql_num_rows($result)
        : 0;
    for($i = 0; $i < $users_count; ++$i)
        if(@mysql_fetch_assoc($result) == $__user_name || @mysql_fetch_assoc($result) == NULL)
            @mysql_close();
            return true;

    @mysql_close();
    return false;
}



function change_access_rights($__path, $__users_arr)
{
    @mysql_connect("localhost", "root") or die("ERROR " . mysql_errno() . " " . mysql_error() . "</br>");
    @mysql_select_db("cloud") or die("ERROR " . mysql_errno() . " " . mysql_error() . "</br>");

    $sql_path = "'".@mysql_real_escape_string($__path)."'";

    @mysql_query("DELETE FROM access_rights WHERE path = $sql_path");

    if(empty($__users_arr))
    {
        @mysql_query("INSERT INTO access_rights SET path = $sql_path, access = NULL");
        return true;
    }

    foreach ($__users_arr as $user)
    {
        $sql_user = "'".@mysql_real_escape_string($user)."'";
        @mysql_query("INSERT INTO access_rights SET path = $sql_path, access = $user");
    }

    @mysql_close();
    return true;
}

function delete_access_rights($__path)
{
    @mysql_connect("localhost", "root") or die("ERROR " . mysql_errno() . " " . mysql_error() . "</br>");
    @mysql_select_db("cloud") or die("ERROR " . mysql_errno() . " " . mysql_error() . "</br>");

    $sql_path = "'" . @mysql_real_escape_string($__path) . "'";

    @mysql_query("DELETE FROM access_rights WHERE path = $sql_path");

    @mysql_close();
    return true;
}
