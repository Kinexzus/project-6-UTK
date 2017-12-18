<?php

require_once dirname(__FILE__).'/../Authorizater.php';

class AuthorizaterTest extends PHPUnit_Framework_TestCase
{
    //register($__login, $__password, $__mail)
    function testRegister()
    {
        $file = fopen(dirname(__FILE__).'/loginsTestFile', 'w');

        $authorizater = new Authorizater(dirname(__FILE__).'/loginsTestFile');

        $user1 = ['Igor', '123', 'igor@mail.ru'];
        $user2 = ['Vitalya', '456', 'vitalya@mail.ru'];
        $user3 = ['Yaroslav', '789', 'yaroslav@mail.ru'];

        $authorizater->register($user1[0], $user1[1], $user1[2]);
        $authorizater->register($user2[0], $user2[1], $user2[2]);
        $authorizater->register($user3[0], $user3[1], $user3[2]);

        $usersInfo = '';
        $usersInfo .= $user1[0]."::".md5($user1[1])."::".$user1[2]."\n";
        $usersInfo .= $user2[0]."::".md5($user2[1])."::".$user2[2]."\n";
        $usersInfo .= $user3[0]."::".md5($user3[1])."::".$user3[2]."\n";

        $this->assertStringEqualsFile(dirname(__FILE__).'/loginsTestFile', $usersInfo);

        fclose($file);
    }


    //loginExists($__login)
    function testLoginExistsTrue()
    {
        $authorizater = new Authorizater(dirname(__FILE__).'/loginsTestFile');

        $exists = true;

        $exists *= $authorizater->loginExists('Igor');
        $exists *= $authorizater->loginExists('Vitalya');
        $exists *= $authorizater->loginExists('Yaroslav');

        $this->assertEquals($exists, true);
    }
    function testLoginExistsFalse()
    {
        $authorizater = new Authorizater(dirname(__FILE__).'/loginsTestFile');

        $exists = false;

        $exists += $authorizater->loginExists('Egor');
        $exists += $authorizater->loginExists('tolya');
        $exists += $authorizater->loginExists('Sanich');

        $this->assertEquals($exists, false);
    }


    //mailExists($__mail)
    function testMailExistsTrue()
    {
        $authorizater = new Authorizater(dirname(__FILE__).'/loginsTestFile');

        $exists = true;

        $exists *= $authorizater->mailExists('igor@mail.ru');
        $exists *= $authorizater->mailExists('vitalya@mail.ru');
        $exists *= $authorizater->mailExists('yaroslav@mail.ru');

        $this->assertEquals($exists, true);
    }
    function testMailExistsFalse()
    {
        $authorizater = new Authorizater(dirname(__FILE__).'/loginsTestFile');

        $exists = false;

        $exists += $authorizater->mailExists('tolya@yandex.ru');
        $exists += $authorizater->mailExists('pasha@mail.ru');
        $exists += $authorizater->mailExists('dima@gmail.com');

        $this->assertEquals($exists, false);
    }


    //loginCheck($__login, $__password)
    function testloginCheckTrue()
    {
        $authorizater = new Authorizater(dirname(__FILE__).'/loginsTestFile');

        $check = true;

        $check *= $authorizater->loginCheck('Igor', '123');
        $check *= $authorizater->loginCheck('Vitalya', '456');
        $check *= $authorizater->loginCheck('Yaroslav', '789');

        $this->assertEquals($check, true);
    }
    function testloginCheckFalse()
    {
        $authorizater = new Authorizater(dirname(__FILE__).'/loginsTestFile');

        $check = false;

        $check += $authorizater->loginCheck('Igor', '124');
        $check += $authorizater->loginCheck('Petya', '456');
        $check += $authorizater->loginCheck('Artem', 'fds');

        $this->assertEquals($check, false);
    }


    function test_getUsers()
    {
        $authorizater = new Authorizater(dirname(__FILE__).'/loginsTestFile');

        $users = $authorizater->getUsers();

        $this->assertEquals(['Igor', 'Vitalya', 'Yaroslav'], $users);
    }

    //login($__login)
//    function testLogin()
//    {
//        $authorizater = new Authorizater('./loginsTestFile');
//
//        $authorizater->login('Petya');
//
//        $this->assertEquals($_COOKIE['login'], 'Petya');
//    }
//
//
//    //logout()
//
//    function testLogout()
//    {
//        $authorizater = new Authorizater('./loginsTestFile');
//
//        $authorizater->logout();
//
//        $this->assertEquals(isset($_COOKIE['login']), false);
//    }
//
//    //getLogin
//    function testGetLogin()
//    {
//        $authorizater = new Authorizater('./loginsTestFile');
//
//        $logins = [];
//        $logins[] = $authorizater->getLogin();
//        $authorizater->login('Petya');
//        $logins[] = $authorizater->getLogin();
//        $authorizater->logout();
//        $logins[] = $authorizater->getLogin();
//
//        $this->assertEquals($logins, [false, 'Petya', false]);
//    }
}

