<? 
/*  Database Information - Required!!  */
/* -- Configure the Variables Below --*/
$dbhost = 'localhost';
$dbusername = 'tessr_admin';
$dbpasswd = 't3$$r4dm1n';
$database_name = 'tessr';
/* global $db; */
/* Database Stuff, do not modify below this line */

$connection = mysqli_connect("$dbhost","$dbusername","$dbpasswd") 
	or die ("Couldn't connect to server.");
	
$db = mysqli_select_db($connection, "$database_name")
	or die("Couldn't select database.");
?>
