<?php
include("database.php");
	  session_start();
	if(isset($_POST['email']))
	{
		$e=$_POST['email'];
		$p=$_POST['pass'];
		$e=strip_tags($e);
		$e=mysql_real_escape_string($e);
		$p=strip_tags($p);
		$p=mysql_real_escape_string($p);
		
		if($e!=""&&$p!="")
		{
		//msql injection prevention
				
				$q=mysql_query("select user_username,user_email,user_password from user where user_email='$e' and user_password='$p'");
				$num=mysql_num_rows($q);
				echo mysql_error();
				//echo $num;
				
				if($num>0)
				{
					$_SESSION['user']=$e;
					//echo $_SESSION['user'];
					
					header("Location:../user.php?page_value=home");
				}
				else
				{	
					$_SESSION['user']="";
					
					header("Location:../user.php?page_value=login_register&error=wrong_input");
			
				}
				
			
			
		}
		else
		{
			//echo "error2";	
					$_SESSION['user']="";
					
			header("Location:../user.php?page_value=login_register&error=wrong_input");
		}
		
	}
	else
	{
	
					$_SESSION['user']="";
					
		//echo "error3";
		header("Location:../user.php?page_value=login_register&error=wrong_input");
	}


?>