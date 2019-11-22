<?php 

	session_start();
	
	if(!isset($_SESSION['rejestrationsuccessful'])) 
	{
		header('Location:index.php');
		exit();
	}
	else 
	{
		unset ($_SESSION['rejestrationsuccessful']);
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body>
<a href="index.php" class="btn btn-dark">Wróć do strony logowania!</a>
<br/><br/>
<a>Gratulacje udało ci się założyć nowe konto!</a>
<?php 
/*
 * jeżeli zmienna sesyjna blad jest aktywna to wyswietli blad
 */
	if(isset($_SESSION['blad'])) 
	{
		echo $_SESSION['blad'];
	}
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>