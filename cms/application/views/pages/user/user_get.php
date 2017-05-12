
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
					<!--<button name="btn-import" disabled><i class="fa fa-upload" aria-hidden="true"></i> Import(CSV)</button>-->
					<button name="btn-deleteSelected" class="" disabled><i class="fa fa-times" aria-hidden="true"></i> Delete Selected</button>
					<div class="deleteResult div_alert hidden"></div>
				</div>
				<table id="mainList" class="table-standard">
					<thead>
						<tr>
							<th colName="selection-all" class="clickable td-center" style="text-align:center;" width="24px"><i name="icon-selection" class="fa fa-square-o"></i></th>
							<th>#</th>
							<th>Full Name</th>
							<th class="hidden-xs">Email</th>
							<th class="hidden-xs hidden-sm hidden">Phone</th>
							<th class="hidden-xs hidden-sm">Department</th>
							<th class="hidden-xs hidden-sm hidden-md">Job Title</th>
							<th class="hidden-xs hidden-sm hidden-md hidden">Last Login</th>
							<th class="hidden-xs">Role</th>
							<th>Status</th>
							<th width="120px;"></th>
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
			<td colName="selection" class="clickable td-center" width="24px"><i name="icon-selection" class="fa fa-square-o"></i></td>
			<td colName="index" width="32px"></td>
			<td colName="1"></td>
			<td colName="2" class="hidden-xs"></td>
			<td colName="3" class="hidden-xs hidden-sm hidden"></td>
			<td colName="4" class="hidden-xs hidden-sm"></td>
			<td colName="5" class="hidden-xs hidden-sm hidden-md"></td>
			<td colName="6" class="hidden-xs hidden-sm hidden-md hidden"></td>
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


