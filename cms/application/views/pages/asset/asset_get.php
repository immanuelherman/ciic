
<div class="page-wrapper">
	<div class="page-container">
		<div class="page-header">
			<div class="div_bigtitle"><?php echo($page_title);?> List</div>
		</div>
		<div class="page-content">
			<div class="div_alert hidden" style="margin-bottom:5px;"></div>
			<div class="page-content-main">
				<div class="page-content-topBar">
					<button name="btn-add" class="btn-green"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
				</div>
				<table id="mainList" class="table-standard">
					<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th class="hidden-xs">Asset Type</th>
							<th class="hidden-xs hidden-sm">Brand</th>
							<th class="hidden-xs hidden-sm">Category</th>
							<th class="hidden-xs hidden-sm hidden-md">Unilever Contact</th>
							<th class="hidden-xs hidden-sm hidden-md">Status</th>
							<th class="hidden-xs">Owner</th>
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
			<td colName="3" class="hidden-xs hidden-sm"></td>
			<td colName="4" class="hidden-xs hidden-sm"></td>
			<td colName="5" class="hidden-xs hidden-sm hidden-md"></td>
			<td colName="6" class="hidden-xs hidden-sm hidden-md"></td>
			<td colName="7" class="hidden-xs hidden-sm hidden-md"></td>
			<td class="td-center">
				<button name="btn-edit">Edit</button> 
				<button name="btn-delete">Delete</button>
			</td>
		</tr>
	</table>
</section>

<!-- JS -->
<script type="text/javascript" src="_lib/pages/asset/asset_get.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/login/login.css">


