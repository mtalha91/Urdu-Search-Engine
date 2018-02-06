<?php
include("database.php");
 session_start();
		$sites_url=$_POST['url'];
		$sites_title=$_POST['title'];
		$sites_description=$_POST['description'];
		$owner=$_SESSION['user'];
		if(isset($_POST['level'])&&$_POST['level']=="full")
		{
			$level=-1;
		}
		else
		{
			$level=2;
		}
		if($sites_url!=""&&$sites_title!=""&&$sites_description!="")
		{
		if(preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \?=.-]*)*\/?$/",$sites_url))
		{
			$compurl=parse_url("".$sites_url);
			if ($compurl['path']=='')
				$sites_url=$sites_url."/";
			$result = mysql_query("select sites_id from sites where sites_url='$sites_url'");
			echo mysql_error();
			$rows = mysql_num_rows($result);
			if ($rows==0 ) 
			{
				mysql_query("INSERT INTO sites (sites_url, sites_title, sites_description,sites_depth,sites_leave_domain,sites_owner) VALUES ('$sites_url', '$sites_title', '$sites_description',$level,0,'$owner')");
				echo mysql_error();
				
				If (!mysql_error())
				{
					$error="no";
				header("Location:../user.php?page_value=submit_site&error=no");
		
				}
				else 
				{
					$error="in_db";
				header("Location:../user.php?page_value=submit_site&error=in_db");
		
				}

			}
			else
			{
				$error="in_db";
				header("Location:../user.php?page_value=submit_site&error=in_db");
		
			}
			
	
		}
		else
		{
			$error="wrong_url";
				header("Location:../user.php?page_value=submit_site&error=wrong_url");
		}
		}
		else
		{
			$error="empty_input";
				header("Location:../user.php?page_value=submit_site&error=empty_input");
		
		}
				
	
		
	
	
	


?>