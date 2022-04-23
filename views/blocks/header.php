<div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <img class="me-4" src="https://img2.freepng.ru/20180324/gqe/kisspng-computer-icons-video-cameras-video-production-film-youtube-5ab71af41fd418.5407590815219494281304.jpg" alt="" width="40" height="40">
        <span class="fs-4">VideoHosting</span>
    </a>

    <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
        <a class="me-3 py-2 text-dark text-decoration-none" href="/">Index</a>
        <a class="me-3 py-2 text-dark text-decoration-none" href="#">Enterprise</a>
        <a class="me-3 py-2 text-dark text-decoration-none" href="#">Support</a>
        <a class="py-2 text-dark text-decoration-none me-3" href="#">Pricing</a>
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