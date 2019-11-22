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

<style>
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="Style/glowny.css" >

</head>
<body>
<div class="jumbotron text-center">
  <h1>Witaj na studiach!</h1><br>
  
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
        <a class="nav-link" href="stronaglowna.php">Powrót</a>
      </li>
    </ul>
    
  </div>
</nav>
<br><br>

<form  action="#" method="post" enctype="multipart/form-data">
  <div class="form-group" >
    <label for="exampleFormControlFile1">Dodaj plik:</label>
    <input type="file" class="form-control-file" name="fileinput" id="exampleFormControlFile1">
  </div>
 <button type="submit" name="wyslij" class="btn btn-success">Submit</button>
</form>

<?php 
require_once 'connect.php';

if(isset($_POST['wyslij']))
{
	$allow=array('pdf');
	$temp=explode(".",$_FILES['fileinput']['name']);
	$extension=end($temp);
	$upload_file=$_FILES['fileinput']['name'];
	move_uploaded_file($_FILES['fileinput']['tmp_name'], "uploads/".$_FILES['fileinput']['name']);
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$qry=mysqli_query($conn,"INSERT INTO files (`file`)VALUES('".$upload_file."');");
	if($qry){
		echo "<b>PDF file input SUCCESS</b>";
	}else {
		echo "Upload error!";
	}
	$conn->close();
}

?>

<br><br><br>
<a href="logout.php" class="btn btn-success">[Wyloguj się!]</a>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>