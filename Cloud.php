<?php
require_once 'Authorizater.php';
require_once 'FileSystem.php';
require_once 'Print.php';

define('MINCHARSLOGIN', 4, true);
define('MINCHARSPASS', 6, true);

class Cloud
{
    private $authorizater;
    private $fileSystem;
    private $printer;

    function __construct($__cloud_path, $__rights_path, $__users_path, $__action)
    {
        $this->authorizater = new Authorizater($__users_path);
        $this->fileSystem = new FileSystem($__cloud_path, $__rights_path);
        $this->printer = new _Print($__action);
    }


    /**
     * Метод рисует страницу с формой регистрации
     */
    function printRegistration()
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Registration_form_creater();
            return;
        }

        $dirInfo = $this->fileSystem->getList("\\$user", $user);
        $users_list = $this->authorizater->getUsers($user);

        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $user);

        //рисуем страничку с содержимым директории пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, "\\$user", $users_list, $access_to_users);
        return;
    }

    /**
     * Метод рисует страницу с формой авторизации
     */
    function printLogin()
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $dirInfo = $this->fileSystem->getList("\\$user", $user);
        $users_list = $this->authorizater->getUsers($user);


        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $user);

        //рисуем страничку с содержимым директории пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, "\\$user", $users_list, $access_to_users);
        return;
    }


    /**
     * Метод проверяет формат логина и в случае ошибки заносит ее в массив ошибок
     * @param string $__login - логин
     * @param array $__errors - массив ошибок
     */
    function loginError($__login, $__errors)
    {
        if (!strlen($__login))
        {
            $__errors[] = "Слишком короткий логин. Необходимо неменее " . MINCHARSLOGIN . " символов ";
            return;
        }

        $chars = ['@', '#', '$', '%', '^', '&', '*', '№',
                    '!', '?', ';', '.', ',', ':', '~', '+', '-', '=',
                    '"', '\'', '`', '<', '>', '[', ']', '{', '}', '(', ')', '|', '\\', '|', '/'];

        foreach ($chars as $char)
            if (strpos($__login, $char))
            {
                $__errors[] = "Некорректный логин. Убедитесь, что он не содержит символы @#$%^&*№!?;.,:~+-=\"'`<>[]{}()|\\|/";
                return;
            }

        if (strlen($__login) < MINCHARSLOGIN)
        {
            $__errors[] = "Слишком короткий логин. Необходимо неменее " . MINCHARSLOGIN . " символов ";
            return;
        }

        if ($this->authorizater->loginExists($__login))
        {
            $__errors[] = "Логин занят";
            return;
        }

        return;
    }

    /**
     * Метод проверяет формат пароля и в случае ошибки заносит ее в массив ошибок
     * @param string $__password - пароль
     * @param string $__passwordcheck - проверочный пароль
     * @param array $__errors - массив ошибок
     */
    function passwordError($__password, $__passwordcheck, $__errors)
    {
        $chars = ['@', '#', '$', '%', '^', '&', '*', '№',
            '!', '?', ';', '.', ',', ':', '~', '+', '-', '=',
            '"', '\'', '`', '<', '>', '[', ']', '{', '}', '(', ')', '|', '\\', '|', '/'];

        foreach ($chars as $char)
            if (strpos($__password, $char))
            {
                $__errors[] = "Некорректный логин. Убедитесь, что он не содержит символы @#$%^&*№!?;.,:~+-=\"'`<>[]{}()|\\|/";
                return;
            }

        if(strlen($__password) < MINCHARSPASS)
        {
            $__errors[] = "Слишком короткий пароль. Необходимо неменее ".MINCHARSLOGIN." символов ";
            return;
        }

        if($__password != $__passwordcheck)
        {
            $__errors[] = "Неверный повтор ввода пароля";
            return;
        }

        return;
    }


    /**
     * Метод проверяет формат адреса электронной почты и в случае ошибки заносит ее в массив ошибок
     * @param string $__mail - адрес электронной почты
     * @param array $__errors - массив ошибок
     */
    function mailError($__mail, $__errors)
    {
        if(!preg_match('/(([a-z0-9\.\-]+)@([a-z0-9\.\-]+\.[a-z]+))/uis', $__mail))
        {
            $__errors[] = "Некорректный адрес электронной почты";
            return;
        }

        if($this->authorizater->mailExists($__mail))
        {
            $__errors[] = "Данный адресс электронной почты занят";
            return;
        }

        return;
    }


    /**
     * Метод регистрирует пользователя
     * @param string $__login - логин
     * @param string $__password - пароль
     * @param string $__passwordcheck - проверочный пароль
     * @param string $__mail - адрес электронной почты
     * @return void
     */
    function register($__login, $__password, $__passwordcheck, $__mail)
    {
        $__mail = mb_strtolower($__mail);

        //Проверка данных на ошибки
        $errors = [];
        $this->loginError($__login, $errors);
        $this->passwordError($__password, $__passwordcheck, $errors);
        $this->mailError($__mail, $errors);

        //Возврат к форме регистрации при наличии ошибок
        if(count($errors))
        {
            $errors_str = implode("\n", $errors);
            echo $this->printer->Registration_form_creater($errors_str, $__login, $__mail);
            return;
        }

        //регистрируем пользователя
        $this->authorizater->register($__login, $__password, $__mail);
        $this->authorizater->login($__login);

        //создаем директорию под пользователя
        $this->fileSystem->addFile('\\', $__login);
        //устанавливаем на нее дефолтные права
        $this->fileSystem->setRights("\\$__login", $__login, []);
        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList("\\$__login", $__login);
        $users_list = $this->authorizater->getUsers($__login);

        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $__login);

        //рисуем страничку с содержимым директории пользователя
        echo $this->printer->File_System_Interface_creater($__login, $dirInfo, true, "\\$__login", $users_list, $access_to_users);
        return;
    }

    /**
     * Метод авторизует пользователя
     * @param string $__login - логин
     * @param string $__password - пароль
     * @return void
     */
    function login($__login, $__password)
    {
        if (!$this->authorizater->loginCheck($__login, $__password))
        {
            echo $this->printer->Log_Form_creater("Неверный логин или пароль", $__login);
            return;
        }

        //автоизуем пользователя
        $this->authorizater->login($__login);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList("/$__login", $__login);
        $users_list = $this->authorizater->getUsers($__login);

        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $__login);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($__login, $dirInfo, true, "\\$__login", $users_list, $access_to_users);
        return;
    }

    /**
     * Метод производит выход пользователя
     */
    function logout()
    {
        $this->authorizater->logout();

        echo $this->printer->Log_Form_creater();
        return;
    }


    /**
     * Метод переводит пользователя в заданную директорию
     * @param string $__clpath - путь к директории
     */
    function openDir($__clpath)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->fileSystem->getRight($__clpath, $user);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList($__clpath, $user);
        $is_owner = ($rights[1] == 'w');
        $users_list = $this->authorizater->getUsers($user);

        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $user);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, $is_owner, $__clpath, $users_list, $access_to_users);
        return;
    }


    /**
     * Метод создает новую директорию
     * @param string $__clpath - директория, в которой будет создана новая
     * @param string $__dir_name - имя директории
     */
    function makeDir($__clpath, $__dir_name)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $file_path = $file_path = $this->fileSystem->addFile($__clpath, $__dir_name);
        $this->fileSystem->setRights($file_path, $user, []);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList($__clpath, $user);
        $users_list = $this->authorizater->getUsers($user);
        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $user);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $__clpath, $users_list, $access_to_users);
        return;
    }


    /**
     * Метод загрузки файла на сервер
     * @param string $__clpath - путь назночения
     * @param string $__file_name - имя файла
     * @param string $__tmp_name - фременное имя файла на сервере
     */
    function uploadFile($__clpath, $__file_name, $__tmp_name)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $file_path = $this->fileSystem->addFile($__clpath, $__file_name, $__tmp_name);
        $this->fileSystem->setRights($file_path, $user, []);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList($__clpath, $user);
        $users_list = $this->authorizater->getUsers($user);
        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $user);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $__clpath, $users_list, $access_to_users );
        return;
    }


    /**
     * Метод скачивания файла с сервера
     * @param string $__clpath - путь к файлу
     */
    function downloadFile($__clpath)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $this->fileSystem->giveFile($__clpath);
        return;
    }


    /**
     * Метод удаления файла
     * @param string $__clpath - путь к файлу
     */
    function deleteFile($__clpath)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $this->fileSystem->removeFile($__clpath);
        $this->fileSystem->delFileRights($__clpath);

        //получаем информацию о содержимом папки пользователя
        $dirs = explode('\\', $__clpath);
        array_pop($dirs);
        $clpath = implode('\\', $dirs);
        $dirInfo = $this->fileSystem->getList($clpath, $user);
        $users_list = $this->authorizater->getUsers($user);
        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $user);
        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $clpath, $users_list, $access_to_users);
        return;
    }


    /**
     * Метод перехода к меню изменения прав доступа к файлу
     * @param string $__clpath - путь к файлу
     */
    function printRightsMenu($__clpath)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $users = $this->authorizater->getUsers();

        foreach ($users as $index => $login)
            if($login == $user)
                unset($users[$index]);

        echo $this->printer->Access_changer_form($__clpath, $users);
    }


    /**
     * Метод изменяет права на файл
     * @param string $__clpath - путь к файлу
     * @param array $__users - пользователи, которым разрешено право на чтение
     */
    function changeRights($__clpath, $__users)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $this->fileSystem->changeRights($__clpath, $__users);


        $dirs = explode('\\', $__clpath);
        array_pop($dirs);
        $back_clpath = implode('\\', $dirs);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList($back_clpath, $user);
        $users_list = $this->authorizater->getUsers($user);
        $access_to_users = [];
        foreach ($users_list as $u)
            $access_to_users[$u] = $this->fileSystem->getRight("\\$u", $user);
        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $back_clpath, $users_list, $access_to_users);
        return;
    }
}