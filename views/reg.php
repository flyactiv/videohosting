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
        <div class="col-md-8" style="display: block; width: 600px; margin: 0 auto; background: #eaedf8; padding: 20px; color:#555; text-align: center;">
            <form action="" method="post" class="form-login" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
                <h2><center>Registration</h2></center><br>
                <input class="form-control" type="text" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/><br><br>
                <input class="form-control" type="text" name="login" placeholder="login" value="<?php echo $login; ?>"/><br><br>
                <input class="form-control" type="password" name="password" placeholder="password" value="<?php echo $_POST['password']; ?>"/><br><br>
                <div class="os"></div>
                <input type="submit" name="submit" class="btn btn-success" style="width: 120px;" value="Registr" />

            </form>
        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>



<?php require 'blocks/footer.php' ?>