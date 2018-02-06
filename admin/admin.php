<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ur" lang="ur" >

<head><title>Urdu Search Engine Admin</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta http-equiv="content-language" content="ur"/>
<meta charset="utf-8">
	 <!-- CSS Reset -->
		<link rel="stylesheet" type="text/css" href="templates/css-js-images/reset.css" tppabs="http://www.xooom.pl/work/magicadmin/css/reset.css" media="screen" />
       
        <!-- Fluid 960 Grid System - CSS framework -->
		<link rel="stylesheet" type="text/css" href="templates/css-js-images/grid.css" tppabs="http://www.xooom.pl/work/magicadmin/css/grid.css" media="screen" />
		
        
        <!-- Main stylesheet -->
        <link rel="stylesheet" type="text/css" href="templates/css-js-images/styles.css" tppabs="http://www.xooom.pl/work/magicadmin/css/styles.css" media="screen" />
        
        <!-- WYSIWYG editor stylesheet -->
        <link rel="stylesheet" type="text/css" href="templates/css-js-images/jquery.wysiwyg.css" tppabs="http://www.xooom.pl/work/magicadmin/css/jquery.wysiwyg.css" media="screen" />
        
        <!-- Table sorter stylesheet -->
        <link rel="stylesheet" type="text/css" href="templates/css-js-images/tablesorter.css" tppabs="http://www.xooom.pl/work/magicadmin/css/tablesorter.css" media="screen" />
        
        <!-- Thickbox stylesheet -->
        <link rel="stylesheet" type="text/css" href="templates/css-js-images/thickbox.css" tppabs="http://www.xooom.pl/work/magicadmin/css/thickbox.css" media="screen" />
        
        <link rel="stylesheet" type="text/css" href="templates/css-js-images/theme-blue.css" tppabs="http://www.xooom.pl/work/magicadmin/css/theme-blue.css" media="screen" />
        
		<!-- JQuery engine script-->
		<script type="text/javascript" src="templates/css-js-images/jquery-1.3.2.min.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery-1.3.2.min.js"></script>
        
		<!-- JQuery WYSIWYG plugin script -->
		<script type="text/javascript" src="templates/css-js-images/jquery.wysiwyg.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery.wysiwyg.js"></script>
        
        <!-- JQuery tablesorter plugin script-->
		<script type="text/javascript" src="templates/css-js-images/jquery.tablesorter.min.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery.tablesorter.min.js"></script>
        
		<!-- JQuery pager plugin script for tablesorter tables -->
		<script type="text/javascript" src="templates/css-js-images/jquery.tablesorter.pager.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery.tablesorter.pager.js"></script>
        
		<!-- JQuery password strength plugin script -->
		<script type="text/javascript" src="templates/css-js-images/jquery.pstrength-min.1.2.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery.pstrength-min.1.2.js"></script>
        
		<!-- JQuery thickbox plugin script -->
		<script type="text/javascript" src="templates/css-js-images/thickbox.js" tppabs="http://www.xooom.pl/work/magicadmin/js/thickbox.js"></script>
        
        <!-- Initiate WYIWYG text area -->
		<script type="text/javascript">
			$(function()
			{
			$('#wysiwyg').wysiwyg(
			{
			controls : {
			separator01 : { visible : true },
			separator03 : { visible : true },
			separator04 : { visible : true },
			separator00 : { visible : true },
			separator07 : { visible : false },
			separator02 : { visible : false },
			separator08 : { visible : false },
			insertOrderedList : { visible : true },
			insertUnorderedList : { visible : true },
			undo: { visible : true },
			redo: { visible : true },
			justifyLeft: { visible : true },
			justifyCenter: { visible : true },
			justifyRight: { visible : true },
			justifyFull: { visible : true },
			subscript: { visible : true },
			superscript: { visible : true },
			underline: { visible : true },
            increaseFontSize : { visible : false },
            decreaseFontSize : { visible : false }
			}
			} );
			});
        </script>
        
        <!-- Initiate tablesorter script -->
        <script type="text/javascript">
			$(document).ready(function() { 
				$("#myTable") 
				.tablesorter({
					// zebra coloring
					widgets: ['zebra'],
					// pass the headers argument and assing a object 
					headers: { 
						// assign the sixth column (we start counting zero) 
						6: { 
							// disable it by setting the property sorter to false 
							sorter: false 
						} 
					}
				}) 
			.tablesorterPager({container: $("#pager")}); 
		}); 
		</script>
        
        <!-- Initiate password strength script -->
		<script type="text/javascript">
			$(function() {
			$('.password').pstrength();
			});
        </script>

