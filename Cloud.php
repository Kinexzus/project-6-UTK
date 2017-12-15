<<<<<<< HEAD
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

    /*
     * Возможные запросы:
     * 1. Форма регистрации +
     * 2. Форма авторизации +
     * 3. Регистрация
     * 4. Авторизация
     * 5. Разлогирование(выход) +
     * 6. Содержимое директории +
     * 7. Создать директорию +
     * 8. Загрузить файл +
     * 9. Скачать файл +
     * 10. Удалить файл/директорию +
     * 11. Форма смены прав	+
     * 12. Смена прав
     * 13. Получение списка пользователей +
     */

    /**
     * Метод рисует страницу с формой регистрации
     */
    function printRegistration()
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Registration_form_creater();;
            return;
        }

        $dirInfo = $this->fileSystem->getList("/$user");

        //рисуем страничку с содержимым директории пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, "/$user");
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

        $dirInfo = $this->fileSystem->getList("/$user");

        //рисуем страничку с содержимым директории пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, "/$user");
        return;
    }

    /**
     * Метод регистрирует пользователя
     * @param $__login
     * @param $__password
     * @param $__mail
     * @return void
     */
    function register($__login, $__password, $__passwordcheck, $__mail)
    {
        $__mail = mb_strtolower($__mail);

        $errors_arr = array();

        //Проверка корректности логина
//        if(preg_match('#[@\#$%^&*№!?;.,:~+-="\'`<>\[\]{}()|\\|/]#', $__login))
//            $errors_arr[] = "Некорректный логин. Убедитесь, что он не содержит символы @#$%^&*№!?;.,:~+-=\"'`<>[]{}()|\\|/";
        if ($this->authorizater->loginExists($__login))
              $errors_arr[] = "Логин занят";
        if(strlen($__login) < MINCHARSLOGIN)
            $errors_arr[] = "Слишком короткий логин. Необходимо неменее ".MINCHARSLOGIN." символов ";

        //Проверка корректности пароля
//        if(preg_match('#[@\#$%^&*№!?;.,:~+-="\'`<>[]{}()|\\|/]#', $__password))
//            $errors_arr[] = "Некорректный парроль. Убедитесь, что он не содержит символы @#$%^&*№!?;.,:~+-=\"'`<>[]{}()|\\|/";
        if(strlen($__password) < MINCHARSPASS)
            $errors_arr[] = "Слишком короткий пароль. Необходимо неменее ".MINCHARSLOGIN." символов ";
        if($__password != $__passwordcheck)
            $errors_arr[] = "Неверный повтор ввода пароля";

        //Проверка почтового адреса
        if(!preg_match('/(([a-z0-9\.\-]+)@([a-z0-9\.\-]+\.[a-z]+))/uis', $__mail))
            $errors_arr[] = "Некорректный адрес электронной почты";
        elseif($this->authorizater->mailExists($__mail))
            $errors_arr[] = "Почта занята";

        if(count($errors_arr))
        {
            $errors_str = implode('\n', $errors_arr);
            echo $this->printer->Registration_form_creater($errors_str, $__login, $__mail);
            return;
        }

        //регистрируем пользователя
        $this->authorizater->register($__login, $__password, $__mail);
        $this->authorizater->login($__login);

        //создаем директорию под пользователя
        $this->fileSystem->addFile('/', $__login);
        //устанавливаем на нее дефолтные права
        $this->fileSystem->setRights("/$__login", $__login, []);
        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList("/$__login");

        //рисуем страничку с содержимым директории пользователя
        echo $this->printer->File_System_Interface_creater($__login, $dirInfo, true, "/$__login");
        return;
    }

    /**
     * Метод авторизует пользователя
     * @param $__login
     * @param $__password
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
        $dirInfo = $this->fileSystem->getList("/$__login");

        //рисуем страничку с содержимым папки пользователя

        echo $this->printer->File_System_Interface_creater($__login, $dirInfo, true, "/$__login");
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


    function openDir($__clpath)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->fileSystem->getRight($__clpath, $user);
        if ($rights[0] != 'r')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList($__clpath);
        $is_owner = ($rights[1] != 'w');

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, $is_owner, $__clpath);
        return;
    }


    function makeDir($__clpath, $__dir_name)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->fileSystem->getRight($__clpath, $user);
        if ($rights[1] != 'w')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $this->fileSystem->addFile($__clpath, $__dir_name);
        $this->fileSystem->setRights("$__clpath/$__dir_name", $user, []);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList($__clpath);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $__clpath);
        return;
    }


    function uploadFile($__clpath, $__file_name, $__tmp_name)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->fileSystem->getRight($__clpath, $user);
        if ($rights[1] != 'w')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $file_path = $this->fileSystem->addFile($__clpath, $__file_name, $__tmp_name);
        $this->fileSystem->setRights($file_path, $user, []);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList($__clpath);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $__clpath);
        return;
    }

    function downloadFile($__clpath)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->fileSystem->getRight($__clpath, $user);
        if ($rights[0] != 'r')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $this->fileSystem->giveFile($__clpath);
        return;
    }

    function deleteFile($__clpath)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->fileSystem->getRight($__clpath, $user);
        if ($rights[1] != 'w')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $this->fileSystem->removeFile($__clpath);
        $this->fileSystem->delFileRights($__clpath);

        //получаем информацию о содержимом папки пользователя
        $dirs = explode('/', $__clpath);
        array_pop($dirs);
        $clpath = implode('/', $dirs);
        $dirInfo = $this->fileSystem->getList($clpath);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $clpath);
        return;
    }

    function printRightsMenu($__clpath)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->fileSystem->getRight($__clpath, $user);
        if ($rights[1] != 'w')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $users = $this->authorizater->getUsers();

        echo $this->printer->Access_changer_form($__clpath, $users);
    }

    function changeRights($__clpath, $__users)
    {
        $user = $this->authorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->fileSystem->getRight($__clpath, $user);
        if ($rights[1] != 'w')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $this->fileSystem->changeRights($__clpath, $__users);


        $dirs = explode('/', $__clpath);
        array_pop($dirs);
        $back_clpath = implode('/', $dirs);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->fileSystem->getList($back_clpath);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $back_clpath);
        return;
    }
}