
        <?php
        class Cloud_Interface //Интерфес облочного хранилища
        {
            /* Сдесь нужно дописать поля класс(хз какие нужны) */
            //
            //
            //поле ошибок
            private $Error;
            //поть до дириктории
            private $__upath;
            
            //Массив с папками замена функции in_dir($__upath);
            private $DirArray;
            //имя пользователя
            private $User_name;
            
            private $User_name_List; // массив пользателей для функции Access_changer()




            /* Методы класса File_System_Interface */
            function __construct() //нужно подумать как будет происходить инициализация
            {
                
            }
            function __destruct() // подумать нужен ли вообще
            {
                
            }
            
            function Registration_form_creater() // форма регистрации
            {
                $html = '<body>'
		.'    <form method="POST" action="Registration.php">
                            <input type="text" placeholder="Login" id="userlogin" name="userlogin">
                            <input type="text" placeholder="mail" id="userlogin" name="userlogin">
                            <input type="password" placeholder="Password" id="userpassword" name="userpassword">
                            <input type="password" placeholder="Conferm" id="userpasswordcheck" name="userpasswordcheck">
                            <button type="submit">Registration</button>
                    </form>'
                      .'<form method="POST" action="Log_Reg.php">'
                   . '<button name="MENU" value="MENU" type="submit">Menu</button>'
                   . '</form>
'               . '</body>';
            
                return $html;
            }
            
            function Log_Form_creater() // форма для авторизации
            {
                $html = '<body>'
		.'    <form method="POST" action="File_System_Inteface.php">
                            <input type="text" placeholder="Login" id="userlogin" name="userlogin">
                            <input type="password" placeholder="Password" id="userpassword" name="userpassword">
                            <button type="submit">Login</button>
                    </form>'
                    .'<form method="POST" action="Log_Reg.php">'
                   . '<button name="MENU" value="MENU" type="submit">Menu</button>'
                   . '</form>'
                     . '</body>';
            
                return $html;
            }
            
            private function File_Form_Creater() // форма дял отображения списка файлов
            {
                $file_arr = $this->DirArray;
                $upath = $file_arr[0];
                unset($file_arr[0]);
    
                $form = '<div style="width:774px; height: 800px; overflow:auto;"><table class="file" bgcolor="#4166F6" width="700" height="auto">';
    
                foreach ($file_arr as $value) 
                {
                    if($value["type"] == 'file' && isset($value["type"]))
                    {
                        $form.= '<tr align="center" class="button1"><td><div style="width:150px; height:30px; overflow:auto;"><p>'.$value['name']." ".'</p><div></td><td><a href = "../File_System_Work/download.php?file='.$upath.'/'.$value['name'].'"> Скачать </a> </td>'
                        . '<td>'. '<a HREF = "../File_System_Work/delete.php?upath='.$upath.'/'.$value[ 'name' ].'" > Удалить </a> '.'</td><td><a href = "change_access.php?name='.$upath.'/'.$value[ 'name' ].' "> Изменить права доступа </a></td></tr>';
                    }
                }
                $form.='</table></div>';
                return $form;
            }
            
            private function Dir_Form_Creater() // форма для отображения списка дирикторий 
            {
                 $file_arr = $this->DirArray;
                 $upath = $file_arr[0];
                 unset($file_arr[0]);
    
                 $form = '<div style="width:774px; height: 800px; overflow:auto;"><table class="Dir" bgcolor="#4166F6" width="700" height="500">';
    
                 foreach ($file_arr as $value) 
                 {
                     if($value["type"] == 'dir' && isset($value["type"]))
                     {
                        $form.= '<tr align="center" class="button1"><td ><div style="width:150px; height:33px; overflow:auto;"><p><a href = "File_System_Inteface.php?path='.$upath.'/'.$value[ 'name' ].' ">'. $value[ 'name' ] .'</a></p></div></td>'
                        . '<td>'. '<a href = "../File_System_Work/delete.php?upath='.$upath.'/'.$value[ 'name' ].'" > Удалить </a> '.'</td><td><a href = "change_access.php?name='.$upath.'/'.$value[ 'name' ].' "> Изменить права доступа </a></td></tr>';
                      }
                 }
                 $form.='</table></div>';
                 return $form;
                 
            }
            private function Upload_File_Form() // форма для подгруззки файла
            {
                $form = '<form action="../File_System_Work/upload.php"  method=post enctype=multipart/form-data class="file-upload">
                <input type="file"  name="FILE"/>
                <input type="hidden"  name="upath"  value="'.$this->__upath.'"/>
                <input type="submit"  name="addFile" value="Загрузить"/>
                </form>';
    
                return $form;
            }
            
            private function Create_Dir_Form() // Создание формы новой дириктории
            {
                 $form = '<form action="../File_System_Work/new_dir.php"  method="post">'
                .'<input type="hidden"  name="upath"  value="'.$this->__upath.'"/>'
                .'<input type="text"  name="dir"  size="20"/>'
                .'<input type="submit" value="Добавить"/>'
                .'</form>';
    
                return $form;
            }
            
            function File_System_Interface_creater() //Основная функция интерфейса файловой системы
            {
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
                                                    <p>User Name:'. $this->User_name. '</p>
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
                                                    <td align="center">'.$this->Upload_File_Form().'</td>
                                                </tr>			
                                            </table>
                                        </td>
                                        <td align="center">
                                            <table class="creat" bgcolor="#4166F6" width="450" height="auto">
                                                <tr>
                                                    <td align="center">'.$this->Create_Dir_Form().'</td>
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
            function Error_Handler();   // Обработчик ошибок. Подумать как лучше реализовать
            
            private function Users_Name_Select_List() // список пользователей
            {
                $users_name_list = $this->User_name_List;
                //здесь должен быть получен массив имён пользователей
                $users_name_select_list_select = '<select name="access" multiple="multiple">';

                foreach ($users_name_list as $value) {
                    $users_name_select_list_select.='<option>'.$value.'</option>';
                }

                $users_name_select_list_select.='</select>';

                return $users_name_select_list_select;
            }
                    
            function Access_changer()   // ССмена прав доступа. Может быть в последствии изменён 
            {
                $form .='<table><tr>'
                . '<td>'
                    . '<form action="access_changer.php" method="post">'
                    .'<button type="submit" value="Privat" name="access">Privat</button>'
                    . '</form>'
                .'</td>'
                . '<td>'
                    .'<form action="access_changer.php" method="post">'
                        .$this->Users_Name_Select_List()
                        .'<button type="submit" value="Select" name="access">Select</button>'
                    .'</form>'
                .'</td>'
                .'<td>'
                    .'<form action="access_changer.php" method="post">'
                    .'<button type="submit" value="Public" name="access">Public</button>'
                .'</form>'
                .'</td>'
                .'</tr></table>';
    
                return $form;
            } 
        }
        ?>
