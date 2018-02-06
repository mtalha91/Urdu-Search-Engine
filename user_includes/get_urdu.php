<?php


		include("get_urdu_functions.php");
	////////////////////////////////////////////////////////////////////////////
	///////////////start of crawl url function///////////////////////////////
	///////////////////////////////////////////////////////////////////////////
		
	function crawl_url($sites_url) 
	{
		
		$sites_url_status = url_status($sites_url);
		
		
		////if the page is redirected to another page  , then
		if (strstr($sites_url_status['state'], "Relocation")) 
		{
		
			////url_purify is function to make a correct link of webpage
			
			$sites_url = preg_replace("/ /", "", url_purify($sites_url_status['path'], $sites_url));

			if ($sites_url <> '') 
			{
				
			}

			$sites_url_status['state'] == "redirected";
			return $sites_url_status;
			
		}

		$min_delay= 0;

		$delay_time = 0;
		$file_state="";
		
		ini_set("user_agent", "use");
	
		///if status is 200
		if ($sites_url_status['state'] == 'ok')
		{
			$ok_to_crawl = 1;
		
			if (time() - $delay_time < $min_delay) 
			{
				sleep ($min_delay- (time() - $delay_time));
			}
			
			$delay_time = time();
			$file_read_error = 0;
			
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
				$file_state=$contents['state'];
				
			}
			
			if ($ok_to_crawl == 1) 
			{	
				
					/////extract urdu from webpage data $file
					$urdu = extract_urdu($file);
					
					$sites_url_status['urdu']= $urdu;
					//print_r($sites_url_status);
					return $sites_url_status;
					
				
				
			}
		} ///end of if url status = ok
		else
		{
			return $sites_url_status;

		}
		
	}

	////////////////////////////////////////////////////////////////////////////
	///////////////end of crawl url function///////////////////////////////
	///////////////////////////////////////////////////////////////////////////
		





	if(isset($_POST['url']))
	{
		if($_POST['url']!="")
		{
			$sites_url=$_POST['url'];
			//echo $sites_url;
			
			$data=crawl_url($sites_url);
			
			if($data['state']=="ok")
			{
				$urdu=$data['urdu'];
				if($urdu!="")
				{
					session_start();
					
					$_SESSION['urdu']=$urdu;
					$_SESSION['sitesurl']=$sites_url;
					
					header("Location:../user.php?page_value=check_urdu&error=no");
				}
				else
				{
							$err="The Requested Url is NOT in URDU Langauge";
				header("Location:../user.php?page_value=check_urdu&error=$err");
	
				}
				//////////////////////////////////////////////////////
				////////////////////////////////////////////////////////
				//////////////////////////////////////////////////////
			}
			else
			{
				$err=$data['state'];
				header("Location:../user.php?page_value=check_urdu&error=$err");
		
			}
		}	
		else
		{
			header("Location:../user.php?page_value=check_urdu&error=empty_input");
		}
	
	}
	else
	{
		header("Location:../user.php?page_value=check_urdu&error=empty_input");
	}

?>