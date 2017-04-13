<div class="page-wrapper">
	<div class="page-container">
		<div class="page-header">
			<div class="div_bigtitle">Profile</span></div>
		</div>
		<div class="page-content">
			<div class="div_alert hidden" style="margin-bottom:5px;"></div>
			<div class="formContent">
				<div class="row">
					<div class="col-sm-4 col-md-4">
						<div>
							<div>Username (Email)</div>
							<input class="register_input" type="text" name="email" id="email" placeholder="user@mail.com"></input>
						</div>
						<div>
							<div>Change Password</div>
							<input class="register_input" type="password" name="password" id="password" placeholder="password" disabled></input>
						</div>
						<div>
							<div>Confirm New Password</div>
							<input class="register_input" type="password" name="passconf" id="passconf" placeholder="password" disabled></input>
							<div class="div_smalltext">
								<span>Your password must be a minimum length of 7 characters and contain at least one of each of the following: Number, Uppercase letter, Lowercase letter</span>
							</div>
						</div>
						
					</div>
					
					<div class="col-sm-4 col-md-4">
						<div>
							<div>First Name</div>
							<input class="register_input" type="text" name="firstname" id="firstname" placeholder="first name"></input>
						</div>
						<div>
							<div>Last Name</div>
							<input class="register_input" type="text" name="lastname" id="lastname" placeholder="last name"></input>
						</div>
						<div>
							<div>Department</div>
							<input class="register_input" type="text" name="department" id="department" placeholder="department"></input>
						</div>
						<div>
							<div>Job Title</div>
							<input class="register_input" type="text" name="jobtitle" id="jobtitle" placeholder="title"></input>
						</div>
						<div>
							<div>Phone</div>
							<input class="register_input" type="number" name="phone" id="phone" placeholder="658881234"></input>
						</div>
						<div>
							<div>Country</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
					</div>
				</div>
				
				<div class="submissionBar">
					<div class="submissionResult div_alert hidden"></div>
					<button name="btn-save">Update Profile</button>
					<button name="btn-reset">Reset</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="page-container" style="margin-top:20px;">
		<div class="page-header">
			<div class="div_bigtitle">My Assets</span></div> 
		</div>
		<div class="page-content">
			<table id="mainList" class="table-standard">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th class="hidden-xs">Asset Type</th>
						<th class="hidden-xs hidden-sm">Location</th>
						<th class="hidden-xs hidden-sm">Brand</th>
						<th class="hidden-xs hidden-sm hidden-md">Channel</th>
						<th class="hidden-xs hidden-sm hidden-md">Total Filesize</th>
						<th class="hidden-xs">Date Upload</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	
</div>
	
<!-- JS -->
<script type="text/javascript" src="_lib/pages/profile/profile_get.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/login/login.css">


