<?php
class _Print //Интерфес облочного хранилища
{   
    function Registration_form_creater($error = NULL) //    форма регистрации +
    {
        if($error === NULL)
        {
            $html = '<form method="POST" action="project-6.php">
                        <input type="text" placeholder="Login" name="login">
                        <input type="text" placeholder="mail" name="mail">
                        <input type="password" placeholder="Password" name="password">
                        <input type="password" placeholder="Conferm" name="passwordcheck">
                        <button name="do" value="registration" type="submit">Registration</button>
                     </form>';
                
           return $html;
        }
                
        if($error !== NULL)
        {
            $html = '<form method="POST" action="project-6.php">
                        <p>'.$error.'</p>
                        <button name="do" value="error" type="submit">Reregistration</button>
                    </form>';
                    
            return $html;
        }
    }
            
    function Log_Form_creater($error = NULL) // форма для авторизации  +
    {
        if($error === NULL)
        {
            $html = '<form method="POST" action="project-6.php">
                    <input type="text" placeholder="Login" name="login">
                    <input type="password" placeholder="Password" name=userpassword">
                    <button name="do" value="login" type="submit">Login</button>
                    </form>';
            
            return $html;
        }
                
        if($error !== NULL)
        {
            $html = '<form method="POST" action="project-6.php">
                        <p>'.$error.'</p>
                        <button name="do" value="error" type="submit">Restart Login</button>
                    </form>';
                    
            return $html;
        }
               
     }
            
    private function File_Form_Creater($directory_contents,$is_owner) // форма дял отображения списка файлов  +
    {
        $file_arr = $directory_contents;
        $upath = $file_arr[0];
        unset($file_arr[0]);
    
        $form = '<div style="width:774px; height: 800px; overflow:auto;"><table class="file" bgcolor="#4166F6" width="700" height="auto">';
    
        foreach ($file_arr as $value) 
        {
            if($value["type"] == 'file' && isset($value["type"]))
            {   
                $fuctional = "";
                if($is_owner)
                {
                    $fuctional = '<td><a href = "project-6.php?file='.$upath.'/'.$value['name'].'&do=download"> Скачать </a></td>'
                .'<td>'. '<a href = "project-6.php?upath='.$upath.'/'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td><a href = "project-6.php?name='.$upath.'/'.$value[ 'name' ].'&do=change_access_file"> Изменить права доступа </a></td>';
                }
                
                $form.= '<tr align="center" class="button1"><td><div style="width:150px; height:30px; overflow:auto;"><p>'.$value['name']." ".'</p><div></td>'.$fuctional.'</tr>';
            }
        }
         $form.='</table></div>';
         return $form;
    }
            
    private function Dir_Form_Creater($directory_contents,$is_owner) // форма для отображения списка дирикторий +
    {
        $file_arr = $directory_contents;
        $upath = $file_arr[0];
        unset($file_arr[0]);
    
        $form = '<div style="width:774px; height: 800px; overflow:auto;"><table class="Dir" bgcolor="#4166F6" width="700" height="500">';
    
        foreach ($file_arr as $value) 
        {
            if($value["type"] == 'dir' && isset($value["type"]))
            {
                $fuctional = "";
                if($is_owner)
                {
                    $fuctional = '<td><a href = "project-6.php?upath='.$upath.'/'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td><a href = "project-6.php?name='.$upath.'/'.$value[ 'name' ].'&do=change_access"> Изменить права доступа </a></td>';
                }
                
                 $form.= '<tr align="center" class="button1"><td ><div style="width:150px; height:33px; overflow:auto;"><p><a href = "project-6.php?path='.$upath.'/'.$value[ 'name' ].'">'. $value[ 'name' ] .'</a></p></div></td>'.$fuctional.'</tr>';
            }
        }
        
        $form.='</table></div>';
        return $form;            
    }
    
    public function Logout($user)     // +
    {
        $html = '<form method="POST" action="project-6.php">
                        <p>'.$user.'</p>
                        <input type="hidden" name="user" value="'.$user.'">
                        <button name="do" value="logout" type="submit">Exit</button>
                    </form>';
        
        return $html;
    }


