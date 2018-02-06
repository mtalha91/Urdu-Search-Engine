

<!-- Header -->
        <div id="header" >
            <!-- Header. Status part -->
            <div id="header-status">
                <div class="container_12">
                    <div class="grid_8">
					&nbsp;<span style="font-size:2em;">دنیا کا پہلا اردو زبان میں سرچ انجن</span>                    </div>
                    <div class="grid_4">
					
                        <?php
						if(isset($_SESSION['user'])&&$_SESSION['user']!="")
						{
						?>
						
						<a href="user.php?page_value=log_out" id="logout">
                        Welcome  <?php echo $_SESSION['user'];?> |
						  Logout
                        </a>
						<?php
						}
						?>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End #header-status -->
            
            <!-- Header. Main part -->
            <div id="header-main">
                <div class="container_12">
                    <div class="grid_12">
                        <div id="logo">
						
                            <ul id="nav">
							
                                <li id="<?php if($page_value=='home')echo 'current';?>"><a href="user.php?page_value=home">URDU Search Engine Home</a></li>
								<li id="<?php if($page_value=='urdu_search')echo 'current';?>"><a href="#" target="blank">URDU Search</a></li>
								<li id="<?php if($page_value=='check_urdu')echo 'current';?>"><a href="user.php?page_value=check_urdu">Verify Urdu Websites</a></li>
								<li id="<?php if($page_value=='about_us' )echo 'current';?>"><a href="user.php?page_value=about_us">About Us </a></li>
                                <li id="<?php if($page_value=='contact_us')echo 'current';?>"><a href="user.php?page_value=contact_us">Contact Us</a></li>
								
							<?php 
							if(isset($_SESSION['user'])&&$_SESSION['user']!="")
							{
							?>
							<li id="<?php if($page_value=='submit_site')echo 'current';?>"><a href="user.php?page_value=submit_site">Submit Your Site</a></li>
								
								
								
								<li id="<?php if($page_value=='user_account'||$page_value=='my_website_status'||$page_value=='change_password')echo 'current';?>"><a href="user.php?page_value=user_account">MY Account</a></li>
							<?php
							}
							else 
							{
							?>
							
							<li id="<?php if($page_value=='login_register')echo 'current';?>"><a href="user.php?page_value=login_register">Login | Register</a></li>
							
							
							
								
							<?php
							
							}
							?>
							</ul>
                        </div><!-- End. #Logo -->
                    </div><!-- End. .grid_12-->
                    <div style="clear: both;"></div>
                </div><!-- End. .container_12 -->
            </div> <!-- End #header-main -->
            <div style="clear: both;"></div>
            <!-- Sub navigation -->
            <div id="subnav">
                <div class="container_12">
                    <div class="grid_12">
                        <ul>
						<?php
						switch($page_value)
						{
							case 'main_page':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
                        <?php
							break;
							
						}
						?>
						<li><h3>اردو سرچ انجن / Urdu Search Engine</h3></li>
						</ul>
                        
                    </div><!-- End. .grid_12-->
                </div><!-- End. .container_12 -->
                <div style="clear: both;"></div>
            </div> <!-- End #subnav -->
        </div> <!-- End #header -->



<?php


?>