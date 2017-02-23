<?php
	session_start();
	if(file_exists("../chats/".$_POST['username'])){
		$_SESSION['usererror']=1;
		header("Location: Sign_Up.php");
		exit();
	}
	else{
		//echo "string";
		mkdir("../chats/".$_POST['username']."/");
		$userfilename="../chats/".$_POST['username']."/.user_creds";
		//echo $userfilename;
		$userfile = fopen($userfilename, "w") or die("Unable to open file!");
		$creds->firstname=$_POST['firstname'];
		$creds->lastname=$_POST['lastname'];
		$creds->username=$_POST['username'];
		$creds->password=$_POST['Password'];
		$creds->time=time();
		fwrite($userfile, json_encode($creds));
		fclose($userfile);
		header("Location: ../Chat_Page.html");
		exit();
		//echo "Done";
	}
	/*if(!isset($_COOKIE['user'])){
		echo "string";
		Cookie_name = "user";
		$cookie_value = $_POST['username'];
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
	}*/
?>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>