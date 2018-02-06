
	
	 <div class="grid_6"  >
                <div class="module">
                     <h2><span>Urdu Search Engine User Login</span></h2>
                        
                     <div class="module-body">
                        <form action="user_includes/verify_login.php" method="post">
                            
							<?php
							
							if(isset($_GET['error'])&&$_GET['error']=="wrong_input")
							{	
				
								echo '<span class="notification n-error">Incorrect email and password.</span>';
                
							
                
							}
							?>
							<p>
                                <label>Email</label>
                                <input class="input-medium" type="text"  name="email"/>
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
						
							if(isset($_SESSION['user']) && isset($_SESSION['user_email']))
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
		


	 <div class="grid_6"  >
                <div class="module">
                     <h2><span>Urdu Search Engine User Registration</span></h2>
                        
                     <div class="module-body">
                        <form action="user_includes/verify_registration.php" method="post">
						
						<?php
						
							if(isset($_GET['error'])&&$_GET['error']=="empty_input")
							{	
				
								echo '<span class="notification n-error">Please fill all inputs.</span>';
                
							
                
							}
							else if(isset($_GET['error'])&&$_GET['error']=="pass_error")
							{	
								echo '<span class="notification n-attention">Password Do not match , Please Enter again .</span>';
                
							}
							else if(isset($_GET['error'])&&$_GET['error']=="in_db")
							{	
								echo '<span class="notification n-attention">This user is already register . Please Login.</span>';
                
							}
							else if(isset($_GET['error'])&&$_GET['error']=="email_incorrect")
							{	
								echo '<span class="notification n-attention">Please Enter a valid email address.</span>';
                
							}
							
							
						?>
						
                            <p>
                                <label>Username</label>
                                <input class="input-medium" type="text"  name="user"/>
                            </p>
                            <p>
                                <label>Email</label>
                                <input class="input-medium" type="text"  name="email"/>
                            </p>
							
							 <p>
                                <label>Country</label>
                                <select class="input-short" name="country">
                                    <option value="pakistan">Pakistan</option>
                                    <option value="india">India</option>
                                    <option value="bangladesh">Bangladesh</option>
                                    <option value="iran">Iran</option>
                                </select>
                            </p>
                            
							<fieldset>
                                
                                <ul>
                                    <li><label><input type="checkbox" name="newsletter"  id="cb1" /> Send weekly newsletters</label></li>
                                    
                                </ul>
                            </fieldset>
							
							
							<p>
                                <label>Password</label>
                                <input type="password" class="input-medium" name="pass"/>
                            </p>
							<p>
                                <label>Confirm Password</label>
                                <input type="password" class="input-medium" name="cpass"/>
                            </p>
                            <fieldset>
                                <input class="submit-green" type="submit" value="Register" name="registerb"/> 
                                
                            </fieldset>
                        </form>
						
						
                        
                     </div> <!-- End .module-body -->
                </div> <!-- End .module -->
                <div style="clear:both;"></div>
            </div> <!-- End .grid_6 -->
			


		
            <div style="clear:both;"></div>
			
		