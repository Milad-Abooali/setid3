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
$title="انتخاب فایل";
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
                <div class="filelist">
                    <div class="folder">
                        <?= $setting['files_folder'] ?>
                        <select id="foldersel">
                            <?php
                            $folder=$setting['files_folder'];
                            echo "<option value='$folder/''> / .</option>";
                            foreach(glob("$folder/*", GLOB_ONLYDIR) as $dir) {
                                $dir = str_replace("$folder/", '', $dir);
                                echo "<option value='$folder/$dir''> / $dir</option>";
                            }
                            ?>
                        </select>
                        <button class="b-listfiles">نمایش فایل ها</button>

                    </div>
                    <div id="files">

                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
        <?php include ('footer.php'); ?>