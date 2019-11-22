<?php
	session_start();
	
	$adminlogin="admin";
	$adminpassword="admin";
	
	$loginad=$_POST['useradmin'];
	$passwordad=$_POST['passwordadmin'];
	if(($loginad==$adminlogin)||($passwordad==$adminpassword))
	{
		require_once 'connect.php';
		$connection = @new mysqli($host,$db_user,$db_password,$db_name);
		if($connection->connect_errno!=0)
		{
			echo "Error: ".$connection->connect_errno;
		}
		else 
		{
			$_SESSION['logged']=true;
			$_SESSION['login']=$adminlogin;
			header('Location:stronaglowna.php');
		}
	}
?>