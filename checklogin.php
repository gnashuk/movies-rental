<?php
	include "DBadapter.php";
if(isset($_POST['Submit'])) {
	$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
	$db->connect();
	$myusername=$_POST['myusername'];
	$mypassword=$_POST['mypassword'];
	$result = $db->getData("SELECT * FROM users WHERE user_email='$myusername' AND user_password='$mypassword'");
	$count=mysql_num_rows($result);
	if($count==1){
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
	$_SESSION['email'] = $email;
	header('Location: main_page.php');
	exit;
}
if(isset($_POST['confirm'])) {
	session_start();
	if(!isset($_SESSION['log'])) {
		$_SESSION['alert'] = 'true';
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	} else {
	$movie = $_SESSION['movie'];
	$dur = $_POST['duration'];
	$today = date("Y-m-d");
	$end = date('Y-m-d', strtotime($today. ' + '.$dur.' days'));
	$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
	$db->connect();
	$email = $_SESSION['email'];
	$result1 = $db->getData("SELECT id_movie, price FROM movies WHERE title='$movie'");
	$result2 = $db->getData("SELECT id_user FROM users WHERE user_email='$email'");
	$price = mysql_result($result1, 0, 1);
	$id_movie = mysql_result($result1, 0, 0);
	$id_user = mysql_result($result2, 0, 0);
	$charge = $dur * $price;
	$db->insertData("INSERT INTO rentals(rent_date, rent_end_date, charge) VALUES('$today','$end', '$charge')");
	$result3 = $db->getData("SELECT id_rental FROM rentals");
	$row = mysql_num_rows($result3) - 1;
	$id_rental = mysql_result($result3, $row, 0);
	$db->insertData("INSERT INTO movies_rentals VALUES('$id_movie', '$id_rental')");
	$db->insertData("INSERT INTO users_rentals VALUES('$id_user', '$id_rental')");
	$message = "You have rented a movie ".$movie." for a period until ".$end.".\n".$charge."€ have been charged from your account.";
	$message = wordwrap($message,70);
	mail($email, "Movie rent confirmation", $message);
	header('Location: main_page.php');
	exit;
	}
}
if(isset($_POST['operation'])) {
	session_start();
	$_SESSION['genre'] = $_POST['operation'];
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
}
if(isset($_POST['review'])) {
	session_start();
	$name = $_SESSION['movie'];
	$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
	$db->connect();
	$result = $db->getData("SELECT id_movie FROM movies WHERE title='$name'");
	$movie_id = mysql_result($result, 0, 0);
	$author = $_SESSION['user'];
	$today = date("Y-m-j");
	$text = stripslashes($_POST['comment']);
	$db->insertData("INSERT INTO reviews(id_movie, author, review_date, review_text) VALUES('$movie_id','$author','$today','$text')");
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}
?>