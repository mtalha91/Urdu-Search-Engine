<?php

$messages = Array (
 "noFollow" => Array (
	0 => " <font color=red><b> No-follow flag set</b></font>. ",
	1 => " No-follow flag set."
 ),
 "inDatabase" => Array (
	0 => " <font color=red><b> already in database</b></font><br>",
	1 => " already in database\n"
 ),
 "completed" => Array (
	0 => "<br>Completed at %cur_time.\n<br>",
	1 => "Completed at %cur_time.\n"
 ),
 "starting" => Array (
	0 => " Starting crawling at %cur_time.\n",
	1 => " Starting crawling at %cur_time.\n"
	 ),
 "quit" => Array (
	0 => "</body></html>",
	1 => ""
 ),
 "pageRemoved" => Array (
	0 => " <font color=red>Page removed from database.</font><br>\n",
	1 => " Page removed from database.\n"
 ),
  "continueSuspended" => Array (
	0 => "<br>Continuing suspended crawling.<br>\n",
	1 => "Continuing suspended crawling.\n"
 ),
  "crawled" => Array (
	0 => "<br><b> <font color=\"green\">Crawled</font></b><br>\n",
	1 => " \nCrawled\n"
 ),
"duplicate" => Array (
	0 => " <font color=\"red\"><b>Page is a duplicate.</b></font><br>\n",
	1 => " Page is a duplicate.\n"
 ),
"md5notChanged" => Array (
	0 => " <font color=\"red\"><b>MD5 sum checked. Page content not changed</b></font><br>\n",
	1 => " MD5 sum checked. Page content not changed.\n"
 ),
"metaNoindex" => Array (
	0 => " <font color=\"red\">No-Index flag set in meta tags.</font><br>\n",
	1 => " No-Index flag set in meta tags.\n"
 ),
  "re-crawled" => Array (
	0 => " <font color=\"green\">Re-Crawled</font><br>\n",
	1 => " Re-Crawled\n"
 ),
"not_urdu" => Array (
	0 => " <font color=\"red\">The webpage is not in urdu language.</font><br>\n",
	1 => " The webpage is not in urdu language.\n"
 )
);

