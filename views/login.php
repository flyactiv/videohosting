<?php require 'blocks/head.php' ?>

<?php require 'blocks/header.php' ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8" style="display: block; width: 600px; margin: 0 auto; background: #eaf1f5; padding: 20px; color:#555; text-align: center; align-content: center;">
            <?php if (User::isGuest()): ?>
                <form action="" method="post" class="form-login" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
                    <center><h2>Authorization</h2></center><br>
                    <input class="form-control" type="text" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/><br><br><br>
                    <input class="form-control" type="password" name="password" placeholder="password" value="<?php echo $_POST['password']; ?>"/><br><br><br>
                    <div class="os"></div>
                    <input type="submit" name="submit" class="btn btn-success" style="width: 120px;" value="GO" />
                    <div class="os"></div>
                    <div style="font-size: 14px; color: #777;">
                        If for some reason you are not registered on our service, then do not waste time <a href="/user/reg">sign up</a>.
                    </div>
                </form>
                <div style="color: red; font-size: 14px; padding: 20px; margin: 0 auto;  width:400px;">
                    <?php if (isset($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li> - <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div style="display: block; width: 600px; margin: 0 auto; padding: 20px; color:#555; text-align: center;">

                    <center><h2 style="color:#555;"> You are already logged in </h2></center>
                    <br> <br>
                    <input type="button" value="Upload Files" class="btn btn-success" onClick='location.href="/download"'>
                     <br> <br>
                    <input type="button" value="Exit" class="btn btn-danger" onClick='location.href="/user/logout"'>
                    <br> <br>
                    <input type="button" value="Reset Password" class="btn btn-success" onClick='location.href="/user/reset_password"'>
                    <br> <br>




                    <br><br><br><h1>ALL YOUR VIDEOS</h1><br>
                    <table>
                        <? include_once './models/Page.php';
                        $files = Page::getFiles();
                        foreach ($files as $files): ?>
                        <div >
                            <tr>
                                <td>
                                    <br>
                                    <h2><? echo $files['uploadfile']; ?></h2> <br>
                                    <p>Дата публикации: <? echo $files['title']; ?></p><br>
                                    <video width="450" height="300" controls="controls" poster="https://activation-keys.ru/wp-content/uploads/2019/03/fcb710093aa005a868c24a7048d2a18d.jpg">

                                        <source src="../views/files/<? echo $files['url'];?>.mp4" type="video/mp4" codecs="avc1.42E01E, mp4a.40.2">

                                    </video>

                                    <br>

                                </td>
                            </tr>
                        </div>
                        <? endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>