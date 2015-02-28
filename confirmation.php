<?php
	session_start();
	if(!isset($_SESSION['log'])) {
		$_SESSION['alert'] = 'true';
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>
<html>
	<head>
		<style>
		</style>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Rent this movie<h1>
<?php
	echo "<h3>".$_SESSION['movie']."</h3>";
?>
		<form name="form" method="post" action="confirm.php">
			Select rent duration (in days) <input type="text" id="days"><br>
			<input type="submit" name="submit" value="Confirm">
		</form>
	</body>
</html>