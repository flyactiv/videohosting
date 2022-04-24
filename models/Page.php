<?php

/**
 * Класс модели для работы с базой данных всего, что не связано с аккаунтами пользователей
 */
class Page{
    /**
     * Функция для проверки подключения к бд
     * @return mixed
     */
    public static function checkDisk(){
        $db = Db::getConnection();

        return $sum;
    }

    /**
     * Функциия для проверки существует ли файл в базе данных с таким именем
     * @param $url
     * @param $rash
     * @return bool
     */
    public static function checkNameFile($url, $rash){
        $filename = 'img/'.$url.'.'.$rash;
        if (file_exists($filename)) {
            return false; //"Файл $filename существует";
        } else {
            return true;//"Файл $filename несуществует";
        }

    }

    /**
     * Функция для заргрузки файлов в сервер
     * @param $name
     * @param $tmp_name
     * @param $rash
     * @return void
     */
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
            $uploaddir = 'D:Program\OpenServer\domains\videohost\views\files/';
            $uploadfile = $uploaddir . basename($name . '.' . $rash);
            if (move_uploaded_file($tmp_name, $uploadfile)) {
                $true[] = 'Downloads!';
            } else {
                $errors[] = 'loading error!';
            }
        }
    }

    /**
     * Функция для добавления видеороликов в базу данных
     * @param $uploadfile
     * @param $title
     * @param $url
     * @param $id_author
     * @return bool
     */
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

    /**
     * Функция для получения всех файлов из базы по id автора
     * @return array
     */
    public static function getFiles()
    {
        $db = Db::getConnection();
        $username = $_SESSION['user'];
        $result = $db->query("SELECT * FROM files WHERE id_author='{$username}' ORDER BY id DESC ");
        $files = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $files[$i]['id'] = $row['id'];
            $files[$i]['uploadfile'] = $row['uploadfile'];
            $files[$i]['title'] = $row['title'];
            $files[$i]['url'] = $row['url'];
            $files[$i]['id_author'] = $row['id_author'];
            $i++;
        }
        return $files;
    }


    /**
     * Функция для получения всех файлов
     * @return array
     */
    public static function getFilesIndex()
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM files ORDER BY id DESC ");
        $files = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $files[$i]['id'] = $row['id'];
            $files[$i]['uploadfile'] = $row['uploadfile'];
            $files[$i]['title'] = $row['title'];
            $files[$i]['url'] = $row['url'];
            $files[$i]['id_author'] = $row['id_author'];
            $i++;
        }
        return $files;
    }




}