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
$title="ویرایش تگ ها";
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
                <?php
                    if (!$_GET['fp']) {
                        ?>
                        <p>                            شما فایلی برای ویرایش انتخاب نکرده اید، لطفا یک فایل <a href="selector.php">انتخاب </a> کنید یا فایل خود را آپلود کنید.
                        </p>
                        <div class="uploaderurl">
							<p>انتقال از وب</p>
							<input type="text" style="width: 300px;color: #3c981c;" id="songfileweb" placeholder="https://example.com/test.mp3" />
							<span class="btnurl">انتقال</span>
							<div id="resuweb"></div>
                       </div>
                        <div class="uploader">
                            <form action="ajax.php?act=upload" method="post" enctype="multipart/form-data">
								<p>آپلود از هارد دیسک</p>
                                <div class="upload-btn-wrapper">
                                    <input type="file" name="songfile"/>
                                    <button class="btn">جستجو</button>
                                </div>
                                <div>
                                    <input type="submit" value="آپلود" name="submit">
                                </div>
                            </form>
                        </div>

                <?php
                    } else {
                ?>
            <div id="result"></div>
            <div class="editor">
                    <form id="editorf">
                        <table>
                            <tr>
                                <td colspan="4"><strong>فایل در حال ویرایش</strong></td>
                            </tr>
                            <tr>
                                <td>مسیر فعلی فایل</td>
                                <td><input type='text' name='mp3_filepath' placeholder='Temp Path'value="<?= $_GET['fp'] ?>"></td>
                                <td>پوشه مقصد فایل</td>
                                <td style="direction:ltr">
                                    <?= $setting['files_folder'] ?>
                                    <select id="foldersel" name="file_folder">
                                        <?php
                                        $folder=$setting['files_folder'];
                                        echo "<option value='$folder/''> / .</option>";
                                        foreach(glob("$folder/*", GLOB_ONLYDIR) as $dir) {
                                            $dir = str_replace("$folder/", '', $dir);
                                            echo "<option value='$folder/$dir''> / $dir</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>تگ ها</strong></td>
                            </tr>
                            <tr>
                                <td>نام فایل</td>
                                <td><input type='text' name='mp3_filename' placeholder='File Name'value="<?= $setting['file_name'] ?>"></td>
                                <td>عنوان</td>
                                <td><input type='text' name='mp3_songname' placeholder='Title'value="<?= $setting['title'] ?>"></td>
                            </tr>
                            <tr>
                                <td>یادداشت</td>
                                <td><input type='text' name='mp3_comment' placeholder='Comment'value="<?= $setting['comment'] ?>"></td>
                                <td>خواننده / مجری</td>
                                <td><input type='text' name='mp3_artist' placeholder='Artist'value="<?= $setting['artist'] ?>"></td>
                            </tr>
                            <tr>
                                <td>آلبوم</td>
                                <td><input type='text' name='mp3_album' placeholder='Album'value="<?= $setting['album'] ?>"></td>
                                <td>سال انتشار</td>
                                <td><input type='text' name='mp3_year' placeholder='Year'value="<?= $setting['year'] ?>"></td>
                            </tr>
                            <tr>
                                <td>سبک</td>
                                <td><input type='text' name='mp3_genre' placeholder='Genre'value="<?= $setting['genre'] ?>"></td>
                                <td>تصویر کاور</td>
                                <td><input type='text' name='album_art' placeholder='Album Art'value="<?= $setting['album_art'] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <br>
                                    <span class='b-edittag button'>ویرایش فایل</span>
                                    <br>
                                </td>
                            </tr>
                        </table>
                    </form>
            </div>
                <?php
                    }
                ?>
            <?php endif ?>
        </div>
    </div>
<?php include ('footer.php'); ?>