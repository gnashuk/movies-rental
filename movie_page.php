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
	echo "<div align='right'>Loged in as "
		.$_SESSION['user']
		."<p><a href='logout.php'>log out</a></p></div>";
}
?>
<html>
	<head>
		<style>
			table {
				table-layout: fixed;
				margin: 30px;
			}
			/*th, td {
   				overflow: hidden;
    			width: 300px;
			}*/
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
<?php
	include "DBadapter.php";
	$name = $_GET['data'];
	$_SESSION['movie'] = $name;
	$movie = $_SESSION['movie'];
	$db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
	$db->connect();
	$result = $db->getData("SELECT cover, title, genre, country, year, director, description, id_movie, price  FROM movies WHERE title='$name'");
	$result1 = $db->getData("SELECT first_name, last_name FROM movies INNER JOIN (movies_actors INNER JOIN actors ON movies_actors.id_actor=actors.id_actor) ON movies.id_movie=movies_actors.id_movie WHERE title='$name'");
	echo "<h3>".mysql_result($result, 0, 1)."</h3>";
	echo "<td><img src='".mysql_result($result, 0, 0)."' width='214' height='318'></td>";
	echo "<td style='width: 400px; vertical-align: top;'><b>Genre: </b>".mysql_result($result, 0, 2)."<br><b>Country: </b>".mysql_result($result, 0, 3)."<br><b>Year: </b>".mysql_result($result, 0, 4)."<br><b>Director: </b>".mysql_result($result, 0, 5)."<br>";
	echo "<b>Actors: </b>";
	for($i = 0; $i < mysql_num_rows($result1) - 1; $i++) {
		echo mysql_result($result1, $i, 0)." ".mysql_result($result1, $i, 1).", ";
	}
	echo mysql_result($result1, mysql_num_rows($result1) - 1, 0)." ".mysql_result($result1, mysql_num_rows($result1) - 1, 1); 
	echo "<p><b>Description: </b>".mysql_result($result, 0, 6)."</p></td>";
	$email = $_SESSION['email'];
	$result2 = $db->getData("SELECT user_email, title FROM (users INNER JOIN users_rentals ON users.id_user=users_rentals.id_user) INNER JOIN (movies INNER JOIN (movies_rentals INNER JOIN rentals ON movies_rentals.id_rental=rentals.id_rental) ON movies.id_movie=movies_rentals.id_movie) ON users_rentals.id_rental=rentals.id_rental WHERE title='$movie' AND user_email='$email'");
	echo mysql_result($result2, 0, 1);
	if(mysql_num_rows($result2) > 0) {
		echo "<td style='width: 400px; text-align: right; vertical-align: top;''>".mysql_result($result, 0, 8)." €/day<br><button class='btn btn-primary btn-lg' disabled='disabled'>Borrow</button></a>";
		echo "<br>You are currently renting this movie";
	} else {
		echo "<td style='width: 400px; text-align: right; vertical-align: top;''>".mysql_result($result, 0, 8)." €/day<br><a href='confirmation.php'><button class='btn btn-primary btn-lg'>Borrow</button></a>";
	}
	if($_SESSION['alert'] == 'true') {
		echo "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>Log in to proceed</div>";
		$_SESSION['alert'] = 'false';
	}
	echo "</td>";
?>
			</tr>
		</table>
<?php
	echo "<div class='container'>
				<h2>User reviews</h2>";
	if(isset($_SESSION['log'])) {
		echo "<form name='form1' method='post' action='script.php'>
    			<div class='form-group'>
      				<label for='comment'>Write your review</label>
      				<textarea class='form-control' rows='5' name='comment'></textarea>
      				<input type='submit' name='submit' value='Submit'>
    			</div>
  				</form>";
	}

	$reviews = $db->getData("SELECT author, review_date, review_text FROM movies INNER JOIN reviews ON movies.id_movie=reviews.id_movie WHERE title='$name'");
	if(mysql_num_rows($reviews) > 0) {
		for($i = 0; $i < mysql_num_rows($reviews); $i++) {
			echo "<b>".mysql_result($reviews, $i, 0)." | ".mysql_result($reviews, $i, 1)."</b><p>".mysql_result($reviews, $i, 2)."</p>";
		}
	} else {
		echo "<p><i>No reviews written for this film.</i></p>";
	}
	echo "</div>";
?>
	</body>
</html>