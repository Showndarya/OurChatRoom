<?php
	function Connect_db()
	{
		$db = mysql_connect("localhost","chat@localhost","Ankit@22");
		if(!$db){
 			echo("<p>Connection to content server failed.</p>");
 			return null;
		}
		//echo("<p>Database Connected</p>");
		if (!mysql_select_db('Chat_Room', $db)) {
    		echo '<p>Could not select database</p>';
    		return null;
		}
		return $db;
	}
	function Get_query_result($db,$query)
	{
		$result = mysql_query($query, $db);
		if (!$result) {
    		echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
    		return null;
		}
		$i=0;
		while ($row = mysql_fetch_assoc($result)) {
    		$out[$i]=$row;
    		$i++;
		}
		mysql_free_result($result);
		return $out;
	}
	function Add_user($db,$details)
	{
		$query="Insert into users (first_name,last_name,user_name,email,password,join_time,last_seen) values ('".$details->firstname."','".$details->lastname."','".$details->username."','".$details->email."','".$details->password."',NOW(),NOW())";
		mysql_query($query,$db);
	}
	function Get_password_query($username)
	{
		$query = sprintf("Select password from users where user_name='%s'",
    	mysql_real_escape_string($username));
    	return $query;
	}
	function Get_password($db,$username)
	{
		$query=Get_password_query($username);
		$result = mysql_query($query, $db);
		if (!$result) {
    		echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
    		return null;
		}
		$row = mysql_fetch_assoc($result);
		return $row['password'];
	}
	function User_exists($db,$username)
	{
		$query = sprintf("Select Count(*) from users where user_name='%s'",mysql_real_escape_string($username));
		$result = mysql_query($query,$db);
		if (!$result) {
    		echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
    		return null;
		}
		$row = mysql_fetch_assoc($result);
		return $row['Count(*)'];
	}
	function Get_user_id($db,$username)
	{
		//echo "Username: $username ";
		$c_id_query = mysql_query(sprintf("Select id from users where user_name='%s'",$username),$db);
		//echo $c_id_query;
		$c_id_row = mysql_fetch_assoc($c_id_query);
		//echo (int)$c_id_row['id'];
		return (int)$c_id_row['id'];
	}
	function Get_chat_id($db,$user1,$user2)
	{
		$query = sprintf("Select chat_id,Count(*) from chat_details where chat_id in (Select chat_id from chat_details where user_id = %d) AND user_id = %d AND chat_id in (Select id from chats where is_group=0)",Get_user_id($db,$user1),Get_user_id($db,$user2));
		$res = Get_query_result($db,$query);
		if($res[0]['Count(*)']=='1')
			return (int)$res[0]['chat_id'];
	}
	function Get_created_chats($db,$creator)
	{
		$ch_id_query = mysql_query(sprintf("Select id from chats where creator=%d",Get_user_id($creator)),$db);
		$ch_id_row = mysql_fetch_assoc($ch_id_query);
		return (int)$ch_id_row['id'];
	}
	function Add_Chat($db,$creator,$reciever)
	{
		$c_id = Get_user_id($db,$creator);
		$r_id = Get_user_id($db,$reciever);
		$query1=sprintf("Insert into chats (creator,is_group,create_time) values (%d,0,NOW())",(int) $c_id);
		//echo $query1;
		if(!mysql_query($query1,$db)){
			echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
		}
		$ch_id = mysql_insert_id();
		//echo $ch_id;
		$query2=sprintf("Insert into chat_details (chat_id,user_id,name,join_time) values (%d,%d,'%s',NOW())",(int) $ch_id,(int) $c_id,mysql_real_escape_string($reciever));
		$query3=sprintf("Insert into chat_details (chat_id,user_id,name) values (%d,%d,'%s')",(int) $ch_id,(int) $r_id,mysql_real_escape_string($creator));
		//echo $query2;
		//echo $query3;
		if(!mysql_query($query2,$db)){
			echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
		}
		if(!mysql_query($query3,$db)){
			echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
		}
	}
	function Chats_with($db,$user1,$user2)
	{
		$c_id = Get_user_id($db,$user1);
		$c2_id = Get_user_id($db,$user2);
		$query = sprintf("Select chat_id from chat_details where chat_id in (Select chat_id from chat_details where user_id = %d) AND user_id = %d",$c_id,$c2_id);
		return Get_query_result($db,$query);
	}
	function Chat_exists($db,$user1,$user2)
	{
		//echo "$user1 $user2";
		$c_id = Get_user_id($db,$user1);
		$c2_id = Get_user_id($db,$user2);
		//echo "$c_id $c2_id<br>"; 
		$query = sprintf("Select chat_id,Count(*) from chat_details where chat_id in (Select chat_id from chat_details where user_id = %d) AND user_id = %d AND chat_id in (Select id from chats where is_group=0)",$c_id,$c2_id);
		//echo $query;
		$res = Get_query_result($db,$query);
		return $res[0]['Count(*)'];
	}

	function Load_chat($db,$user1,$user2)
	{
		$chat_id = Get_chat_id($db,$user1,$user2);
		//echo $chat_id;
		$query=sprintf("Select a.sender_id,a.id,a.time, a.type, a.in_sender, a.contents, b.rec_id, b.time_rec, b.time_read, b.in_rec from messages a, msg_details b where a.id=b.msg_id AND a.chat_id = %d ORDER BY id",$chat_id);
		return Get_query_result($db,$query);
		//echo $query;
	}
	function Send_message($db,$sender,$reciever,$msg)
	{
		$chat_id = Get_chat_id($db,$sender,$reciever);
		
		$query1 = sprintf("Insert into messages (chat_id,sender_id,time,type,in_sender,contents) VALUES (%d,%d,NOW(),1,1,'%s')",$chat_id,Get_user_id($db,$sender),$msg);
		//echo $query1;
		if(!mysql_query($query1,$db)){
			echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
		}
		$query2 = sprintf("Insert into msg_details (msg_id,rec_id,in_rec) VALUES (%d,%d,1)",mysql_insert_id($db),Get_user_id($db,$reciever));
		//echo $query2;
		if(!mysql_query($query2,$db)){
			echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
		}
	}
	function Get_last_chat($db,$chat_id)
	{
		$query = sprintf("SELECT contents  from messages where chat_id = '%d' ORDER BY time DESC",$chat_id);
		$res = Get_query_result($db,$query);
		return $res[0]['contents'];
	}
	function Mark_all_rec($db,$chat_id,$user_id)
	{
		$query=sprintf("UPDATE msg_details set time_rec = NOW() Where msg_id IN (Select id from messages where chat_id = %d) AND rec_id = %d AND time_rec IS NULL",$chat_id,$user_id);
		if(!mysql_query($query,$db)){
			echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
		}
		return mysql_affected_rows();
	}
	function Load_chats_of($db,$username)
	{
		$uid = Get_user_id($db,$username);
		$query = "Select * from chat_details where user_id = ".$uid;
		//echo $query;
		$res = Get_query_result($db,$query);
		$i = 0;
		while($res[$i])
		{
			$last_chat = Get_last_chat($db,(int)$res[$i]['chat_id']);
			$unread = Mark_all_rec($db,(int)$res[$i]['chat_id'],$uid);
			echo sprintf("<div class = 'headBox' ><h2 class = 'chatName'>%s</h2><p class = 'newMsg'>%d</p><p class = 'lastChat' >%s</p></div>",mysql_escape_string($res[$i]['name']),$unread,mysql_escape_string($last_chat));
			$i++;
		}
	}
	function Mark_all_read($db,$chat_id,$user_id)
	{
		$query = sprintf(" UPDATE msg_details set time_read = NOW() Where msg_id IN (Select id from messages where chat_id = %d) AND rec_id = %d AND time_read IS NULL",$chat_id,$user_id);
		//echo $query;
		if(!mysql_query($query,$db)){
			echo "DB Error, could not query the database\n";
    		echo 'MySQL Error: ' . mysql_error();
		}
	}
	$db=Connect_db();
	/*$creds->firstname="Test";
	$creds->lastname="User";
	$creds->username="test_user";
	$creds->email="test.user@localhost.com";
	$creds->password="123456";
	$query=Add_user($creds);
	Get_query_result($db,$query);
	$out=Get_query_result($db,"Select * from users");
	$i=0;
	while($out[$i])
	{
		echo $out[$i]['first_name'].",".$out[$i]['last_name'].",".$out[$i]['user_name'].",".$out[$i]['lastname'].",".$out[$i]['email'].",".$out[$i]['join_time'].",".$out[$i]['last_seen'];
		$i++;
	}*/
?>