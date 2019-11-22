<?php 

	session_start();

	/*
	 * Instrukcja ponizej uniemozliwa niezalogowanym 
	 * uzytkownikom wejsc bezposrednio do glownej strony
	 * !isset - jeżeli nie jest aktywna zmienna sesyjna 'logged'
	 */
	if(!isset($_SESSION['logged']))
	{
		header('Location:index.php');
		exit();
	}
	/*
	if(isset($_POST['uzytkownicy'])){
	
	*/
	
	

?>

<!DOCTYPE HTML>

<html lang="pl">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>strona główna</title>
<style>

</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="Style/glowny.css" >

</head>
<body>
<div class="jumbotron text-center">
<h1>Witaj na studiach!</h1>
<p>Programowanie aplikacji webowych</p><br>
</div>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark" >
  <a class="navbar-brand" >
  <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
    PAW AGH
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="userglowna.php">Powrót</a>
      </li>
    </ul>
    
  </div>
</nav>
<br><br>
<div class="container">
<?php 
require_once 'connect.php';

	//Wydobywanie danyc z bazy danych po kliknieciu przycisku
	
	// Create connection
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	
	// Check connection
	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}	
	$sql = "SELECT file FROM files;" ;
	$result = $conn->query($sql);
	
	
		if ($result->num_rows > 0) {
    		echo '<table class="table table-hover"><tr><th>Pliki</th><th></th></tr>';
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		       echo '<tr><th scope="row">' . $row["file"]. '</th><th><a href="uploads/""'.$row["file"].'">Pobierz</a></th></tr>';
		       
		    }
		    echo "</table>";
		} else {
		    echo "0 results";
		}

	$conn->close();



?>

</div>









<br><br><br>
<a href="logout.php" class="btn btn-success">[Wyloguj się!]</a>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>