<?php
	require 'Database_Functions.php';
	session_start();
	//$db=Connect_db();
	if(User_exists($db,$_POST['username'])=='1'){
		$_SESSION['usererror']=1;
		header("Location: Sign_Up.php");
		exit();
	}
	else{
		//echo "string";
		//echo $userfilename;
		$creds->firstname=$_POST['firstname'];
		$creds->lastname=$_POST['lastname'];
		$creds->username=$_POST['username'];
		$creds->email=$_POST['email'];
		$creds->password=$_POST['Password'];
		Add_user($db,$creds);
		$_SESSION['username']=$_POST['username'];
		header("Location: Chat_Page.php");
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