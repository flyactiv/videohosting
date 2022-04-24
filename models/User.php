<?php

/**
 * Класс модели базы данных для работы со всем, что связано с аккаунтами пользователей
 */
class User{

    /**
     * Функция для создания хешированного пароля
     * @param $pass
     * @return string|void|null
     */
    function generateHash($pass) {
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($pass, $salt);
        }
    }

    /**
     * Функция для проверки на валидность введенного имени
     * @param $name
     * @return bool
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) return true;
        else return false;
    }

    /**
     * Функция проверки на валидность  введенного пароля
     * @param $pass
     * @return bool
     */
    public static function checkPassword($pass)
    {
        if (strlen($pass) >= 4) return true;
        else return false;
    }

    /**
     * Функция для проверки на валидность введенного емейла
     * @param $email
     * @return bool
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
        else return false;
    }


    /**
     * Функция проверки на существование введенного емейла
     * @param $email
     * @return bool
     */
    public static function checkUserEmail($email)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM users WHERE email = :email';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();
        if ($user) return true;
        else return false;
    }


    /**
     * Функция проверки на существования введенного логина
     * @param $login
     * @return bool
     */
    public static function checkUserLogin($login)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM users WHERE login = :login';
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();
        if ($user) return true;
        else return false;
    }


    /**
     * Функция внесения данных регистрации в базу данных
     * @param $login
     * @param $email
     * @param $pass
     * @return bool
     */
    public static function register($login, $email, $pass)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO users (login, email, pass) VALUES (:login, :email, :pass)';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':pass', $pass, PDO::PARAM_STR);
        return $result->execute();
    }


    /**
     * Функция проверки на существование емейла
     * @param $email
     * @return mixed
     */
    public static function checkUserDataHash($email)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'SELECT * FROM users WHERE email = :email';
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    /**
     * Функция сохранения айди пользователя
     * @param $userId
     * @return void
     */
    public static function auth($userId)
    {
        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;
    }


    /**
     * Функция проверки на то, авторизован ли пользователь
     * @return bool
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) return false;
        else return true;
    }


    /**
     * Функция генерации пароля
     * @param $number
     * @return string
     */
    public static function generate_password($number = 6)
    {
        $arr = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0');
        // Генерируем пароль
        $password = "";
        for($i = 0; $i < $number; $i++)
        {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($arr) - 1);
            $password .= $arr[$index];
        }
        return $password;
    }


    /**
     * Функция изменения пароля и внесения в базу данных нового
     * @param $id_user
     * @param $hash_password
     * @return bool
     */
    public static function editPassword($id_user, $hash_password)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "UPDATE users SET pass = :pass WHERE id = :id";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id_user, PDO::PARAM_INT);
        $result->bindParam(':pass', $hash_password, PDO::PARAM_STR);
        return $result->execute();
    }


    /**
     * Функция отправки пароля по почте (не работает)
     * @param $email
     * @param $password
     * @return bool
     */
    public static function sendEmailPassword($email,$password)
    {
        $fromMail = 'alexa.stoyanova@yandex.ru';
        $fromName = 'Alexa';
        $emailTo = $email;
        $subject = 'Восстановление пароля ';
        $subject = '=?utf-8?b?'. base64_encode($subject) .'?=';
        $headers = "Content-type: text/plain; charset=\"utf-8\"\r\n";
        $headers .= "From: ". $fromName ." <". $fromMail ."> \r\n";
        $body = "Ваш новый пароль был сгенерирован автоматически, настоятельно рекомендуем изменить его\n
               E-mail: $email\n
               Пароль: $password\n";
        $mail = mail($emailTo, $subject, $body, $headers, '-f'. $fromMail );
        if ($mail) return true;
        else return false;
    }


    /**
     * Функция удаления аккаунта пользователя из базы данных
     * @param $id
     * @return bool
     */
    public static function deleteAccount($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM users WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

}