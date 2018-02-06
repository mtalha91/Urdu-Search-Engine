<?php
////////////////////////admin site displaying functions/////////////////////////////////
	
	function show_dash_board()
	{
		?>
            
            <!-- Dashboard icons -->
            <div class="grid_7">
            	<a href="../" class="dashboard-module">
                	<img src="templates/css-js-images/user_site.png" tppabs="http://www.xooom.pl/work/magicadmin/images/Crystal_Clear_write.gif" width="64" height="64" alt="edit" />
                	<span>Visit User Site</span>
                </a>
                
				 <a href="#" class="dashboard-module">
                	<img src="templates/css-js-images/urdu_search5.png" tppabs="http://www.xooom.pl/work/magicadmin/images/Crystal_Clear_files.gif" width="64" height="64" alt="edit" />
                	<span>Urdu Search</span>
                </a>
					
			   <a href="admin.php?page_value=main_page" class="dashboard-module">
                	<img src="templates/css-js-images/crawling1.jpg" tppabs="http://www.xooom.pl/work/magicadmin/images/Crystal_Clear_file.gif" width="64" height="64" alt="edit" />
                	<span>Crawling</span>
                </a>
                
               
                <a href="admin.php?page_value=urdu_domains" class="dashboard-module">
                	<img src="templates/css-js-images/urdu_domains.jpg" tppabs="http://www.xooom.pl/work/magicadmin/images/Crystal_Clear_calendar.gif" width="64" height="64" alt="edit" />
                	<span>Urdu Web Domains</span>
                </a>
                <a href="admin.php?page_value=clean_tables" class="dashboard-module">
                	<img src="templates/css-js-images/clean_table.jpg" tppabs="http://www.xooom.pl/work/magicadmin/images/Crystal_Clear_calendar.gif" width="64" height="64" alt="edit" />
                	<span>Clean Tables</span>
                </a>
                
                <a href="admin.php?page_value=database" class="dashboard-module">
                	<img src="templates/css-js-images/database.jpg" tppabs="http://www.xooom.pl/work/magicadmin/images/Crystal_Clear_user.gif" width="64" height="64" alt="edit" />
                	<span>Database</span>
                </a>
                
                <a href="admin.php?page_value=statistics" class="dashboard-module">
                	<img src="templates/css-js-images/Crystal_Clear_stats.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/Crystal_Clear_stats.gif" width="64" height="64" alt="edit" />
                	<span>Stats</span>
                </a>
                
                <a href="admin.php?page_value=settings" class="dashboard-module">
                	<img src="templates/css-js-images/Crystal_Clear_settings.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/Crystal_Clear_settings.gif" width="64" height="64" alt="edit" />
                	<span>Settings</span>
                </a>
				
				            
                <div style="clear: both"></div>
            </div> <!-- End .grid_7 -->
            
            <!-- Account overview -->
            <div class="grid_5">
                <div class="module">
                        <h2><span>Account overview / منتظم کی معلومات</span></h2>
                        
                        <div class="module-body">
                        
                        	<p>
                                <strong>User: </strong><?php echo $_SESSION['admin'];?><br />
                                <strong>Your last visit was on: </strong>NULL<br />
                                <strong>From IP: </strong>NULL
                            </p>
                        
                             <div>
                                 <div class="indicator">
                                     <div style="width: 23%;"></div><!-- change the width value (23%) to dynamically control your indicator -->
                                 </div>
                                 <p>Used bandwidth and storage space</p>
                             </div>
                             
                             <div>
                                 <div class="indicator">
                                     <div style="width: 100%;"></div><!-- change the width value (100%) to dynamically control your indicator -->
                                 </div>
                                 <p>Your Total bandwidth and storage space</p>
                             </div>
                            
                                <h3>دنیا کا پہلا اردو زبان میں سرچ انجن</h3>
                               <p>اردو سرچ انجن بہاوالدین زکریا یونیورسٹی کے کمپوٹر ساءنس کے طلبہ کی ریسرچ ہے۔</p>
                           
                        	<p>
                                Click to see the statistics?<br />
                                <a href="admin.php?page_value=statistics">click here</a><br />
                            </p>
							

                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
           
          <?php  
            
	}
	function show_crawled_links($start,$perpage)
	{
	
		$linksQuery = "select count(*) from crawled_links";
		$result = mysql_query($linksQuery);
		echo mysql_error();
		$row = mysql_fetch_row($result);
		$numOfPages = $row[0]; 
		
		$from = ($start-1) * 30;
		$to = min(($start)*30, $numOfPages);

		
		$linksQuery = "select crawled_links_id, crawled_links_url,crawled_links_title,crawled_links_urdu_text from crawled_links  order by crawled_links_id limit $from, $perpage";
		$result = mysql_query($linksQuery);

			/////here is the error
			
		echo mysql_error();
		
		?>
		
		
		  <!-- Example table -->
                <div class="module">
                	<h2><span>Crawled URDU Links <?php echo "( No. of Links : ".$numOfPages." )";?></span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:5%">ID</th>
                                    <th style="width:10%">URL</th>
                                    <th style="width:10%">Title</th>
                                    <th style="width:35%">URDU Text</th>
                                </tr>
                            </thead>
                            <tbody>
                             

		<?php
		$n=0;
		while ($row = mysql_fetch_array($result)) 
		{
			$n++;
			?>
		
		
		
					<tr>
						<td class="align-center"><?php echo $row['crawled_links_id'];?></td>
						<td><?php print "<a href=\"".$row['crawled_links_url']."\">".$row['crawled_links_url']."</a>";?></td>
						<td><?php echo $row['crawled_links_title'];?></td>
						
						<td><textarea rows=5 cols=70><?php echo $row['crawled_links_urdu_text'];?></textarea></td>
						
						
					</tr>

		
		
		<?php
			
		}

			?>				 
							</tbody>
                        </table>
                        </form>
                        <div class="pager" id="pager">
                            <form action="">
                                <div>
                                <img class="first" src="templates/css-js-images/arrow-stop-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop-180.gif" alt="first"/>
                                <img class="prev" src="templates/css-js-images/arrow-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-180.gif" alt="prev"/> 
                                <input type="text" class="pagedisplay input-short align-center"/>
                                <img class="next" src="templates/css-js-images/arrow.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow.gif" alt="next"/>
                                <img class="last" src="templates/css-js-images/arrow-stop.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop.gif" alt="last"/> 
                                <select class="pagesize input-short align-center">
                                    <option value="10" selected="selected">10</option>
                                    <option value="20" >20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
									<option value="30">50</option>
                                    <option value="40">100</option>
                                </select>
                                </div>
                            </form>
                        </div>
                        
						<div class="table-apply">
												<form action="admin.php" method="post">
							Urls per page: <input type="text" name="perpage" size="3" value="<?php print $perpage;?>"> 
							
							<input type="hidden" name="page_value" value="crawled_links">
							<input type="hidden" name="start" value="<?php print $start;?>">
							<input class="submit-green" type="submit" name="btn" value="Search">
							</form>
                        </div>	
						
						<?php
							
						$pages = ceil($numOfPages / $perpage);
						$prev = $start - 1;
						$next = $start + 1;

						if ($pages > 0)
							print "<center>Pages: ";
						else
							print "<center>No more Pages to Show</center>";

						$links_to_next =10;
						$firstpage = $start - $links_to_next;
						if ($firstpage < 1) $firstpage = 1;
						$lastpage = $start + $links_to_next;
						if ($lastpage > $pages) $lastpage = $pages;
						
						for ($x=$firstpage; $x<=$lastpage; $x++)
							if ($x<>$start)	
							{
								print "<a href=admin.php?page_value=crawled_links&start=$x&perpage=$perpage>$x</a> ";
							} 	else
								print "<b>$x </b>";
						print"</center>";
					
							
						?>
						
						
						
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
        
		
		
		<?php
		
		
	}
	function show_crawl_screen($sites_id,$sites_url,$re_crawl)
	{
		$check = "";
		$levelchecked = "checked";
		$sites_depth = 2;
		if ($sites_url=="") 
		{
			$sites_url = "http://";
			$url_to_crawl = "";
		} else 
		{
			$url_to_crawl = $sites_url;
			$result = mysql_query("select sites_depth,sites_leave_domain from sites where sites_url='$sites_url'");
			echo mysql_error();
			if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_row($result);
				$sites_depth = $row[0];
				if ($sites_depth == -1 )
				{
					$fullchecked = "checked";
					$sites_depth ="";
					$levelchecked = "";
				}
				$sites_leave_domain = $row[1];
			}			
		}

		?>
		
		
		
		 <!-- Form elements -->    
            <div class="grid_12">
            
                <div class="module">
                     <h2><span>Direct Crawling</span></h2>
                        
                     <div class="module-body">
                        <form action="spider_files/spider.php" method="post">
                        
                            
                            <p>
                                <label>Address </label>
                                <input type="text" class="input-short" name="sites_url"  value=<?php print "\"$sites_url\"";?> />
                                
                            </p>
                            
                            
                            <fieldset>
                                <legend>Crawling Option</legend>
                                <ul>
                                    <li><label><input type="radio" name="soption" value="full" <?php print $fullchecked;?>/> Full</label></li>
                                    <li><label><input type="radio" name="soption" value="level" <?php print $levelchecked;?>/>Level</label> To depth <input class="input-short" type="text" name="maxlevel" size="2" value="<?php print $sites_depth;?>"></li>
                                </ul>
                            </fieldset>
                            
                                
                            <fieldset>
                                <?php if ($re_crawl==1) $check="checked"?>
                                <ul>
                                    <li><label><input type="checkbox"  id="cb1" name="re_crawl" value="1" <?php print $check;?>/> Re-crawl</label></li>
                                    
                                </ul>
                            
                            </fieldset>
                           <?php 
			$check_domain="";
			if ($sites_leave_domain==1) 
					{
						$check_domain="checked" ;
					} 
					?> 
					 <fieldset>
                                <?php if ($re_crawl==1) $check="checked"?>
                                <ul>
                                    <li><label><input type="checkbox"  id="cb1" name="check_domain" value="1" <?php print $check_domain;?>/> Crawler Can Leave Domain</label></li>
                                    
                                </ul>
                            
                            </fieldset>
                           
                            <fieldset>
                                <input class="submit-green" type="submit" name="start_crawling" value="Start Crawling" /> 
                                
                            </fieldset>
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div> <!-- End .grid_12 -->
		
		
		<?php 
	
	}
	
	
	function edit_site($site_id)
	{
		$result = mysql_query("SELECT * from sites where sites_id=$site_id");
		echo mysql_error();
		$row = mysql_fetch_array($result);
		$depth = $row['sites_depth'];
		$fullchecked = "";
		$depthchecked = "";		
		if ($depth == -1 ) {
			$fullchecked = "checked";
			$depth ="";
		} else {
			$depthchecked = "checked";
		}
		$leave_domain = $row['sites_leave_domain'];
		if ($leave_domain == 1 ) {
			$domainchecked = "checked";
		} else {
			$domainchecked = "";
		}		
		?>
				
			 <!-- Form elements -->    
            <div class="grid_12">
            
                <div class="module">
                     <h2><span>Edit the Site Information</span></h2>
                        
                     <div class="module-body">
                        <form action="admin.php" method="post">
                        
                            
						<input type=hidden name=page_value value=edit_site_query>
						<input type=hidden name=sites_id value=<?php print $site_id;?>>		
                            <p>
                                <label>URL </label>
                                <input type="text" class="input-short" name=sites_url value=<?php print "\"".$row['sites_url']."\""?> />
                                
                            </p>
                            
                            
                            <p>
                                <label>Title</label>
                                <input type="text" class="input-short" name=sites_title value=<?php print  "\"".stripslashes($row['sites_title'])."\""?> />
                                
                            </p>                    
                            
                            <fieldset>
                                <legend>Crawling Option</legend>
                                <ul>
                                    <li><label><input type="radio" name="soption" value="full" <?php print $fullchecked;?>/> Full</label></li>
                                    <li><label><input type="radio" name="soption" value="level" <?php print $depthchecked;?> />Level</label> To depth: <input type="text" name="sites_depth" size="2" value="<?php print $depth;?>"></li>
                                </ul>
                            </fieldset>
                            
                                
                            <fieldset>
                                
                                <ul>
                                    <li><label><input type="checkbox"  id="cb1" name="sites_leave_domain" value="1" <?php print $domainchecked;?>/> Crawler Can Leave Domain</label></li>
                                    
                                </ul>
                            
                                <label>Description</label>
                                <textarea id="wysiwyg" rows="11" cols="90" name=sites_description> <?php print stripslashes($row['sites_description'])?>   </textarea> 
                            </fieldset>
                            
                            <fieldset>
                                <input class="submit-green" type="submit" value="Edit Information" /> 
                                
                            </fieldset>
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div> <!-- End .grid_12 -->
		
		
		
		
		
		
		
		
		
		<?php
	
	}
	
	function show_site_data($site_id)
	{
			$result = mysql_query("SELECT * from sites where sites_id=$site_id");
		echo mysql_error();
		$row=mysql_fetch_array($result);
		$sites_url = replace_ampersand($row['sites_url']);
		if ($row['sites_crawl_date']==0) {
			$crawl_status="<font color=\"red\">Not Crawled</font>";
			$crawl_option="<a href=\"admin.php?page_value=crawl&sites_url=$sites_url&sites_id=$site_id\">Crawl</a>";
		} else {
			$site_id = $row['sites_id'];
			$result2 = mysql_query("SELECT sites_id from pending where sites_id =$site_id");
			echo mysql_error();			
			$row2=mysql_fetch_array($result2);
			if ($row2['sites_id'] == $row['sites_id']) {
				$crawl_status = "Unfinished";
				$crawl_option="<a href=\"admin.php?page_value=crawl&sites_url=$sites_url\">Continue Crawling</a>";

			} else {
				$crawl_status = $row['sites_crawl_date'];
				$crawl_option="<a href=\"admin.php?page_value=crawl&sites_url=$sites_url&re_crawl=1\">Re-crawl</a>";
			}
		}
		?>

		
		
		
		<!-- Example table -->
                <div class="module">
                	<h2><span>Showing the Complete Information of Site</span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                   
                                    <th style="width:20%">Site Attributes</th>
                                    <th style="width:30%">Site Values</th>
                                    <th style="width:20%">Available Option</th>
                                    <th style="width:15%"></th>
                                </tr>
                            </thead>
                            <tbody>

							
								<tr>
                                    <td class="align-center">URL</td>
                                    
                                    <td><a href="<?php print  $row['sites_url']; print "\">"; print $row['sites_url'];?></a></td>
                                    <td><a href="admin.php?page_value=edit_site&site_id=<?php print  $row['sites_id']?>">Edit</a></td>
                                    <td>
									<img src="templates/css-js-images/pencil.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/pencil.gif" width="16" height="16" alt="edit" />
                                   
                                    </td>
                                </tr>
								<tr>
                                    <td class="align-center">Title</td>
                                    
                                    <td><b><?php print stripslashes($row['sites_title']);?></b></td>
                                    <td><?php print $crawl_option?></td>
                                    <td>
                                    <img src="templates/css-js-images/tick-circle.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/tick-circle.gif" width="16" height="16" alt="not published" />
									
                                    </td>
                                </tr>
								<tr>
                                    <td class="align-center">Description</td>
                                    
                                    <td><?php print stripslashes($row['sites_description']);?></td>
                                    <td><a href="admin.php?page_value=browse_sites_pages&site_id=<?php print  $row['sites_id']?>">Browse site pages</a></td>
                                    <td>
                                    <img src="templates/css-js-images/plus-small.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/plus-small.gif" width="16" height="16" alt="comments" />
                                    </td>
                                </tr>
								<tr>
                                    <td class="align-center">Last Crawled</td>
                                    
                                    <td><?php print $crawl_status;?></td>
                                    <td><a href=admin.php?page_value=delete_crawled_links&site_id=<?php print  $row['sites_id'];?> onclick="return confirm('Are you sure you want to delete? Crawl data will be lost.')">Delete</a></td>
                                    <td>
                                    <img src="templates/css-js-images/bin.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/bin.gif" width="16" height="16" alt="delete" />
									
                                    </td>
                                </tr>
								<tr>
                                    <td class="align-center"><?php ?></td>
                                    
                                    <td><a href="<?php ?>"><?php ?></a></td>
                                    <td><a href=admin.php?page_value=sites_stats&site_id=<?php print  $row['sites_id'];?>>Site Statistics</a></td>
                                    <td>
                                    <img src="templates/css-js-images/balloon.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/balloon.gif" width="16" height="16" alt="comments" />
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                        </form>
						
						<div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
		
		
		
		
	
	<?php 
	
	}

	function browse_sites_pages($sites_id,$start,$perpage)
	{
		//echo "site id=$sites_id , start=$start ,filter=$filter, per page=$per_page";
		/*
		$result = mysql_query("select sites_url from sites where sites_id=$sites_id");
		echo mysql_error();
		$row = mysql_fetch_row($result);
		$url = $row[0];
		*/
		$linksQuery = "select count(*) from crawled_links where sites_id = $sites_id ";
		$result = mysql_query($linksQuery);
		echo mysql_error();
		$row = mysql_fetch_row($result);
		$numOfPages = $row[0]; 
		
		$from = ($start-1) * 30;
		$to = min(($start)*30, $numOfPages);

		
		$linksQuery = "select crawled_links_id, crawled_links_url,crawled_links_urdu_text from crawled_links where sites_id = $sites_id order by crawled_links_url limit $from, $perpage";
		$result = mysql_query($linksQuery);

			/////here is the error
			
		echo mysql_error();
		?>
		
		
		  <!-- Example table -->
                <div class="module">
                	<h2><span>Pages of Web site <a style="color:green;"href="admin.php?page_value=show_site_data&site_id=<?php  print $sites_id?>"><?php print $url;?></a></span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:10%">ID</th>
                                    <th style="width:20%">URL</th>
									 <th style="width:35%">URL</th>
                                    <th style="width:10%">Action</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                             

		<?php
		$n=0;
		while ($row = mysql_fetch_array($result)) 
		{
			$n++;
			?>
		
		
		
					<tr>
						<td class="align-center"><?php echo $row['crawled_links_id'];?></td>
						<td><?php print "<a href=\"".$row['crawled_links_url']."\">".$row['crawled_links_url']."</a>";?></td>
						<td><textarea rows=2 cols=60><?php print $row['crawled_links_urdu_text'];?></textarea></td>
						<td><?php print "<a style=\"color:red;\" href=\"admin.php?crawled_links_id=".$row['crawled_links_id']."&page_value=delete_crawled_links&site_id=$sites_id&start=1&perpage=$perpage\">Delete</a>";?></td>
						
						<td>
							<input type="checkbox" />
							
							<img src="templates/css-js-images/bin.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/bin.gif" width="16" height="16" alt="delete" />
						</td>
					</tr>

		
		
		<?php
			
		}

			?>				 
							</tbody>
                        </table>
                        </form>
                        <div class="pager" id="pager">
                            <form action="">
                                <div>
                                <img class="first" src="templates/css-js-images/arrow-stop-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop-180.gif" alt="first"/>
                                <img class="prev" src="templates/css-js-images/arrow-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-180.gif" alt="prev"/> 
                                <input type="text" class="pagedisplay input-short align-center"/>
                                <img class="next" src="templates/css-js-images/arrow.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow.gif" alt="next"/>
                                <img class="last" src="templates/css-js-images/arrow-stop.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop.gif" alt="last"/> 
                                <select class="pagesize input-short align-center">
                                    <option value="10" selected="selected">10</option>
                                    <option value="20" >20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
									<option value="30">50</option>
                                    <option value="40">100</option>
                                </select>
                                </div>
                            </form>
                        </div>
                        
						<div class="table-apply">
												<form action="admin.php" method="post">
							Urls per page: <input type="text" name="perpage" size="3" value="<?php print $per_page;?>"> 
							
							
							<input type="hidden" name="start" value="1">
							<input type="hidden" name="site_id" value="<?php print $sites_id?>">
							<input type="hidden" name="page_value" value="browse_sites_pages">
							<input class="submit-green" type="submit" value="Search" /> 
							</form>
                        </div>	
						
						<?php
							
						$pages = ceil($numOfPages / $perpage);
						$prev = $start - 1;
						$next = $start + 1;

						if ($pages > 0)
							print "<center>Pages: ";
						else
							print "<center>No more Pages to Show</center>";

						$links_to_next =10;
						$firstpage = $start - $links_to_next;
						if ($firstpage < 1) $firstpage = 1;
						$lastpage = $start + $links_to_next;
						if ($lastpage > $pages) $lastpage = $pages;
						
						for ($x=$firstpage; $x<=$lastpage; $x++)
							if ($x<>$start)	
							{
								print "<a href=admin.php?page_value=browse_sites_pages&site_id=$sites_id&start=$x&perpage=$perpage>$x</a> ";
							} 	else
								print "<b>$x </b>";
						print"</center>";
					
							
						?>
						
						
						
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
        
		
		
		<?php
		
		
		
	}

	
	function sites_stats($sites_id) 
	{
		$result = mysql_query("select sites_url from sites where sites_id=$sites_id");
		echo mysql_error();
		if ($row=mysql_fetch_array($result)) 
		{
			$url=$row[0];

			$lastIndexQuery = "SELECT sites_crawl_date from sites where sites_id = $sites_id";
			$sumSizeQuery = "select sum(length(crawled_links_urdu_text)) from crawled_links where sites_id = $sites_id";
			$siteSizeQuery = "select sum(crawled_links_size) from crawled_links where sites_id = $sites_id";
			$linksQuery = "select count(*) from crawled_links where sites_id = $sites_id";

			$result = mysql_query($lastIndexQuery);
			echo mysql_error();
			if ($row=mysql_fetch_array($result))
			{
				$stats['lastcrawl']=$row[0];
			}

			$result = mysql_query($sumSizeQuery);
			echo mysql_error();
			if ($row=mysql_fetch_array($result))
			{
				$stats['sumSize']=$row[0];
			}
			$result = mysql_query($linksQuery);
			echo mysql_error();
			if ($row=mysql_fetch_array($result)) 
			{
				$stats['links']=$row[0];
			}

			
			$result = mysql_query($siteSizeQuery);
			echo mysql_error();
			if ($row=mysql_fetch_array($result)) 
			{
				$stats['siteSize']=$row[0];
			}
			if ($stats['siteSize']=="")
				$stats['siteSize'] = 0;
			
			$stats['siteSize'] = number_format($stats['siteSize'], 2);
			$sum = number_format($stats['sumSize']/1024, 2);
			
		?>
		
				 <!-- Example table -->
                <div class="module">
                	<h2><span>Statistics for site <?php print "<a style=\"color:green;\" href=\"admin.php?page_value=show_site_data&site_id=$sites_id\">$url</a>";?></span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:10%">#</th>
                                    <th style="width:30%">Attribute Name</th>
                                    <th style="width:30%">Attribute Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-center">1</td>
                                    <td>Last Crawled</td>
                                    <td><?php echo $stats['lastcrawl'];?></td>
                                    
                                </tr>
									<tr>
                                    <td class="align-center">2</td>
                                    <td>Pages Crawled</td>
                                    <td><?php echo $stats['links'];?></td>
                                    
                                </tr>
								<tr>
                                    <td class="align-center">3</td>
                                    <td>Cached texts</td>
                                    <td><?php echo $sum;?>kb</td>
                                    
                                </tr>
								<tr>
                                    <td class="align-center">4</td>
                                    <td>Site size</td>
                                    <td><?php echo $stats['siteSize'];?>kb</td>
                                    
                                </tr>
		
		
		             </tbody>
                        </table>
                        </form>
                       
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
                
		
		<?php
		}
	}

	
	
	
	function show_sites_url_from_db($message,$start,$perpage)
	{
	
		$linksQuery = "select count(*) from sites";
		$result = mysql_query($linksQuery);
		echo mysql_error();
		$row = mysql_fetch_row($result);
		$numOfPages = $row[0]; 
		
		$from = ($start-1) * 30;
		$to = min(($start)*30, $numOfPages);

		
		$linksQuery = "select * from sites  order by sites_crawl_date limit $from, $perpage";
		$result = mysql_query($linksQuery);

		echo mysql_error();
			?>
				
			
			<?php


		
		if (mysql_num_rows($result) > 0)
		{
		
		?>
			  <!-- Example table -->
                <div class="module">
                	<h2><span>Sites in the Database <?php echo "( No. of Sites : ".$numOfPages." )";?></span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th style="width:20%">Site Name</th>
                                    <th style="width:30%">Site URL</th>
                                    <th style="width:20%">Last Crawl</th>
                                    <th style="width:10%">Action</th>
									<th style="width:10%">Site Language</th>
									<th style="width:5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                               
		
		<?php
		
		
		} 
		else
		{
			
			echo '<span class="notification n-information">Welcom to Urdu Search Engine. <br><br>Choose "Add site" from the submenu to add a new site, or "Crawl" to directly go to the Crawling section.</span>';
                
		}
		$n=0;
		while ($row=mysql_fetch_array($result))
		{
			$n++;
			if ($row['sites_crawl_date']==0)
			{
				$crawl_status="<font color=\"red\">Not crawled</font>";
				$crawl_option="<a href=\"admin.php?page_value=crawl&url=$row[sites_url]\">Crawl</a>";
			} 
			else 
			{
				$site_id = $row['sites_id'];
				$result2 = mysql_query("SELECT sites_id from pending where sites_id =$site_id");
				echo mysql_error();			
				$row2=mysql_fetch_array($result2);
				if ($row2['sites_id'] == $row['sites_id'])
				{
					$crawl_status = "Unfinished";
					$crawl_option="<a href=\"admin.php?page_value=crawl&url=$row[sites_url]\">Continue</a>";

				} 
				else 
				{
					$crawl_status = $row['sites_crawl_date'];
					$crawl_option="<a href=\"admin.php?page_value=crawl&url=$row[sites_url]&re_crawl=1\">Re-crawl</a>";
				}
			}
			?>
			
								<tr>
                                    <td class="align-center"><?php echo $row['sites_id'];?></td>
                                    <td><?php echo stripslashes($row['sites_title']);?></td>
                                    <td><a href="<?php echo $row[sites_url];?>"><?php echo $row[sites_url];?></a></td>
                                    <td><?php echo $crawl_status;?></td>
									
                                    <td><a href="admin.php?page_value=show_site_data&site_id=<?php echo $row[sites_id];?>"><?php echo "More Options";?></a></td>
									<td style="color:<?php if($row['sites_lang']== 'urdu'){
									echo "green"; }else{ echo "red";} ?>;"><?php if($row['sites_lang']== 'urdu'){
									echo "URDU"; }else{ echo "Not URDU";}?></td>
                                    <td>
                                    
                                        <a href=""><img src="templates/css-js-images/balloon.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/balloon.gif" width="16" height="16" alt="comments" /></a>
                                        
                                    </td>
                                </tr>
                                
			
			<?php
			
			
		}
		if (mysql_num_rows($result) > 0)
		{
			?>
			 </tbody>
                        </table>
                        </form>
							<div class="pager" id="pager">
                            <form action="">
                                <div>
                                <img class="first" src="templates/css-js-images/arrow-stop-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop-180.gif" alt="first"/>
                                <img class="prev" src="templates/css-js-images/arrow-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-180.gif" alt="prev"/> 
                                <input type="text" class="pagedisplay input-short align-center"/>
                                <img class="next" src="templates/css-js-images/arrow.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow.gif" alt="next"/>
                                <img class="last" src="templates/css-js-images/arrow-stop.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop.gif" alt="last"/> 
                                <select class="pagesize input-short align-center">
                                    <option value="10" selected="selected">10</option>
                                    <option value="20" >20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
									<option value="30">50</option>
                                    <option value="40">100</option>
                                </select>
                                </div>
                            </form>
                        </div>
                        <div class="table-apply">
												<form action="admin.php" method="post">
							Urls per page: <input type="text" name="perpage" size="3" value="<?php print $perpage;?>"> 
							
							<input type="hidden" name="page_value" value="main_page">
							<input type="hidden" name="start" value="<?php print $start;?>">
							<input class="submit-green" type="submit" name="btn" value="Search">
							</form>
                        </div>	
							
							
						<?php
							
						$pages = ceil($numOfPages / $perpage);
						$prev = $start - 1;
						$next = $start + 1;

						if ($pages > 0)
							print "<center>Pages: ";
						else
							print "<center>No more Pages to Show</center>";

						$links_to_next =10;
						$firstpage = $start - $links_to_next;
						if ($firstpage < 1) $firstpage = 1;
						$lastpage = $start + $links_to_next;
						if ($lastpage > $pages) $lastpage = $pages;
						
						for ($x=$firstpage; $x<=$lastpage; $x++)
							if ($x<>$start)	
							{
								print "<a href=admin.php?page_value=main_page&start=$x&perpage=$perpage>$x</a> ";
							} 	else
								print "<b>$x </b>";
						print"</center>";
					
							
						?>
						
						
							
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
                
		<?php
		}
		
		if($message==1)
		{
			echo '<span class="notification n-success"> Site Added Successfully. </span>';
		}
        else if($message==2)
		{
			echo '<span class="notification n-attention">Site Already in Database.</span>';
        } 
		else if($message==3)
		{
			echo '<span class="notification n-error">Please fill All Input fields.</span>';
		}
		else if ($message!="")
		{
			echo '<span class="notification n-error">'.$message.'.</span>';
		}		

	}



