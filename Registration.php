<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Graphical representation of the file system</title>
    </head>
    <body>
        <?php
        if(isset($_REQUEST['Registration'])||isset($_REQUEST['Error']))
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
            
            echo $html;
        }

       if(isset($_POST['userlogin'])&&(strlen($_POST['userlogin']) == 0))
       {
           echo '<form method="POST" action="Registration.php">'
           .'</output>Error</output>'
           .' <button name="Registration" value="Registration" type="submit">Ok</button>'
           . '</form>'
                    .'<form method="POST" action="Log_Reg.php">'
                   . '<button name="MENU" value="MENU" type="submit">Menu</button>'
                   . '</form>';
            
            
       }
//       if(isset($_POST['userlogin']))
//       {
//           echo '<form action="Интерфейсу файловой системе">'
//           .'</output>'.$_POST['userlogin'].'</output>'
//           .' <button type="submit">Ok</button>'
//           . '</form>';
//       }
       
	
        
        ?>
    </body>
</html>