<!--		<link rel="stylesheet" href="spider_files/spider_includes/admin.css" type="text/css" />-->
	
</head>

<body>
	   
<?php
///***************************///
//spider admin site
//Mohammad Talha
//BSCS Hons BZU Multan
//****************************///
	error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING );

	//set_time_limit (0);
	$include_dir00 = "spider_files";
	$include_dir01 = "spider_files/spider_includes";
	$include_dir02 = "spider_files/spider_functions";
	
	require_once ("$include_dir01/database.php");
	include("$include_dir01/authorization_admin.php");
	include("$include_dir01/admin_displaying_functions.php");
	include("$include_dir01/admin_query_functions.php");
	//include("authorization.php");
	//////////including all variables//////////////
	include("$include_dir01/admin_var.php");
	include("$include_dir01/configuration.php");		

	
	
	//////////////gettting the page value to show/////////////////////
	if(isset($_GET['page_value'])&&$_GET['page_value']!="")
	{
		$page_value=$_GET['page_value'];
	}
	else
	{
		$page_value="dash_board";
	}
	if(isset($_POST['page_value'])&&$_POST['page_value']!="")
	{
		$page_value=$_POST['page_value'];
	}

	
	//////////////////////////////menu bar start///////////////////////
	include("$include_dir01/menubar.php");
	///////////////////////////////menu bar end///////////////////////
	
	
	
	
	
	
