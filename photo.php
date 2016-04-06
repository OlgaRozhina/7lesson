<?php 
// Подключение модулей.
include_once('startup.php');
include_once('model.php');
session_start();
 
   
 echo "<br>";echo "<br>";echo "<br>";

if (isset($_GET['id'])) {
    

// Подготовка.
startup(); // соединение с базой
//  получаем  id
  $id = $_GET['id'];
//  выводим картинку на экран по id
get_photo ($id);
    
    //     выводим значение id картинки на экран
echo "<br>id картинки = ".$id."<br>";
    
  // получаем текущее значение views из бд  по id 
 $views = get_views ($id); 
    
    // увеличиваем его на 1
 $views +=1;  
    
    // и оправлем его новое значение в бд
update_views($id,$views);
}
else {
    echo "Error";
}



?>
