<?php
	require 'Database_Functions.php';
	if(User_exists($db,$_POST['username'])=='0'){
		session_start();
		$_SESSION['nameerror']=1;
		header("Location: ../index.php");
		exit();
	}
	else
	{
		if(Get_password($db,$_POST['username'])!=$_POST['Password'])
		{
			session_start();
			//echo Get_password($db,$_POST['username']);
			$_SESSION['passerror']=1;
			header("Location: ../index.php");
			exit();
		}
		else
		{
			session_start();
			$_SESSION['username']=$_POST['username'];
			header("Location: Chat_Page.php");
			exit();
		}
	}
?>