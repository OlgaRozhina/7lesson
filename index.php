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
                
                echo "Данные отправлены в таблицу";
                echo "<br>";
            }
            else {
                echo "ПОВТОРНО НЕ ОТПРАВЛЯЕМ!";
            }
            
            
//                если один из кейсов true , то загружаем фаил и выводи его в галерею в виде ссылки         
                  upload($_FILES['myfile']);// загрузка файла на сервер
            
            
        // получаем массив из базы данных из таблицы фото
            $allPhoto = get_data_from_db ();
            
          // запускаем полученные данные в цикл и выводим картинки в виде ссылок
            for ($i = 0;$i < count ($allPhoto); $i++){
               
                $id = $allPhoto[$i]['id_photo'];        
                $path = $allPhoto[$i]['photo_path'];
                         echo "<br>";
               echo "<a href = photo.php?id=$id><img src= $path width = 50px height = 50px></a>";  // здесь нужно помнить чтобы параметры ушли в $_GET <a href = photo.php?id=$id> нельзя делать пробелы после знака "?"
           }
            
                     }

        else {
            echo "Выберите файл для загрузки!";
                } 
          
        
        
        
        
        ?>


            <br>
            <br>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="myfile" />
                <input type="submit" value="Загрузить фаил!">
            </form>


    </body>

    </html>