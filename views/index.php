<?php require 'blocks/head.php' ?>

<?php require 'blocks/header.php' ?>
<main class="container mt-5">
    <div class="row">
        <div class="col-md-8" style="display: block; width: 600px; margin: 0 auto; background: #eaedf8; padding: 20px; color:#555; text-align: center; align-content: center;">
            <h2>Hello, this is Video Hosting site</h2>
            <hr />
            <h5>Here you can watch other people's videos or upload yours.</h5><br><br>
            <div>

                <div class="fotorama">
                    <? include_once './models/Page.php';
                    $files = Page::getFiles();
                    foreach ($files as $files): ?>
                    <video class="rounded" width="100%" height="340" controls="controls" poster="https://activation-keys.ru/wp-content/uploads/2019/03/fcb710093aa005a868c24a7048d2a18d.jpg">
                        <source src="../views/files/<? echo $files['url'];?>.mp4" type="video/mp4" codecs="avc1.42E01E, mp4a.40.2">
                    </video>
                    <? endforeach; ?>
                </div>

            </div>
        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>





<?php require 'blocks/footer.php' ?>