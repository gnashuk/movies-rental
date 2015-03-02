<?php
session_start();
// session_start();

if( !isset($_SESSION['log']) || ($_SESSION['log'] != 'in') ) {

	echo "<div align='right'><form class='form-inline' name='form1' method='post' action='checklogin.php'>
  			<div class='form-group'>
    		<label for='myusername'>Email</label>
    		<input type='email' class='form-control' name='myusername' id='myusername' placeholder='example@mail.com' size='15'>
 		</div>
		<div class='form-group'>
		    <label for='mypassword'>Password</label>
  			<input type='password' class='form-control' name='mypassword' id='mypassword' size=10>
		</div>
  		<button type='submit' name='Submit' class='btn btn-default'>Login</button>
	</form>
	Don't have account yet? <a href='register.php'>Click here to register</a></div>";
} else {
	echo "<div align='right'>Loged in as <a href='profile.php'>"
		.$_SESSION['user']."</a>"
		."<p><a href='logout.php'>log out</a></p></div>";
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Movies rental</title>
		<style>
			table {
				table-layout: fixed;
			}
		</style>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<table>
			<tr>
				<td>
					<ol>
<?php
	include "DBadapter.php";
	$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
	$db->connect();
	echo "<form name='form2' method='post' action='checklogin.php'>Select by genre 
			<select name='operation' id='genre' onchange='this.form.submit()'>";
	if(!isset($_SESSION['genre']) || $_SESSION['genre'] == 'All genres') {
  		echo "<option value='All genres' selected>All genres</option>";
  		$result = $db->getData("SELECT * FROM genres");
  		$rows_num=mysql_num_rows($result);
  		for($i = 0; $i < $rows_num; $i++) {
  			$val = mysql_result($result, $i, 0);
  			echo "<option value=".$val.">".$val."</option>";
  		}
  	
	
		$result = $db->getData("SELECT title, cover FROM movies");
	} else {
		$sent_val = $_SESSION['genre'];
		$result = $db->getData("SELECT * FROM genres");
  		$rows_num=mysql_num_rows($result);
  		for($i = 0; $i < $rows_num; $i++) {
  			$val = mysql_result($result, $i, 0);
  			if($val == $sent_val) echo "<option value=".$val." selected>".$val."</option>";
  			else echo "<option value=".$val.">".$val."</option>";
  		}
  		echo "<option value='All genres'>All genres</option>";
  		$result = $db->getData("SELECT title, cover FROM movies WHERE genre='$sent_val'");
	}
	echo "</select>
	<form>";
	$rows_num=mysql_num_rows($result);
	for($i = 0; $i < $rows_num; $i++) {
		$title = mysql_result($result, $i, 0);
		$cover = mysql_result($result, $i, 1);
		echo "<li><div style='border: 1px solid grey; width: 800px; padding: 5px;'><a style='vertical-align: top;' href='movie_page.php?data=".$title."'><img width='107' height='159' src='".$cover."'></a><a style='vertical-align: top; padding: 5px;' href='movie_page.php?data=".$title."'>".$title."</a></div></li><hr>";
	}
?>
					</ol>
				</td>
				<td>
					<h3>The most reviewed movies</h3>
					<ol>
<?php
	$result = $db->getData("SELECT title FROM movies");
	$mov_num = mysql_num_rows($result);
	$arr = array();
	for($i = 0; $i < $mov_num; $i++) {
		$mov = mysql_result($result, $i, 0);
		$result1 = $db->getData("SELECT COUNT(*) FROM movies INNER JOIN reviews ON movies.id_movie=reviews.id_movie WHERE title='$mov'");
		$arr[$mov] = mysql_result($result1, 0, 0);
	}
	arsort($arr);
	if($mov_num < 5) {
		for($i = 0; $i < $mov_num; $i++) {
			echo "<li><a href='movie_page.php?data=".key($arr)."'>".key($arr)."</a></li>";
			next($arr);
		}
	} else {
		for($i = 0; $i < 5; $i++) {
			echo "<li><a href='movie_page.php?data=".key($arr)."'>".key($arr)."</a></li>";
			next($arr);
		}
	}
?>
				</ol>
				<h3>The most borrowed movies</h3>
				<ol>
<?php
	$result = $db->getData("SELECT title FROM movies");
	$mov_num = mysql_num_rows($result);
	$arr = array();
	for($i = 0; $i < $mov_num; $i++) {
		$mov = mysql_result($result, $i, 0);
		$result1 = $db->getData("SELECT COUNT(*) FROM movies INNER JOIN movies_rentals ON movies.id_movie=movies_rentals.id_movie WHERE title='$mov'");
		$arr[$mov] = mysql_result($result1, 0, 0);
	}
	arsort($arr);
	if($mov_num < 5) {
		for($i = 0; $i < $mov_num; $i++) {
			echo "<li><a href='movie_page.php?data=".key($arr)."'>".key($arr)."</a></li>";
			next($arr);
		}
	} else {
		for($i = 0; $i < 5; $i++) {
			echo "<li><a href='movie_page.php?data=".key($arr)."'>".key($arr)."</a></li>";
			next($arr);
		}
	}
?>
				</ol>
			</tr>
		</table>
	</body>
</html>