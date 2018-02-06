<?php 
include "authorization_admin.php";


if ($_crawl_numbers=="") {
	$_crawl_numbers=0;
} 

if ($_index_xls=="") {
	$_index_xls=0;
} 

if ($_index_ppt=="") {
	$_index_ppt=0;
}

if ($_index_pdf=="") {
	$_index_pdf=0;
} 

if ($_index_doc=="") {
	$_index_doc=0;
} 

if ($_min_delay=="") {
	$_min_delay=0;
} 

if ($_crawl_host=="") {
	$_crawl_host=0;
}
if ($_keep_log=="") {
	$_keep_log=0;
}
if ($_show_meta_description=="") {
	$_show_meta_description=0;
}

if ($_show_categories=="") {
	$_show_categories=0;
}

if ($_show_query_scores=="") {
	$_show_query_scores=0;
}

if ($_email_log=="") {
	$_email_log=0;
}

if ($_print_results=="") {
	$_print_results=0;
}


if ($_crawl_meta_keywords=="") {
	$_crawl_meta_keywords=0;
}

if ($_crawl_host=="") {
	$_crawl_host=0;
}

if ($_advanced_search=="") {
	$_advanced_search=0;
}

if ($_merge_site_results == "") {
	$_merge_site_results = 0;
}

if ($_did_you_mean_enabled == "") {
	$_did_you_mean_enabled = 0;
}

if ($_stem_words == "") {
	$_stem_words = 0;
}

if ($_strip_sessids == "") {
	$_strip_sessids = 0;
}

if ($_suggest_enabled == "") {
	$_suggest_enabled = 0;
}

if ($_suggest_history == "") {
	$_suggest_history  = 0;
}

if ($_suggest_phrases == "") {
	$_suggest_phrases = 0;
}

if ($_suggest_keywords == "") {
	$_suggest_keywords = 0;
}

if ($_suggest_rows == "") {
 $_suggest_rows = 0;
}




