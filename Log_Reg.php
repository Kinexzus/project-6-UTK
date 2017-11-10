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
       $html = '<body>'
                    .'<table>'
                        . '<tr>'
                          . '<form method="POST" action="Login.php"><td><button type="submit" name="Login" value="Login">Login</button></td></form>'
                          . '<form method="POST" action="Registration.php"><td><button type="submit" name="Registration" value="Registration">Registration</button></td></form>'
                        .'</tr>'
                    .'</table>'
		. '</body>';
	
	echo $html;
        ?>
    </body>
</html>
