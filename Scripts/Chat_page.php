<?php
	if(!file_exists("../chats/".$_POST['username'])){
		session_start();
		$_SESSION['nameerror']=1;
		header("Location: ../index.php");
		exit();
	}
	else
	{
		$userfilename="../chats/".$_POST['username']."/.user_creds";
		$userfile = fopen($userfilename, "r") or die("Unable to open file!");
		$creds = json_decode(fread($userfile,filesize($userfilename)));
		if($creds->password!=$_POST['Password'])
		{
			session_start();
			$_SESSION['passerror']=1;
			header("Location: ../index.php");
			exit();
		}
		else
		{
			header("Location: ../Chat_Page.html");
			exit();
		}
	}
?>