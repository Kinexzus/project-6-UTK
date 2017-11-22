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
$_upath = (isset($_REQUEST['path']))
    ? $_REQUEST['path']
    : '/';  //тут должна быть обработка ошибки

require_once('..\File_System_Work\this_and_that.php');

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
            $form.= '<tr><td><p>'.$value['name']." "."size"." ".$value['size'].'</p></td><td><a href = "../File_System_Work/download.php?file='.$upath.'/'.$value['name'].'"> Скачать </a> </td>'
                    . '<td>'. '<a HREF = "../File_System_Work/delete.php?file='.$upath.'/'.$value[ 'name' ].'" > Удалить </a> '.'</td><td><a href = "change_access.php?name='.$upath.'/'.$value[ 'name' ].' "> Изменить права доступа </a></td></tr>';
        }
    }
    $form .='</table></form></body>';
    
    return $form;
}

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
            $form.= '<tr><td><p><a href = "File_System_Inteface.php?path='.$upath.'/'.$value[ 'name' ].' ">>'. $value[ 'name' ] ." ". "size" ." ". $value['size'] .'</a></p></td>'
                    . '<td>'. '<a href = "../File_System_Work/delete.php?file='.$upath.'/'.$value[ 'name' ].'" > Удалить </a> '.'</td><td><a href = "change_access.php?name='.$upath.'/'.$value[ 'name' ].' "> Изменить права доступа </a></td></tr>';
        }
    }
    $form .='</table></form></body>';
    
    return $form;
}

function Upload_File_Form()
{
    $form = '<form action="../File_System_Work/upload.php"  method="post" enctype="mutipart/form-data">'
        .'<input type="file"  name="FILE"  size="20"/>'
        .'<input type="submit"  name="addFile" value="Добавить"/>'
        .'</form>';
    
    return $form;

}

function Create_Dir_Form()
{
    $form = '<form action="../File_System_Work/new_dir.php"  method="post">'
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

