<?php require 'blocks/head.php' ?>

<?php require 'blocks/header.php' ?>
<script>
    function CopyTxt() {
        function strtr(str, repl) {
            for (var i = 0; i < str.length; i++) {
                var f = str.charAt(i),
                   r = repl[f];
                if (r) {
                    str = str.replace(new RegExp(f, 'g'), r);
                }
            }
            return str;
        }

        var trans = {
            'А':'A', 'Б':'B', 'В':'V', 'Г':'G', 'Д':'D', 'Е':'E', 'Ё':'E', 'Ж':'Gh', 'З':'Z', 'И':'I', 'Й':'Y', 'К':'K', 'Л':'L', 'М':'M', 'Н':'N', 'О':'O', 'П':'P', 'Р':'R', 'С':'S', 'Т':'T', 'У':'U', 'Ф':'F', 'Х':'H', 'Ц':'C', 'Ч':'Ch', 'Ш':'Sh', 'Щ':'Sch', 'Ъ':'Y', 'Ы':'Y', 'Ь':'Y', 'Э':'E', 'Ю':'Yu', 'Я':'Ya', 'а':'a', 'б':'b', 'в':'v', 'г':'g', 'д':'d', 'е':'e', 'ё':'e', 'ж':'gh', 'з':'z', 'и':'i', 'й':'y', 'к':'k', 'л':'l', 'м':'m', 'н':'n', 'о':'o', 'п':'p', 'р':'r', 'с':'s', 'т':'t', 'у':'u', 'ф':'f', 'х':'h', 'ц':'c', 'ч':'ch', 'ш':'sh', 'щ':'sch', 'ъ':'y', 'ы':'y', 'ь':'y', 'э':'e', 'ю':'yu', 'я':'ya', ' ':'_'
        };

        var txt = strtr(document.getElementById('id1').value, trans);
        document.getElementById('id2').value = txt;
    }
</script>





<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h4>Upload your video</h4>
            <br/>


            Allowed file formats: <b>*.MP4</b>
            <br><br>
            <?php if (isset($er_z) && is_array($er_z)): ?>
                <div style="padding:20px 20px 20px 20px; margin: 20px; background:#f1f1f1;">
                    <ul style="color:red; width:100%;">
                        <?php foreach ($er_z as $er_z): ?>
                            <li style="line-height: 27px;"> - <?php echo $er_z; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (isset($errors) && is_array($errors)): ?>
                <div style="padding:20px 20px 20px 20px; margin: 20px; background:#f1f1f1;">
                    <ul style="color:red; width:100%;">
                        <?php foreach ($errors as $error): ?>
                            <li style="line-height: 27px;"> - <?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (isset($true) && is_array($true)): ?>
                <div style="padding:20px 20px 20px 20px; margin: 20px; background:#f1f1f1;">
                    <ul style="color:green; width:100%;">
                        <?php foreach ($true as $true): ?>
                            <li style="line-height: 27px;"> - <?php echo $true; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="post" action="" class=" " enctype="multipart/form-data" style="width:100%; ">
                <table class="admin_table">
                    <tr>
                        <td>Title *</td>
                        <td><input id="id1" class=" mt-2 form-control" onkeyup="CopyTxt()" type="text" name="title"  value="<?=$_POST['title']?>"></td>
                    </tr>
                    <tr>
                        <td>Data*</td>
                        <td><input type="date" class=" mt-2 form-control" name="date" size="10" value="<?=$_POST['date']?>"></td>
                    </tr>
                    <tr>
                        <td>Select File*</td>
                        <td><input name="img_url" class="mt-2 form-control" type="file" /></td>
                    </tr>
                    <tr>
                        <td>Auto Url*</td>
                        <td><input id="id2" type="text" class="mt-2 form-control" name="url"  value="<?=$_POST['url']?>" style="background: #ececec; color:#777;"></td>
                    </tr>
                </table>
                <input class=" mt-2 btn btn-success" type="submit" name="submit" value="Upload"><br><br><br><br>
            </form>
        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>




<?php require 'blocks/footer.php' ?>

