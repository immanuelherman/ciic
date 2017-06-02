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
							<div class="subtitle">Username (Email)</div>
							<input class="register_input" type="text" name="email" id="email" placeholder="user@mail.com"></input>
						</div>
						<div>
							<div class="subtitle">First Name</div>
							<input class="register_input" type="text" name="firstname" id="firstname" placeholder="first name"></input>
						</div>
						<div>
							<div class="subtitle">Last Name</div>
							<input class="register_input" type="text" name="lastname" id="lastname" placeholder="last name"></input>
						</div>
						<div>
							<div class="subtitle">Department</div>
							<input class="register_input" type="text" name="department" id="department" placeholder="department"></input>
						</div>
						<div>
							<div class="subtitle">Job Title</div>
							<input class="register_input" type="text" name="jobtitle" id="jobtitle" placeholder="title"></input>
						</div>
						<div>
							<div class="subtitle">Phone</div>
							<input class="register_input" type="number" name="phone" id="phone" placeholder="658881234"></input>
						</div>
						<div>
							<div class="subtitle">Country</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
						
						
						<div class="submissionResult div_alert hidden" style="margin-bottom:10px;"></div>
						<div class="submissionBar">
							<button name="btn-save">Update Profile</button>
							<button name="btn-reset">Reset</button>
						</div>
						
					</div>
					
					<div class="col-sm-4 col-md-4">
						
						
						<div>
							<div class="subtitle">Password</div>
							<input class="register_input" type="password" name="" id="" value="asdasdasd" editable="0" disabled></input>
							<div style="margin-top:5px;"><button name="btn-passwordChange" class="btn-green"><i class="fa fa-key" aria-hidden="true"></i> Change Password</button></div>
						</div>
						<div class="password-edit hidden">
							<div>
								<div class="subtitle">Current Password</div>
								<input class="register_input" type="password" name="oldpassword" id="oldpassword" placeholder="Current Password"></input>
							</div>
							<div>
								<div class="subtitle">New Password</div>
								<input class="register_input" type="password" name="password" id="password" placeholder="New Password"></input>
							</div>
							<div>
								<div class="subtitle">Confirm New Password</div>
								<input class="register_input" type="password" name="passconf" id="passconf" placeholder="Retype new password"></input>
								<div class="div_smalltext">
									<span>Your password must be a minimum length of 7 characters and contain at least one of each of the following: Number, Uppercase letter, Lowercase letter</span>
								</div>
							</div>
							<div class="passwordSubmissionResult div_alert hidden" style="margin-bottom:10px;"></div>
							<div style="margin-top:5px;">
								<button name="btn-passwordChangeExec" class="btn-green"><i class="fa fa-key" aria-hidden="true"></i> Submit</button>
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	
	<div class="page-container" style="margin-top:20px;">
		<div class="page-header">
			<div class="headerRightFloat">
				<button name="btn-add" class="btn-green"><i class="fa fa-upload" aria-hidden="true"></i></button>
			</div>
			<div class="div_bigtitle">My Assets</span></div>
		</div>
		<div class="page-content">
			<div class="alertAsset div_alert hidden" style="margin-bottom:10px;"></div>
			<div class="page-content-topBar">
				<button name="btn-deleteSelected" class="" disabled><i class="fa fa-times" aria-hidden="true"></i> Delete Selected</button>
				<div class="deleteResult div_alert hidden" style="margin-top:5px;"></div>
			</div>
			<iframe name="iframe-assetDownload" class="hidden"></iframe>
			<table id="mainList" class="table-standard">
				<thead>
					<tr>
						<th colName="selection-all" class="clickable td-center" style="text-align:center;" width="24px"><i name="icon-selection" class="fa fa-square-o"></i></th>
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
			<td colName="selection" class="clickable td-center" width="24px"><i name="icon-selection" class="fa fa-square-o"></i></td>
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


