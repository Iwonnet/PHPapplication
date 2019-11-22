<?php 
session_start();
	if(!isset($_SESSION['logged']))
	{
		header('Location:index.php');
		exit();
	}
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
        <a class="nav-link" href="kontakt.php">Kontakt <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="ogloszenia.php">Ogłoszenia</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="materialy.php" role="button" >Przydatne materiały</a>
      </li>
      
      <div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    Panel studenta
		</button>
		
			<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			<form method="post">
				<input class="dropdown-item" name="loadstatus" type="submit" value="Status">
				<input class="dropdown-item" name="loadadress" type="submit" value="Dane adresowe">
			</form>
			</div>
	</div>
	</ul>
   </div>
   
</nav>
<br><br>
<?php 
  	require_once 'connect.php';
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql="SELECT * FROM student WHERE email = '".$_SESSION['login']."'";
	$result = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_array($result)) {
	 echo '<p>Witaj '. $row['imie'] . " !</p";
    }$conn->close();
?>
<br><br><br>

<?php 

if(isset($_POST['loadstatus'])){
	require_once 'connect.php';
	//Wydobywanie danyc z bazy danych po kliknieciu przycisku
	
	// Create connection
	$conn = @new mysqli($host,$db_user, $db_password, $db_name);
	if($conn->connect_errno!=0)
		{
			//wyjątek przy próbie połaczenia z bazą danych
			throw new Exception(mysqli_connect_errno());
		}
		else 
		{
			//Zapytanie do mysql o konkretna osobę
			$result = $conn->query("SELECT oplata FROM student WHERE email='".$_SESSION['login']."'");
			//Wyjątek gdyby nie udało sie nawiazac polaczenia
			if(!$result) throw new Exception($connection->error);
				
				
			$row=$result->fetch_assoc();
			$id = intval($row['oplata']);
			if($id==3000)
			{
				$studentstatus='<p class="textstatus"> Twoje należności za studia zostały uregulowane</p>'.'<p class="textstatus"<br><b>Zapraszamy na zajęcia</b>';
				echo $studentstatus;
			}
			else 
			{
				$studentstatus='<p class="textstatus">Ureguluj należności</p>';
				echo $studentstatus;
			}
		}
	$conn->close();
	}
?>
<?php 
if(isset($_POST['loadadress'])){
require_once 'connect.php';
	
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}	
	$sql = "SELECT miasto,adres,pesel FROM adres INNER JOIN student ON student.id=adres.student_id WHERE email='".$_SESSION['login']."'; " ;
	$result = $conn->query($sql);
	
	
		if ($result->num_rows > 0) {
    		echo '<table class="table table-hover tabela"><tr><th>Miasto</th><th>Adres</th><th>Pesel</th></tr>';
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		       echo '<tr><th scope="row">' . $row["miasto"]. "</th><td>" . $row["adres"]. "</td><td>" . $row["pesel"]. "</td></tr>";
		       
		    }
		    echo "</table>".
		    	'
		    
			<form class="form-inline" method="post">
			  <div class="form-group mx-sm-3 mb-2">
			    <input type="text" class="form-control" id="inputPassword2" name="aktualizujmiasto" placeholder="Tutaj wpisz nowe miasto">
			  </div>
			  <button type="submit" class="btn btn-success mb-2">Aktualizuj</button>
			</form>
			
			<form class="form-inline" method="post">
			  <div class="form-group mx-sm-3 mb-2">
			    <input type="text" class="form-control" id="inputPassword2" name="aktualizujadres" placeholder="Tutaj wpisz nowy adres">
			  </div>
			  <button type="submit" class="btn btn-success mb-2">Aktualizuj</button>
			</form>
			
			<form class="form-inline" method="post">
			  <div class="form-group mx-sm-3 mb-2">
			    <input type="text" class="form-control" id="inputPassword2" name="aktualizujpesel" placeholder="Tutaj wpisz nowy pesel">
			  </div>
			  <button type="submit" class="btn btn-success mb-2">Aktualizuj</button>
			</form>
			   ';
		} else {
		    echo "0 results";
		}
$conn->close();
}
?>
<?php 
if(isset($_POST['aktualizujmiasto']))
{
	$miasto1=$_POST['aktualizujmiasto'];
	if((strlen($miasto1)<3)||(strlen($miasto1)>20)||(!preg_match("/^[a-zA-Z ]*$/",$miasto1)))
	{
		$_SESSION['e_miasto1']="Nazwa miasta powina posiadać od 3 do 20 znaków i składać się tylko z liter bez polskich znaków!";
	}else 
	{
	require_once 'connect.php';
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}	
	$sql = "UPDATE adres INNER JOIN student ON student.id=adres.student_id SET miasto='".$_POST['aktualizujmiasto']."' WHERE email='".$_SESSION['login']."'; " ;
	$result = $conn->query($sql);
	$conn->close();
		}
}
if(isset($_POST['aktualizujadres']))
{
	require_once 'connect.php';
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}	
	$sql = "UPDATE adres INNER JOIN student ON student.id=adres.student_id SET adres='".$_POST['aktualizujadres']."' WHERE email='".$_SESSION['login']."'; " ;
	$result = $conn->query($sql);
	$conn->close();
}
if(isset($_POST['aktualizujpesel']))
{
	$aktualizujpesel=$_POST['aktualizujpesel'];
	if(!is_numeric($aktualizujpesel) || strlen($aktualizujpesel)!=11){
		$_SESSION['e_pesel']="Wpisz poprawny pesel!";
	}else{
	require_once 'connect.php';
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}	
	$sql = "UPDATE adres INNER JOIN student ON student.id=adres.student_id SET pesel='".$_POST['aktualizujpesel']."' WHERE email='".$_SESSION['login']."'; " ;
	$result = $conn->query($sql);
	$conn->close();
	}
}
?>
<br>
<?php 
if(isset($_SESSION['e_pesel']))
					{
						echo '<div class="error">'.$_SESSION['e_pesel'].'</div>';
						unset($_SESSION['e_pesel']);
					}
if(isset($_SESSION['e_miasto1']))
					{
						echo '<div class="error">'.$_SESSION['e_miasto1'].'</div>';
						unset($_SESSION['e_miasto1']);
					}
?>
<br><br><br>
<a href="logout.php" class="btn btn-success">[Wyloguj się!]</a>

<div id="map" ></div>
<script src="js/google-map.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>