<?php
	/*Cookie_name = "user";
	$cookie_value = "John Doe";
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");*/
?>
<html>
	<?php
		/*if(!isset($_COOKIE["user"])) {
    		echo "Cookie named " . $cookie_name . " is not set!";
		} else {
    		echo "Cookie " . $cookie_name . " is set!<br>";
    		echo "Value is: " . $_COOKIE[$cookie_name];
			echo count($_COOKIE);
		}*/
	?>
	<head>
		<title>OurChatRoom</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body>
		<h1 align="center">Welcome to the chat room!</h1>
		<?php
			session_start();
			if($_SESSION['nameerror']==1)
			{
				$_SESSION['nameerror']=0;
				echo "<p>Username does not exist.</p>";
			}
			else if($_SESSION['passerror']==1)
			{
				$_SESSION['passerror']=0;
				echo "<p>Password does not match.</p>";
			}
			session_destroy();
		?>
		<h2><form method="POST" action="Scripts/Chat_page.php" style="float: left;">
			Log in:<br><br>
			Username:
			<input type="text" placeholder="Ankit_22" name="username"><br><br>
			Password:
			<input type="Password" name="Password"><br><br>
			<input class="login" type="submit" name="Login" value="Login">
			</form>
			<form action="Scripts/Sign_Up.php" style="float: right;">
				<input class="login" type="submit" name="signup" value="Sign Up">
			</form >
			</h2>
	</body>
</html>
