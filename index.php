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
                        
               // если один из кейсов true , то загружаем фаил и выводи его в галерею в виде ссылки         
                         upload($_FILES['myfile']);// загрузка файла на сервер
            
            
            
                          $fileName = $_FILES['myfile']['name'];//  имя загруженного файла   с расширением
            
                          $path = 'img/'.$fileName;//  путь к картинке, которую будем уменьшать
                          $width = 50; // ширина копии картинки
                          $height = 50;// высота копии картинки 
                          $save ="img/copy/copy"."$fileName"; // путь, в котором будет лежать копия картинки
            
                       create_thumbnail($path, $save, $width, $height);// создаем уменьшенную картинку
            
            
            // подготовка переменных для загрузки файла на сервер
            $photoName = $_FILES['myfile']['name'];//  имя файла с расширением  
            $photoSize =$_FILES['myfile']['size']; //  размер файла
            $photoPath = 'img/'.$fileName;//  путь к картинке
//            $id =1;// разобраться как его увеличивать
         
//            send_inform($id, $photoName, $photoSize,$photoPath ); // отпраляем информацию о загруженном файле в базу данных
            
              send_inform( $photoName, $photoSize,$photoPath ); // отпраляем информацию о загруженном файле в базу данных  
            
//            function get_id ($photoPath){
      var_export($photoPath) ; 
       echo "<br>";
      
    
    $connect = $_SESSION['mysql_connect']; 
    $sql ="SELECT id_photo FROM photo WHERE photo_path ='". $photoPath."' ;";//так выглядит запрос в базе данных
   
    $result = mysqli_query($connect, $sql);
        
	while($row = mysqli_fetch_assoc($result)) // mysqli_fetch_assoc($result) извлекает очередную строку из выборки данных и возвращает ее в пременную $row
		$id  = $row;
        echo "<br>";
       var_export ($id);
            echo "<br>";
       echo $id['id_photo'];
            
// строки ниже нужны для понимания что содержится в $photo
// var_export($photo);// содержит: array ( 'photo_path' => 'img/sport.jpg', )
// var_export($photo[ 'photo_path']);// содержит:'img/sport.jpg'
//}
            

                     $dir = scandir ('img/copy/');
                    unset($dir[0]); // .
		            unset($dir[1]); // ..
                    
                    foreach ($dir as $d){
                        if($d == '__DS.Store')
			             continue; 
//                        echo $d;
                        echo "<br>";
                        $save = "img/copy/".$d;// переопределяем $save
                        add_img($path, $save );
                                              
                        
                     }
        }
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