<<<<<<< HEAD
<?php
require_once 'FileSystem.php';
//require_once 'Login.php';
require_once 'Print.php';

class Cloud
{
    private $searcher;
    private $printer;
    private $autorizater;

    function __construct($__cloud_path, $__rights_path, $__users_path)
    {
        $this->searcher = new FileSystem($__cloud_path, $__rights_path);
        $this->printer = new _Print();
        //$this->loginer = new Loginer($__users_path);
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
        echo $this->printer->Registration_form_creater();
    }

    /**
     * Метод рисует страницу с формой авторизации
     */
    function printLogin()
    {
        echo $this->printer->Log_Form_creater();
    }

    /**
     * Метод регистрирует пользователя
     * @param $__login
     * @param $__password
     * @param $__mail
     * @return void
     */
    function register($__login, $__password, $__mail)
    {
        if ($this->autorizater->loginExists($__login)) {
            echo $this->printer->Registration_form_creater("Логин занят");
            return;
        }

        if ($this->autorizater->mailExists($__mail)) {
            echo $this->printer->Registration_form_creater("Почта занята");
            return;
        }

        //регистрируем пользователя
        $this->autorizater->register($__login, $__password, $__mail);

        //создаем директорию под пользователя
        $this->searcher->addFile('/', $__login);
        //устанавливаем на нее дефолтные права
        $this->searcher->setRights("/$__login", $__login, []);
        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->searcher->getList("/$__login");

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
        if ($this->autorizater->loginCheck($__login, $__password))
        {
            echo $this->printer->Log_Form_creater("Неверный логин или пароль");
            return;
        }

        //автоизуем пользователя
        $this->autorizater->login($__login);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->searcher->getList("/$__login");

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($__login, $dirInfo, true, "/$__login");
        return;
    }

    /**
     * Метод производит выход пользователя
     */
    function logout()
    {
        $this->autorizater->logout();

        echo $this->printer->Log_Form_creater();
        return;
    }


    function openDir($__clpath)
    {
        $user = $this->autorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->searcher->getRight($__clpath, $user);
        if ($rights[0] != 'r')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->searcher->getList($__clpath);
        $is_owner = ($rights[1] != 'w');

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, $is_owner, $__clpath);
        return;
    }


    function makeDir($__clpath, $__dir_name)
    {
        $user = $this->autorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->searcher->getRight($__clpath, $user);
        if ($rights[1] != 'w')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $this->searcher->addFile($__clpath, $__dir_name);
        $this->searcher->setRights("$__clpath/$__dir_name", $user, []);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->searcher->getList($__clpath);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $__clpath);
        return;
    }


    function uploadFile($__clpath, $__file_name, $__tmp_name)
    {
        $user = $this->autorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->searcher->getRight($__clpath, $user);
        if ($rights[1] != 'w')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $this->searcher->addFile($__clpath, $__file_name, $__tmp_name);
        $this->searcher->setRights("$__clpath/$__file_name", $user, []);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->searcher->getList($__clpath);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $__clpath);
        return;
    }

    function downloadFile($__clpath)
    {
        $user = $this->autorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->searcher->getRight($__clpath, $user);
        if ($rights[0] != 'r')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $this->searcher->giveFile($__clpath);
        return;
    }

    function deleteFile($__clpath)
    {
        $user = $this->autorizater->getLogin();
        if (!$user)
        {
            echo $this->printer->Log_Form_creater();
            return;
        }

        $rights = $this->searcher->getRight($__clpath, $user);
        if ($rights[1] != 'w')
        {
            echo $this->printer->Access_Error_Form($user, $__clpath);
            return;
        }

        $this->searcher->removeFile($__clpath);
        $this->searcher->delFileRights($__clpath);

        //получаем информацию о содержимом папки пользователя
        $dirInfo = $this->searcher->getList($__clpath);

        //рисуем страничку с содержимым папки пользователя
        echo $this->printer->File_System_Interface_creater($user, $dirInfo, true, $__clpath);
        return;
    }
}