<?php
$_upath = (isset($_REQUEST['path']))
    ? $_REQUEST['path']
    : '/';  //тут должна быть обработка ошибки

$user_name = "User";

require_once('..\File_System_Work\this_and_that.php');

function File_Form_Creater($__upath )
{
    $file_arr = in_dir($__upath);
    $upath = $file_arr[0];
     unset($file_arr[0]);
    
    $form = '<div style="width:774px; height: 800px; overflow:auto;"><table class="file" bgcolor="#4166F6" width="700" height="auto">';
    
    foreach ($file_arr as $value) 
    {
        if($value["type"] == 'file' && isset($value["type"]))
        {
            $form.= '<tr align="center" class="button1"><td><div style="width:150px; height:30px; overflow:auto;"><p>'.$value['name']." ".'</p><div></td><td><a href = "../File_System_Work/download.php?upath='.$upath.'/'.$value['name'].'"> Скачать </a> </td>'
                    . '<td>'. '<a HREF = "../File_System_Work/delete.php?upath='.$upath.'/'.$value[ 'name' ].'" > Удалить </a> '.'</td><td><a href = "change_access.php?name='.$upath.'/'.$value[ 'name' ].' "> Изменить права доступа </a></td></tr>';
        }
    }
    $form.='</table></div>';
    return $form;
}

function Dir_Form_Creater($__upath)
{
    $file_arr = in_dir($__upath);
    $upath = $file_arr[0];
     unset($file_arr[0]);
    
    $form = '<div style="width:774px; height: 800px; overflow:auto;"><table class="Dir" bgcolor="#4166F6" width="700" height="500">';
    
    foreach ($file_arr as $value) 
    {
        if($value["type"] == 'dir' && isset($value["type"]))
        {
            $form.= '<tr align="center" class="button1"><td ><div style="width:150px; height:33px; overflow:auto;"><p><a href = "File_System_Inteface.php?path='.$upath.'/'.$value[ 'name' ].' ">'. $value[ 'name' ] .'</a></p></div></td>'
                    . '<td>'. '<a href = "../File_System_Work/delete.php?file='.$upath.'/'.$value[ 'name' ].'" > Удалить </a> '.'</td><td><a href = "change_access.php?name='.$upath.'/'.$value[ 'name' ].' "> Изменить права доступа </a></td></tr>';
        }
    }
    $form.='</table></div>';
    return $form;
}

function Upload_File_Form($__upath)
{
    $form = '<form action="../File_System_Work/upload.php"  method=post enctype=multipart/form-data class="file-upload">
        <input type="file"  name="FILE"/>
        <input type="hidden"  name="upath"  value="'.$__upath.'"/>
        <input type="submit"  name="addFile" value="Загрузить"/>
        </form>';
    
    return $form;

}

function Create_Dir_Form($__upath)
{
    $form = '<form action="../File_System_Work/new_dir.php"  method="post">'
        .'<input type="text"  name="dir"  size="20"/>'
        .'<input type="hidden"  name="upath"  value="'.$__upath.'"/>'
        .'<input type="submit"  name="addDir" value="Добавить"/>'
        .'</form>';
    
    return $form;
}

$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Index</title>
                    <link href="FSI.css" rel="stylesheet" type="text/css" />
            </head>
            <body>
                <table class="main" width="100%" height="auto">
                    <tr>
			<td align="center">
                            <table class="head" bgcolor="#439BF9" width="100%" height="auto">
				<tr class="logo">
                                   <td align="center" bgcolor="#439BF9" width="50%">
                                        <h1>Project6</h1>
                                        <h2>Thin client. Cloud storage.</h2>
                                    </td>
                                    <td align="right" bgcolor="#2B8CF3" width="50%">
					<ul>
                                            <li>
                                                <p>User Name:'. $user_name. '</p>
                                            </li>
                                        </ul>
                                    </td>
				<tr>
                            </table>
			<td>
                    </tr>
                    <tr>
                        <td  align="center">
                            <table class="middle" bgcolor="#4166F6" width="85%" >
				<tr>
                                    <td align="center">
                                        '.Dir_Form_Creater($_upath)				
                                    .'</td >
                                    <td align="center">
					'.File_Form_Creater($_upath)			
                                    .'</td>
				</tr>
				<tr>
                                    <td align="center">
					<table class="Upload" bgcolor="#4166F6" width="450" height="auto">
                                            <tr>
                                                <td align="center">'.Upload_File_Form($_upath).'</td>
                                            </tr>			
					</table>
                                    </td>
                                    <td align="center">
					<table class="creat" bgcolor="#4166F6" width="450" height="auto">
                                            <tr>
                                                <td align="center">'.Create_Dir_Form($_upath).'</td>
                                            </tr>			
					</table>
                                    </td>
				</tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
        </html>';

echo $html;
