<?php
// $host="10.254.94.2"; // Host name
// $username="s172905"; // Mysql username
// $password="JDfGNBwt"; // Mysql password
// $db_name="s172905"; // Database name
// // Connect to server and select databse.
// mysql_connect($host, $username, $password)or die("cannot connect");
// mysql_select_db($db_name)or die("cannot select DB");
// username and password sent from form
if(isset($_POST['Submit'])) {
	// $myusername=$_POST['myusername'];
	// $mypassword=$_POST['mypassword'];
	// To protect MySQL injection (more detail about MySQL injection)
	// $myusername = stripslashes($myusername);
	// $mypassword = stripslashes($mypassword);
	// $myusername = mysql_real_escape_string($myusername);
	// $mypassword = mysql_real_escape_string($mypassword);
	// $sql="SELECT * FROM users WHERE user_email='$myusername' AND user_password='$mypassword'";
	// $result=mysql_query($sql);
	// Mysql_num_row is counting table row
	include "DBadapter.php";
	$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
	$db->connect();
	$myusername=$_POST['myusername'];
	$mypassword=$_POST['mypassword'];
	$result = $db->getData("SELECT * FROM users WHERE user_email='$myusername' AND user_password='$mypassword'");
	$count=mysql_num_rows($result);
	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count==1){
		// Register $myusername, $mypassword and redirect to file "login_success.php"
		// session_register("myusername");
		// session_register("mypassword");
		session_start();
		$_SESSION['log'] = 'in';
		$_SESSION['user'] = mysql_result($result, 0, 1)." ".mysql_result($result, 0, 2);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}
	else {
		die("Wrong Username or Password");
	}
}
if(isset($_POST['register'])) {

	
	header('Location: main_page.php');
	exit;
}
?>