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
            if (!User::checkPassword($pass)) $errors[] = 'You have not entered a password, the password is less than 6 characters';
            if (!User::checkName($login)) $errors[] = 'Login less than 3 characters';
            if (!User::checkEmail($email)) $errors[] = 'E-mail is not correct';
            else
            {
                // Проверяем существует ли пользователь
                $checkEmail = User::checkUserEmail($email);
                $checkLogin = User::checkUserLogin($login);
                if ($checkLogin == true) $errors[] = 'A user with this Login is already registered, enter a different Login';
                if ($checkEmail == true) $errors[] = 'A user with this E-mail is already registered, enter another E-mail';
                else
                {
                    $hashed_pass = (new User)->generateHash($pass); // Сохраняем Хеш пароля
                    require_once(ROOT . '/views/index.php');
                    if (!User::register($login, $email, $hashed_pass)) $errors[] = 'Database Error';
                }
            }
        }
        // Подключаем вид
        require_once(ROOT . '/views/reg.php');
        return true;
    }



    public function actionLogin()
    {
        $email = false;
        $pass = false;
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $errors = false;
            $errors[] = 'Invalid email';
        }
        if (!User::checkPassword($pass)) {
            $errors[] = 'Password must not be shorter than 6 characters';
        }
        $check = User::checkUserDataHash($email);
        $hashed_pass = $check['pass'];
        $userId = $check['id'];
        if ($this->verify($pass, $hashed_pass)) {
            User::auth($userId);
            require_once(ROOT . '/views/index.php');
            return true;
        } else $errors[] = 'Incorrect login details';
        require_once(ROOT . '/views/login.php');
        return true;
    }

    public function actionLogout()
    {
        unset($_SESSION["user"]);
        session_destroy();
        header("Location: /");
        return true;

    }

    function verify($pass, $hashedPass) {
        return crypt($pass, $hashedPass) == $hashedPass;
    }

}