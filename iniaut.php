<?php
/**
 * iniaut - File Base User Authentication
 *
 * iniaut is a simple class to authentication users from ini files. This class extended iniul class.
 * Originally written by Milad Abooali for NoDB-MultiUser project in Codebox.
 *
 * @category   RUN/NODB
 * @package    CORE/RUN
 * @author     Milad Abooali <m.abooali@hotmail.com>
 * @author     CODEBOX <info@codebox.ir>
 * @copyright  2012-2019 codebox.ir
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    0.9 Beta - 5:16 PM 11/5/2018
 * @link       http://php.codebox.ir/class/iniaut
 * @see        Examples @ iniaut / Examples @ iniaut
 * ================================== START @ iniaut */
class iniaut extends iniul {
#==================================== Construct @ iniaut

#==================================== Login @ iniaut
    public function login($username,$password=Null) {
        try {
            $this->getUser($username);
            if ($this->info('p') == md5($password)) {
                $_SESSION['USER'] = $username;
                return True;
            } else {
                throw new Exception("User Data is Not True!");
            }
        } catch(Exception $e) {
            throw new Exception("User Data is Not True!");
        }
    }
#==================================== Logout @ iniaut
    public function logout() {
        session_unset();
        session_destroy();
        return True;
    }
#==================================== Extend @ iniaut
}
#==================================== END @ iniaut
#==================================== Examples @ iniaut

//$user = new iniaut ();

# Login @ iniaut
//try {
//	$user->login('test','q#123');
//	echo "User Logged In";
//} catch(Exception $e) {
//	echo '<hr>'.$e->getMessage();
//}

# Remove @ iniaut
//try {
//	$user->remove('test');
//	echo "User Removed";
//} catch(Exception $e) {
//	echo '<hr>'.$e->getMessage();
//}
