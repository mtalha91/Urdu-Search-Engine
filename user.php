<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta charset="utf-8">
		<title>Urdu Search Engine </title>
       
        <!-- CSS Reset -->
		<link rel="stylesheet" type="text/css" href="css-js-images/reset.css" tppabs="http://www.xooom.pl/work/magicadmin/css/reset.css" media="screen" />
       
        <!-- Fluid 960 Grid System - CSS framework -->
		<link rel="stylesheet" type="text/css" href="css-js-images/grid.css" tppabs="http://www.xooom.pl/work/magicadmin/css/grid.css" media="screen" />
		
        <!-- IE Hacks for the Fluid 960 Grid System -->
        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="ie6.css" tppabs="http://www.xooom.pl/work/magicadmin/css/ie6.css" media="screen" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="ie.css" tppabs="http://www.xooom.pl/work/magicadmin/css/ie.css" media="screen" /><![endif]-->
        
        <!-- Main stylesheet -->
        <link rel="stylesheet" type="text/css" href="css-js-images/styles.css" tppabs="http://www.xooom.pl/work/magicadmin/css/styles.css" media="screen" />
        
        <!-- WYSIWYG editor stylesheet -->
        <link rel="stylesheet" type="text/css" href="css-js-images/jquery.wysiwyg.css" tppabs="http://www.xooom.pl/work/magicadmin/css/jquery.wysiwyg.css" media="screen" />
        
        <!-- Table sorter stylesheet -->
        <link rel="stylesheet" type="text/css" href="css-js-images/tablesorter.css" tppabs="http://www.xooom.pl/work/magicadmin/css/tablesorter.css" media="screen" />
        
        <!-- Thickbox stylesheet -->
        <link rel="stylesheet" type="text/css" href="css-js-images/thickbox.css" tppabs="http://www.xooom.pl/work/magicadmin/css/thickbox.css" media="screen" />
        
        <!-- Themes. Below are several color themes. Uncomment the line of your choice to switch to different color. All styles commented out means blue theme. -->
        <link rel="stylesheet" type="text/css" href="css-js-images/theme-blue.css" tppabs="http://www.xooom.pl/work/magicadmin/css/theme-blue.css" media="screen" />
        <!--<link rel="stylesheet" type="text/css" href="css/theme-red.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-yellow.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-green.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-graphite.css" media="screen" />-->
        
		<!-- JQuery engine script-->
		<script type="text/javascript" src="css-js-images/jquery-1.3.2.min.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery-1.3.2.min.js"></script>
        
		<!-- JQuery WYSIWYG plugin script -->
		<script type="text/javascript" src="css-js-images/jquery.wysiwyg.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery.wysiwyg.js"></script>
        
        <!-- JQuery tablesorter plugin script-->
		<script type="text/javascript" src="css-js-images/jquery.tablesorter.min.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery.tablesorter.min.js"></script>
        
		<!-- JQuery pager plugin script for tablesorter tables -->
		<script type="text/javascript" src="css-js-images/jquery.tablesorter.pager.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery.tablesorter.pager.js"></script>
        
		<!-- JQuery password strength plugin script -->
		<script type="text/javascript" src="css-js-images/jquery.pstrength-min.1.2.js" tppabs="http://www.xooom.pl/work/magicadmin/js/jquery.pstrength-min.1.2.js"></script>
        
		<!-- JQuery thickbox plugin script -->
		<script type="text/javascript" src="css-js-images/thickbox.js" tppabs="http://www.xooom.pl/work/magicadmin/js/thickbox.js"></script>
        
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
	</head>
	<body>
    	
      <?php
	  
	 	include("user_includes/database.php");
		include("user_includes/user_display_functions.php");
		session_start();
	 
	  