function show_re_crawl_all_form()
	{
	?>
		   <!-- Categories list -->
            <div class="grid_6">
                
                <div class="module">
                     <h2><span>Re-Crawling</span></h2>
						
                        
                     <div class="module-body">
                         <p>Click to Start Re Crawling of Urdu Websites</p>
						
                         <form action="spider_files/spider.php" method="post">
                            <p>
                                <label>Enter the Limit of website for Crawling</label>
                                <input type="text" class="input-short" name="crawling_limit"/>
                                <span class="notification-input ni-correct">Default value is 10!</span>
                            </p>
							
							<fieldset>
                                <input type="hidden" name="re_crawl_all" value="1">
								<input class="submit-green" type="submit" value="click to Start Re-crawling" />
                            </fieldset>
                         </form>
                     </div>
                </div> <!-- module -->
                <div style="clear:both;"></div>
			</div> <!-- End .grid_6 -->
           
	
	<?php
	
		
	}
	




function show_crawl_all_new_sites_form()
	{
	
	?>
	<!-- Categories list -->
            <div class="grid_6">
                
                <div class="module">
                     <h2><span>Crawling All New Sites</span></h2>
						
                        
                     <div class="module-body">
                         <p>Click to Start Crawling of new Urdu Websites</p>
						
                         <form action="spider_files/spider.php" method="post">
                           
							<p>
                                <label>Enter the Limit of website for Crawling</label>
                                <input type="text" class="input-short" name="crawling_limit"/>
                                <span class="notification-input ni-correct">Default value is 10!</span>
                            </p>

						   <fieldset>
						<input type="hidden" name="crawl_all_new_sites" value="1">                               
							   <input class="submit-green" type="submit" value="Click to Start Crawling" />
                            </fieldset>
                         </form>
                     </div>
                </div> <!-- module -->
                <div style="clear:both;"></div>
			</div> <!-- End .grid_6 -->
           
	<?php
	
	
	
	}





