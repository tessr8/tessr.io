<?
/* Check User Script */
session_start();  // Start Session

include 'db.php';
// Conver to simple variables
$username = $_POST['username'];
$password = $_POST['password'];

if((!$username) || (!$password)){
	echo "Please enter ALL of the information! <br />";
	include 'login_form.html';
	exit();
}

// Convert password to md5 hash
$password = md5($password);

// check if the user info validates the db
$sql = mysqli_query($connection,"SELECT * FROM users WHERE username='$username' AND password='$password' AND activated='1'");
$login_check = mysqli_num_rows($sql);

if($login_check > 0){
	while($row = mysqli_fetch_array($sql)){
	foreach( $row AS $key => $val ){
		$$key = stripslashes( $val );
	}
		// Register some session variables!
		// session_is_register('first_name');
		$_SESSION['first_name'] = $first_name;
		// session_is_register('last_name');
		$_SESSION['last_name'] = $last_name;
		// session_is_register('email_address');
		$_SESSION['email_address'] = $email_address;
		// session_is_register('special_user');
		$_SESSION['user_level'] = $user_level;
		
		mysqli_query($connection,"UPDATE users SET last_login=now() WHERE userid='$userid'");
		
		header("Location: login_success.php");
	}
} else {
	echo "You could not be logged in! Either the username and password do not match or you have not validated your membership!<br />
	Please try again!<br />";
	include 'login_form.html';
}
?>