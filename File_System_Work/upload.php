<?php
// Каталог, в который мы будем принимать файл:
$uploaddir = '../File_System';
$uploadfile = $uploaddir.'/'.$_REQUEST['path'].'/'.basename($_FILES['FILE']['name']);

//!!!добавить обработку загрузки существующего файла

// Копируем файл из каталога для временного хранения файлов:
if (move_uploaded_file($_FILES['FILE']['tmp_name'], $uploadfile))
    echo "<h3>Файл успешно загружен на сервер</h3>";
else
    echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
