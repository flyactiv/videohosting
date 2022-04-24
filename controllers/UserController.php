<?php


include_once './models/User.php';

/**
 * Класс контроллер всех действий связанных с аккаунтами пользователей
 */
class UserController{
    /**
     * Функция для регистрации пользователей и вывода формы регистрации
     * @return bool
     */
    public function actionReg()
    {
        // Объявим переменые, чтобы не возникало ошибок
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
                    header("Location: /");
                    if (!User::register($login, $email, $hashed_pass)) $errors[] = 'Database Error';
                }
            }
        }
        // Подключаем вид
        require_once(ROOT . '/views/reg.php');
        return true;
    }


    /**
     * Функция для входа в аккаунт и вывода формы входа
     * @return bool
     */
    public function actionLogin()
    {
        $email = false;
        $pass = false;
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $errors = false;
            $errors[] = 'Invalid email';
            if (!User::checkPassword($pass)) {
                $errors[] = 'Password must not be shorter than 6 characters';
            }
            $check = User::checkUserDataHash($email);
            $hashed_pass = $check['pass'];
            $userId = $check['id'];
            if ($this->verify($pass, $hashed_pass)) {
                User::auth($userId);
                header("Location: /user/login");
                return true;
            } else $errors[] = 'Incorrect login details';
        }

        require_once(ROOT . '/views/login.php');
        return true;
    }

    /**
     * Функция выхода из аккаунта
     * @return bool
     */
    public function actionLogout()
    {
        unset($_SESSION["user"]);
        session_destroy();
        header("Location: /");
        return true;

    }

    /**
     * Функция для проверки хеширования пароля
     * @param $pass
     * @param $hashedPass
     * @return bool
     */
    function verify($pass, $hashedPass) {
        return crypt($pass, $hashedPass) == $hashedPass;
    }


    /**
     * Функция для восстановления пароля
     * @return bool
     */
    public function actionReset()
    {
        $index['title'] = 'Восстановление пароля';
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $email_send = $email;
            if (!User::checkEmail($email)) echo 'Неверно указан E-mail' . '<br>';
            else {
                $result = User::checkUserEmail($email);
                if ($result == true) {
                    $check = User::checkUserDataHash($email);
                    $id_user = $check['id'];
                    $pass = User::generate_password();
                    $hash_password = (new User)->generateHash($pass);
                    User::editPassword($id_user, $hash_password);
                    if (User::sendEmailPassword($email_send, $pass)) {
                        // Подключаем вид
                        require_once(ROOT . '/views/reset_password_ok.php');
                        return true;
                    } else $errors[] = 'Ошибка почтового клиента';
                } else $errors[] = 'Пользователя с таким E-mail не существует';
            }
        }
        // Подключаем вид
        require_once(ROOT . '/views/reset_password.php');
        return true;
    }

    /**
     * Функция для удаления аккаунта пользователя
     * @return bool
     */
    public function actionDelete()
    {

        if (isset($_POST['submit']))
        {
            $id = $_POST['id'];
            User::deleteAccount($id);
            header("Location: /user/reg");
        }
        require_once(ROOT . '/views/delete_account.php');
        return true;
    }

}