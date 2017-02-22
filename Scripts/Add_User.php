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
		$creds="Firstname: ".$_POST['firstname']."\nLastname: ".$_POST['lastname']."\nUsername: ".$_POST['username']."\nPassword: ".$_POST['Password']."\nEmail: ".$_POST['email']."\nSign Up Date: ".time()."\n";
		fwrite($userfile, $creds);
		fclose($userfile);
		header("Location Chat_page.php");
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