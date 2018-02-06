<?php
	



	function command_line_help()
	{
		echo "PHP COMMMAND LINE HELP\n\n";
		echo "For re-crawling all the links  \n";
		echo "Syntax : filename.php re_crawl_all\n";
		
		echo "For Crawling all new links  \n";
		echo "Syntax : filename.php crawl_all_new_sites\n";
		
		echo "For re-crawl a single link  \n";
		echo "Syntax : filename.php re_crawl http://www.example.com/\n";
	
		echo "For crawl a single link  exmaple 1\n";
		echo "Syntax : filename.php crawl soption maxlevel check domain url\n";
		echo "Example : spider.php crawl level -1/1/2/3.. 0/1 http://www";
	
		echo "For crawl a single link  exmaple 2\n";
		echo "Syntax : filename.php crawl soption  check domain url\n";
		echo "Example : spider.php  crawl   full    0/1   http://www\n\n";
	
	}

	function get_domains_from_db ()
	{
		global $mysql_table_prefix;
		$result = mysql_query("select domains_id, domains_url from domains");
		if(mysql_error()){echo mysql_error();echo "Line :32";}
		$domains = Array();
    	while ($row=mysql_fetch_row($result)) 
		{
			$domains[$row[1]] = $row[0];
		}
		return $domains;
			
	}
	
	
	function get_temp_urls ($sessid)
	{
		
		$result = mysql_query("select temp_link from temp where temp_id='$sessid'");
		if(mysql_error()){echo mysql_error();echo "Line :47";}
		$tmp_urls = Array();
    	while ($row=mysql_fetch_row($result)) {
			$tmp_urls[$row[0]] = 1;
		}
		return $tmp_urls;
			
	}
	
	function check_for_removal($url)
	{

		global $command_line;
		$result = mysql_query("select crawled_links_id, crawled_links_visible from crawled_links where crawled_links_url='$url'");
		if(mysql_error()){echo mysql_error();echo "Line :61";}
		if (mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_row($result);
			$link_id = $row[0];
			$visible = $row[1];
			if ($visible > 0)
			{
				$visible --;
				mysql_query("update crawled_links set crawled_links_visible=$visible where crawled_links_id=$link_id");
				if(mysql_error()){echo mysql_error();echo "Line :71";}
			} 
			else
			{
				mysql_query("delete from crawled_links where crawled_links_id=$link_id");
				if(mysql_error()){echo mysql_error();echo "Line :75";}
				
				printStandardReport('pageRemoved',$command_line);
			}
		}
	}

		
	
	
