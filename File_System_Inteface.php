<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var_dump($_REQUEST);
function Select_Creter()
{
    $select = "";
    	foreach($_REQUEST as $key => $value){
		$select.= '<option'. $key 
			.' value="'. $value . '">' . $key . '</option>';		
	}
    return $select;
}

function Dir_Select_Creter()
{
    $select = "";
    	foreach($_REQUEST as $key => $value){
		$select.= '<option'. $key 
			.' value="'. $value . '">' . $key . '</option>';		
	}
    return $select;
}

$html = '<body>'
                    .'<table>'
                        . '<tr>'
                          . '<form method="POST" action="File_System_Inteface.php">' // Первая форма
                            . '<td>'.'<select>'.Select_Creter().'</select>'
                            . ' <input type="radio" name="funct" value="Create Directory">Create Directory<Br>
                                <input type="radio" name="funct" value="Remove">Remove<Br>
                                <input type="radio" name="funct" value="Download">Download the contents of a file<Br>'
                            . '</td>'
                          . '</form>'
                            . '<form method="POST" action="File_System_Inteface.php">'  // Вторая форма 
                            . '<td>'.'<select>'.Dir_Select_Creter().'</select>'
                            . ' <button type="submit" name="funct2" value="Enter">Enter</button><Br>'
                            . '</td>'
                          . '</form>'
                            . '<form method="POST">' // Логин пользователя
                            . '<td>'
                            . ' <output>'.'Login'.'</output><Br>'
                            . '</td>'
                          . '</form>'
                            . '</form>' 
                            . '<form method="POST" action="Access_Rights.php">' // Изменение прав доступа
                            . '<td>'.'<select>'.Select_Creter().'</select>'
                            . ' <button type="submit" name="funct3" value="change of access rights">change of access rights</button><Br>'
                            . '</td>'
                          . '</form>'
                            . '</form>'
                            . '<form method="POST" action="Dispatch.php">' // Подшоузка файда
                            . '<td>'.'<select>'.Select_Creter().'</select>'
                            . ' <button type="submit" name="funct4" value="dispatch">dispatch</button><Br>'
                            . '</td>'
                          . '</form>'
                        .'</tr>'
                    .'</table>'
		. '</body>';
	
	echo $html;
