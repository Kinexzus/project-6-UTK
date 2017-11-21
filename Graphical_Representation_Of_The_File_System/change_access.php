<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var_dump($_REQUEST);

function Header_Html()
{
    $head = 'Что-то не так!';
    if(isset($_REQUEST['name']))
    {
        $head = '<p>Задайте права доступа для '.$_REQUEST['name'].'</p>';
    }
    
    return $head;
}
//Функция создающая список для выбора пользователя для доступа к объекту
function Users_Name_Select_List()
{
    $users_name_list = [];
    //здесь должен быть получен массив имён пользователей
    $users_name_select_list = '<select name="access" multiple="multiple">';
    
    foreach ($users_name_list as $value) {
        $users_name_select_list.='<option>'.$value.'</option>';
    }
    
    $users_name_select_list.='</select>';
    
    return $users_name_select_list;
}

function Form_Creater()
{
    $form = Header_Html();
    $form .='<table><tr>'
            . '<td>'
                . '<form action="access_changer.php" method="post">'
                    .'<button type="submit" value="Privat" name="access">Privat</button>'
                . '</form>'
            . '</td>'
            . '<td>'
                . '<form action="access_changer.php" method="post">'
                .Users_Name_Select_List()
                    .'<button type="submit" value="Select" name="access">Select</button>'
                . '</form>'
            . '</td>'
            . '<td>'
                . '<form action="access_changer.php" method="post">'
                     .'<button type="submit" value="Public" name="access">Public</button>'
                . '</form>'
            . '</td>'
            . '</tr></table>';
    
    return $form;
}

echo Form_Creater();