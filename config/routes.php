<?php
/*** Массив роутов для маршрутизации на сайте */

return array(
    'user/delete_account' => 'user/delete',
    'user/reset_password' => 'user/reset',
    'download' => 'site/download',
    'user/reg' => 'user/reg',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'contacts' => 'site/contacts',

    '' => 'site/index', // actionIndex в SiteController



);
?>
