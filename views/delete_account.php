<?php require 'blocks/head.php' ?>

<?php require 'blocks/header.php' ?>


<main class="container mt-5">
    <div class="row">
        <div class="col-md-8" style="display: block; width: 600px; margin: 0 auto; background: #eaf1f5; padding: 20px; color:#555; text-align: center;">
            <form action="" method="post" class="form-login" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
                <input class="form-control" type="text" name="id" placeholder="id" value="<?php echo $id; ?>"/><br><br><br>
                <div class="os"></div>
                <input type="submit" name="submit" class="btn btn-success" style="width: 200px;" value="Delete Account" />
            </form>
        </div>

        <?php require 'blocks/aside.php' ?>
    </div>
</main>



<?php require 'blocks/footer.php' ?>
