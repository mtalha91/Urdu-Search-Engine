<?php

include("database.php");
	 session_start();
	if(isset($_POST['cpass']))
	{
	
		if($_POST['cpass']!=""&&$_POST['cnpass']!=""&&$_POST['npass']!="")
		{
			
			if($_POST['npass']==$_POST['cnpass'])
			{
				$user_e=$_SESSION['user'];
				$p=$_POST['cpass'];
				$np=$_POST['npass'];
				
				$p=strip_tags($p);
				$p=mysql_real_escape_string($p);
				$np=strip_tags($np);
				$np=mysql_real_escape_string($np);
				
				
				
				$result = mysql_query("select user_password from user where user_email='$user_e' and user_password='$p'");
			echo mysql_error();
			$rows = mysql_num_rows($result);
			//print_r($rows);
				if($rows==0)
				{
					header("Location:../user.php?page_value=change_password&error=cpass_error");
			
				}
				else
				{
					$q=mysql_query("update user set user_password='$np' where user_email='$user_e'");
					echo mysql_error();
					
					header("Location:../user.php?page_value=change_password&error=no");		
					
			
				}
			
			}
			else
			{
			//echo "error1";	
			
					
					
			header("Location:../user.php?page_value=change_password&error=pass_error");
			}
			
			
		}
		else
		{
			//echo "error2";	
			
			header("Location:../user.php?page_value=change_password&error=empty_input");
		}
		
	}
	else
	{
		//echo "error3";
		
					
					
		header("Location:../user.php?page_value=change_password&error=empty_input");
	}


?>