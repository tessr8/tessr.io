<!DOCTYPE html>
	<html lang="zxx" class="js">
		<head>
			<meta charset="utf-8">
			<meta name="author" content="@EJS32 - Tessr.io">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="description" content="Tessr is a unified protocol suite providing interoperability between blockchains">
			<link rel="shortcut icon" href="../images/favicon.png">
			<title>Tessr - Educational Blockchain Solution</title>
			<link rel="stylesheet" href="../assets/css/vendor.bundle.css">
			<link rel="stylesheet" href="../assets/css/style.css?ver=113">
			<link rel="stylesheet" href="../assets/css/theme-java.css?ver=113">
			<link rel="stylesheet" href="../assets/css/ltr.css?ver=113">
		</head>
		
		<body class="theme-dark io-azure io-azure-pro" data-spy="scroll" data-target="#mainnav" data-offset="60">
	<!-- Header --> 
	<header class="site-header is-sticky">
		<!-- Place Particle Js -->
		<div id="particles-js" class="particles-container particles-js"></div>
		<!-- Navbar -->
		<div class="navbar navbar-expand-lg is-transparent" id="mainnav">
			<nav class="container">
				<a class="navbar-brand animated" data-animate="fadeInDown" data-delay=".65" href="../">
					<img class="logo logo-dark" alt="logo" src="../images/logo.png" srcset="../images/logo2x.png 2x">
					<img class="logo logo-light" alt="logo" src="../images/logo-white.png" srcset="../images/logo-white2x.png 2x">
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle">
					<span class="navbar-toggler-icon">
					<span class="ti ti-align-justify"></span>
					</span>
				</button>
				<a href="../docs/Legal_T&C.pdf" class="btn btn-alt btn-sm" download>Legal T&C Document</a>
				<div class="collapse navbar-collapse justify-content-end" id="navbarToggle">
					<ul class="navbar-nav animated" data-animate="fadeInDown" data-delay=".9">
						<li class="nav-item"><a class="nav-link menu-link" href="../index.html">Home<span class="sr-only">(current)</span></a></li>
						<li class="nav-item"><a class="nav-link menu-link" href="login_form.html">Sign In</a></li>
						<li class="nav-item"><a class="nav-link menu-link" href="join.php">Register</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<!-- End Navbar -->
	</header>
	<!-- End Header -->
	<!-- Start Section -->
	<div class="section section-pad section-bg-alt">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
					<div class="section-head" id="tokenSale">
<?

include 'db.php';

// Define post fields into simple variables
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email_address = $_POST['email_address'];
$username = $_POST['username'];
$info = $_POST['info'];

/* Let's strip some slashes in case the user entered
any escaped characters. */

$first_name = stripslashes($first_name);
$last_name = stripslashes($last_name);
$email_address = stripslashes($email_address);
$username = stripslashes($username);
$info = stripslashes($info);


/* Do some error checking on the form posted fields */

if((!$first_name) || (!$last_name) || (!$email_address) || (!$username)){
	echo 'You did not submit the following required information! <br />';
	if(!$first_name){
		echo "First Name is a required field. Please enter it below.<br />";
	}
	if(!$last_name){
		echo "Last Name is a required field. Please enter it below.<br />";
	}
	if(!$email_address){
		echo "Email Address is a required field. Please enter it below.<br />";
	}
	if(!$username){
		echo "Desired Username is a required field. Please enter it below.<br />";
	}
	include 'join_form.php'; // Show the form again!
	/* End the error checking and if everything is ok, we'll move on to
	 creating the user account */
	exit(); // if the error checking has failed, we'll exit the script!
}
	
/* Let's do some checking and ensure that the user's email address or username
 does not exist in the database */
 
 $sql_email_check = mysqli_query($connection,"SELECT email_address FROM users WHERE email_address='$email_address'");
 $sql_username_check = mysqli_query($connection,"SELECT username FROM users WHERE username='$username'");
 
 $email_check = mysqli_num_rows($sql_email_check);
 $username_check = mysqli_num_rows($sql_username_check);
 
 if(($email_check > 0) || ($username_check > 0)){
 	echo "Please fix the following errors: <br />";
 	if($email_check > 0){
 		echo "<strong>Your email address has already been used by another member in our database. Please submit a different Email address!<br />";
 		unset($email_address);
 	}
 	if($username_check > 0){
 		echo "The username you have selected has already been used by another member in our database. Please choose a different Username!<br />";
 		unset($username);
 	}
 	include 'join_form.php'; // Show the form again!
 	exit();  // exit the script so that we do not create this account!
 }
 
/* Everything has passed both error checks that we have done.
It's time to create the account! */

/* Random Password generator. 
http://www.phpfreaks.com/quickcode/Random_Password_Generator/56.php

We'll generate a random password for the
user and encrypt it, email it and then enter it into the db.
*/
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

// Enter info into the Database.
$info2 = htmlspecialchars($info);
$sql = mysqli_query($connection,"INSERT INTO users (first_name, last_name, email_address, username, password, info, signup_date)
		VALUES('$first_name', '$last_name', '$email_address', '$username', '$db_password', '$info2', now())") or die (mysqli_error());

if(!$sql){
	echo 'There has been an error creating your account. Please contact team@tessr.io.';
} else {
	$userid = mysqli_insert_id($connection);
	// Let's mail the user!
	$subject = "Tessr.credit Signup";
	$message = "Dear $first_name $last_name,
	Thank you for registering with the tessr.foundation.
	
	To activate your membership, please click here: https://www.tessr.io/tge/activate.php?id=$userid&code=$db_password
	
	Once you activate your memebership, you will be able to login with the following information:
	Username: $username
	Password: $random_password
	
	Thank You!
	The Tessr Team
	team@tessr.io
	
	This is an automated response, please do not reply!";
	
	mail($email_address, $subject, $message, "From: tessr.io Webmaster<team@tessr.io>\nX-Mailer: PHP/" . phpversion());
	echo 'Your membership information has been sent to your email address! Please check it and follow the directions!';
}

?>
					</div>
				</div>
			</div>
		</div><!-- .container  -->
	</div>
	<!-- Start Section -->
	<!-- Preloader !remove please if you do not want -->
	<div id="preloader">
		<div id="loader"></div>
		<div class="loader-section loader-top"></div>
   		<div class="loader-section loader-bottom"></div>
	</div>
	<!-- Preloader End -->
	<!-- JavaScript (include all script here) -->
	<script src="../assets/js/jquery.bundle.js?ver=113"></script>
	<script src="../assets/js/script.js?ver=113"></script>
</body>
<script>'undefined'=== typeof _trfq || (window._trfq = []);'undefined'=== typeof _trfd && (window._trfd=[]),_trfd.push({'tccl.baseHost':'secureserver.net'}),_trfd.push({'ap':'cpsh'},{'server':'a2plcpnl0172'}) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.</script><script src='https://img1.wsimg.com/tcc/tcc_l.combined.1.0.6.min.js'></script></html>




