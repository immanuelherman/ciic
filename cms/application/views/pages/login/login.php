<link rel="stylesheet" type="text/css" href="_lib/pages/login/login.css">

<section name="login">
	<div class="login_container">
		<div class="div_logo"></div>
		<div class="div_title"><span>Sign In</span></div>
		<div>
			<div style="position:relative; margin-bottom:10px;">
				<input class="login_input" type="text" name="ciic_username" id="username" placeholder="email"></input>
				<div class="iconInputOverlay"><i class="fa fa-user"></i></div>
			</div>
			<div style="position:relative;">
				<input class="login_input" type="password" name="ciic_password" id="password" placeholder="password"></input>
				<div class="iconInputOverlay"><i class="fa fa-unlock-alt"></i></div>
			</div>
			<div class="div_smalltext" style="margin-top:5px;">
				<a href="">Forgotten Password?</a>
			</div>
			<div class="">
				<div style="margin-top:10px;">
					<div class="div_alert hidden" style="margin-bottom:5px;"></div>
					<button class="login_input btn-blue" id="login">Log In</button>
				</div>
				<div class="separator-top">
					<button class="login_input btn-green" id="register">Register</button>
				</div>
			</div>
		</div>
	</div>
</section>

<section name="register">
	<div class="register_container hidden">
		<div class="div_logo"></div>
		<div class="div_title"><span>Register</span></div>
		<div class="div_formregister">
			<div class="row">
				<div class="col-md-6">
					<div>
						<div>Username (Email)</div>
						<input class="register_input" type="text" name="email" id="email" placeholder="user@mail.com"></input>
					</div>
					<div>
						<div>Password</div>
						<input class="register_input" type="password" name="password" id="password" placeholder="password"></input>
					</div>
					<div>
						<div>Confirm Password</div>
						<input class="register_input" type="password" name="passconf" id="passconf" placeholder="password"></input>
						<div class="div_smalltext">
							<span>Your password must be a minimum length of 7 characters and contain at least one of each of the following: Number, Uppercase letter, Lowercase letter</span>
						</div>
					</div>
					<div>
						<div>Country</div>
						<select class="register_input" type="text" name="country" id="country">
							<option value="United Kingdom">United Kingdom</option>
							<option value="United States">United States</option>
							<option value="China">China</option>
							<option value="Singapore">Singapore</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Indonesia">Indonesia</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div>
						<div>First Name</div>
						<input class="register_input" type="text" name="firstname" id="firstname" placeholder="First name"></input>
					</div>
					<div>
						<div>Last Name</div>
						<input class="register_input" type="text" name="lastname" id="lastname" placeholder="Last name"></input>
					</div>
					<div>
						<div>Department</div>
						<input class="register_input" type="text" name="department" id="department" placeholder="Department"></input>
					</div>
					<div>
						<div>Job Title</div>
						<input class="register_input" type="text" name="jobtitle" id="jobtitle" placeholder="Job title"></input>
					</div>
					<div>
						<div>Phone</div>
						<input class="register_input" type="number" name="phone" id="phone" placeholder="6588812345"></input>
					</div>
					
				</div>
			</div>
			
			<div class="separator-top"/>
			
			<div class="row">
				<div class="col-md-6">
					<div>
						<div>Please outline below the reason why you would like access to Digital Library</div>
						<textarea class="register_input" type="text" name="reason" id="reason" placeholder=""></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div>
						<div class="g-recaptcha" data-sitekey="6LcBGAwTAAAAAOFeuB7yAgQSuwqOIUhY8n3y9Itn"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="submissionResult div_alert hidden"></div>
					<div style="text-align:center;">
						<button class="login_input btn-green" id="register_cancel" style="width:150px; margin:10px;">Cancel</button>
						<button class="login_input btn-green" id="register_submit" style="width:150px; margin:10px;">Submit</button>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</section>

<!-- JS -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript" src="_lib/js/crypt/md5.js"></script>
<script type="text/javascript" src="_lib/pages/login/login.js"></script>
<script type="text/javascript" src="_lib/pages/login/register.js"></script>



