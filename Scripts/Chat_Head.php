 <!DOCTYPE html>
 <html>
 <head>
  <meta http-equiv="refresh" content="2">
</head>
<body>
<?php
	require 'Database_Functions.php';
	session_start();
	if(!array_key_exists('username',$_SESSION))
	{
		header("Location: ../");
		exit();
	}
	echo "<link rel = 'stylesheet' type = 'text/css' href = '../chat.css'>";
	//echo $_SESSION['username'];
	Load_Chats_of($db,$_SESSION['username']);
?>
</body>
</html>