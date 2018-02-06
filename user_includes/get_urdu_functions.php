<?php
	

	
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
		$user_agent="use"; 
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
		 $user_agent="Mozilla";
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
	function url_purify($url, $parent_url) 
	{
		
		$urlparts = parse_url($url);

		
	

		if (substr($url, -1) == '\\')
		{
			return '';
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
		
			$portq = "";
		
		$url = $url_parts['scheme']."://".$url_parts['host'].$portq.$urlpath.$query;

		
		
		//only urls in staying in the starting domain/directory are followed	
		$url = convert_url($url);
		
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

	
	
	function extract_urdu($file)
	{
		///////////////////////////////////fetching urdu////////////////////
		
		
		/*preg_match_all("/\p{Arabic}/u", $file,$res)
		if(preg_match_all("#[\x{0600}-\x{06FF}]+#u", $file,$res))
		{
		$one=array_flatten($res);///calling function to convert 
		$urdu_text=implode(" ",$one);
		echo $urdu_text;
		}*/
	
		//$pattern_correct = "#(?:[\x{0600}-\x{06FF}]+(?:\s+[\x{0600}-\x{06FF}]+)*)#u";
		/////////////matching urdu from the given text//////////////////////
		$pattern_correct = "#[\x{0600}-\x{06FF}]+#u";
	
		
		//preg_match_all($pattern_correct, $file, $matches, PREG_SET_ORDER);
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
		
		//echo $urdu_text;
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


	
	
	?>