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
?>

<?php if (!$_SESSION['USER']): ?>
    <ul>
        <li><h5>حساب کاربری من</h5></li>
        <li><a href="#" title="Login" class="b-login">ورود به حساب</a></li>
    </ul>
<?php else: ?>
    <ul>
        <li><h5>حساب کاربری</h5></li>
<?php if ($_SESSION['USER']=="admin"): ?>
      <li><a href="#" title="Add New Users" class="gp-add">ثبت کاربر جدید</a></li>
<?php endif ?>
        <li><a href="#" title="Update Password" class="gp-update">تغییر رمز عبور</a></li>
        <li><a href="#" title="Logout" class="b-logout">» خروج [<?= $_SESSION['USER'] ?>]</a></li>
        <li><h5>لینک ها</h5></li>
        <li><a href="index.php" title="HomePage">صفحه نخست</a></li>
        <li><a href="setting.php" title="Settings">تنظیمات</a></li>
        <li><a href="selector.php" title="Selector">انتخاب فایل</a></li>
        <li><a href="tageditor.php" title="Tag Editor">ویرایش تگ ها</a></li>
    </ul>
<?php
$count_tmp= count(scandir(json_decode(file_get_contents('setting.json'), true)['tmp_path']))-2;
 if ($_SESSION['USER']=="admin"): ?>
      <div style="text-align: center;padding: 20px;">
      <span>فایل های موقت: <span id="cctmp"><?= $count_tmp;?></span></span>
      <?php if ($count_tmp>0): ?>
      <br><br>
      <span title="Clear Temp Folder" class="b-cleartmp buttonct">حذف فایل های موقت</span>
      <?php endif ?>
      </div>
<?php endif ?>
<?php endif ?>
