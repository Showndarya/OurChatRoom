<?php
	require 'Database_Functions.php';
	session_start();
	if(!array_key_exists('username',$_SESSION))
	{
		header("Location: ../");
		exit();
	}
	if(User_exists($db,$_POST['search'])=='1')
	{
		$_SESSION['userfound']=1;
		$_SESSION['chatusername']=$_POST['search'];
		header("Location: Chat_Page.php");
		exit();
	}
	else
	{
		$_SESSION['userfound']=-1;
		$_SESSION['chatusername']=null;
		header("Location: Chat_Page.php");
		exit();
	}
?>