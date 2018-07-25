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
/* Account activation script */

// Get database connection
include 'db.php';

// Create variables from URL.

$userid = $_REQUEST['id'];
$code = $_REQUEST['code'];

$sql = mysqli_query($connection,"UPDATE users SET activated='1' WHERE userid='$userid' AND password='$code'");

$sql_doublecheck = mysqli_query($connection,"SELECT * FROM users WHERE userid='$userid' AND password='$code' AND activated='1'");
$doublecheck = mysqli_num_rows($sql_doublecheck);

if($doublecheck == 0){
	echo "<strong><font color=red>Your account could not be activated!</font></strong>";
} elseif ($doublecheck > 0) {
	echo "<strong>Your account has been activated!</strong> You may login below!<br />";
	include 'login_form.html';
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




