<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>
	<body>
<?php
  session_start();
  $user = $_SESSION['user'];
  $email = $_SESSION['email'];
  include "DBadapter.php";
  $db = new DBadapter("10.254.94.2", "s172905", "s172905", "JDfGNBwt");
  $db->connect();
  $result = $db->getData("SELECT title, rent_date, rent_end_date FROM (users INNER JOIN users_rentals ON users.id_user=users_rentals.id_user) INNER JOIN (movies INNER JOIN (movies_rentals INNER JOIN rentals ON movies_rentals.id_rental=rentals.id_rental) ON movies.id_movie=movies_rentals.id_movie) ON users_rentals.id_rental=rentals.id_rental WHERE user_email='$email'");
  $today = date("Y-m-d");
  echo "<h2>".$user."<h2>";
  $row_num = mysql_num_rows($result);
  if($row_num > 0) {
  echo "<div><table class='table table-striped'>
      <caption>Currently rented movies</caption>
      <thead>
        <tr>
          <th>#</th>
          <th>Movie title</th>
          <th>Rent date</th>
          <th>Due date</th>
          <th>Stream</th>
        </tr>
      </thead>
      <tbody>";
    $count = 1;
    for($i = 0; $i < $row_num; $i++) {
      $title = mysql_result($result, $i, 0);
      $rent_date = mysql_result($result, $i, 1);
      $end_date = mysql_result($result, $i, 2);
      if(strtotime($today) < strtotime($end_date)) {
        echo "<tr>
          <th scope='row'>".$count."</th>
          <td><a href='movie_page.php?data=".$title."'>".$title."</a></td>
          <td>".$rent_date."</td>
          <td>".$end_date."</td>
          <td><a href='player.php?data=".$title."'>watch now</a></td>
        </tr>";
        $count++;
      }

    }
    echo "</tbody>
    </table><div>";
  } else {
    echo "<p><i>No rented movies</i></p>";
  } 
?>
	</body>
</html>