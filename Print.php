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
        
            $html = '<!DOCTYPE html>
            <html lang="en" >
            <head>
              <meta charset="UTF-8">
              <title>Cloud Storage</title>



                  <style>
                  /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
                  @import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
            @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

            body{
                    margin: 0;
                    padding: 0;
                    background: #fff;

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
                    background-image: url(http://ginva.com/wp-content/uploads/2012/07/city-skyline-wallpapers-008.jpg);
                    background-size: cover;
                    -webkit-filter: blur(5px);
                    z-index: 0;
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
                    font-family: ."Exo"., sans-serif;
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
                    font-family: ."Exo"., sans-serif;
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
                    font-family: ."Exo"., sans-serif;
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
                    color: #a18d6c;
                    font-family: ."Exo"., sans-serif;
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
            }
                </style>

              <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

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
              <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


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
              <meta charset="UTF-8">
              <title>Cloud Storage</title>



                  <style>
                  /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
                  @import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
            @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

            body{
                    margin: 0;
                    padding: 0;
                    background: #fff;

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
                    background-image: url(http://ginva.com/wp-content/uploads/2012/07/city-skyline-wallpapers-008.jpg);
                    background-size: cover;
                    -webkit-filter: blur(5px);
                    z-index: 0;
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
                    font-family: '."Exo".', sans-serif;
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
                    font-family: ."Exo"., sans-serif;
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
                    font-family: ."Exo"., sans-serif;
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
                    color: #a18d6c;
                    font-family: ."Exo"., sans-serif;
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
            }
                </style>

              <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

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
              <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


            </body>
            </html>';
            
            return $html;    
     }
            
    public function File_Form_Creater($directory_contents,$is_owner) // форма дял отображения списка файлов  +
    {
        $file_arr = $directory_contents;
        $upath = $file_arr[0];
        unset($file_arr[0]);
    
    
        foreach ($file_arr as $value) 
        {
            if($value["type"] == 'file' && isset($value["type"]))
            {   
                $fuctional = "";
                if($is_owner)
                {
                    $fuctional = '<td><a href = "'.$this->__action.'?file_path='.$upath.'/'.$value['name'].'&do=download"> Скачать </a></td>'
                .'<td>'. '<a href = "'.$this->__action.'?file_path='.$upath.'/'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td><a href = "'.$this->__action.'?file_path='.$upath.'/'.$value[ 'name' ].'&do=changeRightsMenu"> Изменить права доступа </a></td>';
                }
                
                $form.= '<tr align="center" ><td><p>'.$value['name']." ".'</p><div></td>'.$fuctional.'</tr>';
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
    
        $form = '<div style=" height: 800px; overflow:auto;"><table  height="500">';
    
        foreach ($file_arr as $value) 
        {
            if($value["type"] == 'dir' && isset($value["type"]))
            {
                $fuctional = "";
                if($is_owner)
                {
                    $fuctional = '<td><a href = "'.$this->__action.'?file_path='.$upath.'/'.$value[ 'name' ].'&do=delete"> Удалить </a> '.'</td><td><a href = "'.$this->__action.'?file_path='.$upath.'/'.$value[ 'name' ].'&do=changeRightsMenu"> Изменить права доступа </a></td>';
                }
                
                 $form.= '<tr align="center"><td ><p><a href = "'.$this->__action.'?path='.$upath.'/'.$value[ 'name' ].'">'. $value[ 'name' ] .'</a></p></td>'.$fuctional.'</tr>';
            }
        }
        

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
            $Create_Dir = Create_Dir_Form($path);
            $Upload_File = Upload_File_Form($path);   
        }
        
        $html = '<!DOCTYPE html>
        <html lang="en" >
        <head>
         <meta charset="UTF-8">
         <title>Random Login Form</title>
  
  
  
                <style>
                /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
                @import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
          @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

           A {
              text-decoration: none; /* Убирает подчеркивание для ссылок */
             } 

          body{
                  margin: 0;
                  padding: 0;
                  background: #fff;

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
                  background-image: url(http://ginva.com/wp-content/uploads/2012/07/city-skyline-wallpapers-008.jpg);
                  background-size: cover;
                  z-index: 0;
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



          .header div{
                  float: left;
                  color: #fff;
                  font-family: "Exo", sans-serif;
                  font-size: 35px;
                  font-weight: 200;
          }

          .header div span{
                  color: #5379fa !important;
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

          .login input[type=button]{
                  width: 260px;
                  height: 35px;
                  background: #fff;
                  border: 1px solid #fff;
                  cursor: pointer;
                  border-radius: 2px;
                  color: #a18d6c;
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
          }
              </style>



          </head>

          <body>
                           <body>
                           <div class="body" >
                              <table  width="100%" height="auto">
                                  <tr>
                                      <td align="center">
                                          <table class="head"  width="100%" height="auto">
                                              <tr class="header">
                                                  <td align="center"  width="50%">
                                                      <h1>Project6</h1>
                                                      <h2>Thin client. Cloud storage.</h2>
                                                  </td>
                                                  <td align="right"  width="50%">
                                                      <ul>
                                                          <li>
                                                            '.$this->Logout($user).'
                                                          </li>
                                                      </ul>
                                                  </td>
                                              <tr>
                                          </table>
                                      <td>
                                  </tr>
                                  <tr>
                                      <td  align="center">
                                          <table  width="100%" >
                                              <tr>
                                                  <td align="center" width="auto">
                                                      '.$this->Dir_Form_Creater($directory_contents, $is_owner)				
                                                      .$this->File_Form_Creater($directory_contents, $is_owner)			
                                                  .'</td>
                                              </tr>
                                              <tr>
                                                  <td align="center">
                                                      <table >
                                                          <tr>
                                                              <td align="center" class="Login">'.$this->Upload_File_Form($path).
                                                              $this->Create_Dir_Form($path).'</td>
                                                          </tr>			
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                                                  </div>
                          </body>

          </body>
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
        $form .='<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Random Login Form</title>
  
  
  
      <style>
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
      @import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

body{
	margin: 0;
	padding: 0;
	background: #fff;

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
	background-image: url(http://ginva.com/wp-content/uploads/2012/07/city-skyline-wallpapers-008.jpg);
	background-size: cover;
	-webkit-filter: blur(5px);
	z-index: 0;
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
	font-size: 35px;
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

.login button{
	width: 260px;
	height: 35px;
	background: #fff;
	border: 1px solid #fff;
	cursor: pointer;
	border-radius: 2px;
	color: #a18d6c;
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
}
    </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>

<body>
  <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
		</div>
		<br>
		<div class="login">
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
                        <p>Упользователя'.$error.' недостаточно прав на файл'.$fpath.'</p>
                        <button name="do" value="access_error" type="submit">Try again</button>'
                        .'<input type="hidden"  name="user"  value="'.$user.'"/>'
                        .'<input type="hidden"  name="file"  value="'.$fpath.'"/>
                        
                    </form>';
                    
            return $html;
    }
}
?>