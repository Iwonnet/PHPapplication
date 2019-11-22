<?php 
	session_start();
	/*
	 * isset $_post czyli: czy jest aktywna ? Dopiero po nacisnieciu submit!
	 * Walidacja!!!
	 */
	
	
	if(isset($_POST['imie1']))
	{
		$validationstatus=true;
		$miasto=$_POST['miasto'];
		$adres=$_POST['adres'];
		$pesel=$_POST['pesel'];
		
		//Imie - Walidacja
		$imie1=$_POST['imie1'];
		//sprawdzenie dlugosci imienia i czy składa się tylko ze liter(preg_match)
		if((strlen($imie1)<3)||(strlen($imie1)>20)||(!preg_match("/^[a-zA-Z ]*$/",$imie1)))
		{
			$validationstatus=false;
			$_SESSION['e_imie1']="Imię musi posiadać od 3 do 20 znaków i składać się tylko z liter bez polskich znaków!";
		}
		
		//EMAIL - walidacja
		$email=$_POST['email'];
		$emailsafe=filter_var($email,FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailsafe,FILTER_VALIDATE_EMAIL)==false)||($emailsafe!=$email))
		{
			$validationstatus=false;
			$_SESSION['e_email']="podaj poprawny adres email";
		}
		
		//Nazwisko - walidacja
		$nazwisko=$_POST['nazwisko'];
		//sprawdzenie dlugosci imienia i czy składa się tylko ze liter(preg_match)
		if((strlen($nazwisko)<3)||(strlen($nazwisko)>20)||(!preg_match("/^[a-zA-Z ]*$/",$nazwisko)))
		{
			$validationstatus=false;
			$_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 20 znaków i składać się tylko z liter";
		}
		//Hasło - walidacja
		$haslo1=$_POST['haslo1'];
		$haslo2=$_POST['haslo2'];
		if((strlen($haslo1)<8)||(strlen($haslo2)>20))
		{
			$validationstatus=false;
			$_SESSION['e_haslo']="Hasło powinno mieć nie mniej niż 8 i nie wiecej niz 20 znaków!";
		}
		
		if($haslo1!=$haslo2)
		{
			$validationstatus=false;
			$_SESSION['e_haslo1']="Hasła nie są identyczne!";
			
		}
		//Walidacja-PESEL
		$pesel=$_POST['pesel'];
		
		if(!is_numeric($pesel) || strlen($pesel)!=11)
		{
			$validationstatus=false;
			$_SESSION['e_pesel']="Wpisz poprawny pesel!";
		}
		
		
		
		//Haszowanie hasla
		$haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT);
		
		//REGULAMIN - walidacja
		if(!isset($_POST['regulamin']))
		{
			$validationstatus=false;
			$_SESSION['e_regulamin']="Wymagana akceptacja regulaminu!";
		}
		//Sprawdzenie czy uzytkownik jest juz w bazie
		require_once 'connect.php';
		//linijka kodu który mówi php aby nie rzucał Warning z informacjami tylko korzystał  z wyjątków
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		//wyswietlenie czasu (bez odswieżenia)
		$date = date('Y-m-d H:i:s')."<br>";
		
		
		//Polaczenie z baza
		try 
		{
			$connection = new mysqli($host,$db_user,$db_password,$db_name);
			if($connection->connect_errno!=0)
			{
				//wyjątek przy próbie połaczenia z bazą danych
				throw new Exception(mysqli_connect_errno());
			}
			else 
			{
				//Walidacja , email powinien być unikatowy
				$result = $connection->query("SELECT id FROM student WHERE email='$email'");
				//Wyjątek gdyby nie udało sie nawiazac polaczenia
				if(!$result) throw new Exception($connection->error);
				
				$howmanyusers = $result->num_rows;
				if($howmanyusers>0)
				{
					$validationstatus=false;
					$_SESSION['e_email']="Istnieje już użytkownik z takim emailem";
				}
				
				if($validationstatus==true)
				{
					//Wszystkie kroki walidacji zostały zaakceptowane !
					if($connection->query("INSERT INTO student VALUES(NULL,'$imie1','$nazwisko','$haslo_hash','$email',0)")&&
					//użycie funkcji do wstawiania id jako klucza obcego do tabeli adres
					($i=mysqli_insert_id($connection))&&
					($connection->query("INSERT INTO adres (`miasto`, `adres`, `pesel`,`student_id`,`tresc`) VALUES('$miasto','$adres','$pesel','$i','')")))
					{
						$_SESSION['rejestrationsuccessful']=true;
						header('Location:welcome.php');
						
					}
					else 
					{
						throw new Exception($connection->error);
					}
				}
				
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera!</span>';
			echo '<br /> Informacja deweloperska: '.$e;
		}
		
			
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>załóż konto</title>

<style>

</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="Style/stylerejestracja.css" >

</head>
<body>
<div class="container" >
	<form method="post" class="form">
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="TwojeImię">Imię</label>
				<input type="text" class="form-control" id="przykladoweImie" aria-describedby="podpowiedzImię" name="imie1" placeholder="Wpisz Imię">
					<?php 
						/*
						* Jeżeli zmienna sesyjna e_imie1 jest aktywna to wykonaj 
						* instrukcje if
						*/
						if(isset($_SESSION['e_imie1']))
						{
							echo '<div class="error">'.$_SESSION['e_imie1'].'</div>';
							unset($_SESSION['e_imie1']);
						}
					?>
			</div>
			<div class="form-group col-md-6">
					<label for="TwojeNazwisko">Nazwisko</label>			
					<input type="text" class="form-control" aria-describedby="podpowiedzImię" name="nazwisko" placeholder="Wpisz nazwisko" >
					<?php 
						/*
						 * Jeżeli zmienna sesyjna e_imie1 jest aktywna to wykonaj 
						 * instrukcje if
						 */
						if(isset($_SESSION['e_nazwisko']))
						{
							echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
							unset($_SESSION['e_nazwisko']);
							
						}
					?>
			</div>
	</div>
		<div class="form-row">			
			<div class="form-group col-md-4">
					<label for="TwojeNazwisko">e-mail</label>				
					<input type="email" class="form-control" id="przykladowyEmail" aria-describedby="podpowiedzEmail" name="email" placeholder="Wpisz e-mail">
					<small id="warunkiHasla" class="form-text text-warning">
				      E-mail będzie potrzebny do logowania na stronę.
				    </small>
					<?php 
					/*
					 * Jeżeli zmienna sesyjna e_imie1 jest aktywna to wykonaj 
					 * instrukcje if
					 */
					if(isset($_SESSION['e_email']))
					{
						echo '<div class="error">'.$_SESSION['e_email'].'</div>';
						unset($_SESSION['e_email']);
						
					}
					?>
			</div>
			<div class="form-group col-md-4">
					<label for="TwojeHaslo">Hasło</label>
					<input type="password" name="haslo1" class="form-control" id="przykladoweHaslo" placeholder="Wpisz hasło" >
					<small id="warunkiHasla" class="form-text text-warning">
				      Hasło powinno mieć co najmniej 8 znaków, zawierać jedną dużą literę i jeden znak specjalny.
				    </small>
					<?php 
					
					if(isset($_SESSION['e_haslo']))
					{
						echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
						unset($_SESSION['e_haslo']);
						
					}
					?>
			</div>
			<div class="form-group col-md-4">
					<label for="TwojeHaslo">Hasło</label>
					<input type="password" name="haslo2" class="form-control" id="przykladoweHaslo" placeholder="Powtórz hasło" >
					<small id="warunkiHasla" class="form-text text-warning">
				      Hasła powinny być identyczne.
				    </small>
					<?php 
					
					if(isset($_SESSION['e_haslo1']))
					{
						echo '<div class="error">'.$_SESSION['e_haslo1'].'</div>';
						unset($_SESSION['e_haslo1']);
						
					}
					?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-4">
					<label for="TwojeHaslo">Miasto</label>
					<input type="text" name="miasto" class="form-control" id="przykladoweMiasto" placeholder="Wpisz miasto" >
			</div>
			<div class="form-group col-md-4">
					<label for="TwojAdres">Adres</label>
					<input type="text" name="adres" class="form-control" id="przykladowyAdres" placeholder="Wpisz ulicę , numer domu i mieszkania" >
			</div>
			<div class="form-group col-md-4">
					<label for="TwojNumer Pesel">Pesel</label>
					<input type="text" name="pesel" class="form-control" id="przykladowyAdres" placeholder="Wpisz pesel" >
					<small id="warunkiHasla" class="form-text text-warning">
				      Pesel powinien składać się z 11 cyfr.
				    </small>
					<?php 
					
					if(isset($_SESSION['e_pesel']))
					{
						echo '<div class="error">'.$_SESSION['e_pesel'].'</div>';
						unset($_SESSION['e_pesel']);
						
					}
					?>
			</div>
		</div>
			<div class="form-check">
						 
					 	<input type="checkbox" name="regulamin" class="form-check-input" id="przykladowyCheckbox">
					 	<label class="form-check-label" for="przykladowyCheckbox">Potwierdź akceptację regulaminu studiów!</label>
					 
					<?php 
						if(isset($_SESSION['e_regulamin']))
						{
							echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
							unset($_SESSION['e_regulamin']);
						}
					?>
			</div>
				<button type="submit" class="btn btn-secondary" value="Zarejestruj się" >Zarejestruj się</button>
	 	
 		</form>
 	</div>
 	<div class="text-center">
		<a href="index.php"  class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Powrót do strony logowania</a>
	</div>
 
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>