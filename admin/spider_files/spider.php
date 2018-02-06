<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ur" lang="ur" >
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta http-equiv="content-language" content="ur"/>

</head>


<?php
///***************************///
//spider function for crawling
//Mohammad Talha
//BSCS Hons BZU Multan
//****************************///
	
	error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);

	set_time_limit (0);
	$include00 = "spider_functions";
	$include01="spider_includes";
	$log_directory="./crawling_log";
	//require_once ("$include01/database.php");
	include("$include01/configuration.php");
	include("$include00/spider_crawling_main_functions.php");
	include("$include00/spider_crawling_small_functions.php");
	include("$include00/spider_var.php");
	include("$include00/print_log_report.php");
		
	$delay_time = 0;
	$command_line = 0;
	$tmp_urls  = Array();
	$domain_arr = Array();

	//////////if calling through command line//////////////
	if (isset($_SERVER['argv']) && $_SERVER['argc'] >= 2) 
	{
		$command_line = 1;
		
		$ac = 1; //argument counter
		while ($ac < (count($_SERVER['argv']))) 
		{
			$command_line_values = $_SERVER['argv'][$ac];

			crawl_site($sites_url, $re_crawl, $maxlevel, $soption, $check_domain);
			if($command_line_values==1)
				commandline_help();
				die();
			
		}
			
	}
	
	
	////////////////getting values from commmand line start//////////////////////
	
	if (isset($_SERVER['argv']) && $_SERVER['argc'] >= 2) 
	{
		$command_line = 1;
	
		array_shift($argv);
		$command_line_values=$argv;
		//print_r($command_line_values);
	
		if($command_line_values[0]=='re_crawl_all')
		{
			$re_crawl_all=1;
			//echo "re crawl all".$re_crawl_all."\n";
		}
		else if($command_line_values[0]=='crawl_all_new_sites')
		{
			$crawl_all_new_sites=1;
			
		}
		else if($command_line_values[0]=='crawl_all_pending_sites')
		{
			$crawl_all_pending_sites=1;
			
		}
		
		else if($command_line_values[0]=='re_crawl')
		{
			$re_crawl=1;
			$sites_url=$command_line_values[1];
		}
		else if($command_line_values[0]=='crawl')	
		{
			$re_crawl=0;
			$soption=$command_line_values[1];
			if($soption=='full')
			{
				$maxlevel="-1";
				$check_domain=$command_line_values[2];
				$sites_url=$command_line_values[3];
			
			}
			else
			{
				$maxlevel=$command_line_values[2];
				$check_domain=$command_line_values[3];
				$sites_url=$command_line_values[4];
			}
			if($maxlevel==""||$check_domain==""||$soption==""||$sites_url=="")
			{
				command_line_help();
				die();
			}
		}
		else
		{
			command_line_help();
			die();
		}
					
		
	}
	////////////////getting values from commmand line end//////////////////////

	///////////////getting values from $post start//////////////////////

	if(isset($_POST['re_crawl_all'])&&$_POST['re_crawl_all']==1)
	{
		$re_crawl_all=1;
	}
	
	if(isset($_POST['crawl_all_new_sites'])&&$_POST['crawl_all_new_sites']==1)
	{
		$crawl_all_new_sites=1;
	}
	if(isset($_POST['crawl_all_pending_sites'])&&$_POST['crawl_all_pending_sites']==1)
	{
		$crawl_all_pending_sites=1;
	}
	
	
	if(isset($_POST['start_crawling']))
	{
		
		if (isset($_POST['sites_url']) && $_POST['sites_url'] != "")
		{
			$sites_url=$_POST['sites_url'];
		}
		else
		{
			///display message that url field is empty
		}
		if (isset($_POST['soption']) && $_POST['soption'] == 'full')
		{
			$maxlevel = -1;///if crawling unlimited 
			$soption="full";
		}
		
		if (isset($_POST['soption']) && $_POST['soption'] == 'level') 
		{
			$maxlevel = $_POST['maxlevel'];//crawl at max level defined
			$soption="level";
		}
		
		if (isset($_POST['check_domain']))
		{
			$check_domain = $_POST['check_domain'];///crawl other domain
		}
		else
		{
			$check_domain = 0;//dont crawl other domain
		}

		if(isset($_POST['re_crawl'])) 
		{
			$re_crawl=$_POST['re_crawl'];/// re crawling=1 the domain
		}
		else
		{
			$re_crawl=0;///crawling the domain for the first time
		}


		if ($log_format=="html")
		{
			$log_file =  $log_directory."/".Date("ymdHi").".html";
		}
		else
		{
			$log_file =  $log_directory."/".Date("ymdHi").".log";
		}
		
		if (!$log_handle = fopen($log_file, 'w')) 
		{
			//die ("Logging option is set, but cannot open file for logging.");
		}
		
		
	}////end of if (isset $POST)
	
	
	///////////////getting values from $post end//////////////////////

	$tmp_urls  = Array();
	
	if ($re_crawl_all ==  1)
	{
		if(isset($_POST['crawling_limit']))
		{
			$regexp = "/[0-9]+/";
			if(preg_match($regexp, $_POST['crawling_limit'])&&!preg_match("/[0]+/", $_POST['crawling_limit']))
			{
				$limit=$_POST['crawling_limit'];
			} 
			else 
			{
				$limit=10;
			}

		}
		else
		{
			$limit=10;
		
		}
		re_crawl_all($command_line,$limit);
	} 
	else if ($crawl_all_new_sites ==  1)
	{
		if(isset($_POST['crawling_limit']))
		{
			$regexp = "/[0-9]+/";
			if(preg_match($regexp, $_POST['crawling_limit'])&&!preg_match("/[0]+/", $_POST['crawling_limit']))
			{
				$limit=$_POST['crawling_limit'];
			} 
			else 
			{
				$limit=10;
			}

		}
		else
		{
			$limit=10;
		
		}
		crawl_all_new_sites($command_line,$limit);
	}
	else if ($crawl_all_pending_sites ==  1)
	{
		if(isset($_POST['crawling_limit']))
		{
			$regexp = "/[0-9]+/";
			if(preg_match($regexp, $_POST['crawling_limit'])&&!preg_match("/[0]+/", $_POST['crawling_limit']))
			{
				$limit=$_POST['crawling_limit'];
			} 
			else 
			{
				$limit=10;
			}

		}
		else
		{
			$limit=10;
		
		}
		crawl_all_pending_sites($command_line,$limit);
	}
	else 
	{
		if ($re_crawl == 1 || $command_line == 1)
		{
			$sites_url=$_POST['sites_url'];
			$result=mysql_query("select sites_url,sites_depth,sites_leave_domain from sites where sites_url='$sites_url'");
			echo mysql_error();
			if($row=mysql_fetch_row($result)) 
			{
				//print_r($row);
				$sites_url = $row[0];
				$maxlevel = $row[1];
				$check_domain = $row[2];
				if ($check_domain==''||$check_domain== NULL)
				{
					$check_domain=0;
				}
				if ($maxlevel == -1)
				{
					$soption = 'full';
				} 
				else
				{
					$soption = 'level';
				}
			}///end of if $row=mysql fetch row

		}///end of if re crawl =1
		
		crawl_site($sites_url, $re_crawl, $maxlevel, $soption, $check_domain,$command_line);
		
		
		$sites_url=""; $re_crawl=""; $maxlevel=""; $soption=""; $check_domain="";$command_line="";

	}///end of else 
	
	
		
	
	
?>