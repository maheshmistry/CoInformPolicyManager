<?php
session_start();
include 'db/conn.php';
include 'header.php';
include 'forum_header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//someone is calling the file directly, which we don't want
	echo 'This file cannot be called directly.';
}
else
{
	//check for sign in status
	if(!isset($_SESSION['user_name']))
	{
		echo 'You must be signed in to post a reply.';
	}
	else
	{
		//a real user posted a real reply
		$sql = "INSERT INTO 
					posts(post_content,
						  post_date,
						  post_topic,
						  post_by,
						  type) 
				VALUES ('" . mysqli_real_escape_string($link,$_POST['reply-content']) . "',
						NOW(),
						" . mysqli_real_escape_string($link,$_GET['id']) . ",
						" . $_SESSION['user_id'] . ",
						1					
						)";						
		$result = mysqli_query($link,$sql);
		if(!$result)
		{
			echo 'Your reply has not been saved, please try again later.';
		}
		else
		{
			echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
		}
	}
}

include 'footer.php';
?>