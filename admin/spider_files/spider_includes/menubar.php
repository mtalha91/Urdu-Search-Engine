

<!-- Header -->
        <div id="header" >
            <!-- Header. Status part -->
            <div id="header-status">
                <div class="container_12">
                    <div class="grid_8">
					&nbsp;<span style="font-size:2em;">دنیا کا پہلا اردو زبان میں سرچ انجن</span>
                    </div>
                    <div class="grid_4">
                        <a href="admin.php?page_value=log_out" id="logout">
                        Logout
                        </a>
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
							
                                <li id="<?php if($page_value=='dash_board')echo 'current';?>"><a href="admin.php?page_value=dash_board">Dashboard</a></li>
								<li id="<?php if($page_value=='main_page' || $page_value=='add_site' || $page_value=='re_crawl_all' || $page_value=='crawl_all_new_sites' || $page_value=='crawl_all_pending_sites' || $page_value=='add_site_query'|| $page_value=='show_site_data'|| $page_value=='edit_site'|| $page_value=='edit_site_query'|| $page_value=='crawl'|| $page_value=='browse_sites_pages'|| $page_value=='delete_crawled_links'|| $page_value=='sites_stats')echo 'current';?>"><a href="admin.php?page_value=main_page">Sites </a></li>
                                <li id="<?php if($page_value=='crawl_direct')echo 'current';?>"><a href="admin.php?page_value=crawl_direct">Direct Crawl</a></li>
                                <li id="<?php if($page_value=='clean_tables'||$page_value=='delete_links'||$page_value=='delete_temp')echo 'current';?>"><a href="admin.php?page_value=clean_tables">Clean Tables</a></li>
								<li id="<?php if($page_value=='crawled_links')echo 'current';?>"><a href="admin.php?page_value=crawled_links">Crawled Links</a></li>
                                <li id="<?php if($page_value=='statistics'||$page_value=='delete_crawling_log'||$page_value=='urdu_domains')echo 'current';?>"><a href="admin.php?page_value=statistics">Statistics</a></li>
								<li id="<?php if($page_value=='database')echo 'current';?>"><a href="admin.php?page_value=database">Database</a></li>
                                <li id="<?php if($page_value=='settings')echo 'current';?>"><a href="admin.php?page_value=settings">Settings</a></li>
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
							<li><a href="admin.php?page_value=crawl_all_pending_sites">Crawl all Pending Sites</a></li>
							
                        <?php
							break;
							
							case 'dash_board':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
							<li><a href="admin.php?page_value=crawl_all_pending_sites">Crawl all Pending Sites</a></li>
                        <?php
							break;
							case 'add_site':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
							<li><a href="admin.php?page_value=crawl_all_pending_sites">Crawl all Pending Sites</a></li>
                        <?php
							break;
							case 'crawl_all_new_sites':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
							<li><a href="admin.php?page_value=crawl_all_pending_sites">Crawl all Pending Sites</a></li>
                        <?php
							break;
							
							case 're_crawl_all':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
							<li><a href="admin.php?page_value=crawl_all_pending_sites">Crawl all Pending Sites</a></li>
                        <?php
							break;
							
							case 'crawl_all_pending_sites':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
							<li><a href="admin.php?page_value=crawl_all_pending_sites">Crawl all Pending Sites</a></li>
                        <?php
							break;
							case 'add_site_query':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
                        <?php
							break;
							
							case 'edit_site_query':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
                        <?php
							break;
							case 'edit_site':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
                        <?php
							break;
							case 'crawl':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
                        <?php
							break;
							case 'browse_sites_pages':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
                        <?php
							break;
							
							case 'delete_crawled_links':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
                        <?php
							break;
							
							
							case 'sites_stats':
							?>
                            <li><a href="admin.php?page_value=add_site">Add New site</a></li>
                            <li><a href="admin.php?page_value=re_crawl_all">Re-crawl all</a></li>
                     
                            <li><a href="admin.php?page_value=crawl_all_new_sites">Crawl all New Sites</a></li>
                        <?php
							break;
							case 'statistics':
							?>
							
                            <li><a href="admin.php?page_value=statistics&stats_type=pages">Largest pages</a></li>
                            <li><a href="admin.php?page_value=statistics&stats_type=spidering_log">Crawling logs</a></li>
							<li><a href="admin.php?page_value=urdu_domains">Urdu Websites Domains</a></li>
                     
                            
                        <?php
							break;
							
							case 'urdu_domains':
							?>
							
                            <li><a href="admin.php?page_value=statistics&stats_type=pages">Largest pages</a></li>
                            <li><a href="admin.php?page_value=statistics&stats_type=spidering_log">Crawling logs</a></li>
							<li><a href="admin.php?page_value=urdu_domains">Urdu Websites Domains</a></li>
                     
                            
                        <?php
							break;
							case 'delete_crawling_log':
							?>
							
                            <li><a href="admin.php?page_value=statistics&stats_type=pages">Largest pages</a></li>
                            <li><a href="admin.php?page_value=statistics&stats_type=spidering_log">Crawling logs</a></li>
                     
                            
                        <?php
							break;
							case 'show_site_data':
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