function show_crawl_all_pending_sites_form()
	{
	
	?>
	<!-- Categories list -->
            <div class="grid_6">
                
                <div class="module">
                     <h2><span>Crawling All Pending Sites</span></h2>
						
                        
                     <div class="module-body">
                         <p>Click to Continue Crawling of Pending Urdu Websites</p>
						
                         <form action="spider_files/spider.php" method="post">
                           
							<p>
                                <label>Enter the Limit of website for Crawling</label>
                                <input type="text" class="input-short" name="crawling_limit"/>
                                <span class="notification-input ni-correct">Default value is 10!</span>
                            </p>

						   <fieldset>
						<input type="hidden" name="crawl_all_pending_sites" value="1">                               
							   <input class="submit-green" type="submit" value="Click to Start Crawling" />
                            </fieldset>
                         </form>
                     </div>
                </div> <!-- module -->
                <div style="clear:both;"></div>
			</div> <!-- End .grid_6 -->
           
	<?php
	
	
	
	}

	
	
	function show_add_site_form()
	{
	
		?>
		
		<!-- Form elements -->    
            <div class="grid_12">
            
                <div class="module">
                     <h2><span>Add a site</span></h2>
                        
                     <div class="module-body">
                        <form action="admin.php" method="post">
                        
                            <p>
                                <label>URL</label>
								<input type="hidden" name="page_value" value="add_site_query"/>
								<input type="hidden" name="af" value="2"/>
                                <input type="text" class="input-short" name="sites_url" value="http://"/>
                                
                            </p>
                            
							<p>
                                <label>Title</label>
								
                                <input type="text" class="input-short" name="sites_title" value=""/>
                                
                            </p>
                           
                            <fieldset>
                                <label>Short Description</label>
                                <textarea id="wysiwyg" rows="11" cols="90" name="sites_description">    </textarea> 
                            </fieldset>
                            
                            <fieldset>
                                <input class="submit-green" type="submit" value="Add Site" />
                            </fieldset>
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div> <!-- End .grid_12 -->
            
		
		<?php
	
		
	
	}

	
	
	function show_clean_tables_form()
	{
		
		$result = mysql_query("select count(*) from ".$mysql_table_prefix."temp");
		echo mysql_error();
		if ($row=mysql_fetch_array($result)) {
			$temp=$row[0];
		}

		
		?>
		
		
		
			
				 <!-- Example table -->
                <div class="module">
                	<h2><span>Statistics for site <?php print "<a style=\"color:green;\" href=\"admin.php?page_value=show_site_data&site_id=$sites_id\">$url</a>";?></span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:10%">#</th>
                                    <th style="width:30%">Action </th>
                                    <th style="width:30%">Action Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-center">1</td>
                                    <td><a href="admin.php?page_value=delete_links" id="small_button">Clean links</a></td>
                                    <td>Delete all links not associated with any site.</td>
                                    
                                </tr>
									<tr>
                                    <td class="align-center">2</td>
                                    <td><a href="admin.php?page_value=delete_temp" id="small_button">Clear temp tables </a></td>
                                    <td><?php print $temp;?> items in temporary table.</td>
                                    
                                </tr>
								
		
		
		             </tbody>
                        </table>
                        </form>
                       
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
     
		
		
		<?php 
	}
	
	
	function show_statistics($type)
	{
	echo '<meta http-equiv="refresh" content="5;index.php?page_value=statistics"';
		global $log_dir;
		//$log_dir="./spider_files/crawling_log/";
		?>
				
		<?php 
			if ($type == "") {
				$cachedSumQuery = "select sum(length(crawled_links_urdu_text )) from crawled_links";
				$result=mysql_query("select sum(length(crawled_links_urdu_text )) from crawled_links");
				echo mysql_error();
				if ($row=mysql_fetch_array($result)) 
				{
					$cachedSumSize = $row[0];
				}
				$cachedSumSize = number_format($cachedSumSize / 1024, 2);

				$sitesSizeQuery = "select sum(crawled_links_size) from crawled_links";
				$result=mysql_query("$sitesSizeQuery");
				echo mysql_error();
				if ($row=mysql_fetch_array($result))
				{
					$sitesSize = $row[0];
				}
				$sitesSize = number_format($sitesSize, 2);

				$stats = get_database_stats();
			
			?>
			
			
			
			
				 <!-- Example table -->
                <div class="module">
                	<h2><span>Statistics of Urdu Search Engine </span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTabl" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:10%">#</th>
                                    <th style="width:30%">Attribute Name </th>
                                    <th style="width:30%">Attribute Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-center">1</td>
                                    <td>Total Sites</td>
                                    <td><?php echo $stats['sites'];?></td>
                                    
                                </tr>
									<tr>
                                    <td class="align-center">2</td>
                                    <td>Total Crawled Links </td>
                                    <td><?php print $stats['links'];?> </td>
                                    
                                </tr>
								</tr>
									<tr>
                                    <td class="align-center">3</td>
                                    <td>Total Cached Urdu texts </td>
                                    <td><?php print $cachedSumSize;?> kb</td>
                                    
                                </tr>
								
								</tr>
									<tr>
                                    <td class="align-center">4</td>
                                    <td>Total Web Sites size  </td>
                                    <td><?php print $sitesSize;?>  kb</td>
                                    
                                </tr>
		
		
		             </tbody>
                        </table>
                        </form>
                       
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
			
			
			<?php

			}	

			if ($type=='pages') 
			{
				?>
	
				 <!-- Example table -->
                <div class="module">
                	<h2><span>Largest Pages of Urdu Search Engine </span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:10%">#</th>
                                    <th style="width:30%">Pages </th>
                                    <th style="width:30%">Urdu Text Size of Pages</th>
                                </tr>
                            </thead>
                            <tbody>
                              
			<?php	
				$result=mysql_query("select  crawled_links.crawled_links_id, crawled_links_url, length(crawled_links_urdu_text )  as x from crawled_links order by x desc limit 20");
				echo mysql_error();
				$n=0;
				while ($row=mysql_fetch_row($result))
				{
					$n++;
					$url = $row[1];
					$sum = number_format($row[2]/1024, 2);
					?>
					  <tr>
                                    <td class="align-center"><?php echo $n;?></td>
                                    <td><a href="<?php echo $url;?>"><?php echo $url;?></a></td>
                                    <td><?php echo $sum;?>kb</td>
                         </tr>     
					<?php
		 		}			
		
				?>


		             </tbody>
                        </table>
                        </form>
                       							<div class="pager" id="pager">
                            <form action="">
                                <div>
                                <img class="first" src="templates/css-js-images/arrow-stop-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop-180.gif" alt="first"/>
                                <img class="prev" src="templates/css-js-images/arrow-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-180.gif" alt="prev"/> 
                                <input type="text" class="pagedisplay input-short align-center"/>
                                <img class="next" src="templates/css-js-images/arrow.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow.gif" alt="next"/>
                                <img class="last" src="templates/css-js-images/arrow-stop.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop.gif" alt="last"/> 
                                <select class="pagesize input-short align-center">
                                    <option value="10" selected="selected">10</option>
                                    <option value="20" >20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
									<option value="30">50</option>
                                    <option value="40">100</option>
                                </select>
                                </div>
                            </form>
                        </div>
                        
			
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
			

				<?php
		
			}

			
			if ($type=='spidering_log')
			{
				$files = get_dir_contents($log_dir);
				if (count($files)>0)
				{
					
					?>
					<!-- Example table -->
                <div class="module">
                	<h2><span>Crawling Log of Urdu Search Engine </span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:10%">#</th>
                                    <th style="width:20%">File </th>
                                    <th style="width:20%">Time</th>
									<th style="width:20%">Action</th>
									<th style="width:15%"></th>
                                </tr>
                            </thead>
                            <tbody>
					<?php
					$n=0;
					for ($i=0; $i<count($files); $i++)
					{	
						$n++;
						$file=$files[$i];
						$year = substr($file, 0,2);
						$month = substr($file, 2,2);
						$day = substr($file, 4,2);
						$hour = substr($file, 6,2);
						$minute = substr($file, 8,2);
						
						
						?>
					  <tr>
                                    <td class="align-center"><?php echo $n;?></td>
                                    <td><?php echo "<a href='$log_dir/$file' tareget='_blank'>$file</a>";?></td>
                                    <td><?php echo "20$year-$month-$day $hour:$minute";?></td>
									<td><?php echo "<a href='?page_value=delete_crawling_log&file=$file' id='small_button'>Delete File</a>";?></td>
									<td><img src="templates/css-js-images/bin.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/bin.gif" width="16" height="16" alt="delete" /></td>
                         </tr>     
					<?php
						
					
					}

					?>
		             </tbody>
                        </table>
                        </form>
                       
								<div class="pager" id="pager">
                            <form action="">
                                <div>
                                <img class="first" src="templates/css-js-images/arrow-stop-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop-180.gif" alt="first"/>
                                <img class="prev" src="templates/css-js-images/arrow-180.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-180.gif" alt="prev"/> 
                                <input type="text" class="pagedisplay input-short align-center"/>
                                <img class="next" src="templates/css-js-images/arrow.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow.gif" alt="next"/>
                                <img class="last" src="templates/css-js-images/arrow-stop.gif" tppabs="http://www.xooom.pl/work/magicadmin/images/arrow-stop.gif" alt="last"/> 
                                <select class="pagesize input-short align-center">
                                    <option value="10" selected="selected">10</option>
                                    <option value="20" >20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
									<option value="30">50</option>
                                    <option value="40">100</option>
                                </select>
                                </div>
                            </form>
                        </div>
                        
					   
					   
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
			<?php
				} 
				else
				{
					?>
					<br/><br/>
					<center><b>No saved crawling logs.</b></center>
					<?php 
				}
			}
	
	}
	
	
	
	
	function urdu_domains()
	{
	
		$re=mysql_query("select * from domains");
		$num=mysql_num_rows($re);
		?>
		
		
				 <!-- Example table -->
                <div class="module">
                	<h2><span>Domains Statistics of Urdu Search Engine ( <?php echo $num?> No. of domains in the system ) </span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTabl" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:10%">Urdu Domain ID</th>
                                    <th style="width:30%">Urdu Domain URL </th>
                                    <th style="width:20%">click to visit</th>
                                </tr>
                            </thead>
                            <tbody>
                                
								<?php
								
								
								while($row=mysql_fetch_array($re))
								{
								?>
								
								<tr>
                                    <td class="align-center"><?php echo $row['domains_id'];?></td>
                                    <td><?php echo $row['domains_url'];?></td>
                                    <td><a href="http://<?php echo $row['domains_url'];?>">Visit Site</a></td>
                                    
                                </tr>
								<?php
								}
								?>
		
		             </tbody>
                        </table>
                        </form>
                       
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
			
		<?php
	
	
	}

?>