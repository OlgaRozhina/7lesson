<?php

// Подключение модулей.
include_once('startup.php');
include_once('model.php');

// Подготовка.
startup();
?>

 <!DOCTYPE html>
    <html>

    <head>
        <title>Gallery</title>
        <meta charset="utf-8">
    </head>

    <body>
                

        <?php 
         
                 
        if(isset($_FILES['myfile'])) {
            
//            var_export($_FILES['myfile']);// просто выводим содержимое на экран
            
           $fileName = $_FILES['myfile']['name'];//  имя загруженного файла   с расширением
            
            $path = 'img/'.$fileName;//  путь к картинке, которую будем уменьшать
            
            if (!file_exists ($path)){
            // подготовка переменных для загрузки файла на сервер
            $photoName = $_FILES['myfile']['name'];//  имя файла с расширением  
            $photoSize =$_FILES['myfile']['size']; //  размер файла
            $photoPath = 'img/'.$_FILES['myfile']['name'];//  путь к картинке

                send_inform( $photoName, $photoSize,$photoPath ); // отпраляем информацию о загруженном файле в базу данных 
                
                echo "данные отправлены в таблицу";
                echo "<br>";
            }
            else {
                echo "ПОВТОРНО НЕ ОТПРАВИЛ!";
            }
            
            
//                если один из кейсов true , то загружаем фаил и выводи его в галерею в виде ссылки         
                  upload($_FILES['myfile']);// загрузка файла на сервер
            
            
             // получаем массив из базы данных из таблицы фото
    $connect = $_SESSION['mysql_connect']; 
    $sql ="SELECT * FROM photo;";//так выглядит запрос в базе данных
    $result = mysqli_query($connect, $sql);
            
    $allPhoto = array (); // по просто пустой массив 
            
    if (!$result)
		die(mysqli_error($connect));

	while($row = mysqli_fetch_assoc($result)) // mysqli_fetch_assoc($result) извлекает очередную строку из выборки данных и возвращает ее в пременную $row
		$allPhoto[]  = $row;
            //  данный код нужен чтобы видеть что находится в массиве
//            echo "<pre>";
//            var_export ($allPhoto);    
//            echo "</pre>";
           
            
           for ($i = 0;$i < count ($allPhoto); $i++){
               
                $id = $allPhoto[$i]['id_photo'];        
                $path = $allPhoto[$i]['photo_path'];
                         echo "<br>";
               echo "<a href = photo.php?id=$id><img src= $path width = 50px height = 50px></a>";
           }
            
            
            
            
            
            
//        $path = $photo['photo_path'];
//        echo '<img src='.$path.'>';
// строки ниже нужны для понимания что содержится в $photo
// var_export($photo);// содержит: array ( 'photo_path' => 'img/sport.jpg', )
// var_export($photo[ 'photo_path']);// содержит:'img/sport.jpg'
            
            
            
            
            
            
            
            
            
            
            
//             // выводи массив картинок
//                     $dir = scandir ('img/');
//                    unset($dir[0]); // .
//		            unset($dir[1]); // ..
//                    foreach ($dir as $d){
//                        if($d == '__DS.Store')
//			             continue; 
//                        echo $d; // содержит имя фаила с расширением например pic1.png
//                        echo "<br>";              
//                      echo '<a href='.$path.'>'.'<img src=img/'.$d.' width = 50px height = 50px >'.'</a>';                   
                     }
//        }
        else {
            echo "Выберите файл для загрузки!";
                } 
          
        
        
        
        
        ?>
        
        
         <br><br>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="myfile" />
                <input type="submit" value="Загрузить фаил!">
            </form>


    </body>

    </html>