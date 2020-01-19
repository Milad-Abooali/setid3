<?php
/**
 * iniul - Simple User Manager
 *
 * iniul is a simple class to manage user list by ini files. Add / Update / Remove/ also getting informatian as need to make authentication (iniaut class).
 * Originally written by Milad Abooali for NoDB-MultiUser project in Codebox.
 *
 * @category   FILE/INI
 * @package    CORE/LIB
 * @author     Milad Abooali <m.abooali@hotmail.com>
 * @author     CODEBOX <info@codebox.ir>
 * @copyright  2012-2019 codebox.ir
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    0.9 Beta - 5:16 PM 11/5/2018
 * @link       http://php.codebox.ir/class/iniul
 * @see        Examples @ iniul / Examples @ iniaut
 * ================================== START @ iniul */
class iniul {
    private $PATH;
    public $SELECTED;
    public $DATA=array();
#==================================== Construct @ iniaut
    public function __construct ($username=null){
        (!$username) ?: $this->getUser($username);
    }

#==================================== Get User @ iniul
    public function getUser($username) {
        $this->PATH="users/$username.ini";
        if (!file_exists($this->PATH)) {
            throw new Exception("User '$username' Not Exists !");
        } else {
            $this->DATA = parse_ini_file($this->PATH, true);
            $this->SELECTED = $username;
            return True;
        }
    }
#==================================== Add @ iniul
    public function add($username,$password=NULL) {
        $filepath="users/$username.ini";
        if (!file_exists($filepath)) {
            fopen($filepath, 'w');
            $value='[user];'.date("Y-m-d h:i:sa").PHP_EOL.'u = '.$username.PHP_EOL.'p = '.md5($password);
            $file = fopen($filepath, "a") or die("Unable to open file '$filepath' !");
            fwrite($file,$value);
            fclose($file);
            return True;
        } else {
            throw new Exception("User '$username' Already Exists !");
        }
    }
#==================================== Remove @ iniul
    public function remove($username) {
		$filepath="users/$username.ini";
			if (!unlink($filepath)) {
					throw new Exception("User '$username' Not Exists, Nothing Removed!");
            } else {
                return True;
            }
		}
#==================================== info @ iniul
    public function info($value,$username=Null,$section='user') {
        $filepath="users/".(($username) ?? $this->SELECTED).".ini";
        if (!file_exists($filepath)) {
            throw new Exception("User '$username' Not Exists !");
        } else {
            $data = parse_ini_file($filepath, true);
            return (array_key_exists($value,$data[$section])) ? $data[$section][$value] : ' ['.$section.'_'.$value.'] ';
        }
    }
#==================================== Update @ iniul
    public function update($username,$password=NULL) {
        $filepath="users/$username.ini";
        if (file_exists($filepath)) {
            fopen($filepath, 'w');
            $value='[user];'.date("Y-m-d h:i:sa").PHP_EOL.'u = '.$username.PHP_EOL.'p = '.md5($password);
            $file = fopen($filepath, "a") or die("Unable to open file '$filepath' !");
            fwrite($file,$value);
            fclose($file);
            return True;
        } else {
            throw new Exception("User '$username' Not Exists !");
        }
    }
#==================================== Extend @ iniul
}
#==================================== END @ iniul

#==================================== Examples @ iniul

$user = new iniul();

# Get User @ iniul
//try {
//    var_dump($user->getUser('admin'));
//    echo "User Exists";
//} catch(Exception $e) {
//    echo '<hr>'.$e->getMessage();
//}

# info @ iniul
//echo $user->info('u').'<hr>';

# Update @ iniul
//try {
//	$user->update('test','q#123');
//	echo "User Updated";
//} catch(Exception $e) {
//	echo '<hr>'.$e->getMessage();
//}

# Remove @ iniul
//try {
//	$user->remove('test');
//	echo "User Removed";
//} catch(Exception $e) {
//	echo '<hr>'.$e->getMessage();
//}

# Add @ iniul
//try {
//	$user->add('test','password',1,1);
//	echo "User Created";
//} catch(Exception $e) {
//  echo '<hr>'.$e->getMessage();
//}