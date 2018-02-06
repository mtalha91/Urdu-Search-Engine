<?php
///////////////admin query and other functions//////////////////////


	
	function replace_ampersand($str) 
	{
	
		return str_replace("&", "%26", $str);
	
	}
	
	function add_site_query($values)
	{
		$sites_url=$values['sites_url'];
		$sites_title=$values['sites_title'];
		$sites_description=$values['sites_description'];
		$sites_url=strip_tags($sites_url);
		$sites_url=mysql_real_escape_string($sites_url);
		$sites_title=strip_tags($sites_title);
		$sites_title=mysql_real_escape_string($sites_title);
		$sites_description=strip_tags($sites_description);
		$sites_description=mysql_real_escape_string($sites_description);
	
		if($sites_url!=""&&$sites_title!=""&&$sites_description!=""&&preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \?=.-]*)*\/?$/",$sites_url))
		{
			$compurl=parse_url("".$sites_url);
			if ($compurl['path']=='')
				$sites_url=$sites_url."/";
			$result = mysql_query("select sites_id from sites where sites_url='$sites_url'");
			echo mysql_error();
			$rows = mysql_num_rows($result);
			if ($rows==0 ) 
			{
				mysql_query("INSERT INTO sites (sites_url, sites_title, sites_description) VALUES ('$sites_url', '$sites_title', '$sites_description')");
				echo mysql_error();
				
				If (!mysql_error())
				{
					$message =1 ;
				}
				else 
				{
					$message = mysql_error();
				}

			}
			else
			{
				$message = 2;
			}
			return $message;
	
		}
		else
		{
			$message =3;
		}
				return $message;
	
		
	}
	
	
	function edit_site_query($values)
	{
		
			$sites_id=$values['sites_id'];
			$sites_url=$values['sites_url'];
			$sites_title=$values['sites_title'];
			$sites_description=$values['sites_description'];
			$sites_depth=$values['sites_depth'];
			$sites_leave_domain=$values['sites_leave_domain'];
			
			$sites_url=strip_tags($sites_url);
			$sites_url=mysql_real_escape_string($sites_url);
			$sites_title=strip_tags($sites_title);
			$sites_title=mysql_real_escape_string($sites_title);
			$sites_description=strip_tags($sites_description);
			$sites_description=mysql_real_escape_string($sites_description);
	
			$sites_depth=strip_tags($sites_depth);
			$sites_depth=mysql_real_escape_string($sites_depth);
	
			
			
			
			
		//print_r($values);	
		if($sites_url!=""&&$sites_title!=""&&$sites_description!=""&&$sites_depth!=""&&preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})(^[0-9]+$/",$sites_depth))
		{	
			$compurl=parse_url($sites_url);
			if ($compurl['path']=='')
				$sites_url=$sites_url."/";
			mysql_query("UPDATE sites SET sites_url='$sites_url', sites_title='$sites_title', sites_description='$sites_description', sites_depth =$sites_depth,  sites_leave_domain=$sites_leave_domain WHERE sites_id=$sites_id");
			echo mysql_error();
			
			If (!mysql_error()) {
				return "<br/><center><b>Site updated.</b></center>" ;
			} else {
				return mysql_error();
			}
		
		
		}
		else
		{
			$message = "<center><b>Please fill all input fields and depth should be integer value</b></center>";
		}
				return $message;
	
		
	}
	
	function delete_links()
	{
	
		$query = "select sites_id from sites";
		$result = mysql_query($query);
		echo mysql_error();
		$todelete = array();
		if (mysql_num_rows($result)>0)
		{
			while ($row=mysql_fetch_array($result))
			{
				$todelete[]=$row['sites_id'];
			}
			$todelete = implode(",", $todelete);
			$sql_end = " not in ($todelete)";
		}
		
		$result = mysql_query("select crawled_links_id from crawled_links where sites_id".$sql_end);
		echo mysql_error();
		$del = mysql_num_rows($result);
		while ($row=mysql_fetch_array($result)) 
		{
			$links_id=$row['crawled_links_id'];
			
			mysql_query("delete from crawled_links where crawled_links_id=$links_id");
			echo mysql_error();
		}

		$result = mysql_query("select crawled_links_id from crawled_links where sites_id is NULL");
		echo mysql_error();
		$del += mysql_num_rows($result);
		while ($row=mysql_fetch_array($result)) 
		{
			$links_id=$row['crawled_links_id'];
			
			mysql_query("delete from crawled_links where crawled_links_id=$links_id");
			echo mysql_error();
		}
		?>
		<div id="submenu">
		</div><?php 
		print "<br/><center><b>Links table cleaned, $del links deleted.</b></center>";
	}

	function delete_temp()
	{
	
		$result = mysql_query("delete from temp where temp_link_level >= 0");
		echo mysql_error();
		$del = mysql_affected_rows();
				?>
		<div id="submenu">
		</div><?php 
		print "<br/><center><b>Temp table cleared, $del items deleted.</b></center>";
	}
	
	
	function get_database_stats()
	{
		$stats = array();
		$linksQuery = "select count(crawled_links_url) from crawled_links";
		$siteQuery = "select count(sites_id) from sites";
	
		
		$result = mysql_query($linksQuery);
		echo mysql_error();
		if ($row=mysql_fetch_array($result))
		{
			$stats['links']=$row[0];
		}
		
		$result = mysql_query($siteQuery);
		echo mysql_error();
		if ($row=mysql_fetch_array($result)) {
			$stats['sites']=$row[0];
		}
		
		return $stats;
	}
	
	
	function get_dir_contents($dir)
	{
		///log directory is "crawling_log"
		$contents = Array();
		
		if ($handle = opendir($dir))
		{
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					$contents[] = $file;
				}
			}
			closedir($handle);
		}
		else
		{
			echo "directory opening fails";
		}
		return $contents;
	}
	
	
	
?>