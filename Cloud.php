<<<<<<< HEAD
<?php
require_once 'FileSystem.php';
//require_once 'Login.php';
//require_once 'Print.php';

class Cloud
{
    private $searcher;
    private $printer;
    private $loginer;

    function __construct($__cloud_path, $__rights_path)
    {
        $this->searcher = new FileSystem($__cloud_path, $__rights_path);
        //$this->printer = new Print();
        //$this->loginer = new Loginer();
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

    function printLogin()
    {
//      Виталя->методРисованияФормыАвторизации();
    }

    function printRegistration()
    {
//      Виталя->методРисованияФормыРегистрации();
    }

    function login($__login, $__password)
    {
//      if(Ярик->методПроверкиПароляЛогина($__login, $__password))
//      {
//          Ярик->методАвторизации($__login);
//          $содержимое_директории = Игорь->getList("/$__login");
//          echo Виталя->методРисованияСодержимогоДиректори($__login, $содержимое_директории, $is_owner = true);
//          return;
//      }
//
//      echo Виталя->методРисованияФормыАвторизации"($error = "Неверный логин или пароль);
//      return;
    }

    function logout($__login)
    {
//      Ярик->методВыхода();
//      echo Виталя->методРисованияФормыАвторизации();
//      return;
    }

    function printDir($__clpath)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//
//      if(!$user)
//      {
//          echo Виталя->методРисованияФормыАвторизации();
//          return;
//      }
//
//      if(Игорь->getRight($__clpath, $user)[0] != 'r')
//      {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//      }
//
//      $содержимое_директории = Игорь->getList("/$__clpath");
//      echo Виталя->методРисованияСодержимогоДиректори($user, $содержимое_директории, $is_owner);
//      return;
    }

    function makeDir($__clpath, $__dir_name)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//      if(!$user)
//      {
//          echo Виталя->методРисованияФормыАвторизации();
//          return;
//      }
//
//      if(Игорь->getRight($__clpath, $user) != 'rw')
//      {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//      }
//
//
//
//      Игорь->addFie($__clpath, $__dir_name));
//      Игорь->setRights("$__clpath/$__dir_name", $user, []);
//
//      $содержимое_директории = Игорь->getList("/$__clpath");
//      echo Виталя->методРисованияСодержимогоДиректори($user, $содержимое_директории, $is_owner = true);
//      return;
    }

    function uploadFile($__clpath, $__file_name, $__tmp_name)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//      Игорь->addFile($__clpath, $__file_name, $__tmp_name);
//      if(!$user)
//      {
//        echo Виталя->методРисованияФормыАвторизации();
//        return;
//      }
//
//        if(Игорь->getRight($__clpath, $user) != 'rw')
//        {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//        }
//
//        Игорь->addFie($__clpath, $__file_name, $__tmp_name));
//        Игорь->setRights("$__clpath/$__file_name", $user, []);

    }


=======
<<<<<<< HEAD
<?php
require_once 'FileSystem.php';
//require_once 'Login.php';
//require_once 'Print.php';

class Cloud
{
    private $searcher;
    private $printer;
    private $loginer;

    function __construct($__cloud_path, $__rights_path)
    {
        $this->searcher = new FileSystem($__cloud_path, $__rights_path);
        //$this->printer = new Print();
        //$this->loginer = new Loginer();
    }

    /*
     * Возможные запросы:
     * 1. Форма регистрации
     * 2. Форма авторизации
     * 3. Регистрация
     * 4. Авторизация
     * 5. Разлогирование(выход)
     * 6. Содержимое директории
     * 7. Создать директорию
     * 8. Загрузить файл
     * 9. Скачать файл
     * 10. Удалить файл/директорию
     * 11. Форма смены прав
     * 12. Смена прав
     * 13. Получение списка пользователей
     */

    function printLogin()
    {
//      Виталя->методРисованияФормыАвторизации();
    }

    function printRegistration()
    {
//      Виталя->методРисованияФормыРегистрации();
    }

    function login($__login, $__password)
    {
//      if(Ярик->методПроверкиПароляЛогина($__login, $__password))
//      {
//          Ярик->методАвторизации($__login);
//          $содержимое_директории = Игорь->getList("/$__login");
//          echo Виталя->методРисованияСодержимогоДиректори($__login, $содержимое_директории, $is_owner = true);
//          return;
//      }
//
//      echo Виталя->методРисованияФормыАвторизации($error = "Неверный логин или пароль");
//      return;
    }

    function logout($__login)
    {
//      Ярик->методВыхода();
//      echo Виталя->методРисованияФормыАвторизации();
//      return;
    }

    function printDir($__clpath)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//
//      if(!$user)
//      {
//          echo Виталя->методРисованияФормыАвторизации();
//          return;
//      }
//
//      if(Игорь->getRight($__clpath, $user)[0] != 'r')
//      {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//      }
//
//      $содержимое_директории = Игорь->getList("/$__clpath");
//      echo Виталя->методРисованияСодержимогоДиректори($user, $содержимое_директории, $is_owner);
//      return;
    }

    function makeDir($__clpath, $__dir_name)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//      if(!$user)