?>

	<div class="container_12"><!--main body div-->
     
	
	<?php
	
	
	
	switch($page_value)
	{
		
		case 'dash_board':
					
					show_dash_board();
				
		break;
		case 'main_page':
					$message="";
					$start=1;
					$perpage=30;
					if(isset($_POST['perpage'])&& $_POST['perpage']!="")
					{
						$start=$_POST['start'];
						$perpage=$_POST['perpage'];
					}
					if(isset($_GET['perpage'])&& $_GET['perpage']!="")
					{
						$start=$_GET['start'];
						$perpage=$_GET['perpage'];
					}
					show_sites_url_from_db($message,$start,$perpage);
				
		break;
		case 'add_site':
					show_add_site_form();
		break;
		case 'add_site_query':
		
					$values['sites_url']=$_POST['sites_url'];
					$values['sites_title']=$_POST['sites_title'];
					$values['sites_description']=$_POST['sites_description'];
					$message=add_site_query($values);
					///data is updated to database
					
					$start=1;
					$perpage=30;
					if(isset($_POST['perpage'])&& $_POST['perpage']!="")
					{
						$start=$_POST['start'];
						$perpage=$_POST['perpage'];
					}
					if(isset($_GET['perpage'])&& $_GET['perpage']!="")
					{
						$start=$_GET['start'];
						$perpage=$_GET['perpage'];
					}
					show_sites_url_from_db($message,$start,$perpage);
				
					
				
		break;
		case 're_crawl_all':
					show_re_crawl_all_form();
		break;
		case 'crawl_all_new_sites':
					show_crawl_all_new_sites_form();
		break;
		case 'crawl_all_pending_sites':
					show_crawl_all_pending_sites_form();
		break;
		case 'show_site_data':
					$site_id=$_GET['site_id'];
					
					show_site_data($site_id);
		break;
		case 'log_out':
					session_destroy();
					header("Location: admin.php");
		break;
		case 'edit_site':
					$site_id=$_GET['site_id'];
					
					edit_site($site_id);
		break;
		case 'edit_site_query':
					$values['sites_id']=$_POST['sites_id'];
					$values['sites_url']=$_POST['sites_url'];
					$values['sites_title']=$_POST['sites_title'];
					$values['sites_description']=$_POST['sites_description'];
					
					$values['soption']=$_POST['soption'];
					if($values['soption']=="full")
					$values['sites_depth']=-1;
					else
					$values['sites_depth']=$_POST['sites_depth'];
					if(isset($_POST['sites_leave_domain']))
					$values['sites_leave_domain']=1;
					else
					$values['sites_leave_domain']=0;
					
					$message=edit_site_query($values);
					///data is updated to database
					
					$start=1;
					$perpage=30;
					if(isset($_POST['perpage'])&& $_POST['perpage']!="")
					{
						$start=$_POST['start'];
						$perpage=$_POST['perpage'];
					}
					if(isset($_GET['perpage'])&& $_GET['perpage']!="")
					{
						$start=$_GET['start'];
						$perpage=$_GET['perpage'];
					}
					show_sites_url_from_db($message,$start,$perpage);
					
		break;
		case 'crawl':
					$sites_url=$_GET['sites_url'];
					$sites_id=$_GET['sites_id'];
					if(isset($_GET['re_crawl']))
					{
						$re_crawl=$_GET['re_crawl'];
					}
					else
					{
						$re_crawl="";///if re crawl is not set in $GET array
					}
					show_crawl_screen($sites_id,$sites_url,$re_crawl);
					
		break;
		case 'delete_sites':
					
		break;
		case 'browse_sites_pages':
		/////here the values are passing by two methods , post and get 
		////if get is set then assign values of $get array
		////if post is set then assign values of $post array
					if(isset($_GET['site_id']))
					$sites_id=$_GET['site_id'];
					else
					$sites_id=$_POST['site_id'];
					
					$start=1;
					$perpage=30;
					if(isset($_POST['perpage'])&& $_POST['perpage']!="")
					{
						$start=$_POST['start'];
						$perpage=$_POST['perpage'];
					}
					if(isset($_GET['perpage'])&& $_GET['perpage']!="")
					{
						$start=$_GET['start'];
						$perpage=$_GET['perpage'];
					}
					browse_sites_pages($sites_id,$start,$perpage);
					
		break;
		case 'sites_stats':
					$sites_id=$_GET['site_id'];
					sites_stats($sites_id);
					
		break;
		case 'delete_crawled_links':
					$sites_id=$_GET['site_id'];
					$message="Site is not Allowed to Delete";
					
					
					$start=1;
					$perpage=30;
					if(isset($_POST['perpage'])&& $_POST['perpage']!="")
					{
						$start=$_POST['start'];
						$perpage=$_POST['perpage'];
					}
					if(isset($_GET['perpage'])&& $_GET['perpage']!="")
					{
						$start=$_GET['start'];
						$perpage=$_GET['perpage'];
					}
					show_sites_url_from_db($message,$start,$perpage);
				
		break;
		case 'crawl_direct':
					show_crawl_screen("","","");
		break;
		case 'clean_tables':
					show_clean_tables_form();
					
		break;
		case 'delete_links':
					delete_links();
					
		break;
		case 'delete_temp':
					delete_temp();
					
		break;
		
		case 'settings':
					include("$include_dir01/configure_setting.php");
					
		break;
		case 'crawled_links':
						$start=1;
						$perpage=30;
					if(isset($_POST['perpage'])&& $_POST['perpage']!="")
					{
						$start=$_POST['start'];
						$perpage=$_POST['perpage'];
					}
					if(isset($_GET['perpage'])&& $_GET['perpage']!="")
					{
						$start=$_GET['start'];
						$perpage=$_GET['perpage'];
					}
					show_crawled_links($start,$perpage);
					
		break;
		
		case 'statistics':
					if (!isset($_GET['stats_type']))
					{
						$type = "";
					}
					else
					{
						$type = $_GET['stats_type'];
					}
					show_statistics($type);
					
		break;
		case 'urdu_domains':
					
					urdu_domains();
					
		break;
		
		
		case 'delete_crawling_log':
					if(isset($_GET['file'])&&$_GET['file']!="")
					{
						$file=$_GET['file'];
						unlink($log_dir."/".$file);
					}
					
					show_statistics('spidering_log');
					
		break;
		case 'database':
					include("$include_dir01/db_main.php");
					
					
		break;
		
		
		default:
		
	
	}///switch case end
	$stats = get_database_stats();
	?>
	 <div style="clear:both;"></div>
	<span class="notification n-success">
                
	<?php
	print "<br/><br/>	<center>Currently in database: ".$stats['sites']." web sites, ".$stats['links']." crawled links data.<br/><br/></center>\n";
	
?>
	</span>
		</div> <!--end of div class="container_12"-->
	<!-- Footer -->
        <div id="footer">
        	<div class="container_12">
            	<div class="grid_12">
                	<!-- You can change the copyright line for your own -->
                	<p>&copy; 2012. <a href="http://bscs.x10.mx/info" title="">TALHA BSCS Hons BZU Multan.</a></p>
        		</div>
            </div>
            <div style="clear:both;"></div>
        </div> <!-- End #footer -->
	
	
	
	
</body>
</html>