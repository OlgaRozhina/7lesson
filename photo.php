<?php 
// Подключение модулей.
include_once('startup.php');
include_once('model.php');

// Подготовка.
startup(); // соединение с базой
//  получаем  id
$id = $_GET['id'];
//  выводим картинку на экран по id
get_photo ($id);

?>
