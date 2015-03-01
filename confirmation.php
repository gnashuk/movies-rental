<?php
	session_start();
	if(!isset($_SESSION['log'])) {
		$_SESSION['alert'] = 'true';
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="/resources/demos/external/jquery-mousewheel/jquery.mousewheel.js"></script>
		<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script>
		 $(function() {
			$( "#spinner" ).spinner({
			spin: function( event, ui ) {
			if ( ui.value > 365 ) {
				$( this ).spinner( "value", 1 );
				return false;
			} else if ( ui.value < 1 ) {
				$( this ).spinner( "value", 1 );
				return false;
			}
		}
		});
		});
		</script>
	</head>
	<body>
		<h1>Rent this movie<h1>
<?php
	echo "<h3>".$_SESSION['movie']."</h3>";
?>
		<form name="form" method="post" action="checklogin.php">
			<p>
				<label for="spinner">Select duration of rent (in days):</label>
				<input id="spinner" name="duration" size="3" value="1">
			</p>
			<input type="submit" name="confirm" value="Confirm">
		</form>
	</body>
</html>