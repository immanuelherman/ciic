<div class="page-wrapper">
	<div class="page-container">
		
		<div class="page-header">
			<div class="backnav">
				<!--<a href="user/get" target="_self"><i class="fa fa-angle-left"></i> Back to List</a>-->
				<button name="btn-back"><i class="fa fa-chevron-left"></i></button>
			</div>
			<div class="div_bigtitle">User <span name="action"><?php echo($actionType);?></span></div> 
		</div>
	
	
		<div class="page-content">
			<div class="div_alert notificationBar hidden" style="margin-bottom:5px;"></div>
			<div class="formContent">
				<input type="hidden" name="id" value="<?php echo($id);?>" disabled />
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Username (Email)*</div>
							<input class="register_input" type="text" name="email" id="email" placeholder="user@mail.com"></input>
						</div>
						<div>
							<div class="subtitle">Password*</div>
							<input class="register_input" type="text" name="password" id="password" placeholder="password"></input>
						</div>
						<div>
							<div class="subtitle">First Name*</div>
							<input class="register_input" type="text" name="firstname" id="firstname" placeholder="first name"></input>
						</div>
						<div>
							<div class="subtitle">Last Name*</div>
							<input class="register_input" type="text" name="lastname" id="lastname" placeholder="last name"></input>
						</div>
						
					</div>
					
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Department</div>
							<input class="register_input" type="text" name="department" id="department" placeholder="department"></input>
						</div>
						<div>
							<div class="subtitle">Job Title</div>
							<input class="register_input" type="text" name="jobtitle" id="jobtitle" placeholder="title"></input>
						</div>
						<div>
							<div class="subtitle">Phone*</div>
							<input class="register_input" type="number" name="phone" id="phone" placeholder="658881234"></input>
						</div>
						<div>
							<div class="subtitle">Country</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
					</div>
					
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Role</div>
							<select class="register_input" type="text" name="rolecode" id="rolecode"></select>
						</div>
						<div>
							<div class="subtitle">Account Status</div>
							<select class="register_input" type="text" name="activestatus" id="activestatus">
								<option value="0">Inactive</option>
								<option value="1">Active</option>
							</select>
						</div>
					</div>
					
				</div>
				
				
				
				<div class="div_smalltext">*Required</div>
				<div class="submissionBar">
					<div class="submissionResult div_alert hidden"></div>
					<button name="btn-create" class="hidden">Create Another User</button>
					<button name="btn-save">Update</button>
					<button name="btn-reset">Reset</button>
				</div>
			</div>
		</div>
	</div>
	
</div>
	
<!-- JS -->
<script type="text/javascript" src="_lib/pages/user/user_detail.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/login/login.css">


