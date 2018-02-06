<?php


	function user_account()
	{
		?>	
		 <!-- Account overview -->
            <div class="grid_6">
                <div class="module">
                        <h2><span>Your Profile Information</span></h2>
                        
                        <div class="module-body">
						<span class="notification n-information">Your Urdu search engine account information . You can change the information any time you want or change the password by selecting "Change My Password" from the rigth box.</span>
                        <form action="" method="post">
                        	<p>
							
							<?php
							/*
							
								if($error=="empty_input")
								{
							?>
							 <span class="notification n-error"><?php echo "Please fill all inputs  ";?></span>
							<?php
								}
								else if ($error=="in_db")
								{
								?>
									<span class="notification n-attention"><?php echo "The URL Adress already in database . Please enter different URL ";?></span>	
								<?php
								}
								else if($error=="no")
								{
								?>
								<span class="notification n-success"><?php echo "Your website is Successfully submit to URDU Search Engine. ";?></span>
								<?php
								}
								
								
								
								*/
								
								$user_email=$_SESSION['user'];
								$qu=mysql_query("select * from user where user_email='$user_email'");
								$row=mysql_fetch_array($qu);
								
							?>
							
							
							
							<p>
                                <label>Username</label>
                                <input class="input-medium" type="text"  name="user"value="<?php echo $row['user_username']; ?>" readonly="readonly"/>
                            </p>
                            <p>
                                <label>Email</label>
                                <input class="input-medium" type="text"  name="email" value="<?php echo $row['user_email'];?>"  readonly="readonly"/>
                            </p>
							
							<p>
                                <label>Country</label>
                                <input class="input-medium" type="text"  name="email" value="<?php echo $row['user_country'];?>"  readonly="readonly"/>
                            </p>							<fieldset>
                                
                                <ul>
                                    <li><label><input type="checkbox" name="newsletter"  id="cb1" <?php if($row['user_newsletter']==1)echo "checked"; ?> readonly="readonly"/> Send weekly newsletters</label></li>
                                    
                                </ul>
                            </fieldset>
							
							
						
                            <fieldset>
                                <input class="submit-green" type="submit" value="Edit Information" name="registerb" readonly="readonly"/> 
                                
                            </fieldset>
                           </form>  
                             
                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
			
			<?php
			echo "<pre>";
				$user_email=$_SESSION['user'];
							$result=array();
							$qu=mysql_query("select * from sites where sites_owner='$user_email'");
							$n=0;
							while($row=mysql_fetch_array($qu))
							{
								$n++;
								$result[]=$row;
								
							}
							
							
							if($n==0)
							{
								$a_status="Low";
							}
							else if ($n>0&&$n<2)
							{
								$a_status="Medium";
							}
							else 
							{
								$a_status="High";
							}
						echo "</pre>";
						?>
			
			
			
			 <!-- Account overview -->
            <div class="grid_6">
                <div class="module">
                        <h2><span>Account overview</span></h2>
                        
                        <div class="module-body">
                        
                        	<p>
							<span class="notification n-information">Check your website crawled status  (crawled or not).</span>
                
                                <strong><a href="user.php?page_value=user_account">My Profile</a> </strong><br />
                                <strong><a href="user.php?page_value=my_website_status">My websites crawled status</a> </strong><br />
                                <strong><a href="user.php?page_value=change_password">Change my Password</a> </strong>
                            </p>
                        
						
                             <div>
                                 <div class="indicator">
                                     <div style="width:<?php if($a_status=="Low")echo "5"; else if ($a_status=="Medium") echo "50"; else echo "90";?>%;"></div><!-- change the width value (23%) to dynamically control your indicator -->
                                 </div>
                                 <p>Your Account status : <?php 
								 
								 
								 
								 echo $a_status;?></p>
                             </div>
                             <?php
							 if($a_status=="Low")
							 {
							 ?>
                             <span class="notification n-error">You have not submitted any website to URDU Search Engine.</span>
							<?php
							}
							?>
							<?php
							 if($a_status=="Medium")
							 {
							 ?>
                             <span class="notification n-success">You have submitted only one website to URDU Search Engine.</span>
							<?php
							}
							?>
                             <?php
							 if($a_status=="High")
							 {
							 ?>
                             <span class="notification n-success">You have successfully submitted more than one website to URDU Search Engine.</span>
							<?php
							}
							?>
                        	<p>
                                My crawled website by Urdu Search Engine<br />
                                <a href="user.php?page_value=my_website_status">click here</a><br />
                            </p>

                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
	
	<?php
	
	}
	function my_website_status()
	{
		?>	
		 <div class="grid_6">
				 <!-- Example table -->
                <div class="module">
                	<h2><span>MY website Crawled status </span></h2>
                    
                    <div class="module-table-body">
                    	
                        <table id="myTabl" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:5%">Your Sites ID</th>
                                    <th style="width:15%">Your Sites Title </th>
                                    <th style="width:25%">Your Sites URL</th>
									<th style="width:20%">Crawled Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                
								<?php
								$user_e=$_SESSION['user'];
								$qs=mysql_query("select * from sites where sites_owner='$user_e'");
								if(mysql_num_rows($qs)==0)
								{
									?>
									 <span class="notification n-information">You have not submitted any website to URDU Search Engine.</span>
                
									<?php
								}
								else
								{
									echo '<span class="notification n-information">Crawled Status tells that the url is crawled or not . Note :url submission takes one week to crawl after verifying that the page is in URDU Langauge.</span>';
									while($row=mysql_fetch_array($qs))
									{
									?>
									
									<tr>
										<td class="align-center"><?php echo $row['sites_id'];?></td>
										<td><?php echo $row['sites_title'];?></td>
										<td><a href="http://<?php echo $row['sites_url'];?>"><?php echo $row['sites_url'];?></a></td>
										<td><?php if($row['sites_crawl_date']==NULL){ echo "Not Crawled";}
										else{ echo "Crawled at : ".$row['sites_crawl_date'];}?></td>
										
										
									</tr>
									<?php
									}
								}
								?>
		
		             </tbody>
                        </table>
                        
                       
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
			</div>
			<?php
			echo "<pre>";
				$user_email=$_SESSION['user'];
							$result=array();
							$qu=mysql_query("select * from sites where sites_owner='$user_email'");
							$n=0;
							while($row=mysql_fetch_array($qu))
							{
								$n++;
								$result[]=$row;
								
							}
							
							
							if($n==0)
							{
								$a_status="Low";
							}
							else if ($n>0&&$n<2)
							{
								$a_status="Medium";
							}
							else 
							{
								$a_status="High";
							}
						echo "</pre>";
						?>
			
			
			
			 <!-- Account overview -->
            <div class="grid_6">
                <div class="module">
                        <h2><span>Account overview</span></h2>
                        
                        <div class="module-body">
                        
                        	<p>
							<span class="notification n-information">Check your website crawled status  (crawled or not).</span>
                
                                <strong><a href="user.php?page_value=user_account">My Profile</a> </strong><br />
                                <strong><a href="user.php?page_value=my_website_status">My websites crawled status</a> </strong><br />
                                <strong><a href="user.php?page_value=change_password">Change my Password</a> </strong>
                            </p>
                        
						
                             <div>
                                 <div class="indicator">
                                     <div style="width:<?php if($a_status=="Low")echo "5"; else if ($a_status=="Medium") echo "50"; else echo "90";?>%;"></div><!-- change the width value (23%) to dynamically control your indicator -->
                                 </div>
                                 <p>Your Account status : <?php 
								 
								 
								 
								 echo $a_status;?></p>
                             </div>
                             <?php
							 if($a_status=="Low")
							 {
							 ?>
                             <span class="notification n-error">You have not submitted any website to URDU Search Engine.</span>
							<?php
							}
							?>
							<?php
							 if($a_status=="Medium")
							 {
							 ?>
                             <span class="notification n-success">You have submitted only one website to URDU Search Engine.</span>
							<?php
							}
							?>
                             <?php
							 if($a_status=="High")
							 {
							 ?>
                             <span class="notification n-success">You have successfully submitted more than one website to URDU Search Engine.</span>
							<?php
							}
							?>
                        	<p>
                                My crawled website by Urdu Search Engine<br />
                                <a href="user.php?page_value=my_website_status">click here</a><br />
                            </p>

                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
	
	<?php
	
	}
	function change_password($error)
	{
		?>	
		 <!-- Account overview -->
            <div class="grid_6">
                <div class="module">
                        <h2><span>Change your Password</span></h2>
                        
                        <div class="module-body">
                        <form action="user_includes/change_pass.php" method="post">
                        	<p>
							
							<?php
							
								if($error=="empty_input")
								{
							?>
							 <span class="notification n-error"><?php echo "Please fill all inputs  ";?></span>
							<?php
								}
								else if ($error=="pass_error")
								{
								?>
									<span class="notification n-error"><?php echo "Your New Password and Confirm New Password Do Not Match ";?></span>	
								<?php
								}
								else if($error=="cpass_error")
								{
								?>
								<span class="notification n-attention"><?php echo "Your current password is Incorrect. ";?></span>
								<?php
								}
								else if ($error=="no")
								{
								?>
								<span class="notification n-success"><?php echo "Your password is updated successfully. ";?></span>
								
								<?php
								
								}
								
							?>
							
							
							
							
                                <label>Current Password</label>
                                <input type="password" class="input-medium" name="cpass" />
                                
                            </p>
                        <p>
                                <label>New Password</label>
                                <input type="password" class="input-medium" name="npass"/>
                                
                            </p>
							<p>
                                <label>Confirm New Password</label>
                                <input type="password" class="input-medium" name="cnpass"/>
                                
                            </p>
							
							
							
                            <fieldset>
                                <input class="submit-green" type="submit" value="Change my Password" /> 
                                
                            </fieldset>
                           </form>  
                             
                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
			
			<?php
			echo "<pre>";
				$user_email=$_SESSION['user'];
							$result=array();
							$qu=mysql_query("select * from sites where sites_owner='$user_email'");
							$n=0;
							while($row=mysql_fetch_array($qu))
							{
								$n++;
								$result[]=$row;
								
							}
							
							
							if($n==0)
							{
								$a_status="Low";
							}
							else if ($n>0&&$n<2)
							{
								$a_status="Medium";
							}
							else 
							{
								$a_status="High";
							}
						echo "</pre>";
						?>
			
			
			
			 <!-- Account overview -->
            <div class="grid_6">
                <div class="module">
                        <h2><span>Account overview</span></h2>
                        
                        <div class="module-body">
                        
                        	<p>
							<span class="notification n-information">Check your website crawled status  (crawled or not).</span>
                
                                <strong><a href="user.php?page_value=user_account">My Profile</a> </strong><br />
                                <strong><a href="user.php?page_value=my_website_status">My websites crawled status</a> </strong><br />
                                <strong><a href="user.php?page_value=change_password">Change my Password</a> </strong>
                            </p>
                        
						
                             <div>
                                 <div class="indicator">
                                     <div style="width:<?php if($a_status=="Low")echo "5"; else if ($a_status=="Medium") echo "50"; else echo "90";?>%;"></div><!-- change the width value (23%) to dynamically control your indicator -->
                                 </div>
                                 <p>Your Account status : <?php 
								 
								 
								 
								 echo $a_status;?></p>
                             </div>
                             <?php
							 if($a_status=="Low")
							 {
							 ?>
                             <span class="notification n-error">You have not submitted any website to URDU Search Engine.</span>
							<?php
							}
							?>
							<?php
							 if($a_status=="Medium")
							 {
							 ?>
                             <span class="notification n-success">You have submitted only one website to URDU Search Engine.</span>
							<?php
							}
							?>
                             <?php
							 if($a_status=="High")
							 {
							 ?>
                             <span class="notification n-success">You have successfully submitted more than one website to URDU Search Engine.</span>
							<?php
							}
							?>
                        	<p>
                                My crawled website by Urdu Search Engine<br />
                                <a href="user.php?page_value=my_website_status">click here</a><br />
                            </p>

                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
	
	<?php
	
	}
	function submit_site($error)
	{
	?>	
		 <!-- Account overview -->
            <div class="grid_6">
                <div class="module">
                        <h2><span>Submit your Website to URDU Search Engine</span></h2>
                        
                        <div class="module-body">
                        <form action="user_includes/submit_site.php" method="post">
                        	<p>
							
							<?php
								if($error=="empty_input")
								{
							?>
							 <span class="notification n-error"><?php echo "Please fill all inputs  ";?></span>
							<?php
								}
								else if ($error=="in_db")
								{
								?>
									<span class="notification n-attention"><?php echo "The URL Adress already in database . Please enter different URL ";?></span>	
								<?php
								}
								else if($error=="no")
								{
								?>
								<span class="notification n-success"><?php echo "Your website is Successfully submit to URDU Search Engine. ";?></span>
								<?php
								}
								
								else if($error=="wrong_url")
								{
								?>
								<span class="notification n-success"><?php echo "Please enter a valid url address ";?></span>
								<?php
								}
								
							?>
							
							
							
							
                                <label>URL address of your website</label>
                                <input type="text" class="input-medium" name="url" />
                                
                            </p>
                        <p>
                                <label>Title of your website</label>
                                <input type="text" class="input-medium" name="title"/>
                                
                            </p>
							
							<fieldset>
                                <legend>Crawling Level</legend>
                                <ul>
                                    <li><label><input type="radio" name="level" checked="checked" id="cb1" value="not_full" /> Not Full</label></li>
                                    <li><label><input type="radio" name="level" id="cb2" value="full" /> Full</label></li>
                                </ul>
                            </fieldset>
                             
                             <fieldset>
                                <label>Description of your website</label>
                                <textarea id="wysiwyg" rows="11" cols="60" name="description">    </textarea> 
                            </fieldset>
                            
                            <fieldset>
                                <input class="submit-green" type="submit" value="Submit your website" /> 
                                <input class="submit-gray" type="submit" value="Cancel" />
                            </fieldset>
                           </form>  
                             
                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
			
			<?php
			echo "<pre>";
				$user_email=$_SESSION['user'];
							$result=array();
							$qu=mysql_query("select * from sites where sites_owner='$user_email'");
							$n=0;
							while($row=mysql_fetch_array($qu))
							{
								$n++;
								$result[]=$row;
								
							}
							
							
							if($n==0)
							{
								$a_status="Low";
							}
							else if ($n>0&&$n<2)
							{
								$a_status="Medium";
							}
							else 
							{
								$a_status="High";
							}
						echo "</pre>";
						?>
			
			
			
			 <!-- Account overview -->
            <div class="grid_6">
                <div class="module">
                        <h2><span>Account overview</span></h2>
                        
                        <div class="module-body">
                        
                        	<p>
							<span class="notification n-information">Check your website crawled status  (crawled or not).</span>
                
                                <strong><a href="user.php?page_value=user_account">My Profile</a> </strong><br />
                                <strong><a href="user.php?page_value=my_website_status">My websites crawled status</a> </strong><br />
                                <strong><a href="user.php?page_value=change_password">Change my Password</a> </strong>
                            </p>
                        
						
                             <div>
                                 <div class="indicator">
                                     <div style="width:<?php if($a_status=="Low")echo "5"; else if ($a_status=="Medium") echo "50"; else echo "90";?>%;"></div><!-- change the width value (23%) to dynamically control your indicator -->
                                 </div>
                                 <p>Your Account status : <?php 
								 
								 
								 
								 echo $a_status;?></p>
                             </div>
                             <?php
							 if($a_status=="Low")
							 {
							 ?>
                             <span class="notification n-error">You have not submitted any website to URDU Search Engine.</span>
							<?php
							}
							?>
							<?php
							 if($a_status=="Medium")
							 {
							 ?>
                             <span class="notification n-success">You have submitted only one website to URDU Search Engine.</span>
							<?php
							}
							?>
                             <?php
							 if($a_status=="High")
							 {
							 ?>
                             <span class="notification n-success">You have successfully submitted more than one website to URDU Search Engine.</span>
							<?php
							}
							?>
                        	<p>
                                My crawled website by Urdu Search Engine<br />
                                <a href="user.php?page_value=my_website_status">click here</a><br />
                            </p>

                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
	
	<?php
	}

	function check_urdu($error,$urdu,$req_url)
	{
		?>
		 
            <!-- Form elements -->    
            <div class="grid_12">
            
                <div class="module">
                     <h2><span>Enter the URL to verify that the page contain URDU text or not </span></h2>
                        
                     <div class="module-body">
                        <form action="user_includes/get_urdu.php" method="post">
                        
                           
                           
                            
                            <p>
							<?php
								if($error=="empty_input")
								{
							?>
							 <span class="notification n-error"><?php echo "Please enter url address of any web page ";?></span>
							<?php
								}
								else if($error=="no")
								{
								?>
								<span class="notification n-success"><?php echo "The input URL address of webpage is in  URDU Langauge";?></span>
								<?php
								}
								else if ($error!="")
								{
								?>
							 <span class="notification n-error"><?php echo $error;?></span>
							<?php
								
								}
							?>
							
                                <label>Enter the Url</label>
                                <input type="text" class="input-medium" name="url" value="http://www.<?php if($req_url!="")echo $req_url;?>"/>
								<span class="notification-input ni-correct">url of urdu website!</span>
                                
                            </p>
                           
                            
                            <p>
                                <label>Urdu Text found in the URL</label>
                                <textarea name="url_urdu" rows="7" cols="90" class="input-medium" readonly>
								<?php if($urdu!="")
								echo $urdu;
								
								?>
								
								</textarea>
                            </p>
                            
                            <fieldset>
							<input class="submit-green" type="submit" value="Check for URDU" /> 
							 
                            </fieldset>
							
						</form>
							<form action="user.php?page_value=check_urdu" method="post">
                                
							<fieldset>
							 
							 <input class="submit-green" type="submit" value="Reset" /> 
                                
                            </fieldset>
							
							</form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div> <!-- End .grid_12 -->
                
		
		<?php
		
	}
?>