<?php 
// Подключение модулей.
include_once('startup.php');
include_once('model.php');

// Подготовка.
startup(); // соединение с базой

echo $id = $_GET['id']; 
get_photo ($id);
//echo "<img src =# $_GET['id']>";
?>
