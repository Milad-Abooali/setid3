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
$_SESSION['HI']= md5(session_id());
$return['HI'] = $_SESSION['HI'];
$start_time = microtime(TRUE);
require_once('iniul.php');
require_once('iniaut.php');

function hSize($size,$round=2){
    $sizes=array(' Byts',' Kb',' Mb',' Gb',' Tb');
    $total=count($sizes)-1;
    for($i=0;$size>1024 && $i<$total;$i++){
        $size/=1024;
    }
    return round($size,$round).$sizes[$i];
}

function getFileList($dir) {
    $retval = [];
    if(substr($dir, -1) != "/") {
        $dir .= "/";
    }
    $d = @dir($dir) or die("getFileList: Failed opening directory {$dir} for reading");
    while(FALSE !== ($entry = $d->read())) {
        if($entry{0} == ".") continue;
        if(is_dir("{$dir}{$entry}")) {
            $retval[] = [
                'name' => "{$entry}/",
                'path' => "{$dir}{$entry}/",
                'type' => filetype("{$dir}{$entry}"),
                'size' => 0,
                'lastmod' => date("Y-m-d H:i:s",filemtime("{$dir}{$entry}"))
            ];
        } elseif(is_readable("{$dir}{$entry}")) {
            $retval[] = [
                'name' => "{$entry}",
                'path' => "{$dir}{$entry}",
                'type' => mime_content_type("{$dir}{$entry}"),
                'size' => filesize("{$dir}{$entry}"),
                'lastmod' => date("Y-m-d H:i:s",filemtime("{$dir}{$entry}"))
            ];
        }
    }
    $d->close();
    return $retval;
}

