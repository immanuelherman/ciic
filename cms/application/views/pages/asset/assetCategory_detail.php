<div class="page-wrapper">
	<div class="page-container">
		<div class="page-header">
			<div name="containerEdit" class="container-floatRight hidden">
				<button name="btn-edit" class="btn-green"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Asset</button>
			</div>
			<div class="div_bigtitle">Asset Detail</span></div> 
		</div>
	
	
		<div class="page-content">
			<a name="link-back" href="<?php echo($navigation);?>" target="_self"><i class="fa fa-angle-left"></i> Back</a>
			<div class="div_alert hidden" style="margin-bottom:5px;"></div>
			<div class="assetCategoryDetail">
				<input type="hidden" name="id" value="<?php echo($id);?>" disabled />
				
				<div class="row">
					<div class="col-sm-12">
						<div class="thumbnailContainer" class="col-sm-12 col-md-12"></div>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				
				<div class="row">
					<div class="col-sm-6 col-md-5 col-lg-5">
						<table style="width:100%;">
							<tr><td class="asset-param"><span>Title</span></td><td class="asset-value"><span name="title">-</span></td></tr>
							<tr><td class="asset-param"><span>Organizer</span></td><td class="asset-value"><span name="organizer">-</span></td></tr>
							<tr><td class="asset-param"><span>Objective</span></td><td class="asset-value"><span name="objective">-</span></td></tr>
							<tr><td class="asset-param"><span>Background</span></td><td class="asset-value"><span name="background">-</span></td></tr>
						</table>
					</div>
					<div class="col-sm-6 col-md-5 col-lg-5">
						<table style="width:100%;">
							<tr><td class="asset-param"><span>Overview</span></td><td class="asset-value"><span name="overview">-</span></td></tr>
							<tr><td class="asset-param"><span>Outcome</span></td><td class="asset-value"><span name="outcome">-</span></td></tr>
							<tr><td class="asset-param"><span>Repeatable</span></td><td class="asset-value"><span name="repeatable_model">-</span></td></tr>
							<tr><td class="asset-param"><span>Comments</span></td><td class="asset-value"><span name="additional_comment">-</span></td></tr>
						</table>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				
				<div class="row">
					<div class="col-sm-6 col-md-5 col-lg-5">
						<table style="width:100%;">
							<tr><td class="asset-param"><span>Project Type</span></td><td class="asset-value"><span name="project_type">-</span></td></tr>
							<tr><td class="asset-param"><span>Brand</span></td><td class="asset-value"><span name="brand">-</span></td></tr>
							<tr><td class="asset-param"><span>Developer</span></td><td class="asset-value"><span name="developer">-</span></td></tr>
							<tr><td class="asset-param"><span>Asset Type</span></td><td class="asset-value"><span name="asset_type">-</span></td></tr>
							<tr><td class="asset-param"><span>Country</span></td><td class="asset-value"><span name="country">-</span></td></tr>
							<tr><td class="asset-param"><span>Channel</span></td><td class="asset-value"><span name="channel">-</span></td></tr>
							<tr><td class="asset-param"><span>Audience</span></td><td class="asset-value"><span name="audience">-</span></td></tr>
							<tr><td class="asset-param"><span>Category</span></td><td class="asset-value"><span name="category">-</span></td></tr>
							<tr><td class="asset-param"><span>Original Store</span></td><td class="asset-value"><span name="original_store">-</span></td></tr>
						</table>
					</div>
					<div class="col-sm-6 col-md-5 col-lg-5">
						<table style="width:100%;">
							<tr><td class="asset-param"><span>Contact</span></td><td class="asset-value"><span name="unilever_contact">-</span></td></tr>
							<tr><td class="asset-param"><span>Objective</span></td><td class="asset-value"><span name="objective">-</span></td></tr>
							<tr><td class="asset-param"><span>Status</span></td><td class="asset-value"><span name="status">-</span></td></tr>
							<tr><td class="asset-param"><span>Owner</span></td><td class="asset-value"><span name="owner">-</span></td></tr>
							<tr><td class="asset-param"><span>Privacy</span></td><td class="asset-value"><span name="privacy_status">-</span></td></tr>
							<tr><td class="asset-param"><span>Workspace</span></td><td class="asset-value"><span name="workspace">-</span></td></tr>
							<tr><td class="asset-param"><span>Project Filesize</span></td><td class="asset-value"><span name="filesize">-</span></td></tr>
							</table>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="subtitle" style="margin-bottom:10px;">Asset Files</div>
						<iframe class="hidden" name="assetFilesIframe"></iframe>
						<table id="mainList" class="table-standard">
							<thead>
								<tr>
									<th>#</th>
									<th>Filename</th>
									<th class="hidden-md">Type</th>
									<th class="hidden-xs" style="text-align:center;">Size (KB)</th>
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
	</div>
	
</div>


<section id="templates" class="hidden">
	<table>
		<tr id="template-mainList-row">
			<td colName="index"></td>
			<td colName="1"></td>
			<td colName="2" class="hidden-xs hidden-sm hidden-md"></td>
			<td colName="3" class="hidden-xs" style="text-align:center;"></td>
			<td class="td-center">
				<button name="btn-assetDownload">Download</button>
			</td>
		</tr>
	</table>
</section>

<!-- JS -->
<script>
	var asset_type = "<?php echo($navigation);?>";
</script>
<script type="text/javascript" src="_lib/pages/asset/assetCategory_detail.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/asset/assetCategory.css">


