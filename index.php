<?php

// Подключение модулей.
include_once('startup.php');
include_once('model.php');

function send_inform($photoName, $photoSize,$photoPath )
{
	$connect = $_SESSION['mysql_connect'];
	      	
 $sql = "INSERT INTO photo ( photo_name, photo_size, photo_path) 
			VALUES ( '$photoName', '$photoSize', '$photoPath')";
		   
 $result = mysqli_query($connect, $sql);
									
	if (!$result)
		die(mysqli_error($connect));		   
}


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
                        upload($_FILES['myfile']);
                          $fileName = $_FILES['myfile']['name'];//  имя файла   с расширением
                          $path = 'img/'.$fileName;//  путь к картинке, которую будем уменьшать
                          $width = 50; // ширина копии картинки
                          $height = 50;// высота копии картинки 
                          $save ="img/copy/copy"."$fileName"; // путь, в котором будет лежать копия картинки
                          create_thumbnail($path, $save, $width, $height);
            
            
            $connect = $_SESSION['mysql_connect'];
            $photoName = $_FILES['myfile']['name'];//  имя файла с расширением  
            $photoSize =$_FILES['myfile']['size']; //  размер файла
            $photoPath = 'img/'.$fileName;//  путь к картинке
            
            send_inform($photoName, $photoSize,$photoPath );

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