<html>
	<head>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="../main.css">

	</head>
	<body>
		<h1>Sign Up</h1>
		<?php
			session_start();
			if($_SESSION['usererror']==1)
			{
				$_SESSION['usererror']=0;
				echo "<p>Username already exists. Try a new username.</p>";
			}
		?>
		<h2>
			<form method="POST" action="Add_User.php" style="float: left;">
			Enter Details:<br><br>
			First Name:
			<input type="text" placeholder ="Ankit" name="firstname"><br><br>
			Last Name:
			<input type="text" placeholder="Tripathi" name="lastname"><br><br>
			E-mail ID:
			<input type="text" placeholder="ankitmani.t@somaiya.edu" name="email"><br><br>
			Username:
			<input type="text" placeholder="Ankit_22" name="username"><br><br>
			Password:
			<input type="Password" name="Password"><br><br>
			Confirm:
			<input type="Password" name="Conf_Password"><br><br>
			<input class="login" type="submit" name="Login" value="Login">
			</form>
		</h2>
	</body>
</html>