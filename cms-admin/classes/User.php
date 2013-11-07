<?

/**
* @package CandyCMS
* @version 0.5.3
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Methods to get users and user info
*/

class User {
	
	public static function getUserInfo($user){
	
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT userid, name, email, username, role FROM '. DB_PREFIX .'users WHERE username = "'.$user.'"');
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_CLASS);
		
	}
	
	public static function saveUserInfo($user, $name, $email){
	
		$dbh = new CandyDB();
		$dbh->exec("UPDATE ". DB_PREFIX ."users SET name='$name', email='$email' WHERE username='$user'");
	
	}
	
	public static function getUsers(){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT userid, name, email, username, role FROM '. DB_PREFIX .'users');
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_CLASS);
		
	}
	
	public static function getUserTable(){
	
		$users = self::getUsers();
		
		$html = '<table class="usertbl">';
		$html .= '<thead><tr><th>Username</th><th>Name</th><th>Email</th><th>Role</th><th></th><th></th></tr></thead>';
		
		foreach ($users as $user) {
			$html .= '<tr>';
			$html .= '<td>'.$user->username.'</td>';
			$html .= '<td>'.$user->name.'</td>';
			$html .= '<td>'.$user->email.'</td>';
			$html .= '<td>'.$user->role.'</td>';
			$html .= '<td><a href="dashboard.php?page=users&edit='.$user->username.'" title="Edit Page">Edit</a></td>';
			$html .= '<td><a class="delete" href="dashboard.php?page=users&delete='.$user->username.'" title="'.$user->username.'">[x]</a></td>';
			$html .= '</tr>';	
		}
		
		$html .= '</table>';
		
		echo $html;
		
	
	}
	
	public static function addUser($username, $name, $email, $pass, $role){
	
		$pass = sha1(trim($pass).SALT);
		
		$dbh = new CandyDB();
		$dbh->exec("INSERT INTO ".DB_PREFIX."users (username, name, email, password, role) VALUES ('$username', '$name', '$email', '$pass', '$role')");
		
	}
	
	public static function editUser($userid, $username, $name, $email, $role){
	
		$dbh = new CandyDB();
		$dbh->exec("UPDATE ".DB_PREFIX."users SET username='$username', name='$name', email='$email', role='$role' WHERE userid='$userid'");
	
	}
	
	public static function deleteUser($username){
		
		$dbh = new CandyDB();
		$dbh->exec("DELETE FROM ".DB_PREFIX."users WHERE username='$username'");
		
	}
	
	public static function getRole($username){
		return CandyDB::val('SELECT role FROM '. DB_PREFIX .'users WHERE username = :username', array('username' => $username));
	}
	
	public static function changePassword($user, $old, $new){
		
		$old = sha1(trim($old).SALT);
		$new = sha1(trim($new).SALT);
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare("UPDATE ".DB_PREFIX."users SET password='$new' WHERE username='$user' AND password='$old'");
		$sth->execute();
		$rows = $sth->rowCount();
		
		if ($rows != 0) {
			echo '<p class="message success">Password Updated</p>';
		} else {
			echo '<p class="message notice">Your Password Was Incorrect</p>';
		}
		
	}
	
	public static function resetPassword($email){
		
		$password = "";
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
		$maxlength = 10;
		
		$i = 0; 
		
		while ($i < $maxlength) { 
			$char = substr($possible, mt_rand(0, $maxlength-1), 1);
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}
		}
		
		$rand = sha1($password.SALT);
		
		$dbh = new CandyDB();
		$dbh->exec("UPDATE ".DB_PREFIX."users SET password='$rand' WHERE email='$email'");
		
		
		mail($email, 'Your New CandyCMS Password', "Your new password is\n\n$password\n\nPlease change this after logging in.");
		
	}
	
	public static function getGravatar($username, $size = 32){
		
		$info = self::getUserInfo($username);

		$hash = md5( strtolower( trim($info[0]->email) ) );
		
		echo '<img src="http://www.gravatar.com/avatar/'.$hash.'?s='.$size.'" />';
		
	}
	
}