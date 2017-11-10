<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_REQUEST['Login'])||isset($_REQUEST['Error']))
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
            
            echo $html;
        }
  
        if(isset($_POST['userlogin'])&&(strlen($_POST['userlogin']) == 0))
       {
           echo '<form method="POST" action="Login.php">'
           .'</output>Error</output>'
           .' <button name="Error" value="Error" type="submit">Ok</button>'
           . '</form>'
                   .'<form method="POST" action="Log_Reg.php">'
                   . '<button name="MENU" value="MENU" type="submit">Menu</button>'
                   . '</form>';   
       }