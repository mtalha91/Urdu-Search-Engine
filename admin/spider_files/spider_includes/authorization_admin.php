<?php 
	
	
	$admin = "admin";
	$admin_pw = "admin";

	session_start();
	
if (isset($_POST['user']) && isset($_POST['pass']))
{
	
	$username = $_POST['user'];
	$password = $_POST['pass'];
	$username=strip_tags($username);
	//$username=mysql_real_escape_string($username);
	$password=strip_tags($password);
	//$password=mysql_real_escape_string($password);
	
	
	$_SESSION['admin'] = $username;
	$_SESSION['admin_pw'] = $password;
	if (($username == $admin) && ($password ==$admin_pw))
	{
		$_SESSION['admin'] = $username;
		$_SESSION['admin_pw'] = $password;
		
	}
	header("Location:../../admin.php");//moving two folder back
	
} elseif ((isset($_SESSION['admin']) && isset($_SESSION['admin_pw']) &&$_SESSION['admin'] == $admin && $_SESSION['admin_pw'] == $admin_pw ))
	{
		
			//////////its mean admin is logged in
	}

 else {
		
 ?>	
	
	<!-- Header -->
        <div id="header">
            <!-- Header. Status part -->
            <div id="header-status">
                <div class="container_12">
                    <div class="grid_8">
					&nbsp;<span style="font-size:2em;">دنیا کا پہلا اردو زبان میں سرچ انجن</span>
                    </div>
                    <div class="grid_4">
                        
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End #header-status -->
            
            <!-- Header. Main part -->
            <div id="header-main">
                <div class="container_12">
                    <div class="grid_12">
                        <div id="logo">
                            
                        </div><!-- End. #Logo -->
                    </div><!-- End. .grid_12-->
                    <div style="clear: both;"></div>
                </div><!-- End. .container_12 -->
            </div> <!-- End #header-main -->
            <div style="clear: both;"></div>
            
        </div> <!-- End #header -->


	
	<div class="container_12"><!--main body div-->
	
	
	 <div class="grid_6"  >
                <div class="module">
                     <h2><span>Urdu Search Engine Admin Login</span></h2>
                        
                     <div class="module-body">
                        <form action="spider_files/spider_includes/authorization_admin.php" method="post">
                            <p>
                                <label>Username</label>
                                <input class="input-medium" type="text"  name="user"/>
                            </p>
                            <p>
                                <label>Password</label>
                                <input type="password" class="input-medium" name="pass"/>
                            </p>
                            <fieldset>
                                <input class="submit-green" type="submit" value="Login" name="loginb"/> 
                                
                            </fieldset>
                        </form>
						
						
                        <?php
						
							if(isset($_SESSION['admin']) && isset($_SESSION['admin_pw']))
							{	
								if($_POST['user'] =="" || $_POST['pass'] == "")
								{
									echo '<span class="notification n-attention">Please Fill All Fields.</span>';
								}
								else
								{
									echo '<span class="notification n-error">Incorect Username or Password.</span>';
                
								}
                
							
							}
						?>
                     </div> <!-- End .module-body -->
                </div> <!-- End .module -->
                <div style="clear:both;"></div>
            </div> <!-- End .grid_6 -->
			
            <div style="clear:both;"></div>
			
			
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
	
 
 <?php

	exit();
}




?>