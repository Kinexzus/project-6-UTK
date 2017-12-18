<?php
class _Print //Интерфес облочного хранилища
{   
    private $__action;


    public function __construct($action)
    {
        $this->__action = $action;
    }
    
    function Registration_form_creater($error = NULL, $login = "", $mail = "") //    форма регистрации +
    {
            $error_out = '';
            if($error !== NULL)
            {
                $error_out = '<input type="text" value="'.$error.'" name="login">';
            }
        
            $html = '
            <html lang="en" >
            <head>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <link href="Log.css" rel="stylesheet">
              <title>Cloud Storage</title>

            </head>

            <body>
              <div class="body"></div>
                            <div class="grad"></div>
                            <div class="header">
                                    <div>Cloud Storage<span></span></div>
                            </div>
                            <br>
                            <div class="login">
                                            <form method="POST" action="'.$this->__action.'">
                                <input type="text" placeholder="Login" name="login" value="'.$login.'">
                                <input type="password" placeholder="Password" name="password">
                                <input type="password" placeholder="Conferm" name="passwordcheck">
                               <input type="text" placeholder="mail" name="mail" value="'.$mail.'">
                                                    <input type="submit" value="register" name="do">
                                                    <input type="submit" value="authorization" name="do">
                                                    '.$error_out.'
                                </form>
                            </div>
              


            </body>
            </html>';
                
           return $html;
    }
            
    function Log_Form_creater($error = NULL, $login = "") // форма для авторизации  +
    {       
            $error_out = '';
            if($error !== NULL)
            {
                $error_out = '<input type="text" value="'.$error.'" name="login">';
            }
        
            $html = '<!DOCTYPE html>
            <html lang="en" >
            <head>
				
             <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			 <link href="Log.css" rel="stylesheet">
              <title>Cloud Storage</title>

            </head>

            <body>
              <div class="body"></div>
                            <div class="grad"></div>
                            <div class="header">
                                    <div>Cloud Storage<span></span></div>
                            </div>
                            <br>
                            <div class="login">
                                            <form method="POST" action="'.$this->__action.'">
                                <input type="text" placeholder="Login" name="login" value="'.$login.'">
                                <input type="password" placeholder="Password" name="password">
                                <input type="submit" value="login" name="do">
                                <input type="submit" value="registration" name="do">
                                '.$error_out.'
                                </form>
                            </div>


            </body>
            </html>';
            
            return $html;    
     }
            
    public function File_Form_Creater($directory_contents,$is_owner) // форма дял отображения списка файлов  +
    {
        $file_arr = $directory_contents;
        $upath = $file_arr[0];
        unset($file_arr[0]);
    
        $form = '<div style=" height: 800px; overflow:auto;"><table width="100%" bgcolor="#808080"  cellspacing="4" border="6" cellpadding="7" height="auto">';
        foreach ($file_arr as $value) 
        {
			
            if($value["type"] == 'file' && isset($value["type"]))
            {   
                $fuctional = "";
                if($is_owner)
                {
                    $fuctional = '<td bgcolor="#38E54F"><a href = "'.$this->__action.'?file_path='.$upath.'/'.$value['name'].'&do=download"> Скачать </a></td>'
                .'<td bgcolor="#DA0791">'. '<a href = "'.$this->__action.'?file_path='.$upath.'/'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td bgcolor="#DAD907"><a href = "'.$this->__action.'?file_path='.$upath.'/'.$value[ 'name' ].'&do=changeRightsMenu"> Изменить права доступа </a></td>';
                }
                
                $form.= '<tr align="center" bgcolor="#85C6FF"><td><p>'.$value['name']." ".'</p><div></td>'.$fuctional.'</tr>';
            }
			
			if($value["type"] == 'dir' && isset($value["type"]))
            {
                $fuctional = "";
                if($is_owner)
                {
                    $fuctional = '<td bgcolor="#808080"></td><td bgcolor="#DA0791"><a href = "'.$this->__action.'?file_path='.$upath.'/'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td bgcolor="#DAD907"><a href = "'.$this->__action.'?file_path='.$upath.'/'.$value[ 'name' ].'&do=changeRightsMenu"> Изменить права доступа </a></td>';
                }
                
                 $form.= '<tr align="center"><td bgcolor="#808080" ><a href = "'.$this->__action.'?path='.$upath.'/'.$value[ 'name' ].'&do=openDir">'. $value[ 'name' ] .'</a></td>'.$fuctional.'</tr>';
            }
        }
         $form.='</table></div>';
         return $form;
    }
            
    public function Logout($user)     // +
    {
        $html = '<form method="POST" action="'.$this->__action.'">
                        <p>'.$user.'</p>
                        <button name="do" value="logout" type="submit">Exit</button>
                    </form>';
        
        return $html;
    }