//////////////gettting the page value to show/////////////////////
	if(isset($_GET['page_value'])&&$_GET['page_value']!="")
	{
		$page_value=$_GET['page_value'];
	}
	else
	{
		$page_value="home";
	}
	if(isset($_POST['page_value'])&&$_POST['page_value']!="")
	{
		$page_value=$_POST['page_value'];
	}

	
	//////////////////////////////menu bar start///////////////////////
	include("user_includes/user_menubar.php");
	///////////////////////////////menu bar end///////////////////////
	?>


	  
		<div class="container_12">
      
	<?php
	
	switch($page_value)
	{
		
		case 'home':
					echo '<span class="notification n-success"><center>اردو سرچ انجن پکستان</center></span>';
					
					include("user_includes/home_info.php");
					//home();
					//echo $_SESSION['user'];
				
		break;
		case 'log_out':
					session_destroy();
					header("Location: user.php");
		break;
		
		case 'about_us':
					echo '<span class="notification n-success"><center>اردو سرچ انجن پکستان</center></span>';
					include("user_includes/about_us.php");
					//about_us();
		break;
		
		case 'contact_us':
					echo '<span class="notification n-success"><center>اردو سرچ انجن پکستان</center></span>';
					include("user_includes/contact_us.php");
					//contact_us();
		break;
		
		case 'submit_site':
					if(isset($_GET['error'])&&$_GET['error']=="empty_input")
					{	
						$error="empty_input";
						
					}
					else if(isset($_GET['error'])&&$_GET['error']=="no")
					{
						$error=$_GET['error'];
						
					}
					else if(isset($_GET['error'])&&$_GET['error']=="in_db")
					{
						$error=$_GET['error'];
						
					}
					else
					{
						$error="";
					}
					
					submit_site($error);
		break;
		
		case 'check_urdu':
					echo '<span class="notification n-success"><center>اردو سرچ انجن پکستان</center></span>';
					
					if(isset($_GET['error'])&&$_GET['error']=="empty_input")
					{	
						$error="empty_input";
						
					}
					else if(isset($_GET['error'])&&$_GET['error']!="")
					{
						$error=$_GET['error'];
						
					}
					else if(isset($_GET['error'])&&$_GET['error']=="no")
					{
						$error="no";
					}
					else
					{
						$error="";
					}
					if(isset($_SESSION['urdu'])&&$_SESSION['urdu']!="")
					{
						$urdu=$_SESSION['urdu'];
						$req_url=$_SESSION['sitesurl'];
						$_SESSION['urdu']="";
						$_SESSION['sitesurl']="";
					}
					else
					{
						$urdu="";
						if(isset($_SESSION['sitesurl']))
						$req_url=$_SESSION['sitesurl'];
						else
						{
						
						$_SESSION['urdu']="";
						$_SESSION['sitesurl']="";
						$req_url="";
						}
					}
					
					check_urdu($error,$urdu,$req_url);
		break;
		
		case 'user_account':
					user_account();
		break;
		
		
		case 'my_website_status':
					my_website_status();
		break;
		case 'change_password':
					$error="";
					if(isset($_GET['error'])&&$_GET['error']=="empty_input")
					{	
						$error="empty_input";
						
					}
					else if(isset($_GET['error'])&&$_GET['error']=="pass_error")
					{
						$error=$_GET['error'];
						
					}
					else if(isset($_GET['error'])&&$_GET['error']=="cpass_error")
					{
						$error=$_GET['error'];
						
					}
					
					else if(isset($_GET['error'])&&$_GET['error']=="no")
					{
						$error="no";
					}
		
		
					change_password($error);
		break;
		case 'login_register':
					if(isset($_GET['error'])&&$_GET['error']=="empty_input")
					{	
						$error="empty_input";
						
					}
					else if (isset($_GET['error'])&&$_GET['error']=="pass_error")
					{
						$error="pass_error";
						
					
					}
					else if (isset($_GET['error'])&&$_GET['error']=="in_db")
					{
						$error="in_db";
						
					
					}
					else
					{
						$error="";
						
					
					}
					
					//include("user_includes/authorization_user.php?error=$error");
					include("user_includes/authorization_user.php");
					
					
		break;
		
		case 'log_out':
					session_destroy();
					header("Location: user.php");
		break;			
		default:
		
	
	}///switch case end
	?>
             
            <div style="clear:both;"></div>
            
            
            
        </div> <!-- End .container_12 -->
		
           
        <!-- Footer -->
        <div id="footer">
        	<div class="container_12">
            	<div class="grid_12">
                	<!-- You can change the copyright line for your own -->
                	<p>&copy; 2012. <a href="http://bscs.x10.mx/info" title="M. Talha BSCS Hons">M.Talha BSCS Hons</a></p>
        		</div>
            </div>
            <div style="clear:both;"></div>
        </div> <!-- End #footer -->
	</body>
</html>