<?php 

	session_start();
	/*
	if((isset($_SESSION['logged'])) && ($_SESSION['logged']=true))
	{
		header('Location:stronaglowna.php');
		
		exit();
	*/
	/*
		 * Linia poniżej natychmiast wykonuje kod wykonany powyzej aby nie ładować reszty pliku niepotrzebnie
		 */

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Hello world!</title>
<style>

</style>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">	
<link rel="stylesheet" type="text/css" href="Style/style.css" >
<link rel="stylesheet" type="text/css" href="Style/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="Style/fontawesome.min.css" >
<link rel="stylesheet" type="text/css" href="Style/solid.css" >

</head>
<body>


<div class="modal-dialog text-center">
	<div class="col-sm-8 main-section">
		<div class="modal-content">
			<div class="col-12 user-img" >
				<img src="img/face.png">
			</div>
					<?php 
					/*
					 * jeżeli zmienna sesyjna blad jest aktywna to wyswietli blad
					 */
						if(isset($_SESSION['blad'])) 
						{
							echo $_SESSION['blad'];
						}
						echo "<br>"."<br>";
						
						echo date('Y-m-d H:i:s')."<br>";
					?>
				<form class="col-12" action="panel.php" method="post">
					<div class="form-group">
						<i class="fas fa-users"></i><input class="form-control" type="text" name="login" placeholder="Wprowadź e-mail *"/>
					</div>
					<div class="form-group">
						<i class="fas fa-lock"></i><input class="form-control" type="password" name="password" placeholder="Wprowadź hasło *" />
					</div>
					
					<button type="submit" value="Zaloguj sie" class="btn" /><i class="fas fa-sign-in-alt"></i>Zaloguj</button>
					
				</form>
				
		</div>
	</div>
</div>

	<div class="text-center">
		<a href="rejestracja.php"  class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Rejestracja na studia</a>
	    <a href="adminindex.php"  class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Panel admina</a>
	</div>
	
<?php 
/*
 * jeżeli zmienna sesyjna blad jest aktywna to wyswietli blad
 */
	if(isset($_SESSION['blad'])) 
	{
		echo $_SESSION['blad'];
	}
	
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>