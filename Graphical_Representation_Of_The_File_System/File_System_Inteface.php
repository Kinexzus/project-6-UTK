<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php
$_upath = "E:/Talik";
require_once('..\File_System_Work\File_System_Work.php');
//Функция выводящая список файлов в каталоге
function File_Form_Creater($__upath )
{
    $file_arr = in_dir($__upath);
    $upath = $file_arr[0];
     unset($file_arr[0]);
    
    $form = '<body><form><table>';
    
    foreach ($file_arr as $value) 
    {
        if($value["type"] == 'file' && isset($value["type"]))
        {
            $form.= '<tr><td><p>'. $value[ 'name' ] ." ". "size" ." ". $value['size'] .'</p></td><td><a HREF = " download.php? '.$upath.'/'.$value[ 'name' ].' "> Скачать </a> </td>'
                    . '<td>'. '<a HREF = " delete.php? '.$upath.'/'.$value[ 'name' ].' " > Удалить </a> '.'</td></tr>';
        }
    }
    $form .='</table></form></body>';
    
    return $form;
}
//Функция выводящая список директорий в каталоге
function Dir_Form_Creater($__upath)
{
    $file_arr = in_dir($__upath);
    $upath = $file_arr[0];
     unset($file_arr[0]);
    
    $form = '<body><form><table>';
    
    foreach ($file_arr as $value) 
    {
        if($value["type"] == 'dir' && isset($value["type"]))
        {
            $form.= '<tr><td><p><a HREF = "'.$upath.'/'.$value[ 'name' ].' ">>'. $value[ 'name' ] ." ". "size" ." ". $value['size'] .'</a></p></td>'
                    . '<td>'. '<a HREF = " delete.php? '.$upath.'/'.$value[ 'name' ].' " > Удалить </a> '.'</td></tr>';
        }
    }
    $form .='</table></form></body>';
    
    return $form;
}
//Форма дял подгрузки файлов
function Upload_File_Form()
{
    $form = '<form action="upload.php"  method="post" enctype="mutipart/form-data">'
        .'<input type="file"  name="FILE"  size="20"/>'
        .'<input type="submit"  name="addFile" value="Добавить"/>'
        .'</form>';
    
    return $form;

}
//Форма для создании директроии
function Create_Dir_Form()
{
    $form = '<form action="new_dir.php"  method="post">'
        .'<input type="text"  name="DIR"  size="20"/>'
        .'<input type="submit"  name="addDir" value="Добавить"/>'
        .'</form>';
    
    return $form;
}

$html = '<table><tr>'
        . '<td>'.Dir_Form_Creater($_upath).'</td>'
        . '<td>'.File_Form_Creater($_upath).'</td>'
        
        . '<td>'.Upload_File_Form().'</td>'
        . '<td>'.Create_Dir_Form().'</td>'
        . '<tr></table>';

echo $html;