//      {
//          echo Виталя->методРисованияФормыАвторизации();
//          return;
//      }
//
//      if(Игорь->getRight($__clpath, $user) != 'rw')
//      {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//      }
//
//
//
//      Игорь->addFie($__clpath, $__dir_name));
//      Игорь->setRights("$__clpath/$__dir_name", $user, []);
//
//      $содержимое_директории = Игорь->getList("/$__clpath");
//      echo Виталя->методРисованияСодержимогоДиректори($user, $содержимое_директории, $is_owner = true);
//      return;
    }

    function uploadFile($__clpath, $__file_name, $__tmp_name)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//      Игорь->addFile($__clpath, $__file_name, $__tmp_name);
//      if(!$user)
//      {
//        echo Виталя->методРисованияФормыАвторизации();
//        return;
//      }
//
//        if(Игорь->getRight($__clpath, $user) != 'rw')
//        {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//        }
//
//        Игорь->addFie($__clpath, $__file_name, $__tmp_name));
//        Игорь->setRights("$__clpath/$__file_name", $user, []);

    }


=======
<?php
require_once 'FileSystem.php';
//require_once 'Login.php';
//require_once 'Print.php';

class Cloud
{
    private $searcher;
    private $printer;
    private $loginer;

    function __construct($__cloud_path, $__rights_path)
    {
        $this->searcher = new FileSystem($__cloud_path, $__rights_path);
        //$this->printer = new Print();
        //$this->loginer = new Loginer();
    }

    /*
     * Возможные запросы:
     * 1. Форма регистрации
     * 2. Форма авторизации
     * 3. Регистрация
     * 4. Авторизация
     * 5. Разлогирование(выход)
     * 6. Содержимое директории
     * 7. Создать директорию
     * 8. Загрузить файл
     * 9. Скачать файл
     * 10. Удалить файл/директорию
     * 11. Форма смены прав
     * 12. Смена прав
     * 13. Получение списка пользователей
     */

    function printLogin()
    {
//      Виталя->методРисованияФормыАвторизации();
    }

    function printRegistration()
    {
//      Виталя->методРисованияФормыРегистрации();
    }

    function login($__login, $__password)
    {
//      if(Ярик->методПроверкиПароляЛогина($__login, $__password))
//      {
//          Ярик->методАвторизации($__login);
//          $содержимое_директории = Игорь->getList("/$__login");
//          echo Виталя->методРисованияСодержимогоДиректори($__login, $содержимое_директории, $is_owner = true);
//          return;
//      }
//
//      echo Виталя->методРисованияФормыАвторизации($error = "Неверный логин или пароль");
//      return;
    }

    function logout($__login)
    {
//      Ярик->методВыхода();
//      echo Виталя->методРисованияФормыАвторизации();
//      return;
    }

    function printDir($__clpath)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//
//      if(!$user)
//      {
//          echo Виталя->методРисованияФормыАвторизации();
//          return;
//      }
//
//      if(Игорь->getRight($__clpath, $user)[0] != 'r')
//      {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//      }
//
//      $содержимое_директории = Игорь->getList("/$__clpath");
//      echo Виталя->методРисованияСодержимогоДиректори($user, $содержимое_директории, $is_owner);
//      return;
    }

    function makeDir($__clpath, $__dir_name)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//      if(!$user)
//      {
//          echo Виталя->методРисованияФормыАвторизации();
//          return;
//      }
//
//      if(Игорь->getRight($__clpath, $user) != 'rw')
//      {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//      }
//
//
//
//      Игорь->addFie($__clpath, $__dir_name));
//      Игорь->setRights("$__clpath/$__dir_name", $user, []);
//
//      $содержимое_директории = Игорь->getList("/$__clpath");
//      echo Виталя->методРисованияСодержимогоДиректори($user, $содержимое_директории, $is_owner = true);
//      return;
    }

    function uploadFile($__clpath, $__file_name, $__tmp_name)
    {
//      $user = Ярик->методПолученияЛогинаПользователя();
//      Игорь->addFile($__clpath, $__file_name, $__tmp_name);
//      if(!$user)
//      {
//        echo Виталя->методРисованияФормыАвторизации();
//        return;
//      }
//
//        if(Игорь->getRight($__clpath, $user) != 'rw')
//        {
//          Виталя->методРисованияОшибкиПравДоступа($user);
//          return;
//        }
//
//        Игорь->addFie($__clpath, $__file_name, $__tmp_name));
//        Игорь->setRights("$__clpath/$__file_name", $user, []);

    }


>>>>>>> 975267015844235c60e178e73625c63102b89e7d
>>>>>>> bf883e2d6df43f9355950558fa03f7c226e953b8
}