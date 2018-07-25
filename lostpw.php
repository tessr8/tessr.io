<?
include 'db.php';

switch($_POST['recover']){
	default:
	include 'lost_pw.html';
	break;
	
	case "recover":
	recover_pw($_POST['email_address']);
	break;
}
function recover_pw($email_address){
	if(!$email_address){
		echo "You forgot to enter your Email address <strong>Knucklehead</strong><br />";
		include 'lost_pw.html';
		exit();
	}
	// quick check to see if record exists	
	$sql_check = mysqli_query($connection,"SELECT * FROM users WHERE email_address='$email_address'");
	$sql_check_num = mysqli_num_rows($sql_check);
	if($sql_check_num == 0){
		echo "No records found matching your email address<br />";
		include 'lost_pw.html';
		exit();
	}
	// Everything looks ok, generate password, update it and send it!
	
	function makeRandomPassword() {
  		$salt = "abchefghjkmnpqrstuvwxyz0123456789";
  		srand((double)microtime()*1000000); 
	  	$i = 0;
	  	while ($i <= 7) {
	    		$num = rand() % 33;
	    		$tmp = substr($salt, $num, 1);
	    		$pass = $pass . $tmp;
	    		$i++;
	  	}
	  	return $pass;
	}

	$random_password = makeRandomPassword();

	$db_password = md5($random_password);
	
	$sql = mysqli_query($connection,"UPDATE users SET password='$db_password' WHERE email_address='$email_address'");
	
	$subject = "Your Password at MyWebsite!";
	$message = "Hi, we have reset your password.
	
	New Password: $random_password
	
	http://www.mywebsite.com/login.php
	
	Thanks!
	The Webmaster
	
	This is an automated response, please do not reply!";
	
	mail($email_address, $subject, $message, "From: MyDomain Webmaster<admin@mydomain.com>\nX-Mailer: PHP/" . phpversion());
	echo "Your password has been sent! Please check your email!<br />";
	include 'login_form.html';
}
?>