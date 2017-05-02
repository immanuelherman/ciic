
<div class="page-wrapper">
	<div class="page-container">
		<div class="page-header">
			<div class="div_bigtitle">User List</div>
		</div>
		<div class="page-content">
			<div class="div_alert hidden" style="margin-bottom:5px;"></div>
			<div class="page-content-main">
				<div class="page-content-topBar">
					<button name="btn-add" class="btn-green"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
					<button name="btn-import" disabled><i class="fa fa-upload" aria-hidden="true"></i> Import(CSV)</button>
				</div>
				<table id="mainList" class="table-standard">
					<thead>
						<tr>
							<th>#</th>
							<th>Full Name</th>
							<th class="hidden-xs">Email</th>
							<th class="hidden-xs hidden-sm hidden">Phone</th>
							<th class="hidden-xs hidden-sm">Department</th>
							<th class="hidden-xs hidden-sm hidden-md">Job Title</th>
							<th class="hidden-xs hidden-sm hidden-md">Last Login</th>
							<th class="hidden-xs">Role</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<section id="templates" class="hidden">
	<table>
		<tr id="template-mainList-row">
			<td colName="index"></td>
			<td colName="1"></td>
			<td colName="2" class="hidden-xs"></td>
			<td colName="3" class="hidden-xs hidden-sm hidden"></td>
			<td colName="4" class="hidden-xs hidden-sm"></td>
			<td colName="5" class="hidden-xs hidden-sm hidden-md"></td>
			<td colName="6" class="hidden-xs hidden-sm hidden-md"></td>
			<td colName="7" class="hidden-xs"></td>
			<td colName="8"></td>
			<td class="td-center">
				<button name="btn-edit">Edit</button> 
				<button name="btn-delete">Delete</button>
			</td>
		</tr>
	</table>
</section>

<!-- JS -->
<script type="text/javascript" src="_lib/pages/user/user_get.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/login/login.css">


