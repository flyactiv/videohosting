<?php


include_once './models/User.php';
class UserController{
    public function actionReg()
    {
        // Объявим переменые, что не возникало ошибок
        $login = false;
        $email = false;
        $pass = false;
        // Обработка формы
        if (isset($_POST['submit']))
        {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            if (!User::checkPassword($pass)) $errors[] = 'Вы не ввели пароль, пароль меньше 6-х символов';
            if (!User::checkName($login)) $errors[] = 'Логин меньше 3-х символов';
            if (!User::checkEmail($email)) $errors[] = 'Не верно указан E-mail';
            else
            {
                // Проверяем существует ли пользователь
                $checkEmail = User::checkUserEmail($email);
                $checkLogin = User::checkUserLogin($login);
                if ($checkLogin == true) $errors[] = 'Пользователь с таким Логином, уже зарегистрирован, введите другой Логин';
                if ($checkEmail == true) $errors[] = 'Пользователь с таким E-mail, уже зарегистрирован, введите другой E-mail';
                else
                {
                    $hashed_pass = (new User)->generateHash($pass); // Сохраняем Хеш пароля
                    if (!User::register($login, $email, $hashed_pass)) $errors[] = 'Ошибка Базы Данных';
                }
            }
        }
        // Подключаем вид
        require_once(ROOT . '/views/reg.php');
        return true;
    }
}