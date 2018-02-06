<?php 
/***********************
 Urdu Search Engine configuration file
***********************/


/*********************** 
General settings 
***********************/

// Crawler version 
$version_nr			= '1.0';

//Language of the search page 
$language			= 'ur';

// Template name/directory in templates dir
$template	= 'standart/templates';

//Administrators email address (logs can be sent there)	
$admin_email		= 'admin@localhost';

// Print crawling results to standard out
$print_results		= 1;

// Temporary directory, this should be readable and writable
$tmp_dir	= 'tmp';


/*********************** 
Logging settings 
***********************/

// Should log files be kept
$keep_log			= 1;

//Log directory, this should be readable and writable
$log_dir	= 'spider_files/crawling_log';

// Log format
$log_format			= 'text';

//  Send log file to email 
$email_log			= 1;


/*********************** 
Crawler settings 
***********************/

// Crawl numbers as well
$crawl_numbers		= 1;

// if this value is set to 1, word in domain name and url path are also indexed,// so that for example the index of www.php.net returns a positive answer to query 'php' even 	// if the word is not included in the page itself.
$crawl_host		 = 0;


// Wether to index keywords in a meta tag 
$crawl_meta_keywords = 1;

// User agent string 
$user_agent			 = 'USE';

// Minimal delay between page downloads 
$min_delay			= 0;

// Strip session ids (PHPSESSID, JSESSIONID, ASPSESSIONID, sid) 
$strip_sessids			= 1;?>