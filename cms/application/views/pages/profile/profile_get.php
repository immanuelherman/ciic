<div class="page-wrapper">
	<div class="page-container">
		<div class="page-header">
			<div class="div_bigtitle">Profile</span></div>
		</div>
		<div class="page-content">
			<div class="alertProfile div_alert hidden" style="margin-bottom:5px;"></div>
			<div class="formContent">
				<div class="row">
					<div class="col-sm-4 col-md-4">
						<div>
							<div>Username (Email)</div>
							<input class="register_input" type="text" name="email" id="email" placeholder="user@mail.com"></input>
						</div>
						<div>
							<div>Change Password</div>
							<input class="register_input" type="password" name="password" id="password" placeholder="New Password"></input>
						</div>
						<div>
							<div>Confirm New Password</div>
							<input class="register_input" type="password" name="passconf" id="passconf" placeholder="Retype new password"></input>
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
				
				<div class="submissionResult div_alert hidden" style="margin-bottom:10px;"></div>
				
				<div class="submissionBar">
					<button name="btn-save">Update Profile</button>
					<button name="btn-reset">Reset</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="page-container" style="margin-top:20px;">
		<div class="page-header">
			<div style="clear:both; float:right; margin-top:-7px;">
				<button name="btn-add" class="btn-green"><i class="fa fa-upload" aria-hidden="true"></i> Upload Asset</button>
			</div>
			<div class="div_bigtitle">My Assets</span></div>
		</div>
		<div class="page-content">
			<div class="alertAsset div_alert hidden" style="margin-bottom:10px;"></div>
			<iframe name="iframe-assetDownload" class="hidden"></iframe>
			<table id="mainList" class="table-standard">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Asset Type</th>
						<th class="hidden-xs">Brand</th>
						<th class="hidden-xs hidden-sm hidden-md">Contact</th>
						<th class="hidden-xs hidden-sm hidden-md">Last Update</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<section id="templates" class="hidden">
	<table>
		<tr id="template-mainList-row">
			<td colName="index"></td>
			<td colName="1"><span colName="title">-</span></td>
			<td colName="2"><span colName="asset_type">-</span></td>
			<td colName="3" class="hidden-xs"><span colName="brand">-</span></td>
			<td colName="4" class="hidden-xs hidden-sm hidden-md"><span colName="unilever_contact">-</span></td>
			<td colName="5" class="hidden-xs hidden-sm hidden-md"><span colName="modified_date">-</span></td>
			<td class="td-center">
				<button class="btn-blue" name="btn-download"><i class="fa fa-download"></i> <span class="hidden-xs">Download</span></button> 
			</td>
			<td class="td-center">
				<button name="btn-detail">Detail</button>
				<button name="btn-delete">Delete</button>
			</td>
		</tr>
	</table>
</section>


<!-- JS -->
<script type="text/javascript" src="_lib/pages/profile/profile_get.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/login/login.css">


