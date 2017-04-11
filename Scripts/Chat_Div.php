 <!DOCTYPE html>
 <html>
 <head>
  <meta http-equiv="refresh" content="2">
</head>
<body>
<?php
	//echo "string";
	require 'Database_Functions.php';
	//echo "string";
	session_start();
	if(!array_key_exists('username',$_SESSION))
	{
		header("Location: ../");
		exit();
	}
	if(isset($_POST['send']))
	{
		//echo "string";
		Send_Message($db,$_SESSION['username'],$_SESSION['chatusername'],$_POST['msg']);
	}
	//echo $_SESSION['username'];echo $_SESSION['chatusername'];
	//echo Chat_exists($db,$_SESSION['username'],$_SESSION['chatusername']);
	if(Chat_exists($db,$_SESSION['username'],$_SESSION['chatusername'])=='0')
	{
		//echo "In IF";
		Add_chat($db,$_SESSION['username'],$_SESSION['chatusername']);
		
	}
	else
	{
		//echo "In else";
		$res = Load_chat($db,$_SESSION['username'],$_SESSION['chatusername']);
		Mark_all_read($db,Get_chat_id($db,$_SESSION['username'],$_SESSION['chatusername']),Get_user_id($db,$_SESSION['username']));
		echo "<link rel='stylesheet' type='text/css' href='../chat.css'>";
		echo "<div id='chatbox'>";
		echo "<h1 class = 'Chat_Name' >".$_SESSION['chatusername']."</h1>";
		$i=0;
		while($res[$i])
		{
			//echo "In while..";
			//echo $res[$i];
			//echo $res[$i]['contents'];
			//echo Get_user_id($_SESSION['username']);
			if($res[$i]['sender_id']==Get_user_id($db, $_SESSION['username']))
			{
				echo "<p class = 'sent'>".$res[$i]['contents']."</p>";
			}
			else
			{
				echo "<p class = 'recieved'>".$res[$i]['contents']."</p>";
			}
			$i++;
		}
		echo "</div>";
		echo "<div class='footer'>";
		echo"<form action='Chat_Div.php' method='POST' id='msg_input'>";
		echo "<textarea form='msg_input' class='chat_msg' name='msg' placeholder='Enter your message'></textarea><input class='send' type='submit' name='send' value='send'>";
		echo "</form></div>";
	}
?>
</body>
</html>
