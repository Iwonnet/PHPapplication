<?php 

	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Panel admina</title>
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
			<a>Panel admina!</a>
					<?php 
					/*
					 * jeżeli zmienna sesyjna blad jest aktywna to wyswietli blad
					 */
						if(isset($_SESSION['blad'])) 
						{
							echo $_SESSION['blad'];
						}
						echo "<br>"."<br>";
						
					?>
					<form class="col-12" action="adminpanel.php" method="post">
							<div class="form-group">
								<i class="fas fa-users"></i><input class="form-control" type="text" name="useradmin" placeholder="Wprowadź login"/>
							</div>
							<div class="form-group">
								<i class="fas fa-lock"></i><input class="form-control" type="password" name="passwordadmin" placeholder="Wprowadź hasło" />
							</div>
							
							<button type="submit" value="Zaloguj sie" class="btn" /><i class="fas fa-sign-in-alt"></i>Zaloguj</button>
							
					</form>
				</div>
				
		</div>
	</div>
</div>

<div class="text-center">
	<a href="index.php"  class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Wróć do strony użytkownika</a>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>