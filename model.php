<?php

// подключаем связь с базой
include_once('startup.php');
// Подготовка.
startup();

function upload($myfile){
            
        if(is_uploaded_file($myfile["tmp_name"])) // Проверяем загружен ли файл
             {
            // Если файл загружен успешно, перемещаем его из временной директории в конечную
             move_uploaded_file($myfile["tmp_name"], "img/".$myfile["name"]);
             echo 'Фаил успешно загружен'.'<br>';                 
                           }               
        else {
               echo("Ошибка загрузки файла");
                           }
}


function add_img($path, $save ){
    $path= 'photo.php';
//    echo '<a href='.$path.'>'.'<img src='.$save.'>'.'</a>';//  выводим картинку на экран в виде ссылки
   echo '<a href='.$path.'>'.'<img src='.$save.'>'.'</a>';//  делаем ссылку на photo.php
     
}

function create_thumbnail($path, $save, $width, $height) {
	$info = getimagesize($path); //получаем размеры картинки и ее тип
	$size = array($info[0], $info[1]); //закидываем размеры в массив

        //В зависимости от расширения картинки вызываем соответствующую функцию
	if ($info['mime'] == 'image/png') {
		$src = imagecreatefrompng($path); //создаём новое изображение из файла
	} else if ($info['mime'] == 'image/jpeg') {
		$src = imagecreatefromjpeg($path);
	} else if ($info['mime'] == 'image/gif') {
 		$src = imagecreatefromgif($path);
	} else {
		return false;
	}

	$thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
	$src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
	$thumb_aspect = $width / $height; //отношение ширины к высоте аватарки

	if($src_aspect < $thumb_aspect) { 		//узкий вариант (фиксированная ширина) 		$scale = $width / $size[0]; 		$new_size = array($width, $width / $src_aspect); 		$src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); //Ищем расстояние по высоте от края картинки до начала картины после обрезки 	} else if ($src_aspect > $thumb_aspect) {
		//широкий вариант (фиксированная высота)
		$scale = $height / $size[1];
		$new_size = array($height * $src_aspect, $height);
		$src_pos = array(($size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
	} else {
		//другое
		$new_size = array($width, $height);
		$src_pos = array(0,0);
	}

	$new_size[0] = max($new_size[0], 1);
	$new_size[1] = max($new_size[1], 1);

	imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);
	//Копирование и изменение размера изображения с ресемплированием

	if($save === false) {
		return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
	} else {
		return imagepng($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
	}

}

function send_inform( $photoName, $photoSize,$photoPath )
{
	$connect = $_SESSION['mysql_connect'];
    
	      	
 $sql = "INSERT INTO photo ( photo_name, photo_size, photo_path) 
			VALUES ( '$photoName', '$photoSize', '$photoPath')";
		   
 $result = mysqli_query($connect, $sql);
									
	if (!$result)
		die(mysqli_error($connect));		   
}

function get_photo ($id){
    
    $connect = $_SESSION['mysql_connect']; 
    $sql ="SELECT photo_path FROM photo WHERE id_photo = $id ;";//так выглядит запрос в базе данных
    $result = mysqli_query($connect, $sql);
        
    if (!$result)
		die(mysqli_error($connect));

	while($row = mysqli_fetch_assoc($result)) // mysqli_fetch_assoc($result) извлекает очередную строку из выборки данных и возвращает ее в пременную $row
		$photo  = $row;
    
        $path = $photo['photo_path'];
        echo '<img src='.$path.'>';
// строки ниже нужны для понимания что содержится в $photo
// var_export($photo);// содержит: array ( 'photo_path' => 'img/sport.jpg', )
// var_export($photo[ 'photo_path']);// содержит:'img/sport.jpg'
}

//function get_data_from_db () {
//    $connect = $_SESSION['mysql_connect']; 
//    $sql ="SELECT * FROM photo;";//так выглядит запрос в базе данных
//    $result = mysqli_query($connect, $sql);
//            
//    $allPhoto = array (); // по просто пустой массив 
//            
//    if (!$result)
//		die(mysqli_error($connect));
//
//	while($row = mysqli_fetch_assoc($result)) // mysqli_fetch_assoc($result) извлекает очередную строку из выборки данных и возвращает ее в пременную $row
//		$allPhoto[]  = $row;
//        
//        return $allPhoto;
//            //  данный код нужен чтобы видеть что находится в массиве
////            echo "<pre>";
////            var_export ($allPhoto);    
////            echo "</pre>";
//           }

function update_views($id, $views){
	$connect = $_SESSION['mysql_connect'];
	
	$sql = "UPDATE photo SET views = " . (int)$views . " WHERE id_photo = " . (int)$id; 
	
	mysqli_query($connect, $sql);
     echo "данные обнавлены в бд ";  
        
    }



function get_views($id){
     
    $connect = $_SESSION['mysql_connect']; 
    $sql ="SELECT views FROM photo WHERE id_photo = $id ;";//так выглядит запрос в базе данных
    $result = mysqli_query($connect, $sql);
        
    if (!$result)
		die(mysqli_error($connect));

	while($row = mysqli_fetch_assoc($result)) // mysqli_fetch_assoc($result) извлекает очередную строку из выборки данных и возвращает ее в пременную $row
		$photo  = $row;
    
        $views = $photo['views'];
        echo " текущее число просмотров = ".$views."<br>";
      return $views;
}

function get_data_from_db () {
    
    $connect = $_SESSION['mysql_connect']; 
    // сначала посылаем запрос на сортировку данных в бд по количеству просмотров views
    $sql="SELECT * FROM photo ORDER BY `views` DESC LIMIT 1000;";
//     mysqli_query($connect, $first_sql);  
    // птом отправлем запрос на получение таблицы
    
//    $sql ="SELECT * FROM photo;";//так выглядит запрос в базе данных
    $result = mysqli_query($connect, $sql);
         $allPhoto = array (); //  просто пустой массив 
            
    if (!$result)
		die(mysqli_error($connect));

	while($row = mysqli_fetch_assoc($result)) // mysqli_fetch_assoc($result) извлекает очередную строку из выборки данных и возвращает ее в пременную $row
		$allPhoto[]  = $row;
        
        return $allPhoto;
//              данный код нужен чтобы видеть что находится в массиве
            echo "<pre>";
            var_export ($allPhoto);    
            echo "</pre>";
           }



?>