    public function Upload_File_Form($path) // форма для подгруззки файла  +
    {
        $form = '<form action="project-6.php"  method=post enctype=multipart/form-data class="file-upload">
                    <input type="file"  name="FILE"/>
                    <input type="hidden"  name="upath"  value="'.$path.'"/>
                    <input type="submit"  name="do" value="Upload"/>
                </form>';
    
        return $form;
    }
            
    public function Create_Dir_Form($path) // Создание формы новой дириктории  +
    {
        $form = '<form action="project-6.php"  method="post">'
                .'<input type="hidden"  name="upath"  value="'.$path.'"/>'
                .'<input type="text"  name="dir"  size="20"/>'
                .'<input type="submit" name="do" value="Create"/>'
                .'</form>';
    
        return $form;
    }
            
    function File_System_Interface_creater($user, $directory_contents,$is_owner, $path) //Отрисовка дириктории   +
    {
        $Create_Dir = "";
        $Upload_File = "";
        
        if($is_owner === TRUE)
        {
            $Create_Dir = Create_Dir_Form($path);
            $Upload_File = Upload_File_Form($path);   
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
                                                    <p>User Name:'. Unlog($user). '</p>
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
                                            '.$this->Dir_Form_Creater()				
                                        .'</td >
                                        <td align="center">
                                            '.$this->File_Form_Creater()			
                                        .'</td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <table class="Upload" bgcolor="#4166F6" width="450" height="auto">
                                                <tr>
                                                    <td align="center">'.$Upload_File.'</td>
                                                </tr>			
                                            </table>
                                        </td>
                                        <td align="center">
                                            <table class="creat" bgcolor="#4166F6" width="450" height="auto">
                                                <tr>
                                                    <td align="center">'.$Create_Dir.'</td>
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
                
    }
            
    public function Users_Name_Select_List($_users_name_list) // список пользователей ввиде  +
    {
        $users_name_list = $_users_name_list;
        //здесь должен быть получен массив имён пользователей
        $users_name_select_list_select = '<select name="access" multiple="multiple">';

        foreach ($users_name_list as $value) 
        {
            $users_name_select_list_select.='<option>'.$value.'</option>';
        }

            $users_name_select_list_select.='</select>';

            return $users_name_select_list_select;
        }
                    
    function Access_changer_form($file)   // ССмена прав доступа. Может быть в последствии изменён +
    {
        $form .='<table><tr>'
            . '<td>'
                    . '<form action="project-6.php" method="post">'
                    .'<button type="submit" value="access_change" name="do">Privat</button>'
                    .'<input type="hidden"  name="access"  value="privat"/>'
                    .'<input type="hidden"  name="file"  value="'.$file.'"/>'
                    . '</form>'
                .'</td>'
                . '<td>'
                    .'<form action="project-6.php" method="post">'
                        .$this->Users_Name_Select_List()
                        .'<button type="submit" value="access_change" name="do">Select</button>'
                        .'<input type="hidden"  name="access"  value="select"/>'
                        .'<input type="hidden"  name="file"  value="'.$file.'"/>'
                    .'</form>'
                .'</td>'
                .'<td>'
                    . '<form action="project-6.php" method="post">'
                    .'<button type="submit" value="access_change" name="do">Public</button>'
                    .'<input type="hidden"  name="access"  value="public"/>'
                    .'<input type="hidden"  name="file"  value="'.$file.'"/>'
                    . '</form>'
                .'</td>'
                .'</tr></table>';
    
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
        $html = '<form method="POST" action="project-6.php">
                        <p>Упользователя'.$error.' недостаточно прав на файл'.$fpath.'</p>
                        <button name="do" value="access_error" type="submit">Try again</button>'
                        .'<input type="hidden"  name="user"  value="'.$user.'"/>'
                        .'<input type="hidden"  name="file"  value="'.$fpath.'"/>
                        
                    </form>';
                    
            return $html;
    }
}
?>