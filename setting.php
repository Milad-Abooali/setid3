<?php
/**
 * NoDB MultiUser - File Base User Authentication
 *
 * NoDB MultiUser is a standalone MiniPM (Mini PHP Module).
 * Originally written by Milad Abooali for NoDB-MultiUser project in Codebox.
 *
 * @category   RUN/NODB-MULTIUSER
 * @package    CORE/RUN
 * @author     Milad Abooali <m.abooali@hotmail.com>
 * @author     CODEBOX <info@codebox.ir>
 * @copyright  2012-2019 codebox.ir
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    0.9 Beta - 5:16 PM 11/5/2018
 * @link       http://php.codebox.ir/nodb-multiuser
 * @see        Examples @ iniaut / Examples @ iniaut
 * ================================== START */
session_start();
$_SESSION['SHID']= md5(session_id());
$start_time = microtime(TRUE);
require_once('iniul.php');
require_once('iniaut.php');
$title="تنظیمات";
$setting = json_decode(file_get_contents('setting.json'), true);
?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="favicon.png" type="image/x-icon" />
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css">
    </head>
<body>
<div id="page">
    <div id="container">
    <div id="left">
        <?php include ('widget.php'); ?>
    </div>
    <div id="right">
                    <span>
                    <?= $title ?>
                    </span>
        <!-- <ul>
              <li><a class="active" href="#link1">link1</a></li>
              <li><a href="#link2">link2</a></li>
          </ul> -->
        <div id="content">
            <?php if (!$_SESSION['USER']): ?>
                <form>
                    نام کاربری:<br>
                    <input type="text" id="f-user" placeholder="username"><br>
                    رمز عبور:<br>
                    <input type="password" id="f-pass" placeholder="password">
                    <br>
                    <span class="b-login button">ورود به حساب کاربری</span>
                </form>
            <?php else: ?>
            <div class="setting">
                <form id="settingf">
                    <table>
                        <tr>
 <td colspan="2"><strong>تنظیمات سیستم</strong></td>
                     </tr>
                        <tr><td><span>مسیر موقت فایل:</span><br><input type='text' name='tmp_path' placeholder='Temp Path'value="<?= $setting['tmp_path'] ?>"></td><td><span>پوشه اصلی فایل ها:</span><br><input type='text' name='files_folder' placeholder='Files Folder'value="<?= $setting['files_folder'] ?>"></td>
                        </tr>
                        <tr>
 <td colspan="2"><strong>تگ های پیش فرض</strong></td>
                        </tr>
                        <tr><td><span>نام فایل:</span><br><input type='text' name='file_name' placeholder='File Name'value="<?= $setting['file_name'] ?>"></td><td><span>عنوان:</span><br><input type='text' name='title' placeholder='Title'value="<?= $setting['title'] ?>"></td>
                        </tr>
                        <tr><td><span>یادداشت:</span><br><input type='text' name='comment' placeholder='Comment'value="<?= $setting['comment'] ?>"></td><td><span>خواننده / مجری:</span><br><input type='text' name='artist' placeholder='Artist'value="<?= $setting['artist'] ?>"></td>
                        </tr>
                        <tr><td><span>آلبوم:</span><br><input type='text' name='album' placeholder='Album'value="<?= $setting['album'] ?>"></td><td><span>سال انتشار:</span><br><input type='text' name='year' placeholder='Year'value="<?= $setting['year'] ?>"></td>
                        </tr>
                        <tr><td><span>سبک:</span><br><input type='text' name='genre' placeholder='Genre'value="<?= $setting['genre'] ?>"></td><td><span>تصویر کاور:</span><br><input type='text' name='album_art' placeholder='Album Art'value="<?= $setting['album_art'] ?>"></td>
                        </tr>
                        <tr>
 <td>
                                <br>
                                <span class='b-reset buttonc'>پاکسازی فرم</span>
                                <span class='b-setting button'>ثبت تنظیمات</span>
                                <br>
                            </td>
                            <td>
                                <h4>پیش نمایش</h4>
                                <div class="demo">
                                    <img src="<?= $setting['album_art'] ?>" />
                                    <div>
                                        Title: <?= $setting['title'] ?><br><br>
                                        Artitst: <?= $setting['artist'] ?><br>
                                        Album: <?= $setting['album'] ?>  ( <?= $setting['year'] ?> )<br>
                                        Genre: <?= $setting['genre'] ?><br>
                                        File: <?= $setting['file_name'] ?><br>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    </table>

                </form>
            </div>

            <?php endif ?>
        </div>
    </div>
<?php include ('footer.php'); ?>