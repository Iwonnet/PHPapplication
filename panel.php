<?php
	session_start();
	if((!isset($_POST['login']))||(!isset($_POST['password'])))
	{
		header('Location:index.php');
		exit();
	}
	
	require_once 'connect.php';
	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else 
	{
		$login = $_POST['login'];
		$haslo = $_POST['password'];
		/*Przepuszczamy zmienne przez encje,
		 * encje html'a - zastepuja niektóre znaki które przeglądarka zrozumie 
		 * jednocześnie wie że nie są częścią kodu źródłowego.
		 * ENT_QUOTES zamienia także apostrofy i cudzysłowie na encje
		 * dodatkowo zminna sql usuwamy i wstawiamy zapytanie do if'a 
		 * gdzie wstawiamy do funkcji sprintf jak ponizej.
		 * Zapytanie może być bez sprintf' a ale wtedy łaczymy linijki za pomoca kropki = konkatenacji (nieczytelnykod, brzydkowyglada)
		 * %s oznacza że jest to łańcuch znaków, kolejność jest odpowiednia imie-1 i haslo-2
		 */
		$login = htmlentities($login,ENT_QUOTES,"UTF-8");
		
		
		
	//	$sql = "SELECT *FROM student WHERE imie='$login' AND haslo='$haslo' które po wprowadzeniu funkcji haszujacej nie jest narazone na sql inj.";
		
		if($result = @$connection -> query(
		sprintf("SELECT *FROM student WHERE email='%s'",
		mysqli_real_escape_string($connection,$login))))
		{
			$userquantity = $result->num_rows;
			if($userquantity>0)
			{
				$row = $result->fetch_assoc();
				/*
				 * Funkcja password_verify zwróci wartość true oznacza iż hase sa identyczne
				 */
				if(password_verify($haslo,$row['haslo']))
				{
					$_SESSION['logged']=true;
					$_SESSION['login'] = $row['email'];
				
					/*
					 * na wszelki wypadek usuwamy zmienna sesyjna gdy nie ma potrzeby aby istniała
					 * unset - zniszcz
				 	*/
					unset($_SESSION['blad']);
					$result->free_result();
				
					header('Location:userglowna.php');
				}else 
				{
					$_SESSION['blad']='<span style="color:red"> Nieprawidłowy login lub hasło!</span>';
					header('Location:index.php');
				}
				
			
				
			}else 
			{
				$_SESSION['blad']='<span style="color:red"> Nieprawidłowy login lub hasło!</span>';
				header('Location:index.php');
			}
		}
		
		
		$connection->close();
	}

	
?>