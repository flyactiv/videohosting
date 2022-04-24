<div class="d-flex flex-column flex-md-row align-items-center p-2 pb-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <img class="me-4" src="../views/img/icon.png" alt="" width="120" height="45">
        <span class="fs-4">Video for everyone</span>
    </a>

    <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
        <a class="me-3 py-2 text-dark text-decoration-none" href="/">Index</a>
        <a class="me-3 py-2 text-dark text-decoration-none" href="/contacts">Contacts</a>
    </nav>
    <?php
        if ($_COOKIE['log'] == ''):
    ?>
    <a class="btn btn-outline-primary me-2" href="/user/reg">Sign up</a>
    <a class="btn btn-outline-primary me-2" href="/user/login">Sign in</a>
    <?php
        else:
    ?>
    <a class="btn btn-outline-primary me-2" href="/user/logout">User account</a>
    <?php
        endif;
    ?>
</div>