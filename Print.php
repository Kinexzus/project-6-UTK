<?php

class _Print //Класс содержащий методы реализации графического представления облочного хранилища
{   
    private $__action; //Поле содержащие имя сервера обработки запросов

	//$action -  имя сервера обработки запросов
    public function __construct($action) //Конструктор класса
    {
        $this->__action = $action;
    }
    
	//$error - ошибка возникающая при регистрации, $login - восстанавливает значение логина в форме при ошибке, если ошибка допущена не в поле логина; , $mail - восстанавливает значение почты в форме при ошибке, если ошибка допущена не в поле почты;
    public function Registration_form_creater($error = NULL, $login = "", $mail = "") //Функция отображающая форму регистрации новых пользователей
    {
            $error_out = '';
            if($error !== NULL)
            {
                $error_out = '<input type="text" value="'.$error.'" name="error">'; // если приходит ошибка, то отрисовывает лополнительное поле с ошибкой
            }
			
			//Код html-страницы авторизации
            $html = '
            <html lang="en" >
            <head>
			 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <link rel="stylesheet" type="text/css" href="log%reg.css">
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
     
	//$error - ошибка возникающая при логировании, $login - восстанавливает значение логина в форме при ошибке, если ошибка допущена не в поле логина;	 
	public function Log_Form_creater($error = NULL, $login = "") //Функция отображающая форму логирования новых пользователей
    {       
            $error_out = '';
            if($error !== NULL)
            {
                $error_out = '<input type="text" value="'.$error.'" name="error">'; 	// если приходит ошибка, то отрисовывает лополнительное поле с ошибкой
            }
        
			//Код html-страницы логирования
            $html = '<!DOCTYPE html>
            <html lang="en" >
            <head>
			 <link rel="stylesheet" type="text/css" href="./log%reg.css">	
             <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    //$path - путь до директории 
	private function  Directory_tree($path) // Функция возвращающая иерархию представления вложенности директорий
	{
		$dir_arr = explode("\\", $path);	//	Раскладываем полученный путь в массив 
        array_shift($dir_arr);
		$path_S = [];


		while(count($dir_arr) > 0) // Создаём массив с путями до котологов
		{
			$path_S[] = "\\".implode("\\", $dir_arr);
            array_pop($dir_arr);
		}


		$dir = explode("\\", $path); //	Раскладываем полученный путь в массив
        array_shift($dir);
		$path_S = array_reverse($path_S);
		$res = "";

		for($i = 0; $i != count($path_S); $i++) //	Создаём иерархию представления вложенности директорий с сылками к каждой ступени вложенности
		{
			$res .= '<a href = "'.$this->__action.'?path='.$path_S[$i].'&do=openDir">'. '\\'.$dir[$i] .'</a>';
		}
		
		return $res;
	}
	
	//$directory_contents - массив содержимого дериктории ,$is_owner - параметр определяющий является ли пользователь владельцем
    private function File_Form_Creater($directory_contents,$is_owner) // Функция возвращающая список контента директории
    {
        $file_arr = $directory_contents;
        $upath = $file_arr[0];
        unset($file_arr[0]); // Отделяем путь до директории 
    
        $form = '<div style=" height: 800px; overflow:auto;"><table width="100%" bgcolor="#808080"  cellspacing="4" border="6" cellpadding="7" height="auto">'; //Создаем таблицу для записи файлов дериктории
        foreach ($file_arr as $value) 
        {
				
			// Определяем что это дериктории или файла
            if($value["type"] == 'file' && isset($value["type"]))   //Если файл то добавляем скачивание 
            {   
	    
                $fuctional = "";
                if($is_owner)	//Проверка владельца
                {
                    $fuctional = '<td bgcolor="#38E54F"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value['name'].'&do=download"> Скачать </a></td>' //добавление возможностей: скачивание, удаление, смена прав
			.'<td bgcolor="#DA0791">'. '<a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td bgcolor="#DAD907"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=changeRightsMenu"> Изменить права доступа </a></td>';
			$form .= '<tr align="center" bgcolor="#85C6FF"><td><p>'.$value['name']." ".'</p><div></td>'.$fuctional.'</tr>';
			continue;
                }
                
		else if($value['access_rights'] == 'r-')
		{
			$fuctional = '<td bgcolor="#38E54F"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value['name'].'&do=download"> Скачать </a></td>'; //добавление возможностей: скачивание
			$form .= '<tr align="center" bgcolor="#85C6FF"><td><p>'.$value['name']." ".'</p><div></td>'.$fuctional.'</tr>';
			 continue;
		}
		else if($value['access_rights'] == '-w')
		{	
			//добавление возможностей: удаление
			$fuctional = '<td bgcolor="#DA0791">'. '<a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td>';
			$form .= '<tr align="center" bgcolor="#85C6FF"><td><p>'.$value['name']." ".'</p><div></td>'.$fuctional.'</tr>';
			 continue;
		}
		else if($value['access_rights'] == 'rw')
		{
			$fuctional = '<td bgcolor="#38E54F"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value['name'].'&do=download"> Скачать </a></td>' //добавление возможностей: скачивание, удаление
			.'<td bgcolor="#DA0791">'. '<a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td bgcolor="#DAD907"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=changeRightsMenu"> Изменить права доступа </a></td>';
			$form .= '<tr align="center" bgcolor="#85C6FF"><td><p>'.$value['name']." ".'</p><div></td>'.$fuctional.'</tr>';
			 continue;
		}
		else if($value['access_rights'] == '--')
		{
			$fuctional = '';
			$form .= '<tr align="center" bgcolor="#85C6FF"><td><p>'.$value['name']." ".'</p><div></td>'.$fuctional.'</tr>';
			 continue;
		}
                
            }
			
	     if($value["type"] == 'dir' && isset($value["type"])) //Если директория то делаем ссылка внуть директории
            {
                $fuctional = "";
                if($is_owner)	//Проверка владельца
                {
                    $fuctional = '<td bgcolor="#808080"></td><td bgcolor="#DA0791"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td bgcolor="#DAD907"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=changeRightsMenu"> Изменить права доступа </a></td>'; //добавление возможностей:удаление, смена прав
		    $form.= '<tr align="center"><td bgcolor="#808080" ><a href = "'.$this->__action.'?path='.$upath.'\\'.$value[ 'name' ].'&do=openDir">'. $value[ 'name' ] .'</a></td>'.$fuctional.'</tr>';
		     continue;
                }
                
		else if($value['access_rights'] == 'r-')
		{
			 $fuctional = ''; //добавление возможностей:чтение 
			$form.= '<tr align="center"><td bgcolor="#808080" ><a href = "'.$this->__action.'?path='.$upath.'\\'.$value[ 'name' ].'&do=openDir">'. $value[ 'name' ] .'</a></td>'.$fuctional.'</tr>';
			continue;
		}
		else if($value['access_rights'] == '-w')
		{
			 $fuctional = '<td bgcolor="#808080"></td><td bgcolor="#DA0791"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td>'; //добавление возможностей:удаление
			$form.= '<tr align="center"><td bgcolor="#808080" >'. $value[ 'name' ] .'</td>'.$fuctional.'</tr>';
			 continue;
		}
		else if($value['access_rights'] == 'rw')
		{
			 $fuctional = '<td bgcolor="#808080"></td><td bgcolor="#DA0791"><a href = "'.$this->__action.'?file_path='.$upath.'\\'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td>'; //добавление возможностей:удаление
			$form.= '<tr align="center"><td bgcolor="#808080" ><a href = "'.$this->__action.'?path='.$upath.'\\'.$value[ 'name' ].'&do=openDir">'. $value[ 'name' ] .'</a></td>'.$fuctional.'</tr>';
			 continue;
		}
		else if($value['access_rights'] == '--')
		{
			 $fuctional = '';
			$form.= '<tr align="center"><td bgcolor="#808080" >'. $value[ 'name' ] .'</td>'.$fuctional.'</tr>';
			 continue;
		}
	
            }
        }
         $form.='</table></div>';
         return $form;
    }
    
	//$user - имя пользователя
    private function Logout($user)   // Функция отрисовывает форму выхода из системы пользователя
    {
        $html = '<form method="POST" action="'.$this->__action.'">
                        <p>'.$user.'</p>
                        <button name="do" value="logout" type="submit">Exit</button>
                    </form>';
        
        return $html;
    }

	
	// $path - путь до директории куда будем подгружать файл
    private function Upload_File_Form($path) // Функция отображающая форму для подгрузки файлов на сервер
    {
        $form = '<form action="'.$this->__action.'"  method=post enctype=multipart/form-data class="file-upload">
                    <input type="file"  name="file_name"/>
                    <input type="hidden"  name="path"  value="'.$path.'"/>
                    <input type="submit"  name="do" value="upload"/>
                </form>';
    
        return $form;
    }
    
	// $path - путь до директории где будем создавать директорию
    private function Create_Dir_Form($path) // Функция отображающая форму для создания директории на сервере
    {
        $form = '<form action="'.$this->__action.'"  method="post">'
                .'<input type="hidden"  name="path"  value="'.$path.'"/>'
                .'<input type="text"  name="dir_name"  size="20"/>'
                .'<input type="submit" name="do" value="makeDir"/>'
                .'</form>';
    
        return $form;
    }
    
	//$user - имя пользователя , $directory_contents - массив содержимого дериктории,$is_owner - параметр определяющий является ли пользователь владельцем , $path - путь до директории
    public function File_System_Interface_creater($user, $directory_contents,$is_owner, $path, $access) //Функция отображающая графическое представление файлов системы
    {
	 
        $Create_Dir = "";
        $Upload_File = "";

        if($is_owner === TRUE) // если владелец, то добавляем создание директории и подгрузку файлов 
        {
            $Create_Dir = $this->Create_Dir_Form($path);		
            $Upload_File = $this->Upload_File_Form($path);
        }
        //Код html-страницы
        $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
        <html lang="en" >
        <head>
         <meta charset="UTF-8">
		 <link href="FSI.css" rel="stylesheet">
         <title>Cloud Storage</title>
		<style>
		</style>
		</head>
            <body bgcolor="#808080" link="black" vlink="black" alink="black" bgcolor="black" text-color="white">
                <table  width="100%" height="auto" border="2">
                    <tr>
                         <td align="center"  width="100%" color="white">
                            '.$this->Logout($user).' 
                        </td>
                     <tr>
				</table>
				<table width="100%" bgcolor="#808080"  cellspacing="4" border="6" cellpadding="7" height="auto">
					<tr>
						<td>'
							.$this->Directory_tree($path).
						'</td>
						
						<td bgcolor="#DAD907" width="50%"><a href = "'.$this->__action.'?file_path='.$path.'&do=changeRightsMenu"> Изменить права доступа </a></td>
					</tr>
				</table>'
				.$this->Users_List($access).'
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
	
    //  $_users_name_list - массив пользователей обачного хранилища, $file - изменяемый файл
    private function Users_Name_Select_List($_users_name_list, $file) // Функция возвращает область выбора пользователь в виде checkbox для интерфейса смены прав на файлы
    {
        $i = 1; //Индексация параметра name для checkbox
        $users_name_list = $_users_name_list;
        $users_name_select_list_selectr = '';
	$users_name_select_list_select_w = '';
	 $users_name_select_list_select_rw = '';
	 $users_name_select_list_select__ = '';
	   
	$form = '<table width="100%" bgcolor="#808080"  cellspacing="4" border="6" cellpadding="7" height="auto"><tr><td>Чтение</td></tr>';/*<td>Запись</td><td>Чтение/Запись</td><td>-/-</td>'</tr>'*/

        foreach ($users_name_list as $value) //создаём список пользователей
        {
            $users_name_select_list_selectr.= '<p><input type="checkbox" name="r-'.strval($i).'" value="'.$value.'"> '.$value.'</p><br>';
            ++$i;
        }
	
	/*foreach ($users_name_list as $value) //создаём список пользователей
        {
            $users_name_select_list_select_w.= '<p><input type="checkbox" name="-w'.strval($i).'" value="'.$value.'"> '.$value.'</p><br>';
            ++$i;
        }
	
	foreach ($users_name_list as $value) //создаём список пользователей
        {
            $users_name_select_list_select_rw.= '<p><input type="checkbox" name="rw'.strval($i).'" value="'.$value.'"> '.$value.'</p><br>';
            ++$i;
        }
	
	foreach ($users_name_list as $value) //создаём список пользователей
        {
            $users_name_select_list_select__.= '<p><input type="checkbox" name="--'.strval($i).'" value="'.$value.'"> '.$value.'</p><br>';
            ++$i;
        }*/
	
		$form .= '<tr>
		<td>
		<form action="'.$this->__action.'" method="post">'
                .'<div style=" height: 400px; overflow:auto;">'
                  .$users_name_select_list_selectr
                 .'</div>'
                 .'<button type="submit" value="changeRights" name="do">Select</button>'
                 .'<input type="hidden"  name="access"  value="select"/>'
                 .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                 .'</form>
		 </td></tr>
		 </table>';
		 /*<td>
		 <form action="'.$this->__action.'" method="post">'
                .'<div style=" height: 400px; overflow:auto;">'
                 .$users_name_select_list_select_w
                 .'</div>'
                 .'<button type="submit" value="changeRights" name="do">Select</button>'
                 .'<input type="hidden"  name="access"  value="select"/>'
                 .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                 .'</form>
		 </td>
		 <td>
		 <form action="'.$this->__action.'" method="post">'
                .'<div style=" height: 400px; overflow:auto;">'
                 .$users_name_select_list_select_rw
                 .'</div>'
                 .'<button type="submit" value="changeRights" name="do">Select</button>'
                 .'<input type="hidden"  name="access"  value="select"/>'
                 .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                 .'</form>
		 </td>
		 <td>
		 <form action="'.$this->__action.'" method="post">'
                .'<div style=" height: 400px; overflow:auto;">'
                 .$users_name_select_list_select__
                 .'</div>'
                 .'<button type="submit" value="changeRights" name="do">Select</button>'
                 .'<input type="hidden"  name="access"  value="select"/>'
                 .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                 .'</form>
		 </td>
		 </tr>
		 </table>';
	    */
	return $form;
    }
    
	//$file - файл у которого меняются права , $_users_name_list - массив пользователей обачного хранилища 
	public function Access_changer_form($file, $_users_name_list)   // Функция отображающая интерфейс смены прав у выбранного файла или директории
    {
		//Код html-страницы
        $form =' <!DOCTYPE html>
		 <html lang="en" >
		 <head>
		  <meta charset="UTF-8">
		  <link href="Access.css" rel="stylesheet">
		  <title>Access list</title>
		  <style>
		  </style>
		 </head>

		<body>
		<div class="login">
		<table width="100%" bgcolor="#808080"  cellspacing="4" border="6" cellpadding="7" height="auto">
                               <tr>
                               <td align="center" width="auto">
                               <form action="'.$this->__action.'" method="post">'
                                .'<button type="submit" value="changeRights" name="do">Privat</button>'
                                .'<input type="hidden"  name="access"  value="privat"/>'
                                .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                                .'</form>
				</td>
				<td align="center" width="auto">
				<form action="'.$this->__action.'" method="post">'
                                .'<button type="submit" value="changeRights" name="do">Public</button>'
                                .'<input type="hidden"  name="access"  value="public"/>'
                                .'<input type="hidden"  name="file_path"  value="'.$file.'"/>'
                                . '</form>
				</td>
				 </tr>
				 </table>'
				.$this->Users_Name_Select_List($_users_name_list,$file).'
				</div>
				</body>
				</html>';
    
        return $form;
    } 
    
	//$_users_name_list - массив пользователей обачного хранилища $access - массив прав доступа
    private function Users_List($access) // Функция создаёт таблицу пользователь для перехода по каталогам других пользователей хранилища
    {
        $html = '<div style=" height: 800px; overflow:auto;"><table width="100%" bgcolor="#808080"  cellspacing="4" border="6" cellpadding="7" height="auto">';
        foreach ($access as $key => $value) 
        {
	    if($value == "rw" || $value == "r-")
            {
		$html .= '<tr align="center"><td bgcolor="#808080" ><a href = "'.$this->__action.'?path=\\'.$key.'&do=openDir">'. $key .'</a></td></tr>';
	    }
	    else
	    {
		$html .= '<tr align="center"><td bgcolor="#808080" >'. $key .'</td></tr>';    
	    }
        }
        
       $html .= '</div></table>';
       
       return $html;
    }
    
	
	private function GetStyleForm() // Резервная функция котора возвращает стили для формы логировании и регистрации
	{
		return 'body{
                    margin: 0;
                    padding: 0;
                    background: #000;

                    color: #fff;
                    font-family: Arial;
                    font-size: 12px;
            }

            .body{
                    position: absolute;
                    top: -20px;
                    left: -20px;
                    right: -40px;
                    bottom: -40px;
                    width: auto;
                    height: auto;
            }

            .grad{
                    position: absolute;
                    top: -20px;
                    left: -20px;
                    right: -40px;
                    bottom: -40px;
                    width: auto;
                    height: auto;
                    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
                    z-index: 1;
                    opacity: 0.7;
            }

            .header{
                    position: absolute;
                    top: calc(50% - 35px);
                    left: calc(50% - 255px);
                    z-index: 2;
            }

            .header div{
                    float: left;
                    color: #fff;
                    font-family: "Exo", sans-serif;
                    font-size: 32px;
                    font-weight: 200;
            }

            .header div span{
                    color: #5379fa !important;
            }

            .login{
                    position: absolute;
                    top: calc(50% - 75px);
                    left: calc(50% - 50px);
                    height: 150px;
                    width: 350px;
                    padding: 10px;
                    z-index: 2;
            }

            .login input[type=text]{
                    width: 250px;
                    height: 30px;
                    background: transparent;
                    border: 1px solid rgba(255,255,255,0.6);
                    border-radius: 2px;
                    color: #fff;
                    font-family: "Exo", sans-serif;
                    font-size: 16px;
                    font-weight: 400;
                    padding: 4px;
            }

            .login input[type=password]{
                    width: 250px;
                    height: 30px;
                    background: transparent;
                    border: 1px solid rgba(255,255,255,0.6);
                    border-radius: 2px;
                    color: #fff;
                    font-family: "Exo", sans-serif;
                    font-size: 16px;
                    font-weight: 400;
                    padding: 4px;
                    margin-top: 10px;
            }

            .login input[type=submit]{
                    width: 260px;
                    height: 35px;
                    background: #fff;
                    border: 1px solid #fff;
                    cursor: pointer;
                    border-radius: 2px;
                    color: #000;
                    font-family: "Exo", sans-serif;
                    font-size: 16px;
                    font-weight: 400;
                    padding: 6px;
                    margin-top: 10px;
            }

            .login input[type=submit]:hover{
                    opacity: 0.8;
            }

            .login input[type=submit]:active{
                    opacity: 0.6;
            }

            .login input[type=text]:focus{
                    outline: none;
                    border: 1px solid rgba(255,255,255,0.9);
            }

            .login input[type=password]:focus{
                    outline: none;
                    border: 1px solid rgba(255,255,255,0.9);
            }

            .login input[type=submit]:focus{
                    outline: none;
            }

            ::-webkit-input-placeholder{
               color: rgba(255,255,255,0.6);
            }

            ::-moz-input-placeholder{
               color: rgba(255,255,255,0.6);
            }';
	}
	
	private function GetStyleAccessForm() // Резервная функция котора возвращает стили для формы изменения прав доступа
	{
	    return '	body{
				margin: 0;
			padding: 0;
			background: #000;
			color: #fff;
			font-family: Arial;
			font-size: 12px;
		}

		.body{
			position: absolute;
			top: -20px;
			left: -20px;
			right: -40px;
			bottom: -40px;
			width: auto;
			height: auto;
		}

		.login button{
			width: 260px;
			height: 35px;
			background: #fff;
			border: 1px solid #fff;
			cursor: pointer;
			border-radius: 2px;
			color: #000;
			font-family: "Exo", sans-serif;
			font-size: 16px;
			font-weight: 400;
			padding: 6px;
			margin-top: 10px;
		}

		.login input[type=button]:hover{
			opacity: 0.8;
		}

		.login input[type=button]:active{
			opacity: 0.6;
		}

		.login input[type=text]:focus{
			outline: none;
			border: 1px solid rgba(255,255,255,0.9);
		}

		.login input[type=password]:focus{
			outline: none;
			border: 1px solid rgba(255,255,255,0.9);
		}

		.login input[type=button]:focus{
			outline: none;
		}

		::-webkit-input-placeholder{
		   color: rgba(255,255,255,0.6);
		}

		::-moz-input-placeholder{
		   color: rgba(255,255,255,0.6);
		}';
	}
	
	private function GetStyleFSI()  // Резервная функция котора возвращает стили для графического представления файловой системы
	{
		return 'body{
			margin: 0;
			padding: 0;
			background: #000;
			color: #fff;
			font-family: Arial;
			font-size: 12px;
			}
		a {
			text-decoration: none;
		  } 
			 [type=submit]{
             width: 250px;
             height: 30px;
             background: transparent;
             border: 1px solid rgba(255,255,255,0.6);
             border-radius: 2px;
             color: #fff;
             font-family: ."Exo"., sans-serif;
             font-size: 16px;
             font-weight: 400;
             padding: 4px;
            }
			 [type=text]{
             width: 250px;
             height: 30px;
             background: transparent;
             border: 1px solid rgba(255,255,255,0.6);
             border-radius: 2px;
             color: #fff;
             font-family: ."Exo"., sans-serif;
             font-size: 16px;
             font-weight: 400;
             padding: 4px;
            }';
	}
}
?>