switch ($_GET['act']) {
    case 'cleartmp':
        $settingcc = json_decode(file_get_contents('setting.json'), true);
        $i=0;
        $filess = glob($settingcc['tmp_path'].'/*');
        if (!empty($filess)) {
          foreach ($filess as $filee) {
            unlink ($filee);
            $i++;
          }
        }
        $return['COUNT'] = $i;
        $return['IO'] = ($i) ? True : False;
        break;
    case 'logout':
        $user = new iniaut();
        try {
            $return['IO'] = ($user->logout()) ? True : False;
        } catch(Exception $e) {
            $return['ERROR'][] = $e->getMessage();
        }
        break;
    case 'login':
        $user = new iniaut();
        $u = $_POST['u'] ?? NULL;
        $p = $_POST['p'] ?? NULL;
        try {
            $return['IO'] = ($user->login($u,$p)) ? True : False;
        } catch(Exception $e) {
            $return['ERR']['login'] = $e->getMessage();
        }
        break;
    case 'add':
        if ($_SESSION['USER']) {
            $user = new iniul();
            $u = $_POST['u'] ?? NULL;
            $p = $_POST['p'] ?? NULL;
            try {
                $return['IO'] = ($user->add($u,$p)) ? True : False;
            } catch(Exception $e) {
                $return['ERR']['login'] = $e->getMessage();
            }
        }
        break;
    case 'setting':
        file_put_contents("setting.json",json_encode($_POST));
        $return['IO'] = True;
        break;
    case 'listdir':
        $dir = $_POST['dir'] ?? NULL;
        $dirlist = getFileList("./$dir");
        $return['IO'] = True;
        $return['LIST'] = $dirlist;
        break;
    case 'upload':
        $target_dir = "tmp/";
        $target_file = $target_dir . basename($_FILES["songfile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if ($imageFileType!='mp3') {
            $uploadOk = 0;
            $return['ERR'][] = 'Type: File is not mp3.';
        }
        if (file_exists($target_file)) {
            $uploadOk = 0;
            $return['ERR'][] = 'File: Already exists.';
        }
        if ($_FILES["fileToUpload"]["size"] > 50000000) {
            $uploadOk = 0;
            $return['ERR'][] = 'File: Too large.';
        }
        if ($uploadOk == 0) {
            $return['ERR'][] = 'File was not uploaded.';
        } else {
            if (move_uploaded_file($_FILES["songfile"]["tmp_name"], $target_file)) {
                $return['IO'] = True;
                $return['NAME'] = basename( $_FILES["songfile"]["name"]);
                header("Location: tageditor.php?fp=$target_file");
                exit();
            } else {
                $return['IO'] = False;
            }
        }
        break;
    case 'uploadurl':
		$remote_file_url = $_POST['u'] ?? NULL;
		if ($remote_file_url) {
			$uploadOk = 1;
			$FileType = strtolower(pathinfo($remote_file_url,PATHINFO_EXTENSION));
			$local_file = 'tmp/' . md5($remote_file_url) . '.mp3';
			if ($FileType!='mp3') {
				$uploadOk = 0;
				$return['ERR'][] = 'Type: File is not mp3.';
			}
			if (file_exists($local_file)) {
				$uploadOk = 0;
				$return['ERR'][] = 'File: Already exists.';
			}
			if ($uploadOk == 0) {
				$return['ERR'][] = 'File was not uploaded.';
				$return['IO'] = False;
			} else {
				$copy = copy( $remote_file_url, $local_file );
				if( !$copy ) {
					$return['ERR'][] = "File was not uploaded. '$file'";
					$return['IO'] = False;
				} else {
					$return['IO'] = True;
					$return['NAME'] = $local_file;
				}
			}
		} else {
			$return['IO'] = False;
			$return['ERR'][] = 'URL: Not Valid URL.';
		}
        break;
    case 'update':
        if ($_SESSION['USER']) {
            $user = new iniul();
            $p = $_POST['p'] ?? NULL;
            try {
                $return['IO'] = ($user->update($_SESSION['USER'],$p)) ? True : False;
            } catch(Exception $e) {
                $return['ERR']['login'] = $e->getMessage();
            }
        }
        break;
    case 'edittag':
        $default_mp3_directory = $_POST['file_folder'].'/';
        $mp3_filepath = $_POST['mp3_filepath'];
        $mp3_filename = $_POST['mp3_filename'];
        $mp3_songname = $_POST['mp3_songname'];
        $mp3_comment = $_POST['mp3_comment'];
        $mp3_artist = $_POST['mp3_artist'];
        $mp3_album = $_POST['mp3_album'];
        $mp3_year = $_POST['mp3_year'];
        $mp3_genre = $_POST['mp3_genre'];
        $mp3_album_art = $_POST['album_art'];
        if($mp3_filename!=""){
            $mp3_filename = str_replace(DIRECTORY_SEPARATOR,"-X-",$mp3_filename);
            if(strtolower(end(explode(".",basename($mp3_filepath))))!="mp3"){
                $return['ERR'][] = 'URL must have a .mp3 exntension !';
            }
            if(strtolower(end(explode(".",basename($mp3_filename))))!="mp3"){
                $return['ERR'][] = 'Filename must have a .mp3 exntension !';
            }
            $sname = $default_mp3_directory.$mp3_filename;
            if(copy($mp3_filepath,$sname)){
                $size = hSize(filesize($sname));
                $return['TEXT'] = "Copied [ <a target='_blank' href='$mp3_filepath'>$mp3_filepath</a> ]  TO [ <a target='_blank' href='$sname'>".basename($sname)."</a> ] ( $size )";
                $mp3_tagformat = 'UTF-8';
                require_once('getid3/getid3.php');
                $mp3_handler = new getID3;
                $mp3_handler->setOption(array('encoding'=>$mp3_tagformat));
                require_once('getid3/write.php');
                $mp3_writter = new getid3_writetags;
                $mp3_writter->filename       = $sname;
                $mp3_writter->tagformats     = array('id3v1', 'id3v2.3');
                $mp3_writter->overwrite_tags = true;
                $mp3_writter->tag_encoding   = $mp3_tagformat;
                $mp3_writter->remove_other_tags = true;
                $mp3_data['title'][]   = $mp3_songname;
                $mp3_data['artist'][]  = $mp3_artist;
                $mp3_data['album'][]   = $mp3_album;
                $mp3_data['year'][]    = $mp3_year;
                $mp3_data['genre'][]   = $mp3_genre;
                $mp3_data['comment'][] = $mp3_comment;
                $mp3_data['attached_picture'][0]['data'] = file_get_contents($mp3_album_art);
                $mp3_data['attached_picture'][0]['picturetypeid'] = "image/png";
                $mp3_data['attached_picture'][0]['description'] = 'Album Art';
                $mp3_data['attached_picture'][0]['mime'] = "image/png";
                $mp3_writter->tag_data = $mp3_data;
                if($mp3_writter->WriteTags()) {
                    $return['IO'] = True;
                    $return['TEXT'] .= "<br />Album art image aded. <br> All Done.";
                }
                else{
                    $return['IO'] = False;
                    $return['ERR'][] = 'implode("<br />",$mp3_writter->errors)';
                }
            }
            else{
                $return['IO'] = False;
                $return['ERR'][] = 'Unable to copy file.';
            }
        }
        else{
            $return['IO'] = False;
            $return['ERR'][] = 'Empty filename.';
        }
        break;
    default:
        echo ("No Action!");
}
echo json_encode($return);
