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
	
	
//funkcja pobierajaca dane z bazy danych plus biblioteka tcpdf do tworzenia i pobierania pdf ze strony	
function fetch_data ()
{
	require_once 'connect.php';
	$output="";
	$connect = @mysqli_connect($host,$db_user,$db_password,$db_name);
	$sql1 = "SELECT id,imie,nazwisko,email,oplata FROM student; ";
	$resultat = mysqli_query($connect,$sql1);
	while($row=mysqli_fetch_array($resultat))
	{
		
		$output .='<tr>
					<td>'.$row["id"].'</td>
					<td>'.$row["imie"].'</td>
					<td>'.$row["nazwisko"].'</td>
					<td>'.$row["email"].'</td>
					<td>'.$row["oplata"].'</td>
					</tr>';
	}
	return $output;
}
if(isset($_POST['generatepdf']))
{
	require_once 'tcpdf/tcpdf.php';
	$obj_pdf = new TCPDF ('p', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8',false );
	$obj_pdf->SetCreator(PDF_CREATOR);
	$obj_pdf->SetTitle("GeneratePDF");
	$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 11);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h4 align="center">Generate Table to PDF</h4><br /> 
      <table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                <th width="5%">Id</th>  
                <th width="25%">Imie</th>  
                <th width="15%">Nazwisko</th>  
                <th width="40%">Email</th>
                <th width="15%">Oplata</th>  
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('file.pdf', 'I');
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>strona główna</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="Style/glowny.css" >
</head>
<body>
<div class="jumbotron text-center">
  <h1>Panel administratora!</h1>
  <p>Programowanie aplikacji webowych</p>
</div>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark" >
  <a class="navbar-brand" >
  <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
    PAW AGH
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

	  <a class="navbar-brand" href="dodajplik.php">Dodaj plik</a>
      </li>
      <div class="dropdown">
		  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    Lista studentów
		  </button>
			<form action="#" method="post">  
			  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			    <input class="dropdown-item" name="zaladujliste" type="submit" value="Lista studentów">
			    <input class="dropdown-item" name="schowajliste" type="submit" value="Schowaj listę">
			  </div>
			</div>
			</form>
			
		<div class="dropdown">
		  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    Lista studentów opłacone składki
		  </button>
			<form action="#" method="post">  
			  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			    <input class="dropdown-item" name="zaladujliste1" type="submit" value="Lista studentów">
			    <input class="dropdown-item" name="schowajliste1" type="submit" value="Schowaj listę">
			  </div>
			</div>
			</form>
			
			<div class="dropdown">
			  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Lista studentów brak opłaty
			  </button>
			<form action="#" method="post">  
			  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			    <input class="dropdown-item" name="zaladujliste2" type="submit" value="Lista studentów">
			    <input class="dropdown-item" name="schowajliste2" type="submit" value="Schowaj listę">
			  </div>
			</div>
			
			<div class="dropdown">
			  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Dodaj ogloszenie
			  </button>
			<form action="#" method="post">  
			  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			    <input class="dropdown-item" name="ogloszenie" type="submit" value="Ogłoszenia">
			  </div>
			 </div>
		</form>
   </ul>
  </div>
</nav>




<?php 
// button nr 1
if(isset($_POST['schowajliste'])){
	unset($_POST['zaladujliste']);
}

if(isset($_POST['zaladujliste'])){
require_once 'connect.php';
	//Wydobywanie danyc z bazy danych po kliknieciu przycisku
	
	// Create connection
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	
	// Check connection
	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}	
	$sql = "SELECT id,imie,nazwisko,email FROM student; ";
	$result = $conn->query($sql);
	
	
		if ($result->num_rows > 0) {
    		echo '<table class="table table-hover"><tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>E-mail</th></tr>';
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		       echo '<tr><th scope="row">' . $row["id"]. "</th><td>" . $row["imie"]. "</td><td>" . $row["nazwisko"]. "</td><td>".$row["email"]. "</td></tr>";
		       
		    }
		    echo "</table>";
		} else {
		    echo "0 results";
		}
$result->free();
$conn->close();
}
?>

<?php 
// button nr 2
if(isset($_POST['schowajliste1'])){
	unset($_POST['zaladujliste1']);
}

if(isset($_POST['zaladujliste1'])){
require_once 'connect.php';
	//Wydobywanie danyc z bazy danych po kliknieciu przycisku
	
	// Create connection
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	
	// Check connection
	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}	
	$sql = "SELECT id,imie,nazwisko,email,oplata FROM student WHERE oplata=3000; " ;
	$result = $conn->query($sql);
	
	
		if ($result->num_rows > 0) {
    		echo '<table class="table table-hover"><tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>E-mail</th><th>Opłata</th></tr>';
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		       echo '<tr><th scope="row">' . $row["id"]. "</th><td>" . $row["imie"]. "</td><td>" . $row["nazwisko"]. "</td><td>".$row["email"]. "</td><td>zapłacono</td></tr>";
		       
		    }
		    echo '<div class="col-md-12" align="right">
					<form method="post">  
					 <input type="submit" name="generatepdf" class="btn btn-success" value="Generate PDF" /> 
					</form>  
				</div>'."</table>";
		} else {
		    echo "0 results";
		}
$result->free();
$conn->close();
}
?>

<?php 
// button nr 3
if(isset($_POST['schowajliste2'])){
	unset($_POST['zaladujliste2']);
}

if(isset($_POST['zaladujliste2'])){
require_once 'connect.php';
	//Wydobywanie danyc z bazy danych po kliknieciu przycisku
	
	// Create connection
	$conn = new mysqli($host,$db_user, $db_password, $db_name);
	
	// Check connection
	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}	
	$sql = "SELECT id,imie,nazwisko,email,oplata FROM student WHERE oplata=0; " ;
	$result = $conn->query($sql);
	
	
		if ($result->num_rows > 0) {
    		echo '<table class="table table-hover"><tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>E-mail</th><th>Opłata</th></tr>';
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		       echo '<tr><th scope="row">' . $row["id"]. "</th><td>" . $row["imie"]. "</td><td>" . $row["nazwisko"]. "</td><td>".$row["email"]. "</td><td>brak opłaty</td></tr>";
		       
		    }
		    echo '<div class="col-md-12" align="right">
					<form method="post">  
					 <input type="submit" name="generatepdf" class="btn btn-success" value="Generate PDF" /> 
					</form>  
				</div>'."</table>";
		} else {
		    echo "0 results";
		}
$result->free();
$conn->close();
}
?>
<br>
<?php 
if(isset($_POST['ogloszenie'])){
	
	echo '
	<form method="post">
	  <div class="form-group">
	    <label for="exampleFormControlTextarea1">textarea</label>
	    <textarea class="form-control"  name="tresc" id="exampleFormControlTextarea1" rows="3"></textarea>
	  </div>
	  <input class="btn btn-success" name="dodajogloszenie" type="submit" value="Dodaj ogłoszenie">
	</form>';
}
	if(isset($_POST['dodajogloszenie'])){
	require_once 'connect.php';
	
		$text = $_POST['tresc'];
		$conn = new mysqli($host,$db_user, $db_password, $db_name);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}	
		$sql = "INSERT INTO ogloszenia (`info`) VALUES('$text')";
		if($result = $conn->query($sql)){
		echo "Ogloszenie dodano do bazy danych!";
		$conn->close();
		}
		else 
		{
			echo "Process has failed";
		}
	}
?>
<br><br><br>
<?php 
	date('d.m.Y H:i:s');
	echo '<a href="logout.php" class="btn btn-success" >[Wyloguj się!]</a>';
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>