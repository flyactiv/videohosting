<?php require 'blocks/head.php' ?>

<?php require 'blocks/header.php' ?>

<div style="color: red; font-size: 14px; padding: 20px; margin: 0 auto; display: block; width:400px;">
    <?php if (isset($errors) && is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <?php if (User::isGuest()): ?>
                <form action="" method="post" class="form-login" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
                    <center><h2>Авторизация</h2></center><br>
                    <input type="text" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/><br><br><br>
                    <input type="password" name="password" placeholder="Пароль" value="<?php echo $_POST['password']; ?>"/><br><br><br>
                    <div class="os"></div>
                    <input type="submit" name="submit" class="btn btn-default" style="width: 120px;" value="Вход" />
                    <div class="os"></div>
                    <div style="font-size: 14px; color: #777;">
                        Если вы еще по какой то причине не зарегистрированы на нашем сервисе, то не теряйте времени <a href="/register">зарегистрируйтесь</a>.
                    </div>
                </form>
            <?php else: ?>
                <div style="display: block; width: 400px; margin: 0 auto; background: #f2f1f0; padding: 20px; color:#555; text-align: center;">
                    <center><h2 style="color:#555;">Вы уже авторизированы </h2></center>
                </div>
            <?php endif; ?>
        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>