
<div class="page-wrapper">
	<div class="page-container">
		<div class="page-header">
			<div style="clear:both; float:right;">
				<button name="btn-add" class="btn-green"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
			</div>
			<div class="div_bigtitle"><?php echo($page_title);?></div>
		</div>
		
		<div class="page-filter">
			<div class="row">
				<div class="col-xs-6 col-sm-3 col-tight">
					<select name="brand">
						<option>Brand</option>
					</select>
				</div>
				<div class="col-xs-6 col-sm-3 col-tight">
					<select name="country">
						<option>Country</option>
					</select>
				</div>
				<div class="col-xs-6 col-sm-3 col-tight">
					<select name="type">
						<option>Type</option>
					</select>
				</div>
				<div class="col-xs-6 col-sm-3 col-tight">
					<select name="category">
						<option>Category</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="page-content">
			<div class="div_alert hidden" style="margin-bottom:5px;"></div>
			<div class="page-content-main">
				<table id="mainList" class="table-standard assetCategory">
					<thead class="hidden">
						<tr>
							<th>Asset</th>
						</tr>
					</thead>
					<tbody>
						<tr id="template-mainList-row">
							<td colName="1" style="width:100%;">
								<div class="row assetCategory-content">
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-tight">
										<div class="asset-thumbnail"><img src="_lib/images/asset_img_sample.jpg"></div>
									</div>
									<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
										<div class="row asset-title">
											<div class="col-sm-12 col-tight">Metro-China-Laundry-00</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-md-5 col-tight">
												<table style="width:100%;">
													<tr><td class="asset-param">Location</td><td name="val-1" class="asset-value">China</td></tr>
													<tr><td class="asset-param">Brand</td><td name="val-2" class="asset-value">CLEAR</td></tr>
													<tr><td class="asset-param">Asset Type</td><td name="val-3" class="asset-value">Aisle</td></tr>
													<tr><td class="asset-param">Original Store</td><td name="val-4" class="asset-value">Metro</td></tr>
												</table>
											</div>
											<div class="col-sm-6 col-md-5 col-tight">
												<table style="width:100%;">
													<tr><td class="asset-param">Audience</td><td name="val-1" class="asset-value">Internal</td></tr>
													<tr><td class="asset-param">Customer</td><td name="val-2" class="asset-value">-</td></tr>
													<tr><td class="asset-param">Unilever Contact</td><td name="val-3" class="asset-value">Emma Morgan</td></tr>
													<tr><td class="asset-param">Owner</td><td name="val-4" class="asset-value">Unilever</td></tr>
												</table>
											</div>
											<div class="col-md-2 col-tight" style="padding-top:10px; text-align:center;">
												<button name="btn-download" class="btn-green">Download</button>
												<button name="btn-edit" class="btn-blue">Edit</button>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						
						<tr id="template-mainList-row">
							<td colName="1" style="width:100%;">
								<div class="row assetCategory-content">
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-tight">
										<div class="asset-thumbnail"><img src="_lib/images/asset_img_sample_2.jpg"></div>
									</div>
									<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
										<div class="row asset-title">
											<div class="col-sm-12 col-tight">1650-PK-Metro-Islamabad</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-md-5 col-tight">
												<table style="width:100%;">
													<tr><td class="asset-param">Location</td><td name="val-1" class="asset-value">Pakistan</td></tr>
													<tr><td class="asset-param">Brand</td><td name="val-2" class="asset-value">-</td></tr>
													<tr><td class="asset-param">Asset Type</td><td name="val-3" class="asset-value">POSM</td></tr>
													<tr><td class="asset-param">Original Store</td><td name="val-4" class="asset-value">-</td></tr>
												</table>
											</div>
											<div class="col-sm-6 col-md-5 col-tight">
												<table style="width:100%;">
													<tr><td class="asset-param">Audience</td><td name="val-1" class="asset-value">Internal</td></tr>
													<tr><td class="asset-param">Customer</td><td name="val-2" class="asset-value">-</td></tr>
													<tr><td class="asset-param">Unilever Contact</td><td name="val-3" class="asset-value">Monique</td></tr>
													<tr><td class="asset-param">Owner</td><td name="val-4" class="asset-value">Unilever</td></tr>
												</table>
											</div>
											<div class="col-md-2 col-tight" style="padding-top:10px; text-align:center;">
												<button name="btn-download" class="btn-green">Download</button>
												<button name="btn-edit" class="btn-blue">Edit</button>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<section id="templates" class="hidden">
	<table>
		
	</table>
</section>

<!-- JS -->
<script type="text/javascript" src="_lib/pages/asset/assetCategory_get.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/asset/assetCategory.css">


