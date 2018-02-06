<?php

include("database.php");
	 session_start();
	if(isset($_POST['user']))
	{
	
				$u=$_POST['user'];
				$e=$_POST['email'];
				$p=$_POST['cpass'];
				$cp=$_POST['pass'];
				//mysql injection prevention
				$u=strip_tags($u);
				$e=strip_tags($e);
				$p=strip_tags($p);
				$cp=strip_tags($cp);
				
				$u=mysql_real_escape_string($u);
				$e=mysql_real_escape_string($e);
				$p=mysql_real_escape_string($p);
				$cp=mysql_real_escape_string($cp);
				
				
		
	
		if($u!=""&&$e!=""&&$_POST['country']!=""&&$p!="")
		{
			$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
			if(preg_match($regexp,$e))
			{
				if(isset($_POST['newsletter']))
			$newsletter=1;
			else
			$newsletter=0;
			if($p==$cp)
			{
				
				$c=$_POST['country'];
				$n=$newsletter;
				
				
				$result = mysql_query("select user_email from user where user_email='$e'");
			echo mysql_error();
			$rows = mysql_num_rows($result);
				if($row==0)
				{
					$q=mysql_query("insert into user(user_username,user_email,user_country,user_newsletter,user_password) values('$u','$e','$c',$n,'$p')");
					echo mysql_error();
					$_SESSION['user']=$e;
					header("Location:../user.php?page_value=home");
				}
				else
				{
							$_SESSION['user']="";
					
			header("Location:../user.php?page_value=login_register&error=in_db");
			
				}
			
			}
			else
			{
			//echo "error1";	
			
					$_SESSION['user']="";
					
			header("Location:../user.php?page_value=login_register&error=pass_error");
			}
		
		}
		else
		{
			$_SESSION['user']="";
					
			header("Location:../user.php?page_value=login_register&error=email_incorrect");
		}
			
		}
		else
		{
			//echo "error2";	
			
					$_SESSION['user']="";
					
			header("Location:../user.php?page_value=login_register&error=empty_input");
		}
		
	}
	else
	{
		//echo "error3";
		
					$_SESSION['user']="";
					
		header("Location:../user.php?page_value=login_register&error=empty_input");
	}


?>