    public function Upload_File_Form($path) // форма для подгруззки файла  +
    {
        $form = '<form action="'.$this->__action.'"  method=post enctype=multipart/form-data class="file-upload">
                    <input type="file"  name="file_name"/>
                    <input type="hidden"  name="path"  value="'.$path.'"/>
                    <input type="submit"  name="do" value="upload"/>
                </form>';
    
        return $form;
    }
            
    public function Create_Dir_Form($path) // Создание формы новой дириктории  +
    {
        $form = '<form action="'.$this->__action.'"  method="post">'
                .'<input type="hidden"  name="path"  value="'.$path.'"/>'
                .'<input type="text"  name="dir_name"  size="20"/>'
                .'<input type="submit" name="do" value="makeDir"/>'
                .'</form>';
    
        return $form;
    }
            
    function File_System_Interface_creater($user, $directory_contents,$is_owner, $path) //Отрисовка дириктории   +
    {
        $Create_Dir = "";
        $Upload_File = "";
        
        if($is_owner === TRUE)
        {
            $Create_Dir = $this->Create_Dir_Form($path);
            $Upload_File = $this->Upload_File_Form($path);
        }
        
        $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
        <html lang="en" >
        <head>
         <meta charset="UTF-8">
		 <link href="FSI.css" rel="stylesheet">
         <title>Cloud Storage</title>

		</head>
            <body bgcolor="#808080" link="black" vlink="black" alink="black" bgcolor="black" text-color="white">
                <table  width="100%" height="auto" border="2">
                    <tr>
                         <td align="center"  width="100%" color="white">
                            '.$this->Logout($user).'
                        </td>
                     <tr>
				</table>
                <table width="100%" height="auto" border="2">
					<tr>
						<td align="center">'
							.$this->Create_Dir_Form($path).
						'</td>
						<td align="center">'
							.$this->Upload_File_Form($path).'			
						</td>
					</tr>
                 </table>'
					.$this->File_Form_Creater($directory_contents, $is_owner)			
            .'</body>
        </html>';

        return $html;
                
    }
            
    public function Users_Name_Select_List($_users_name_list) // список пользователей ввиде  +
    {
        $i = 1;
        $users_name_list = $_users_name_list;
        //здесь должен быть получен массив имён пользователей
        $users_name_select_list_select = '';

        foreach ($users_name_list as $value) 
        {
            $users_name_select_list_select.= '<p><input type="checkbox" name="Param'.strval($i).'" value="'.$value.'"> '.$value.'</p><br>';
            ++$i;
        }
            return $users_name_select_list_select;
        }
                    
    function Access_changer_form($file, $_users_name_list)   // ССмена прав доступа. Может быть в последствии изменён +
    {
        $form ='<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <link href="Access.css" rel="stylesheet">
  <title>Access list</title>
  

</head>

<body>
	<div class="login">
             <table  width="100%" >
                                              <tr>
                                                  <td align="center" width="auto">
                                                   	<form action="'.$this->__action.'" method="post">'
                                                        .'<button type="submit" value="changeRights" name="do">Privat</button>'
                                                        .'<input type="hidden"  name="access"  value="privat"/>'
                                                        .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                                                        . '</form>'	

                                                            .'<form action="'.$this->__action.'" method="post">'
                                                            .'<div style=" height: 400px; overflow:auto;">'
                                                            .$this->Users_Name_Select_List($_users_name_list)
                                                            .'</div>'
                                                            .'<button type="submit" value="changeRights" name="do">Select</button>'
                                                            .'<input type="hidden"  name="access"  value="select"/>'
                                                            .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                                                        .'</form>'


                                                        .'<form action="'.$this->__action.'" method="post">'
                                                        .'<button type="submit" value="changeRights" name="do">Public</button>'
                                                        .'<input type="hidden"  name="access"  value="public"/>'
                                                        .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                                                        . '</form>		
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td align="center">
                                                      <table >
                                                          <tr>

                                                          </tr>			
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table>
		
							</div>

						</body>
					</html>';
    
        return $form;
    } 
    
    public function Users_List($_users_name_list) // хз какой список нужен будет пока только имена, если что исправлю. +
    {
        $html = '<table>';
        foreach ($_users_name_list as $value) 
        {
            $html .= '<tr><td><p>'.$value.'</p></td></tr>';
        }
        
       $html .= '</table>';
       
       return $html;
    }
    
    
    //методРисованияСпискаПользователей($пользователь, $список_пользователей) чёт на въехал 
    
    public function Access_Error_Form($user, $fpath) // форма для ошибок прав доступа  +
    {
        $html = '<form method="POST" action="'.$this->__action.'">
                        <p>Упользователя'.$user.' недостаточно прав на файл'.$fpath.'</p>
                        <button name="do" value="access_error" type="submit">Try again</button>'
                        .'<input type="hidden"  name="user"  value="'.$user.'"/>'
                        .'<input type="hidden"  name="file"  value="'.$fpath.'"/>
                        
                    </form>';
                    
            return $html;
    }
}
?>