if (isset($_POST['Submit']))
 {
	if (!is_writable("spider_files/spider_includes/configuration.php")) 
	{
		print "Configuration file is not writable, chmod 666 configuration.php under *nix systems";
	}
	else 
	{
		$fhandle=fopen("spider_files/spider_includes/configuration.php","wb");
		fwrite($fhandle,"<?php \n");
		fwrite($fhandle,"/***********************\n Urdu Search Engine configuration file\n***********************/");
		fwrite($fhandle,"\n\n\n/*********************** \nGeneral settings \n***********************/");
		fwrite($fhandle, "\n\n// Crawler version \n");
		fwrite($fhandle,"$"."version_nr			= '".$_version_nr. "';");
		fwrite($fhandle, "\n\n//Language of the search page \n");
		fwrite($fhandle,"$"."language			= '".$_language. "';");
		fwrite($fhandle, "\n\n// Template name/directory in templates dir\n");
		fwrite($fhandle,"$"."template	= '".$_template. "';");
		fwrite($fhandle, "\n\n//Administrators email address (logs can be sent there)	\n");
		fwrite($fhandle,"$"."admin_email		= '".$_admin_email. "';");
		fwrite($fhandle, "\n\n// Print crawling results to standard out\n");
		fwrite($fhandle,"$"."print_results		= ".$_print_results. ";");
		fwrite($fhandle, "\n\n// Temporary directory, this should be readable and writable\n");
		fwrite($fhandle,"$"."tmp_dir	= '".$_tmp_dir. "';");

		fwrite($fhandle,"\n\n\n/*********************** \nLogging settings \n***********************/");
		fwrite($fhandle, "\n\n// Should log files be kept\n");
		fwrite($fhandle,"$"."keep_log			= ".$_keep_log. ";");
		fwrite($fhandle, "\n\n//Log directory, this should be readable and writable\n");
		fwrite($fhandle,"$"."log_dir	= '".$_log_dir. "';");
		fwrite($fhandle, "\n\n// Log format\n");
		fwrite($fhandle,"$"."log_format			= '".$_log_format. "';");
		fwrite($fhandle, "\n\n//  Send log file to email \n");
		fwrite($fhandle,"$"."email_log			= ".$_email_log. ";");

		fwrite($fhandle,"\n\n\n/*********************** \nCrawler settings \n***********************/");
		fwrite($fhandle, "\n\n// Crawl numbers as well\n");
		fwrite($fhandle,"$"."crawl_numbers		= ".$_crawl_numbers. ";");
		fwrite($fhandle,"\n\n// if this value is set to 1, word in domain name and url path are also indexed,// so that for example the index of www.php.net returns a positive answer to query 'php' even 	// if the word is not included in the page itself.\n");
		fwrite($fhandle,"$"."crawl_host		 = ".$_crawl_host.";\n");
		fwrite($fhandle, "\n\n// Wether to index keywords in a meta tag \n");
		fwrite($fhandle,"$"."crawl_meta_keywords = ".$_crawl_meta_keywords. ";");		
		fwrite($fhandle, "\n\n// User agent string \n");
		fwrite($fhandle,"$"."user_agent			 = '".$_user_agent. "';");
		fwrite($fhandle, "\n\n// Minimal delay between page downloads \n");
		fwrite($fhandle,"$"."min_delay			= ".$_min_delay. ";");
		fwrite($fhandle, "\n\n// Strip session ids (PHPSESSID, JSESSIONID, ASPSESSIONID, sid) \n");
		fwrite($fhandle,"$"."strip_sessids			= ".$_strip_sessids. ";");

		
		fwrite($fhandle,"?>");
		fclose($fhandle);
	
	}
		//header("location: admin.php");		
} 	
include "spider_files/spider_includes/configuration.php"; 
?>


 <!-- Form elements -->    
            <div class="grid_12">
            
                <div class="module">
                     <h2><span>General Settings</span></h2>
                        
                     <div class="module-body">
                        <form name="form1" method="post" action="admin.php">
                        
                            <input type="hidden" name="page_value" value="settings">
							<input type="hidden" name="Submit" value="1">
                            
                            <p>
                                <label></label>
                                <input name="_version_nr" value="<?php print $version_nr;?>" type="hidden" class="input-short" />
                                <?php print $version_nr;?> : 
								Urdu Search Engine version
                            </p>
                            
                           
                            
                                                        
                            <p>
                                <label>Language (Urdu Search Engine , اردو )</label>
                                <select class="input-short" name="_language">
                                    <option value="ur" <?php  if ($language == "ur") echo "selected";?>>Urdu</option>

									<option value="ar" <?php  if ($language == "ar") echo "selected";?>>Arabic</option>
									<option value="bg" <?php  if ($language == "bg") echo "selected";?>>Bulgarian</option>
									<option value="hr" <?php  if ($language == "hr") echo "selected";?>>Croatian</option>
									<option value="cns" <?php  if ($language == "cns") echo "selected";?>>Simple Chinese</option>
									<option value="cnt" <?php  if ($language == "cnt") echo "selected";?>>Traditional Chinese</option>
									<option value="cz" <?php  if ($language == "cz") echo "selected";?>>Czech</option>
									<option value="nl" <?php  if ($language == "nl") echo "selected";?>>Dutch</option>
									<option value="en" <?php  if ($language == "en") echo "selected";?>>English</option>
									<option value="ee" <?php  if ($language == "ee") echo "selected";?>>Estonian</option>
									<option value="fi" <?php  if ($language == "fi") echo "selected";?>>Finnish</option>
									<option value="fr" <?php  if ($language == "fr") echo "selected";?>>French</option>
									<option value="de" <?php  if ($language == "de") echo "selected";?>>German</option>
									<option value="hu" <?php  if ($language == "hu") echo "selected";?>>Hungarian</option>
									<option value="it" <?php  if ($language == "it") echo "selected";?>>Italian</option>
									<option value="lv" <?php  if ($language == "lv") echo "selected";?>>Latvian</option>
									<option value="pl" <?php  if ($language == "pl") echo "selected";?>>Polish</option>
									<option value="pt" <?php  if ($language == "pt") echo "selected";?>>Portuguese</option>
									<option value="ro" <?php  if ($language == "ro") echo "selected";?>>Romanian</option>
									<option value="ru" <?php  if ($language == "ru") echo "selected";?>>Russian</option>
									<option value="sr" <?php  if ($language == "sr") echo "selected";?>>Serbian</option>
									<option value="sk" <?php  if ($language == "sk") echo "selected";?>>Slovak</option>
									<option value="si" <?php  if ($language == "si") echo "selected";?>>Slovenian</option>
									<option value="es" <?php  if ($language == "es") echo "selected";?>>Spanish</option>
									<option value="se" <?php  if ($language == "se") echo "selected";?>>Swedish</option>
									<option value="tr" <?php  if ($language == "tr") echo "selected";?>>Turkish</option>

                                </select>
								
								<!--<SELECT name="_template">
							<?php 
								/*$directories = get_dir_contents($template_dir);
								if (count($directories)>0) 
								{
									for ($i=0; $i<count($directories); $i++)
									{
										$dir=$directories[$i];
										?>
											<option value="<?php print $dir;?>" <?php  if ($template == $dir) echo "selected";?>><?php print $dir;?></option>
											<?php 
									}
								}
							*/
							?>

							</SELECT>Search template
								-->							
								
								
                            </p>
                            
                           
                             <p>
                                <label>Administrator e-mail address</label>
                                <input type="text" class="input-short"  name="_admin_email" value="<?php print $admin_email;?>"/>
                            </p>
                            
                                
                            <fieldset>
                                
                                <ul>
                                    <li><label><input name="_print_results" type="checkbox" id="print_results" value="1" <?php  if
									($print_results==1) echo "checked";?> id="cb1" /> Print crawling results to standard out</label></li>
                                    
                                </ul>
                            </fieldset>
							
							<p>
                                <label>Temporary directory (absolute or relative to admin directory)</label>
                                <input type="text" class="input-short"  name="_tmp_dir"   value="<?php print $tmp_dir;?>"/>
                                
							
                            </p>
							
				<h2><span>Logging Settings</span></h2>
                       
							 <fieldset>
                                
                                <ul>
                                    <li><label><input  id="cb1" name="_keep_log" type="checkbox"  value="1" <?php  if
									($keep_log==1) echo "checked";?> />
										Log crawling results		
										</label>
									</li>
                                    <li><label><input  id="cb1" name="_email_log" type="checkbox"  value="1" <?php  if
									($email_log==1) echo "checked";?>/>
										Send crawling log to e-mail
									</label></li>
                                </ul>
                            </fieldset>
                           
                             <p>
                                <label> Log directory (absolute or relative to admin directory)</label>
                                <input type="text" class="input-short" name="_log_dir"  value="<?php print $log_dir;?>"  />
                            </p>
							
							<p>
                                <label>Log file format</label>
                                <select class="input-short" name="_log_format">
								<option value="text" <?php  if ($log_format == "text") echo "selected";?>>Text</option>
								<option value="html" <?php  if ($log_format == "html") echo "selected";?>>Html</option>

								</select>
							</p>	
							
							
				<h2><span>Crawling Settings</span></h2>
                       
					   
						   
					   
							<p>
                                <label> User agent string</label>
                                <input type="text" class="input-short"  name="_user_agent" value="<?php print $user_agent;?>"  />
                            </p>
							 <p>
                                <label>Minimal delay between page downloads </label>
                                <input type="text" class="input-short" name="_min_delay" value="<?php print $min_delay;?>" />
                            </p>
							<fieldset>
                                
                                <ul>
                                    <li><label><input  id="cb1" name="_crawl_numbers" type="checkbox" value="1"  <?php  if($crawl_numbers==1) echo "checked";?>/>
										Crawling Numbers		
										</label>
									</li>
                                    <li><label><input  id="cb1" name="_crawl_host" type="checkbox"  value="1"  <?php  if ($crawl_host==1)echo "checked";?>/>
										Crawl words in domain name and url path
									</label></li>
									<li><label><input  id="cb1" name="_crawl_meta_keywords" type="checkbox"  value="1"  <?php  if ($crawl_meta_keywords==1) echo"checked";?>/>
										Crawl meta keywords		
										</label>
									</li>
                                    <li><label><input  id="cb1" name="_strip_sessids" type="checkbox"  value="1"  <?php  if ($strip_sessids==1) echo"checked";?>/>
										Strip session ids (PHPSESSID, JSESSIONID, ASPSESSIONID, sid)
									</label></li>
                                </ul>
                            </fieldset>
							
							
							
							
							
							
							
                            <fieldset>
							<span class="submit-green">Save Button is Disable due under construction</span>
                              <!--  <input class="submit-green" type="submit" value="Save settings" /> -->
                                
                            </fieldset>
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div> <!-- End .grid_12 -->


