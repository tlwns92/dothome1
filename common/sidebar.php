<div id="sidebar-bg">
			<div id="sidebar">

			<!-- <?php echo $user_id . " " . $email . " " . $login_time . " " . $session_timeout;?> -->


				<div class="region region-sidebar-first">
					<div id="block-block-5" class="block block-block">
				  
						  <h2 >Contact Us</h2>
					  
					<div class="content">
					  <p><strong>NYU Cardiovascular Clinical Research Center </strong><br />227 East 30th Street, New York, NY 10016 <br />Telephone: 212-263-4225 <br />Email: <a href="mailto:ISCHEMIA@nyulangone.org">ISCHEMIA@nyulangone.org</a></p>
					</div>
					
				  </div> <!-- /.block -->
				  <div id="block-user-login" class="block block-user">
				  
						  <h2 >User login</h2>
					  
					<div class="content">
					<?php 
						if($islogin) {
							echo "Welcome, " . $email;
					?>

						<input type="submit" value="LOGOUT" onclick='location.replace("controller/logout.php")'><br>
						<button type="button" class="button_signup" onClick="location.href='index.php?category=page/upload'">Upload</button>
					</div>
					<?php 
						}else{
					?>


					  <form onsubmit="event.preventDefault()" id="user-login-form">
					<div><div class="form-item form-type-field form-item-name">
					<label for="email">email <span class="form-required" title="This field is required.">*</span></label>
				   <input type="text" id="login-email" name="login-email" value="" size="15" maxlength="60" class="form-text required" />
				  </div>
				  <br>
				  <div class="form-item form-type-password form-item-pass">
					<label for="password">Password <span class="form-required" title="This field is required.">*</span></label>
				   <input type="password" id="login-password" name="login-password" size="15" maxlength="128" class="form-text required"  autocomplete="new-password"/>
				  </div>
				  <br>
				  <div class="item-list"><ul><li class="first last"><a href="/user/password" title="Request new password via e-mail.">Request new password</a></li>
				  </ul></div><input type="hidden" name="form_build_id" value="form-RZxfQPk2njCPJd6_zQePpTnz_Bw6-yoM5K4rhBVpzRo" />
				  <input type="hidden" name="form_id" value="user_login_block" />
				  <br>&emsp;&emsp;&emsp;&emsp;

				  <div class="form-actions form-wrapper button_login" id="edit-actions">
					<input type="submit" id="edit-submit" name="op" value="Log in" class="form-submit" onclick="logincheck()" />
				  </div>&emsp;
				  <div id="button_signup">
					<button type="button" class="button_signup" onClick="location.href='index.php?category=page/signup'">Sign Up</button>				
				  </div>
				</div></form>  </div>
				<?php }?>




				  </div> <!-- /.block -->
				  <div id="block-views-news-block" class="block block-views">
				  
						  <h2 >News</h2>
					  
					<div class="content">
					  <div class="view view-news view-id-news view-display-id-block view-dom-id-5d0b7a368fc4d0f029d0a687fcd900d8">
						  
					
					
						<div class="view-content">
						  <div class="views-row views-row-1 views-row-odd views-row-first views-row-last">
						
					<div class="views-field views-field-field-date">        <div class="field-content"><span class="date-display-single" property="dc:date" datatype="xsd:dateTime" content="2022-06-15T00:00:00-04:00">Wed, 06/15/2022 - 00:00</span></div>  </div>  
					<div class="views-field views-field-title">        <span class="field-content"><a href="/news/ischemia-social-media">ISCHEMIA in the Social Media</a></span>  </div>  </div>
					  </div></div></div></div></div>
					<br><br>

			</div><!-- end #sidebar -->
		</div>
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page -->
</div>
