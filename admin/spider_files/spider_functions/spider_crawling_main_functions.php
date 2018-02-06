<?php

include('spider_includes../database.php');
	
	$stop_crawling_domain=false;
	
	////////////////////////////////////////////////////////////////////////////
	///////////////start of crawl url function///////////////////////////////
	///////////////////////////////////////////////////////////////////////////
		
	function crawl_url($sites_url, $level, $site_id, $md5sum, $domain, $crawled_date, $sessid, $check_domain, $re_crawl) 
	{
		//echo "crawl_url function is calling";
		
		global $stop_crawling_domain;
		global $entities; /// in spider_var.php
		global $min_delay; //in cofiguration.php
		global $command_line; /// in spider.php
		global $min_words_per_page; ///in configuration.php
		//global $supdomain;
		global $user_agent; //in configuration.php
		global $tmp_urls;///this is an array in spider.php
		global $delay_time; //in spider.php
		global $domain_arr; ////contain values of get_domains_from_db in spider.php
		//global $soption;
		//global $level;
		//global $maxlevel;
		//echo  $entities;echo $min_delay; echo $command_line; echo $min_words_per_page; echo $user_agent; echo $tmp_urls; echo $delay_time; 	echo $domain_arr; 
		
		//echo "displaying crawling/recrawling values....url......$sites_url...level... $level ..id..$site_id ..md5....$md5sum ..domain..$domain ..date....$crawled_date...session.... $sessid  ...check domain....$check_domain ....recrawl.....$re_crawl ";
		//exit();
		
		$need_re_crawl = 1;
		$deletable = 0;
		$stop_crawling_domain=false;

		$sites_url_status = url_status($sites_url);
		$thislevel = $level - 1;

		//print_r($sites_url_status);exit();
		////if the page is redirected to another page  , then
		if (strstr($sites_url_status['state'], "Relocation")) 
		{
		
			////url_purify is function to make a correct link of webpage
			
			$sites_url = preg_replace("/ /", "", url_purify($sites_url_status['path'], $sites_url, $check_domain));

			if ($sites_url <> '') 
			{
				$result = mysql_query("select temp_link from temp where temp_link='$sites_url' && temp_id = '$sessid'");
				if(mysql_error()){echo mysql_error();echo "Line :49";}
				$rows = mysql_num_rows($result);
				if ($rows == 0) 
				{
					mysql_query ("insert into temp (temp_link, temp_link_level, temp_id) values ('$sites_url', '$level', '$sessid')");
					if(mysql_error()){echo mysql_error();echo "Line :55";}
				}
			}

			$sites_url_status['state'] == "redirected";
		}

		
		//if ($crawled_date <> '' && $sites_url_status['date'] <> '') {
			//if ($crawled_date > $sites_url_status['date']) {
				//$sites_url_status['state'] = "Date checked. Page contents not changed";
				//$need_re_crawl = 0;
			//}
		//}
		
		
		ini_set("user_agent", $user_agent);
	
		///if status is 200
		if ($sites_url_status['state'] == 'ok')
		{
			
			$ok_to_crawl = 1;
			$file_read_error = 0;
			
			if (time() - $delay_time < $min_delay) 
			{
				sleep ($min_delay- (time() - $delay_time));
			}
			
			$delay_time = time();
			
			
			////////////now sending request to web page for data//////////////
			if (!fst_lt_snd(phpversion(), "4.3.0"))
			{
				$file = file_get_contents($sites_url);
				if ($file === FALSE) 
				{
					$file_read_error = 1;
				}
			} 
			else 
			{
				$fl = @fopen($sites_url, "r");
				if ($fl) 
				{
					while ($buffer = @fgets($fl, 4096))
					{
						$file .= $buffer;
					}
				}
				else 
				{
					$file_read_error = 1;
				}

				fclose ($fl);
			}
			if ($file_read_error) 
			{
				$contents = getFileContents($sites_url);
				$file = $contents['file'];
			}
			
			///////////the webpage is crawled and its data is in $file//////////////////
			
			///////////////////getting the size of web page ////////////////////////
			////number_format if php function
			$pageSize = number_format(strlen($file)/1024, 2, ".", "");
			printPageSizeReport($pageSize);
		
			
			

			printStandardReport('starting', $command_line);
			
			
				
			/////extract urdu from webpage data $file
			$urdu = extract_urdu($file);
			//echo " printing full urdu ".$urdu;
			
				///////////////////getting the size of web page ////////////////////////
			////number_format if php function
			$pageSizeUrdu = number_format(strlen($urdu)/1024, 2, ".", "");
			printPageSizeReportUrdu($pageSizeUrdu);
					
			
			///getting the new md5sum of web page data 
			/// if md5sum match the previous one , its mean that web page contents are not changed
			$newmd5sum = md5($urdu);
			//echo "old: $md5sum  : new : $newmd5sum";exit();
			///in case of pending crawling , the md5sum='' its mean the url is not crawled yet , and we crawled that url , no urdu found in this url then the newmd5sum='' now both are same , this should be call while re crawling , but here it is called in pending 
			if ($md5sum == $newmd5sum) 
			{
				printStandardReport('md5notChanged',$command_line);
				$ok_to_crawl = 0;
			} 
			else if (isDuplicateMD5($newmd5sum)) 
			{
				$ok_to_crawl = 0;
				printStandardReport('duplicate',$command_line);
			}

			if (($md5sum != $newmd5sum || $re_crawl ==1) && $ok_to_crawl == 1) 
			{
				$sites_urlparts = parse_url($sites_url);
				$newdomain = $sites_urlparts['host'];
				$type = 0;
				
				//if ($newdomain <> $domain)
					//$domainChanged = 1;

				//if ($domaincb==1) {
					//$start = strlen($newdomain) - strlen($supdomain);
					//if (substr($newdomain, $start) == $supdomain) {
						//$domainChanged = 0;
					//}
				//}

				
				
				
				// remove link to css file
				//get all links from file
			
				$data = get_web_page_data($file, $sites_url, $sites_url_status['content']);
				
				//if the domain is not in urdu language so no need to crawl its other pages , so stop here
				
				$lev=$level-1;
				if($urdu == "" && $lev == 0)
				{
					return false;
				}
				if ($data['noindex'] == 1 ) 
				{
					$ok_to_crawl = 0;
					$deletable = 1;
					printStandardReport('metaNoindex',$command_line);
				}
				
				
			//	$wordarray = unique_array(explode(" ", $data['content']));
	
				if ($data['nofollow'] != 1)
				{
					
					////extract all href links from page data
					$links = get_links($file, $sites_url, $check_domain, $data['base']);
				
					///remove duplicate links from array
					$links = distinct_array($links);
					$all_links = count($links);
					$numoflinks = 0;
					//if there are any, add to the temp table, but only if there isnt such url already
					
					if (is_array($links))
					{
						reset ($links);

						while ($thislink = each($links))
						{
							if ($tmp_urls[$thislink[1]] != 1) 
							{
								$tmp_urls[$thislink[1]] = 1;
								$numoflinks++;
								$match=$thislink[1];
								if(invalid_url($match))
								{
									///the url is invalid & not save to database
								}
								else
								{
									//echo "now links are inserting";
									//echo $level;
									
									
									 $match = parse_url($match);
									 //print_r($match);
									 
									  if(stristr($sites_url,$match['host']))
										{
											mysql_query ("insert into temp (temp_link, temp_link_level, temp_id) values ('$thislink[1]', '$level', '$sessid')");
											if(mysql_error()){echo mysql_error();echo "Line :229";}
										}
										else
										{
											
											if(isset($match['scheme'])&&$match['scheme']!="")
											 {
												$url=$match['scheme']."://".$match['host']."/";
												$url_host=$match['host'];
											 }
											 else
											 {
												$url="http://".$match['host']."/";
												$url_host=$match['host'];
											 }
											 
											
											$result = mysql_query("select sites_id from sites where sites_url='$url'");
											echo mysql_error();
											$rows = mysql_num_rows($result);
											if ($rows==0 ) 
											{
											
											
											mysql_query("insert into sites (sites_url, sites_title, sites_description) values ('$url', '$url_host', '')");
											echo mysql_error();
											}
				
										}
									
									
								}
							}
						}///end of while
					}///end of if (is array)
				} ///end of if (data no follow !=1)
				else 
				{
					printStandardReport('noFollow',$command_line);
				}
				
				
				
				
				if ($ok_to_crawl == 1) 
				{
					
					//extract paragraph of urdu from webpage
					$urdu_p=extract_urdu_p($file);
					//extract headings of urdu from webpage
					$urdu_h=extract_urdu_h($file);
					$urdu_text=extract_urdu_text($file);
					//echo "printing urdu  ".$urdu_text;
					if($urdu_text == "")
					{
						$urdu_text=$urdu;
					}
					$title = $data['title'];
					$host = $data['host'];
					$path = $data['path'];
					
					$description = substr($data['description'], 0,254);
					$keywords=$data['keywords'];
					$sites_url_parts = parse_url($sites_url);
					$domain_for_db = $sites_url_parts['host'];
					
					if($keywords == "")
					{
						$keywords = $title;
					}
					if($description == "")
					{
						$description =$title;
					}
					
					
					///domain_arr is an array contains the domains in the database 
					///if this url in the domain then no insert else insert this new domain into the database
					if($urdu!="")
					{
					/*
						if (isset($domain_arr[$domain_for_db])) 
						{
							$dom_id = $domain_arr[$domain_for_db];
							
						} 
						else 
						{
							
							mysql_query("insert into domains (domains_url,sites_id) values ('$domain_for_db',$sites_id)");
							if(mysql_error()){echo mysql_error();echo "Line :272";}
							$dom_id = mysql_insert_id();
							$domain_arr[$domain_for_db] = $dom_id;
						}*/
					}
					
					

					//if there are words to index, add the link to the database, get its id, and add the word + their relation
					if ($urdu!="") 
					{
						if ($md5sum == '') 
						{
							$time=mktime();
							mysql_query ("insert into crawled_links (sites_id, crawled_links_url, crawled_links_title, crawled_links_keywords, crawled_links_description,crawled_links_urdu_headings,crawled_links_urdu_paragraph, crawled_links_urdu_text, crawled_links_crawled_time, crawled_links_size, crawled_links_md5sum, crawled_links_level) values ('$site_id', '$sites_url', '$title','$keywords', '$description','$urdu_h','$urdu_p', '$urdu_text',$time, '$pageSizeUrdu', '$newmd5sum', $thislevel)");
							if(mysql_error()){echo mysql_error();echo "Line :285";}
						
							/*$result = mysql_query("select crawled_links_id from crawled_links where crawled_links_url='$sites_url'");
							if(mysql_error()){echo mysql_error();echo "Line :288";}
							$row = mysql_fetch_row($result);
							$link_id = $row[0];
							*/
							//save_keywords($wordarray, $link_id, $dom_id);
							
							printStandardReport('crawled', $command_line);
						}
						else if (($md5sum <> '') && ($md5sum <> $newmd5sum)) 
						{ //if page has changed, start updating
						
							$time=mktime();
							$result = mysql_query("select crawled_links_id from crawled_links where crawled_links_url='$sites_url'");
							if(mysql_error()){echo mysql_error();echo "Line :301";}
							$row = mysql_fetch_row($result);
							$link_id = $row[0];
							
							
							$query = "update crawled_links set crawled_links_title='$title', crawled_links_keywords='$keywords',crawled_links_description ='$description',crawled_links_urdu_headings='$urdu_h', crawled_links_urdu_paragraph='$urdu_p',crawled_links_urdu_text = '$urdu_text', crawled_links_crawled_time=$time, crawled_links_size = '$pageSizeUrdu', crawled_links_md5sum='$newmd5sum', crawled_links_level=$thislevel where crawled_links_id=$link_id";
							mysql_query($query);
							if(mysql_error()){echo mysql_error();echo "Line :308";}
							printStandardReport('re-crawled', $command_line);
						}
					}///end of if (urdu !="")
					else
					{
						printStandardReport('not_urdu', $command_line);

					}
					
					/*
					echo "<pre>";
					print_r($data);
					echo $urdu;
					print_r($links);
					echo "</pre>";
					exit();
						*/
					
				}///end of if (ok to crawl =1)
			}///end of if md5sum != newmd5sum
		} ///end of if url status = ok
		else
		{
			$deletable = 1;
			printUrlStatus($sites_url_status['state'], $command_line);

		}
		if ($re_crawl ==1 && $deletable == 1) 
		{
			
			check_for_removal($sites_url); 
		} 
		
		else if ($re_crawl == 1) 
		{
			
		}
		if (!isset($all_links))
		{
			$all_links = 0;
		}
		if (!isset($numoflinks)) 
		{
			$numoflinks = 0;
		}
		printLinksReport($numoflinks, $all_links, $command_line);
		
		return true;
	
	}

	////////////////////////////////////////////////////////////////////////////
	///////////////end of crawl url function///////////////////////////////
	///////////////////////////////////////////////////////////////////////////
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
	
	////////////////////////////////////////////////////////////////////////////
	///////////////start of crawl site function///////////////////////////////
	///////////////////////////////////////////////////////////////////////////
		


	function crawl_site($sites_url, $re_crawl, $maxlevel, $soption, $check_domain,$command_line)
	{
		//echo "$sites_url, $re_crawl, $maxlevel, $soption, $check_domain";
		//echo "functions is called crawl_site\n";
		
		global $tmp_urls;
		global $domain_arr;
		global $stop_crawling_domain;
		
		$sites_url_complete = parse_url($sites_url);
		if ($sites_url_complete['path'] == '')
			$sites_url = $sites_url . "/";
		
		$t = microtime();///get the time in micro secods
		$a =  getenv("REMOTE_ADDR");///get the remote address of server 127.0.0.0 etc
		$sessid = md5 ($t.$a);///create a md5 sum with time and remote address
	
	
		
		$sites_url_parts = parse_url($sites_url);
	
		//print_r($sites_url_parts);
	
		$domain = $sites_url_parts['host'];///get to domain from the url
		if (isset($sites_url_parts['port']))
		{
			$port = (int)$sites_url_parts['port'];
		}
		else 
		{
			$port = 80;
		}

		/*****************************
		the link which is going to crawl is first insert into temp table then its links in pending table and when crawled then in crawled_links table and deleting from temp and pending
		*******************************/
		
		
		//////getting the url id , it return true if url is already inserted in the database
		
		$result = mysql_query("select sites_id from sites where sites_url='$sites_url'");
		if(mysql_error()){echo mysql_error();echo "Line :411";}
		$row = mysql_fetch_row($result);
		$sites_id = $row[0];
		//echo $sites_id;
		//echo "site id of this url is $sites_id";
		//exit();
		
		/////if the url is re crawling 
		if ($sites_id != "" && $re_crawl == 1)
		{
			////insert this url link in temp table
			mysql_query ("insert into temp (temp_link, temp_link_level, temp_id) values ('$sites_url', 0, '$sessid')");
			if(mysql_error()){echo mysql_error();echo "Line :422";}
			//echo "error";
			//echo "data is inserting in temp table\n";
				//echo "re crawling\n";
			
			////select the already crawled url from database to crawled again these url of website
			$result = mysql_query("select crawled_links_url, crawled_links_level from crawled_links where sites_id = $sites_id");
			if(mysql_error()){echo mysql_error();echo "Line :429";}
			while ($row = mysql_fetch_array($result))
			{
				///insert all crawled link  of the web site to temp table for re crawling
				$site_link = $row['crawled_links_url'];
				$link_level = $row['crawled_links_level'];
				if ($site_link != $sites_url) 
				{
					mysql_query ("insert into temp (temp_link, temp_link_level, temp_id) values ('$site_link', $link_level, '$sessid')");
				
				}
			}
			
			$qry = "update sites set sites_crawl_date=now(), sites_depth = $maxlevel,  sites_leave_domain=$check_domain where sites_id=$sites_id";
			mysql_query ($qry);
			if(mysql_error()){echo mysql_error();echo "Line :444";}
			
		} 
		else if ($sites_id == "") 
		{
			//echo "insert then crawling\n";
			//echo "dont beleive this section is running";
			////if the url is not in the database , so first add this url into the database and then crawl
			mysql_query ("insert into sites (sites_url, sites_crawl_date, sites_depth,  sites_leave_domain) values('$sites_url', now(), $maxlevel, $check_domain)");
			if(mysql_error()){echo mysql_error();echo "Line :454";}
			
			////url is inserted in the database now select its id
			$result = mysql_query("select sites_id from sites where sites_url='$sites_url'");
			$row = mysql_fetch_row($result);
			$sites_id = $row[0];
			
		} 
		else
		{
			//echo "update then crawling";
			
			///if url is already in the database then simply updates its other values
			mysql_query ("update sites set sites_crawl_date=now(), sites_depth = $maxlevel, sites_leave_domain=$check_domain where sites_id=$sites_id");
			if(mysql_error()){echo mysql_error();echo "Line :466";}
		}
		
		/////select other url of that url from pending tables 
		$result = mysql_query("select sites_id, pending_temp_id, pending_level, pending_count, pending_num from pending where sites_id='$sites_id'");
		if(mysql_error()){echo mysql_error();echo "Line :471";}
		$row = mysql_fetch_row($result);
		$pending_sites_id = $row[0];
		$level = 0;
		
		////get the domains url from database
		$domain_arr = get_domains_from_db();
		$pending_site=false;
		
		
		if ($pending_sites_id == '')
		{
			//echo "pending table donot contain any link of this webiste\n";
			
			///its mean the sites url is crawled for the first time
			mysql_query ("insert into temp (temp_link, temp_link_level, temp_id) values ('$sites_url', 0, '$sessid')");
			if(mysql_error()){echo mysql_error();echo "Line :485";}
		} 
		else if ($pending_sites_id != '') 
		{
			//echo "pending table contains links ";
		
			
			///its mean the site is crawling of site is not crawled for the first time
			$pending_site=true;
			printStandardReport('continueSuspended',$command_line);
		//	mysql_query("select pending_temp_id, pending_level, pending_count from pending where sites_id=$sites_id");
			if(mysql_error()){echo mysql_error();echo "Line :494";}
			$sessid = $row[1];
			$level = $row[2];
			$pend_count = $row[3] + 1;
			$num = $row[4];
			$pending_sites_id = 1;///means sites links are pending
			$tmp_urls = get_temp_urls($sessid);
			//print_r($row);
		
			//echo "getting the temp urls of this sessionid";
		}
	
		
		if ($re_crawl != 1 && $pending_site==false) 
		{
			//echo "if crawling then insert it into pending table";
			
			mysql_query ("insert into pending (sites_id, pending_temp_id, pending_level, pending_count) values ($sites_id, '$sessid', 0, 0)");
			if(mysql_error()){echo mysql_error();echo "Line :510";}
			
			
		}
		
	
		$time = time();
	
		/*
		Read robots.txt file in the server, to find any disallowed files/folders
		*/
		$disallowed_link = check_robot_txt($sites_url);
		
		//echo "read robot txt and find disallowed links";
		
		printHeader ($disallowed_link, $sites_url, $command_line);
	//////////////////////////////////////////////////////////////
	
		$mainurl = $sites_url;
		$num = 0;
		/*echo $soption;
		echo $level;
		echo $maxlevel;*/
	////while level of the link is less the crawled level from 0 to ....
		while (($level <= $maxlevel && $soption == 'level') || ($soption == 'full'))
		{
			//echo "while level is less then max level";
			
			
			///count is a variable that is used to know that how many links of the website has been crawled , 
			// e.g websites has 100 links to crawl , but when 50 links crawled , the function stop , now 50 more links remaining for crawling , so next time when the function start , it takes value of pending count =50 and start crawling from 50 and end at 100 , in this way the already crawled links do not crawled again.
			if ($pending_sites_id == 1)///if pending_sites_id !=""  
			{
				//or continue crawling the remaining link of that level
				///its mean continue crawling the previous website
				$count = $pend_count;
				$pending_sites_id = 0;
			} 
			else
				$count = 0;////if Pending_sites_id == ""
				///its mean the next level of links is starting now start count from zero
	
	
			$links = array();
	
			$result = mysql_query("select distinct temp_link from temp where temp_link_level=$level && temp_id='$sessid' order by temp_link");
			if(mysql_error()){echo mysql_error();echo "Line :554";}
			$rows = mysql_num_rows($result);
		
			if ($rows == 0)
			{ //// if there are no links in the temp table
				break;
				
				///break from the while loop
			}
	
			$i = 0;
		
	////if there are links in the temp table
			while ($row = mysql_fetch_array($result))
			{////storing all the links of temp table to array name links
				$links[] = $row['temp_link'];
			}
			
			//echo "temp link are selected from database";
			
			reset ($links);

			////num==0
			while ($count < count($links)) 
			{
				
				$num++;
				$thislink = $links[$count];////resuming the crawling
				$sites_url_parts = parse_url($thislink);
				
				
				reset($disallowed_link); /// reset the array pointer to first index of array
				
				
				$forbidden = 0;
				foreach ($disallowed_link as $disallowed_linkurl)
				{
					$disallowed_linkurl = trim($disallowed_linkurl);
	
					$disallowed_linkurl_parts = parse_url($disallowed_linkurl);
					if ($disallowed_linkurl_parts['scheme'] == '')
					{
						$check_omit = $sites_url_parts['host'] . $disallowed_linkurl;
					} else
					{
						$check_omit = $disallowed_linkurl;
					}
	
	
					///if the disallowed link is matched then delete
					if (strpos($thislink, $check_omit))
					{
						printRobotsReport($num, $thislink, $command_line);
						check_for_removal($thislink);///deleting the link from database 
						$forbidden = 1;
						break;
					}
				}
			
			//	echo "removing disallowed links";
			 
				if ($forbidden == 0) 
				{
					///if access to this link is not forbidden
					printRetrieving($num, $thislink, $command_line);
					
				//	echo "selecting link from crawledlink table";
					
					$query = "select crawled_links_md5sum, crawled_links_crawled_time from  crawled_links where crawled_links_url='$thislink'";
					$result = mysql_query($query);
					if(mysql_error()){echo mysql_error();echo "Line :621";}
					
					$rows = mysql_num_rows($result);
			//echo "i am here";echo $forbidden;echo $thislink;echo "rows :".$rows;exit();		
					if ($rows == 0)
					{
						//echo "now crawling the link $thislink";
					//	echo "$thislink, $level+1, $sites_id, '',  $domain, '', $sessid, $check_domain ,$re_crawl";exit();
						$crawl_url_return=crawl_url($thislink, $level+1, $sites_id, '',  $domain, '', $sessid, $check_domain, $re_crawl);
			
							
						mysql_query("update pending set pending_level = $level, pending_count=$count, pending_num=$num where sites_id=$sites_id");
						if(mysql_error()){echo mysql_error();echo "Line :632";}
				
					
					}
					else if ($rows <> 0 && $re_crawl == 1) 
					{
						$row = mysql_fetch_array($result);
						$md5sum = $row['crawled_links_md5sum'];
						$crawled_time = $row['crawled_links_crawled_time'];
						
					//	echo "now recrawling the link $thislink";
						
						$crawl_url_return=crawl_url($thislink, $level+1, $sites_id, $md5sum,  $domain, $crawled_time, $sessid, $check_domain, $re_crawl);
						
						mysql_query("update pending set pending_level = $level, pending_count=$count, pending_num=$num where sites_id=$sites_id");
						if(mysql_error()){echo mysql_error();echo "Line :645";}
					}
					else 
					{
						printStandardReport('inDatabase',$command_line);
					}
					
					
					///it the first page of website is crawled and it is not in urdu , then no furthur crawling , function stop crawling here
					if($crawl_url_return == false)
					{
						
						$level=$maxlevel;
						$soption="level";
						$count=count($links);
						mysql_query("update sites set sites_lang = 'not_urdu' where sites_id=$sites_id");
						$r=mysql_query("select domains_id from domains_not_urdu where domains_not_urdu_url='$sites_url'");
						$numd=mysql_num_rows($r);
						if($numd>0)
						{}
						else
						{
							mysql_query("insert into domains_not_urdu(domains_not_urdu_url,sites_id) values('$sites_url',$sites_id)");
						
						}
						
					
					}
					else
					{
						
						$r=mysql_query("select domains_id from domains where domains_url='$sites_url'");
						$numd=mysql_num_rows($r);
						if($numd>0)
						{}
						else
						{
							mysql_query("insert into domains(domains_url,sites_id) values('$sites_url',$sites_id)");
						
						}

					
					}
				}
				$count++;
			}///end of while (count < total links)
			$level++;
			
			///deleting the previous level links from database
			$delete_level=$level-1;
			mysql_query ("delete from temp where temp_id = '$sessid' and temp_link_level=$delete_level");
			if(mysql_error()){echo mysql_error();echo "Line :668";}
			//echo "stop";
			//exit();
			//exit();
			/*echo $soption;
			echo $level;
			echo $maxlevel;*/
			
			
			
		}////end of while ( level <= maxlevel)
	
		mysql_query ("delete from temp where temp_id = '$sessid'");
		if(mysql_error()){echo mysql_error();echo "Line :681";}
		mysql_query ("delete from pending where sites_id = '$sites_id'");
		if(mysql_error()){echo mysql_error();echo "Line :684";}
		printStandardReport('completed',$command_line);
		
		//echo "delete from temp and pending";
	
	}////end of function crawl_site
	
	////////////////////////////////////////////////////////////////////////////
	///////////////end of crawl site function///////////////////////////////
	///////////////////////////////////////////////////////////////////////////
		
	
	
	
	
	
	
	function re_crawl_all($command_line,$limit)
	{
		///select all the url from table sites , wether it is crawled or not
		$result=mysql_query("select sites_url, sites_depth, sites_leave_domain from sites where sites_crawl_date IS NOT NULL limit $limit");
		if(mysql_error()){echo mysql_error();echo "Line :691";}
    	
		///re crawl all url one by one
		while ($row=mysql_fetch_row($result))
		{
			//print_r($row);
    		
			$sites_url = $row[0];
	   		$depth = $row[1];
    		$check_domain = $row[2];
    		if ($check_domain==''||$check_domain==0||$check_domain==NULL) 
			{
    			$check_domain=0;
    		}
    		if ($depth == -1) 
			{
    			$soption = 'full';
				$maxlevel=$depth;
    		} 
			else 
			{
    			$soption = 'level';
				$maxlevel=$depth;
    		}
			
			crawl_site($sites_url,1, $maxlevel, $soption, $check_domain,$command_line);
			
			$sites_url=""; $maxlevel=""; $soption=""; $check_domain="";


		}
		
	}

	function crawl_all_new_sites($command_line,$limit)
	{	
	
		
		///select all the url from table sites , wether it is crawled or not
		$result=mysql_query("select sites_url, sites_depth, sites_leave_domain from sites where sites_crawl_date IS NULL limit $limit");
	
		if(mysql_error()){echo mysql_error();echo "Line :727";}
    	
		///re crawl all url one by one
		while ($row=mysql_fetch_row($result))
		{
			//print_r($row);
    		
			$sites_url = $row[0];
	   		$depth = $row[1];
    		$check_domain = $row[2];
    		if ($check_domain==''||$check_domain==0||$check_domain==NULL) 
			{
    			$check_domain=0;
    		}
    		if ($depth == -1) 
			{
    			$soption = 'full';
				$maxlevel=$depth;
    		} 
			else 
			{
				$maxlevel=$depth;
    			$soption = 'level';
    		}
			
			crawl_site($sites_url,0, $maxlevel, $soption, $check_domain , $command_line);
			
			$sites_url="";  $maxlevel=""; $soption=""; $check_domain="";


		}
		
	}
	
	function crawl_all_pending_sites($command_line,$limit)
	{	
	
		$result=mysql_query("select sites_id from pending");
	
		
		if(mysql_error()){echo mysql_error();echo "Line :727";}
    	
		///re crawl all url one by one
		while ($row=mysql_fetch_row($result))
		{
			//print_r($row);
    		$site_id_new=$row[0];
			///select all the url from table sites , wether it is crawled or not
			$result1=mysql_query("select sites_url, sites_depth, sites_leave_domain from sites where sites_id=$site_id_new limit $limit");
				//echo $site_id_new;
			while ($row1=mysql_fetch_row($result1))
			{	//print_r($row1);
				
				$sites_url = $row1[0];
				$depth = $row1[1];
				$check_domain = $row1[2];
				if ($check_domain==''||$check_domain==0||$check_domain==NULL) 
				{
					$check_domain=0;
				}
				if ($depth == -1) 
				{
					$soption = 'full';
					$maxlevel=$depth;
				} 
				else 
				{
					$maxlevel=$depth;
					$soption = 'level';
				}
				
				crawl_site($sites_url,0, $maxlevel, $soption, $check_domain , $command_line);
				
				$sites_url="";  $maxlevel=""; $soption=""; $check_domain="";

			}
		}
		
	}
	
	
?>