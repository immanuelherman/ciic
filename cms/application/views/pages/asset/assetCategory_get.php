
<div class="page-wrapper">
	<div class="page-container">
		<div class="page-header">
			<div class="headerRightFloat">
				<button name="btn-add" class="btn-green"><i class="fa fa-upload" aria-hidden="true"></i></button>
			</div>
			<div class="div_bigtitle"><?php echo($page_title);?></div>
		</div>
		
		<div class="page-filter">
			<div class="row">
				<div class="col-xs-6 col-sm-3 col-tight">
					<table class="filter-selecttable">
						<tr>
							<td><span>Brand</span></td>
							<td>
								<select name="brand">
									<option value="0">All</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				
				<div class="col-xs-6 col-sm-3 col-tight">
					<table class="filter-selecttable">
						<tr>
							<td><span>Country</span></td>
							<td>
								<select name="country">
									<option value="0">All</option>
									<option value="china">China</option>
									<option value="singapore">Singapore</option>
									<option value="united kingdom">United Kingdom</option>
									<option value="united states">United States</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="col-xs-6 col-sm-3 col-tight">
					<table class="filter-selecttable">
						<tr>
							<td><span>Type</span></td>
							<td>
								<select name="type">
									<option value="0">All</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="col-xs-6 col-sm-3 col-tight">
					<table class="filter-selecttable">
						<tr>
							<td><span>Category</span></td>
							<td>
								<select name="category">
									<option value="0">All</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div class="page-content">
			<div class="div_alert hidden" style="margin-bottom:5px;"></div>
			<div class="page-content-main">
				<iframe name="iframe-assetDownload" class="hidden"></iframe>
				
				<div class="displayStyleContainer">
					<button name="displayStyle"><i class="fa fa-th"></i></button>
				</div>
				
				<div id="mainList_card" class="row mainList_card"></div>
				
				<table id="mainList" class="table-standard assetCategory hidden">
					<thead class="hidden">
						<tr>
							<th>Asset</th>
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
	
	<div id="template-mainList_card-item" class="mainList_card-item col-xs-6 col-sm-4 col-md-3 col-lg-3 col-tight">
		<div class="mainList_card-item-content">
			<div class="mainList_card-image">
				<table>
					<tr><td valign="middle"><img width="24px" src="_lib/images/giphy.gif"></img></td></tr>
				</table>
			</div>
			<div class="mainList_card-item-content-text">
				<div class="mainList_card-title"><a><span colName="title"></span></a></div>
				<div class="mainList_card-detail">
					<table width="100%">
						<tr>
							<td class="mainList_card-content"><i class="fa fa-map-marker"></i> <span colName="country">-</span></td>
							<td class="mainList_card-content"><i class="fa fa-star-o"></i> <span colName="brand">-</span></td>
						</tr>
						<tr>
							<td class="mainList_card-content"><i class="fa fa-tag"></i> <span colName="asset_type">-</span></td>
							<td class="mainList_card-content"><i class="fa fa-user"></i> <span colName="unilever_contact">-</span></td>
						</tr>
					</table>
				</div>
				<div style="text-align:left; margin-top:7px;">
					<button name="btn-download" class="btn-blue"><i class="fa fa-download"></i></button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- -->
	<table>
		<tr id="template-mainList-row" class="assetCategory-tr">
			<td colName="1" style="width:100%;">
				<div class="row assetCategory-content">
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-tight">
						<div class="asset-thumbnail fotorama" data-auto="false" data-width="100%"><img src="_lib/images/no_image.png"></div>
					</div>
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 assetListContainer">
						<div class="row asset-title">
							<div class="col-sm-12 col-tight"><span colName="title"></span></div>
						</div>
						<div class="row">
							<div class="col-sm-6 col-md-5 col-lg-3 col-tight">
								<table style="width:100%;">
									<tr><td class="asset-param">Location</td><td name="val-1" class="asset-value"><span colName="country">-</span></td></tr>
									<tr><td class="asset-param">Brand</td><td name="val-2" class="asset-value"><span colName="brand">-</span></td></tr>
									<tr><td class="asset-param">Type</td><td name="val-3" class="asset-value"><span colName="asset_type">-</span></td></tr>
								</table>
							</div>
							<div class="hidden-xs col-sm-6 col-md-5 col-lg-3 col-tight">
								<table style="width:100%;">
									<tr><td class="asset-param">Store</td><td name="val-4" class="asset-value"><span colName="original_store">-</span></td></tr>
									<tr><td class="asset-param">Audience</td><td name="val-1" class="asset-value"><span colName="audience">-</span></td></tr>
									<tr><td class="asset-param">Customer</td><td name="val-2" class="asset-value"><span colName="customer">-</span></td></tr>
								</table>
							</div>
							<div class="hidden-sm hidden-md col-sm-6 col-md-5 col-lg-3 col-tight">
								<table style="width:100%;">
									<tr><td class="asset-param">Contact</td><td name="val-3" class="asset-value"><span colName="unilever_contact">-</span></td></tr>
									<tr><td class="asset-param">Owner</td><td name="val-4" class="asset-value"><span colName="owner">-</span></td></tr>
								</table>
							</div>
							<div class="col-md-2 col-lg-3 col-tight" style="text-align:center;">
								<button name="btn-download" class="btn-blue"><i class="fa fa-download"></i> Download</button>
								<button name="btn-detail" class="">Detail</button>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</section>

<!-- JS -->
<script>
	var asset_type = "<?php echo($asset_type);?>";
</script>
<script type="text/javascript" src="_lib/pages/asset/assetCategory_get.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/asset/assetCategory.css">


