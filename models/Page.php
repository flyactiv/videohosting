<?php


class Page{
    public static function checkDisk(){
        $db = Db::getConnection();

        return $sum;
    }

    public static function checkNameFile($url, $rash){
        $filename = 'img/'.$url.'.'.$rash;
        if (file_exists($filename)) {
            return false; //"Файл $filename существует";
        } else {
            return true;//"Файл $filename несуществует";
        }

    }

    public static function downloadFile($name, $tmp_name, $rash)
    {
        if ($rash == 'zip') {
            // Имя файла
            $filename = $tmp_name;
// Разбиваем файл на части по 10 Kb
            $piece = 250000;
// Открываем исходный файл для чтения
            $fp = fopen($filename, "r");
// Читаем содержимое файла в буфер
            $bufer = fread($fp, filesize($filename));
// Закрываем файл
            fclose($fp);
// Подсчитываем число частей, на которые необходимо разбить файл
            $count = (int)filesize($filename)/$piece;
            if((float)(filesize($filename)/$piece) - $count != 0) $count++;
// В цикле разбиваем содержимое файла в переменной
// $bufer на части
            for($i=0; $i<$count; ++$i)
            {
                $part = substr($bufer,$i*$piece,$piece);
// Сохраняем текущую часть в отдельном файле
                $fp = fopen("part/big_file.part".$i,"w");
                fwrite($fp,$part);
                fclose($fp);
            }
            $buffer = "";
            for($i=0; $i<$count; ++$i)
            {
                // Генерируем имя файла
                $filename = "part/big_file.part".$i;
                // Если такой файл существует,
                // добавляем его содержимое к $buffer
                if(file_exists($filename))
                {
                    $fp = fopen($filename,"r");
                    $buffer .= fread($fp,filesize($filename));
                    fclose($fp);
                }
                else
                {
                    // Если файла с таким именем не
                    // существует, выходим из цикла
                    break;
                }
                // Склеенные в переменной $bufer
                // части помещаем в конечный файл

                $fp = fopen('files/'.$name.'.'.$rash,"w");
                fwrite($fp, $buffer);
                fclose($fp);
                unlink($filename);
            }

        } else {
            $uploaddir = 'A:\openserver\OpenServer\domains\videohost\views\files/';
            $uploadfile = $uploaddir . basename($name . '.' . $rash);
            if (move_uploaded_file($tmp_name, $uploadfile)) {
                $true[] = 'Downloads!';
            } else {
                $errors[] = 'loading error!';
            }
        }
    }

    public static function add_news($uploadfile, $title, $url, $id_author)
    {

        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'INSERT INTO files (uploadfile, title, url, id_author) VALUES (:uploadfile, :title, :url, :id_author)';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':uploadfile', $uploadfile, PDO::PARAM_STR);
        $result->bindParam(':title', $title, PDO::PARAM_STR);

        $result->bindParam(':url', $url, PDO::PARAM_STR);
        $result->bindParam(':id_author', $_SESSION['user'], PDO::PARAM_STR);

        return $result->execute();
    }
}