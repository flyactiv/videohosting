<?php

include_once './models/Page.php';
class SiteController
{
    public function actionIndex()
    {
        require_once(ROOT . '/views/index.php');
        return true;
    }


    public function actionDownload()
    {
        function HumanBytes($size)
        {
            $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
            return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
        }
        $sum = Page::checkDisk();
        $hranilishe = HumanBytes($sum);
        $svobod = explode(' ', $hranilishe);
        if ((trim($svobod[0])) == 0) {
            $svobod = 0;
        } else {
            if ($svobod[1] !== 'MB') {
                $svobod = 1;
            } else {
                $svobod = (real)trim($svobod[0]);
            }
        }
        if ($svobod > 200) {
            $errors[] = 'No storage space, contact developers!';
        } else {
            if (isset($_POST['submit'])) {
                $title = $_POST['title'];
                $date = $_POST['date'];
                $size = $_FILES['img_url']['size'];
                $url = $_POST['url'];
                $name = $_FILES['img_url']['name'];
                $tmp_name = $_FILES['img_url']['tmp_name'];

                // Флаг ошибок
                $errors = false;
                $true = false;
                $er_z = false;

                $inf = pathinfo($name);
                if (!$date) { $er_z[] = 'Select data'; }
                if (!$url) {
                    $er_z[] = 'Enter the title of the news manually as auto url cannot be generated';
                }
                if ($er_z == false) {
                    $rash = $inf['extension'];
                    if (Page::checkNameFile($url, $rash)) {
                        if ($rash === 'pdf') {
                            $true[] = 'File format PDF';
                            $errors = true;
                        }

                        if ($rash === 'mp4') {
                            $true[] = 'File format MP4';
                            $errors = true;
                        }

                        if ($errors == true) {
                            Page::downloadFile($url, $tmp_name, $rash);
                            $result = Page::add_news($title, $date, $url, $rash, $size);
                            if ($result == true) {
                                $true[] = 'File upload.';
                                require_once(ROOT . './views/index.php');
                            } else {
                                $errors = [];
                                $errors[] = 'loading error!';
                            }

                        } else {
                            $errors[] = 'Downloadable files can be in * .MP4 format';
                        }
                    } else {
                        $errors[] = 'Such a file already exists in the repository, change the File Header, and reselect the file';
                    }
                }
            }
        }

        require_once(ROOT . '/views/download_file.php');
        return true;
    }

    public function actionAllFiles() {
        $files = Page::getFiles();
        require_once(ROOT . '/views/login.php');
        return true;
    }


}
?>