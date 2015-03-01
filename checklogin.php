<?php
	include "DBadapter.php";
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
		$_SESSION['email'] = mysql_result($result, 0, 3);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}
	else {
		die("Wrong Username or Password");
	}
}
if(isset($_POST['register'])) {
	session_start();
	$email = $_POST['email'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	if($email == "" || $password1 == "" || $password2 == "" || $name == "" || $surname == "") {
		$_SESSION['fill_alert'] = 'true';
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}
	if($password1 != $password2) {
		$_SESSION['pass_alert'] = 'true';
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}
	$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
	$db->connect();
	$result = $db->getData("SELECT user_email FROM users");
	for($i = 0; $i < mysql_num_rows($result); $i++) {
		if($email == mysql_result($result, 0, $i)) {
			$_SESSION['exists_alert'] = 'true';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit;
		}
	}
	$db->insertData("INSERT INTO users(user_email, user_password, user_name, user_surname) VALUES('$email', '$password1', '$name', '$surname')");
	$_SESSION['log'] = 'in';
	$_SESSION['user'] = $name." ".$surname;
	header('Location: main_page.php');
	exit;
}
if(isset($_POST['confirm'])) {
	session_start();
	$movie = $_SESSION['movie'];
	$dur = $_POST['duration'];
	$today = date("Y-m-j");
	$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
	$db->connect();
	$email = $_SESSION['email'];
	$result1 = $db->getData("SELECT id_movie, price FROM movies WHERE title='$movie'");
	$result2 = $db->getData("SELECT id_user FROM users WHERE user_email='$email'");
	$price = mysql_result($result1, 0, 1);
	$id_movie = mysql_result($result1, 0, 0);
	$id_user = mysql_result($result2, 0, 0);
	$charge = $dur * $price;
	$db->insertData("INSERT INTO rentals(rent_date, rent_duration, charge) VALUES('$today','$dur', '$charge')");
	$result3 = $db->getData("SELECT id_rental FROM rentals");
	$row = mysql_num_rows($result3) - 1;
	$id_rental = mysql_result($result3, $row, 0);
	$db->insertData("INSERT INTO movies_rentals VALUES('$id_movie', '$id_rental')");
	$db->insertData("INSERT INTO users_rentals VALUES('$id_user', '$id_rental')");
	header('Location: main_page.php');
	exit;
}
?>