/*
Read robots.txt file in the server, to find any disallowed files/folders
*/
	function check_robot_txt($url)
	 {
		global $user_agent;
		$urlparts = parse_url($url);
		$url = 'http://'.$urlparts['host']."/robots.txt";

		/////call to user defined function url_status to get the url status 
		$url_status = url_status($url);
		$disallowed_link = array ();

		if ($url_status['state'] == "ok")
		{
		//its mean host exist  so url status is ok
			$robot = file($url);
			if (!$robot)
			{
				$contents = getFileContents($url);
				$file = $contents['file'];
				$robot = explode("\n", $file);
			}

			////the $ robot has a robot file  , now parsing that robot file  
			
			$regs = Array ();
			$this_agent= "";
			
		/* list is a function that get the values from arrray and their variables
		list (id, line)=After each() has executed, the array cursor will be left on the next element of the array, or past the last element if it hits the end of the array. */
			
			
			while (list ($id, $line) = each($robot))
			{
				///each() is php function to move through the all the index of the array
				///checking the user agent in the robot file
				if (preg_match("/^user-agent: *([^#]+) */", $line, $regs)) 
				{
					$this_agent = trim($regs[1]);
					if ($this_agent == '*' || $this_agent == $user_agent)
						$check = 1;
					else
						$check = 0;
				}
				////checking for disallowed pages in the robot file
				if (preg_match("/disallow: *([^#]+)/", $line, $regs) && $check == 1)
				{
					$disallow_str = preg_replace("/[\n ]+/i", "", $regs[1]);
					if (trim($disallow_str) != "") 
					{
						$disallowed_link[] = $disallow_str;
					}
					else
					{
						if ($this_agent == '*' || $this_agent == $user_agent)
						{
							return null;
						}
					}
				}///end of if preg_match (disallow)
			}////end of while (list =robot)
		}///end of if urlstatus=ok

		return $disallowed_link;
	}
	
	
	
		/*
	check if file is available and in readable form
	*/
	function url_status($url)
	{
		global $user_agent; 
		$urlparts = parse_url($url);
		$path = $urlparts['path'];
		$host = $urlparts['host'];
		if (isset($urlparts['query']))
			$path .= "?".$urlparts['query'];

		if (isset ($urlparts['port']))
		{
			$port = (int) $urlparts['port'];
		}
		else
			if ($urlparts['scheme'] == "http")
			{
				$port = 80;
			} 
			else
				if ($urlparts['scheme'] == "https") 
				{
					$port = 443;
				}

		if ($port == 80) 
		{
			$portq = "";
		} else 
		{
			$portq = ":$port";
		}
		
		$all = "*/*"; //just to prevent "comment effect" in get accept
		$request = "HEAD $path HTTP/1.1\r\nHost: $host$portq\r\nAccept: $all\r\nUser-Agent: $user_agent\r\n\r\n";

		if (substr($url, 0, 5) == "https") 
		{
			$target = "ssl://".$host;
		} 
		else 
		{
			$target = $host;
		}

		$fsocket_timeout = 30;
		$errno = 0;
		$errstr = "";
		
		
		$fp = fsockopen($target, $port, $errno, $errstr, $fsocket_timeout);
		print $errstr;
		$linkstate = "ok";
		if (!$fp) 
		{
			$status['state'] = "NOHOST";
		}
		else 
		{
			socket_set_timeout($fp, 30);///php function socket set timeout
			fputs($fp, $request);
			$answer = fgets($fp, 4096);
			$regs = Array ();
			if (preg_match("/HTTP/[0-9.]+ (([0-9])[0-9]{2})/", $answer, $regs)) 
			{
				$httpcode = $regs[2];
				$full_httpcode = $regs[1];

				if ($httpcode <> 2 && $httpcode <> 3) 
				{
					$status['state'] = "Unreachable: http $full_httpcode";
					$linkstate = "Unreachable";
				}
			}

			if ($linkstate <> "Unreachable") 
			{
				while ($answer)
				{
					$answer = fgets($fp, 4096);

					if (preg_match("/Location: *([^\n\r ]+)/", $answer, $regs) && $httpcode == 3 && $full_httpcode != 302) 
					{
						$status['path'] = $regs[1];
						$status['state'] = "Relocation: http $full_httpcode";
						fclose($fp);
						return $status;
					}

					if (preg_match("/Last-Modified: *([a-z0-9,: ]+)/i", $answer, $regs)) 
					{
						$status['date'] = $regs[1];
					}

					if (preg_match("/Content-Type:/i", $answer)) 
					{
						$content = $answer;
						$answer = '';
						break;
					}
				}
				$socket_status = socket_get_status($fp);
				if (preg_match("/Content-Type: *([a-z\/.-]*)/i", $content, $regs)) 
				{
					if ($regs[1] == 'text/html' || $regs[1] == 'text/' || $regs[1] == 'text/plain') 
					{
						$status['content'] = 'text';
						$status['state'] = 'ok';
					}
					else if ($regs[1] == 'application/pdf' && $index_pdf == 1) 
					{
						$status['content'] = 'pdf';
						$status['state'] = 'ok';                                 
					}
					else if (($regs[1] == 'application/msword' || $regs[1] == 'application/vnd.ms-word') && $index_doc == 1) 
					{
						$status['content'] = 'doc';
						$status['state'] = 'ok';
					}
					else if (($regs[1] == 'application/excel' || $regs[1] == 'application/vnd.ms-excel') && $index_xls == 1) 
					{
						$status['content'] = 'xls';
						$status['state'] = 'ok';
					}
					else if (($regs[1] == 'application/mspowerpoint' || $regs[1] == 'application/vnd.ms-powerpoint') && $index_ppt == 1)
					{
						$status['content'] = 'ppt';
						$status['state'] = 'ok';
					} else 
					{
						$status['state'] = "Not text or html";
					}

				} 
				else
					if ($socket_status['timed_out'] == 1)
					{
						$status['state'] = "Timed out (no reply from server)";

					} 
					else
						$status['state'] = "Not text or html";

			}///if link state < > unreachable
		}///if $ fp return true
		fclose($fp);
		return $status;
	}

	function getFileContents($url)
	{
		global $user_agent;
		$urlparts = parse_url($url);
		$path = $urlparts['path'];
		$host = $urlparts['host'];
		if ($urlparts['query'] != "")
			$path .= "?".$urlparts['query'];
		if (isset ($urlparts['port']))
		{
			$port = (int) $urlparts['port'];
		}
		else
			if ($urlparts['scheme'] == "http")
			{
				$port = 80;
			} 
			else
				if ($urlparts['scheme'] == "https")
				{
					$port = 443;
				}

		if ($port == 80)
		{
			$portq = "";
		}
		else
		{
			$portq = ":$port";
		}

		$all = "*/*";

		$request = "GET $path HTTP/1.0\r\nHost: $host$portq\r\nAccept: $all\r\nUser-Agent: $user_agent\r\n\r\n";

		$fsocket_timeout = 30;
		if (substr($url, 0, 5) == "https")
		{
			$target = "ssl://".$host;
		}
		else
		{
			$target = $host;
		}


		$errno = 0;
		$errstr = "";
		
		///requesting webpage for data
		$fp = @ fsockopen($target, $port, $errno, $errstr, $fsocket_timeout);

		print $errstr;
		if (!$fp)
		{
			///if error in requesting then terminate and print report
			$contents['state'] = "NOHOST";
			printConnectErrorReport($errstr);
			return $contents;
		} 
		else
		{
			///if request granted
			if (!fputs($fp, $request)) 
			{
				///error in writing web page data
				$contents['state'] = "Cannot send request";
				return $contents;
			}
			$data = null;
			socket_set_timeout($fp, $fsocket_timeout);
			do{
				$status = socket_get_status($fp);
				$data .= fgets($fp, 8192);
			} while (!feof($fp) && !$status['timed_out']) ;

			fclose($fp);
			if ($status['timed_out'] == 1) 
			{
				$contents['state'] = "timeout";
			}
			else
				$contents['state'] = "ok";
			$contents['file'] = substr($data, strpos($data, "\r\n\r\n") + 4);
		}
		return $contents;
	}

	
	
	
	
		
	/*
	Checks if url is legal, relative to the main url.
	*/
	function url_purify($url, $parent_url, $check_domain) 
	{
		global $ext, $mainurl, $apache_indexes, $strip_sessids;


		$urlparts = parse_url($url);

		$main_url_parts = parse_url($mainurl);
		if ($urlparts['host'] != "" && $urlparts['host'] != $main_url_parts['host']  && $check_domain != 1) 
		{
			return '';
		}
		
		reset($ext);
		while (list ($id, $excl) = each($ext))
			if (preg_match("/\.$excl$/i", $url))
				return '';

		if (substr($url, -1) == '\\')
		{
			return '';
		}



		if (isset($urlparts['query']))
		{
			if ($apache_indexes[$urlparts['query']])
			{
				return '';
			}
		}

		if (preg_match("/[\/]?mailto:|[\/]?javascript:|[\/]?news:/i", $url))
		{
			return '';
		}
		if (isset($urlparts['scheme'])) 
		{
			$scheme = $urlparts['scheme'];
		} 
		else 
		{
			$scheme ="";
		}



		//only http and https links are followed
		if (!($scheme == 'http' || $scheme == '' || $scheme == 'https')) 
		{
			return '';
		}

		//parent url might be used to build an url from relative path
		$parent_url = remove_file_from_url($parent_url);
		$parent_url_parts = parse_url($parent_url);


		if (substr($url, 0, 1) == '/') 
		{
			$url = $parent_url_parts['scheme']."://".$parent_url_parts['host'].$url;
		} 
		else
			if (!isset($urlparts['scheme'])) 
			{
				$url = $parent_url.$url;
			}

		$url_parts = parse_url($url);

		$urlpath = $url_parts['path'];

		$regs = Array ();
		
		while (preg_match("/[^\/]*\/[.]{2}\//", $urlpath, $regs))
		{
			$urlpath = str_replace($regs[0], "", $urlpath);
		}

		//remove relative path instructions like ../ etc 
		$urlpath = preg_replace("/\/+/", "/", $urlpath);
		$urlpath = preg_replace("/[^\/]*\/[.]{2}/", "",  $urlpath);
		$urlpath = str_replace("./", "", $urlpath);
		$query = "";
		if (isset($url_parts['query']))
		{
			$query = "?".$url_parts['query'];
		}
		if ($main_url_parts['port'] == 80 || $url_parts['port'] == "")
		{
			$portq = "";
		} 
		else
		{
			$portq = ":".$main_url_parts['port'];
		}
		$url = $url_parts['scheme']."://".$url_parts['host'].$portq.$urlpath.$query;

		//if we crawl sub-domains
		if ($check_domain == 1)
		{
			return $url;
		}

		$mainurl = remove_file_from_url($mainurl);
		
		if ($strip_sessids == 1) 
		{
			$url = remove_sessid($url);
		}
		//only urls in staying in the starting domain/directory are followed	
		$url = convert_url($url);
		if (strstr($url, $mainurl) == false) 
		{
			return '';
		}
		else
			return $url;
	}

		
	/*
	Remove the file part from an url (to build an url from an url and given relative path)
	*/
	function remove_file_from_url($url)
	{
		$url_parts = parse_url($url);
		$path = $url_parts['path'];

		$regs = Array ();
		if (preg_match('/([^\/]+)$/i', $path, $regs))
		{
			$file = $regs[1];
			$check = $file.'$';
			$path = preg_replace("/$check"."/i", "", $path);
		}

		if ($url_parts['port'] == 80 || $url_parts['port'] == "")
		{
			$portq = "";
		} else {
			$portq = ":".$url_parts['port'];
		}

		$url = $url_parts['scheme']."://".$url_parts['host'].$portq.$path;
		return $url;
	}

	
	function convert_url($url)
	{
		$url = str_replace("&amp;", "&", $url);
		$url = str_replace(" ", "%20", $url);
		return $url;
	}

	function  remove_sessid($url)
	{
		return preg_replace("/(\?|&)(PHPSESSID|JSESSIONID|ASPSESSIONID|sid)=[0-9a-zA-Z]+$/", "", $url);
	}

	
	
	
		
	function fst_lt_snd($version1, $version2)
	{
		$list1 = explode(".", $version1);
		$list2 = explode(".", $version2);

		$length = count($list1);
		$i = 0;
		while ($i < $length) {
			if ($list1[$i] < $list2[$i])
				return true;
			if ($list1[$i] > $list2[$i])
				return false;
			$i++;
		}
		
		if ($length < count($list2)) {
			return true;
		}
		return false;

	}

	
		
	function isDuplicateMD5($md5sum)
	{
		$result = mysql_query("select crawled_links_id from crawled_links where crawled_links_md5sum='$md5sum'");
		if(mysql_error()){echo mysql_error();echo "Line :";}
		if (mysql_num_rows($result) > 0)
		{
			return true;
		}
		return false;
	}
	 
	 
			
	function get_head_data($file)
	{
		$headdata = "";
			   
		preg_match("@<head[^>]*>(.*?)<\/head>@si",$file, $regs);	
		
		$headdata = $regs[1];

		$description = "";
		$robots = "";
		$keywords = "";
		$base = "";
		$res = Array ();
		if ($headdata != "")
		{
			preg_match("/<meta +name *=[\"']?robots[\"']? *content=[\"']?([^<>'\"]+)[\"']?/i", $headdata, $res);
			if (isset ($res))
			{
				$robots = $res[1];
			}

			preg_match("/<meta +name *=[\"']?description[\"']? *content=[\"']?([^<>'\"]+)[\"']?/i", $headdata, $res);
			if (isset ($res)) 
			{
				$description = $res[1];
			}

			preg_match("/<meta +name *=[\"']?keywords[\"']? *content=[\"']?([^<>'\"]+)[\"']?/i", $headdata, $res);
			if (isset ($res)) 
			{
				$keywords = $res[1];
			}
			// e.g. <base href="http://www.consil.co.uk/index.php" />
			preg_match("/<base +href *= *[\"']?([^<>'\"]+)[\"']?/i", $headdata, $res);
			if (isset ($res))
			{
				$base = $res[1];
			}
			$keywords = preg_replace("/[, ]+/", " ", $keywords);
			$robots = explode(",", strtolower($robots));
			$nofollow = 0;
			$noindex = 0;
			foreach ($robots as $x) {
				if (trim($x) == "noindex")
				{
					$noindex = 1;
				}
				if (trim($x) == "nofollow")
				{
					$nofollow = 1;
				}
			}
			$data['description'] = addslashes($description);
			$data['keywords'] = addslashes($keywords);
			$data['nofollow'] = $nofollow;
			$data['noindex'] = $noindex;
			$data['base'] = $base;
		}
		
		if($data['keywords'] == "")
		{
			
			preg_match('/(<meta name="keywords" content="([\x{0600}-\x{06FF}]+.*)" \/>)/i', $headdata, $res);
			if (isset ($res)) 
			{
				$data['keywords'] = $res[1];
			}
		}
		
		if($data['description'] == "")
		{
			
			//[\x{0600}-\x{06FF}]
			preg_match('/(<meta name="description" content="([\x{0600}-\x{06FF}]+.*)" \/>)/i', $headdata, $res);
			if (isset ($res)) 
			{
				$data['description'] = $res[1];
			}
		}
		
		return $data;
	}

		
	function get_web_page_data($file, $url, $type) 
	{
		global $entities, $crawl_host, $crawl_meta_keywords;

		$urlparts = parse_url($url);
		$host = $urlparts['host'];
		//remove filename from path
		$path = preg_replace('/([^\/]+)$/i', "", $urlparts['path']);
		$file = preg_replace("/<link rel[^<>]*>/i", " ", $file);
		$file = preg_replace("@<!--USE_nocrawl-->.*?<!--\/USE_nocrawl-->@si", " ",$file);	
		$file = preg_replace("@<!--.*?-->@si", " ",$file);	
		$file = preg_replace("@<script[^>]*?>.*?</script>@si", " ",$file);
		
		$headdata = get_head_data($file);
		
		$regs = Array ();
		
		if (preg_match("@<title *>(.*?)<\/title*>@si", $file, $regs))
		{
			$title = trim($regs[1]);
			$file = str_replace($regs[0], "", $file);
		} 
		//else if ($type == 'pdf' || $type == 'doc')
		//{ //the title of a non-html file is its first few words
			//$title = substr($file, 0, strrpos(substr($file, 0, 40), " "));
		//}

		$file = preg_replace("@<style[^>]*>.*?<\/style>@si", " ", $file);

		//create spaces between tags, so that removing tags doesnt concatenate strings
		$file = preg_replace("/<[\w ]+>/", "\\0 ", $file);
		$file = preg_replace("/<\/[\w ]+>/", "\\0 ", $file);
		$file = strip_tags($file);
		$file = preg_replace("/&nbsp;/", " ", $file);

		$fulltext = $file;
		$file .= " ".$title;
		if ($crawl_host == 1)
		{
			$file = $file." ".$host." ".$path;
		}
		if ($crawl_meta_keywords == 1) 
		{
			$file = $file." ".$headdata['keywords'];
		}
		
		
		//replace codes with ascii chars
		$file = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $file);
		$file = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $file);
		$file = strtolower($file);
		reset($entities);
		while ($char = each($entities)) 
		{
			$file = preg_replace("/".$char[0]."/i", $char[1], $file);
		}
		$file = preg_replace("/&[a-z]{1,6};/", " ", $file);
		$file = preg_replace("/[\*\^\+\?\\\.\[\]\^\$\|\{\)\(\}~!\"\/@#£$%&=`´;><:,]+/", " ", $file);
		$file = preg_replace("/\s+/", " ", $file);
		$data['fulltext'] = addslashes($fulltext);
		$data['content'] = addslashes($file);
		$data['title'] = addslashes($title);
		$data['description'] = $headdata['description'];
		$data['keywords'] = $headdata['keywords'];
		$data['host'] = $host;
		$data['path'] = $path;
		$data['nofollow'] = $headdata['nofollow'];
		$data['noindex'] = $headdata['noindex'];
		$data['base'] = $headdata['base'];

		
		
		return $data;

	}

	function extract_urdu($file)
	{
			
		///////////////////////////////////fetching urdu////////////////////
		
		//$pattern_correct = "#(?:[\x{0600}-\x{06FF}]+(?:\s+[\x{0600}-\x{06FF}]+)*)#u";
		$pattern_correct = "#[\x{0600}-\x{06FF}]+#u";
		
		/////////////matching urdu from the given text//////////////////////
		
		$urdu_found=false;
	
		if(preg_match_all($pattern_correct, $file, $matches, PREG_SET_ORDER))
		{
		
		$one_dimensional_array=array_flatten($matches);///calling function to convert multidimensional array to one array
		$urdu_text=implode(" ",$one_dimensional_array);
		$urdu_finder=array(' ہے ‌',' ہیں ',' کے ',' میں ',' کی ');
		$urdu_letters=array('چ','ٹ','ڈ','ڑ');
						
				
					//checking for ? ? ? in the text to confirm it is in urdu
					for($i=0;$i<count($urdu_letters);$i++)
					{
						
						if(strstr($urdu_text,$urdu_letters[$i]))
						{	
							$urdu_found=true;
							//echo "<p>urdu found in 1st check<p>";
							break;
						}	
					}
					///checking for urdu words in the text
					if($urdu_found==false)
					{
						for($i=0;$i<count($urdu_finder);$i++)
						{
							
							if(strstr($urdu_text,$urdu_finder[$i]))
							{	
								
								$urdu_found=true;
								break;
							}	
						}
					}			
					
					if($urdu_found==false)
					{
						//echo "<h1>the webpage is in urdu</h1>";
						//echo $domain;
						$urdu_text="";
					}
		
		}//end of if statement
		else
		{
			//echo "<h1>the webpage is not in arabic script</h1>";
			//echo $domain;
				$urdu_text="";
		}
			
		
		//echo $urdu_text;exit();
			return $urdu_text;	 
		
	
	}
	
		//////////////////////////function for urdu checking///////////////////////////
	function array_flatten($matches)
	{ 
		   
		  $result = array(); 
		  foreach ($matches as $key => $value)
		  { 
			if (is_array($value)) 
			{ 
			  $result = array_merge($result, array_flatten($value)); 
			} 
			else 
			{ 
			  $result[$key] = $value; 
			} 
		  } 
		  return $result; 
	}


		
	/*
	Extract links from html
	*/
	function get_links($file, $url, $check_domain, $base)
	{

		$chunklist = array ();
		// The base URL comes from either the meta tag or the current URL.
		if (!empty($base)) 
		{
			$url = $base;
		}

		$links = array ();
		$regs = Array ();
		$checked_urls = Array();

		//////////finding links from the webpage//////////////////
		//preg_match_all("/href=\"([^\"]*)\"/i", $data, $matches);

		
		preg_match_all("/href\s*=\s*[\'\"]?([+:%\/\?~=&;\\\(\),._a-zA-Z0-9-]*)(#[.a-zA-Z0-9-]*)?[\'\" ]?(\s*rel\s*=\s*[\'\"]?(nofollow)[\'\"]?)?/i", $file, $regs, PREG_SET_ORDER);
		foreach ($regs as $val)
		{
			if ($checked_urls[$val[1]]!=1 && !isset ($val[4])) 
			{ //if nofollow is not set
				if (($a = url_purify($val[1], $url, $check_domain)) != '')
				{
					$links[] = $a;
				}
				$checked_urls[$val[1]] = 1;
			}
		}
		
		preg_match_all("/(http-equiv=['\"]refresh['\"] *content=['\"][0-9]+;url)[[:blank:]]*=[[:blank:]]*[\'\"]?(([[a-z]{3,5}:\/\/(([.a-zA-Z0-9-])+(:[0-9]+)*))*([+:%\/?=&;\\\(\),._ a-zA-Z0-9-]*))(#[.a-zA-Z0-9-]*)?[\'\" ]?/i", $file, $regs, PREG_SET_ORDER);
		foreach ($regs as $val)
		{
			if ($checked_urls[$val[1]]!=1 && !isset ($val[4]))
			{ //if nofollow is not set
				if (($a = url_purify($val[1], $url, $check_domain)) != '')
				{
					$links[] = $a;
				}
				$checked_urls[$val[1]] = 1;
			}
		}


		return $links;
	}
	
	
	
	/*
	Removes duplicate elements from an array
	*/
	function distinct_array($arr)
	{
		rsort($arr);
		reset($arr);
		$newarr = array();
		$i = 0;
		$element = current($arr);

		for ($n = 0; $n < sizeof($arr); $n++) 
		{
			if (next($arr) != $element)
			{
				$newarr[$i] = $element;
				$element = current($arr);
				$i++;
			}
		}

		return $newarr;
	}

	
	//////////////////////////fucntions for removing bad url/////////////////////
	function invalid_url($match)
	{
			// we want to ignore all these strings
					if (stripos($match, ".exe") !== false) return true;
					if (stripos($match, ".zip") !== false) return true;
					if (stripos($match, ".rar") !== false) return true;
					if (stripos($match, ".wmv") !== false) return true;
					if (stripos($match, ".wav") !== false) return true;
					if (stripos($match, ".mp3") !== false) return true;
					if (stripos($match, ".sit") !== false) return true;
					if (stripos($match, ".mov") !== false) return true;
					if (stripos($match, ".avi") !== false) return true;
					if (stripos($match, ".msi") !== false) return true;
					if (stripos($match, ".rpm") !== false) return true;
					if (stripos($match, ".rm") !== false) return true;
					if (stripos($match, ".ram") !== false) return true;
					if (stripos($match, ".asf") !== false) return true;
					if (stripos($match, ".mpg") !== false) return true;
					if (stripos($match, ".mpeg") !== false) return true;
					if (stripos($match, ".tar") !== false) return true;
					if (stripos($match, ".tgz") !== false) return true;
					if (stripos($match, ".bz2") !== false) return true;
					if (stripos($match, ".deb") !== false) return true;
					if (stripos($match, ".pdf") !== false) return true;
					if (stripos($match, ".jpg") !== false) return true;
					if (stripos($match, ".jpeg") !== false) return true;
					if (stripos($match, ".gif") !== false) return true;
					if (stripos($match, ".tif") !== false) return true;
					if (stripos($match, ".png") !== false) return true;
					if (stripos($match, ".swf") !== false) return true;
					if (stripos($match, ".svg") !== false) return true;
					if (stripos($match, ".bmp") !== false) return true;
					if (stripos($match, ".dtd") !== false) return true;
					if (stripos($match, ".xml") !== false) return true;
					if (stripos($match, ".js") !== false) return true;
					if (stripos($match, ".vbs") !== false) return true;
					if (stripos($match, ".css") !== false) return true;
					if (stripos($match, ".ico") !== false) return true;
					if (stripos($match, ".rss") !== false) return true;
					if (stripos($match, "\'") !== false) return true;
					if (stripos($match, "w3.org") !== false) return true;
					if (stripos($match[0], ".") !== false) return true;
					
					// yes, these next two are very vague, but they do cut out
					// the vast majority of advertising links.  Like I said,
					// this crawler is far from perfect!
					if (stripos($match, "ads.") !== false) return true;
					if (stripos($match, "ad.") !== false) return true;
					$empty_url="#";
					if($match==$empty_url) 
					return true;
				
		return false;
	}
	
	
	
	// retrieve all h1 tags
    function get_h($file)
	{
		
		
        $h1tags = preg_match_all("/(<h[1-6]+.*>)(\w.*)(<\/h[1-6]+>)/isxmU",$file,$patterns);
        $res = array();
		
		
        array_push($res,$patterns[2]);
        array_push($res,count($patterns[2]));
        return $res;
    }
    
    
    // retrieve p tag contents
    function get_p($file)
	{
        $h1tags = preg_match_all("/(<p.*>)(\w.*)(<\/p>)/ismU",$file,$patterns);
        $res = array();
		
        array_push($res,$patterns[2]);
        array_push($res,count($patterns[2]));
		
		
		return $res;
    }
    
	
	
	function extract_urdu_h($file)
	{
		$u1=get_h($file);//multi dimensional array of headings
		//echo "<h1>heading 1</h1>";
		$new=array_flatten($u1);///one dimensional array of headings
		$u1=implode(" ",$new);///string of headings
		$u1=extract_urdu($u1);///urdu of headings
		
		//print_r($u1);
		return $u1;
	}
	
	function extract_urdu_p($file)
	{	
		///get paragraph text
		$urdu_para=get_p($file);
		///make a string of paragraph text
		//echo "<h1>paragraph</h1>";
		//print_r($urdu_para);
		$new=array_flatten($urdu_para);
		//echo "new";
		//print_r($new);
		$u_p=implode(" ",$new);
		//extract urdu from paragraph text
		//print_r($u_p);
		$urdu_para=extract_urdu($u_p);
		//print_r($urdu_para);
		return $urdu_para;
	
	}

	function extract_urdu_text($file)
	{	
		////removing ancher tags data 
		$file=preg_replace('/(<a([^>]+)>)(.*?)(<\/a>)/is', " ", $file); 

		////removing meta tags data 
		$file = preg_replace("/<meta\s.*?\/>/is", "", $file);


		
		
		$urdu_para=extract_urdu($file);
		//print_r($urdu_para);
		return $urdu_para;
	
	}
	?>