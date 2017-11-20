<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 function Select_Creter($__upath )
{
    $file_arr = in_dir($__upath);
    unset($file_arr[0]);
    
    $select = "";
    foreach($file_arr as $value)
    { 
        if($value["type"] == 'file' && isset($value["type"]))
        {
            $select.= '<option'. ' value="'. $__upath. '/'. $value['name'] . '">'. $value[ 'name' ] ." ". "size" ." ". $value['size']
            . '</option>';
        }
        
    }
    return $select;
}

function Dir_Select_Creter($__upath)
{
    $file_arr = in_dir($__upath);
    unset($file_arr[0]);
    $select = "";
    foreach($file_arr as $value)
    {   
        if($value["type"] == 'dir' && isset($value["type"]))
        {
            $select.= '<option'. ' value="'. $__upath. '/'. $value['name'] . '">'. $value[ 'name' ] ." ". "size" ." ". $value['size']
            . '</option>';
        }
        
    }
    return $select;
}

$html = '<body>'
                    .'<table>'
                        . '<tr>'
                          . '<form method="POST" action="File_System_Inteface.php">' // Первая форма
                            . '<td>'.'<select>'.Select_Creter($__upath).'</select>'
                            . ' <input type="radio" name="funct" value="Create Directory">Create Directory<Br>
                                <input type="radio" name="funct" value="Remove">Remove<Br>
                                <input type="radio" name="funct" value="Download">Download the contents of a file<Br>'
                            . '</td>'
                          . '</form>'
                            . '<form method="POST" action="File_System_Inteface.php">'  // Вторая форма 
                            . '<td>'.'<select>'.Dir_Select_Creter($__upath).'</select>'
                            . ' <button type="submit" name="funct2" value="Enter">Enter</button><Br>'
                            . '</td>'
                          . '</form>'
                        .'</tr>'
                    .'</table>'
		. '</body>';
	
	echo $html;