////writting to file
	function writeToLog($msg)
	{
		global $log_handle;
		global $log_format;
			if ($log_format=="html")
		{
			$log_file =  "crawling_log../".Date("ymdHi").".html";
		}
		else
		{
			$log_file =  "crawling_log../".Date("ymdHi").".log";
		}
		
		if (!$log_handle = fopen($log_file, 'w')) 
		{
			die ("Logging option is set, but cannot open file for logging.");
		}
		
		
		
		
		
			if (!$log_handle) {
				die ("Cannot open file for logging. ");
			}

			if (fwrite($log_handle, $msg) === FALSE) {
				die ("Cannot write to file for logging. ");
			}
			//echo "now done";
			//exit();
		
	}
	

	
	function printStandardReport($type, $command_line)
	{
		global $print_results, $log_format, $messages;
		if ($print_results) 
		{
			print str_replace('%cur_time', date("H:i:s"), $messages[$type][$command_line]);
			flush();
		}

		if ($log_format=="html")
		{
			writeToLog(str_replace('%cur_time', date("H:i:s"), $messages[$type][0]));
		} else 
		{
			writeToLog(str_replace('%cur_time', date("H:i:s"), $messages[$type][1]));
		}

	}
	
	
	
	function printRobotsReport($num, $thislink, $cl) 
	{
		global $print_results, $log_format;
		$log_msg_txt = "$num. Link $thislink: file checking forbidden in robots.txt file.\n";
		$log_msg_html = "<b>$num</b>. Link <b>$thislink</b>: <font color=red>file checking forbidden in robots.txt file</font></br>";
		if ($print_results) 
		{
			if ($cl==0)
			{
				print $log_msg_html; 
			} else 
			{
				print $log_msg_txt;
			}
			flush();
		}
		if ($log_format=="html") 
		{
			writeToLog($log_msg_html);
		} else 
		{
			writeToLog($log_msg_txt);
		}

	}

		
	function printRetrieving($num, $thislink, $cl) 
	{
		global $print_results, $log_format;
		$log_msg_txt = "$num. Retrieving: $thislink at " . date("H:i:s").".\n";
		$log_msg_html = "<b>$num</b>. Retrieving: <b>$thislink</b> at " . date("H:i:s").".<br>\n";
		if ($print_results)
		{
			if ($cl==0)
			{
				print $log_msg_html;
			} else 
			{
				print $log_msg_txt;
			}
			flush();
		}

		if ($log_format=="html")
		{
			writeToLog($log_msg_html);
		} else 
		{
			writeToLog($log_msg_txt);
		}
	}

		
	function printHeader($disallowed_link, $url, $cl)
	{
		global $print_results, $log_format;

		if (count($disallowed_link) > 0 )
		{
			$urlparts = parse_url($url);
			foreach ($disallowed_link as $dir) 
			{			
				$disallowed_links[] = $urlparts['scheme']."://".$urlparts['host'].$dir;
			}
		}
		
		$log_msg_txt = "Crawling $url\n";
		if (count($disallowed_link) > 0) 
		{
			$log_msg_txt .= "Disallowed files and directories in robots.txt:\n";
			$log_msg_txt .= implode("\n", $disallowed_links);
			$log_msg_txt .= "\n\n";
		}

		$log_msg_html_1 = "<html><head><LINK REL=STYLESHEET HREF=\"spider_files/spider_includes/admin.css\" TYPE=\"text/css\"></head>\n";
		$log_msg_html_1 .= "<body style=\"font-family:Verdana, Arial; font-size:12px\">";
		
		$log_msg_html_link = "[Back to <a href=\"http://localhost/urdu_search_engine_final/admin/\">admin</a>]";
		$log_msg_html_2 = "<p><font size=\"+1\">Crawling <b>$url</b></font></p>\n";

		if (count($disallowed_link) > 0) 
		{
			$log_msg_html_2 .=  "Disallowed files and directories in robots.txt:<br>\n";
			$log_msg_html_2 .=  implode("<br>", $disallowed_links);
			$log_msg_html_2 .=  "<br><br>";
		}

		if ($print_results)
		{
			if ($cl==0)
			{
				print $log_msg_html_1.$log_msg_html_link.$log_msg_html_2;
			}
			else
			{
				print $log_msg_txt;
			}
			flush();
		}

		if ($log_format=="html")
		{
			writeToLog($log_msg_html_1.$log_msg_html_2);
		} 
		else 
		{
			writeToLog($log_msg_txt);
		}
	}

	
	
		
	function printConnectErrorReport($errmsg)
	{
		global $print_results, $log_format;
		$log_msg_txt = "Establishing connection with socket failed. ";
		$log_msg_txt .= $errmsg;

		if ($print_results)
		{
			print $log_msg_txt;
			flush();
		}

		writeToLog($log_msg_txt);
	}

	
	function printPageSizeReport($pageSize) 
	{
		global $print_results, $log_format;
		$log_msg_txt = "Size of page: $pageSize"."kb. ";
		if ($print_results)
		{
			print $log_msg_txt;
			flush();
		}

		writeToLog($log_msg_txt);
	}

	
	function printPageSizeReportUrdu($pageSizeUrdu)
	{
		global $print_results, $log_format;
		$log_msg_txt = "Size of Urdu text in the page: $pageSizeUrdu"."kb. ";
		if ($print_results)
		{
			print $log_msg_txt;
			flush();
		}

		writeToLog($log_msg_txt);
	}

	
	function printUrlStatus($report, $cl) 
	{
		global $print_results, $log_format;
		$log_msg_txt = "$report\n";
		$log_msg_html = " <font color=red><b>$report</b></font><br>\n";
		if ($print_results) 
		{
			if ($cl==0)
			{
				print $log_msg_html; 
			} 
			else 
			{
				print $log_msg_txt;
			}
			flush();
		}
		if ($log_format=="html") 
		{
			writeToLog($log_msg_html);
		}
		else
		{
			writeToLog($log_msg_txt);
		}

	}

		
	function printLinksReport($numoflinks, $all_links, $cl)
	{
		global $print_results, $log_format;
		$log_msg_txt = " Legit links found: $all_links. New links found: $numoflinks\n";
		$log_msg_html = " Links found: <font color=\"blue\"><b>$all_links</b></font>. New links: <font color=\"blue\"><b>$numoflinks</b></font><br>\n";
		if ($print_results) 
		{
			if ($cl==0)
			{
				print $log_msg_html;
			}
			else 
			{
				print $log_msg_txt;
			}
			flush();
		}

		if ($log_format=="html") 
		{
			writeToLog($log_msg_html);
		}
		else
		{
			writeToLog($log_msg_txt);
		}
	}

	
?>