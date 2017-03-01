<html>
	<head>
		<title>Chat</title>
		<link rel="stylesheet" type="text/css" href="../chat.css">
	</head>
	<body>
	<div class="container">
		<div class="top">
			<form action="Search_User.php" method="POST">
				Search: <input type="search" name="search">
				<input type="submit" name="submit" value="GO">
			</form>
		</div>
		<div class="left">
			<?php
				echo "<iframe name = 'theFrame' src='Chat_Head.php' frameborder='0' style='width:100%; height:100%;'></iframe>";
			?>
		</div>
		<div class="middle">
			<?php
				session_start();
				if(!array_key_exists('username',$_SESSION))
				{
					header("Location: ../");
					exit();
				}
				if($_SESSION['userfound']==1)
				{
					echo "<iframe name = 'theFrame' src='Chat_Div.php' frameborder='0' style='width:100%; height:100%;'></iframe>";
				}
				else if($_SESSION['userfound']==-1)
				{
					$_SESSION['userfound']=0;
					echo "<h1 align='center'>No user found by that name</h1>";
				}
				else
				{
					echo "<h1 align='center'>Start a new chat by searching username</h1>";
				}
			?>
		</div>
	</div>
	</body>
</html>