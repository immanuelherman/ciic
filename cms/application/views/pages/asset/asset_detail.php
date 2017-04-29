<div class="page-wrapper">
	
	<div class="page-container">
		<div class="page-header">
			<div class="div_bigtitle">Asset <span name="action"><?php echo($actionType);?></span></div> 
		</div>
		
		<div class="page-content">
			<a href="asset/get" target="_self"><i class="fa fa-angle-left"></i> Back to List</a>
			<div class="div_alert hidden" style="margin-bottom:5px;"></div>
			<div class="formContent">
				<input type="hidden" name="id" value="<?php echo($id);?>" disabled />
				
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div>Asset Type</div>
							<select class="register_input" type="text" name="assetType" id="assetType" disabled>
								<option value="0">POSM</option>
								<option value="1">Product</option>
								<option value="2">Store</option>
								<option value="3">Executable</option>
							</select>
						</div>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div>Thumbnail</div>
							<input type="file" accept="image/*" name="assetThumbnail" id="assetThumbnail" multiple></input>
						</div>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div>Title</div>
							<input class="register_input" type="text" name="title" id="title" placeholder="Title"></input>
						</div>
						<div>
							<div>Organizer</div>
							<input class="register_input" type="text" name="organizer" id="organizer" placeholder="Organizer"></input>
						</div>
						<div>
							<div>Objective</div>
							<input class="register_input" type="text" name="objective" id="objective" placeholder="Objective"></input>
						</div>
						<div>
							<div>Background</div>
							<textarea class="register_input" type="text" name="background" id="background" placeholder="Background"></textarea>
						</div>
					</div>
					<div class="col-sm-4 col-md-3">
						<div>
							<div>Content</div>
							<input class="register_input" type="text" name="content" id="content" placeholder="Content"></input>
						</div>
						<div>
							<div>Outcome</div>
							<input class="register_input" type="text" name="outcome" id="outcome" placeholder="Outcome"></input>
						</div>
						<div>
							<div>Repeatable Model</div>
							<input class="register_input" type="text" name="repeatableModel" id="repeatableModel" placeholder="Yes / No"></input>
						</div>
						<div>
							<div>Additional Comment</div>
							<textarea class="register_input" type="text" name="additionalComment" id="additionalComment" placeholder="Additional Comment"></textarea>
						</div>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div>Project Type</div>
							<input class="register_input" type="number" name="phone" id="phone" placeholder="658881234"></input>
						</div>
						<div>
							<div>Brand</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
						<div>
							<div>Developer Contact</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
						<div>
							<div>Country</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>	
						<div>
							<div>Channel</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
					</div>
					
					<div class="col-sm-4 col-md-3">
						<div>
							<div>Audience</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
						<div>
							<div>Category</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>	
						<div>
							<div>Original Store</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
						<div>
							<div>Unilever Contact</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>	
						<div>
							<div>Key Objective</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
					</div>
					
					<div class="col-sm-4 col-md-3">
						<div>
							<div>Status</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
						<div>
							<div>Owner</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
						<div>
							<div>Privacy Status</div>
							<input class="register_input" type="text" name="country" id="country"></input>
						</div>
						<div>
							<div>Workspace</div>
							<input class="register_input" type="text" name="country" id="country"></input>
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
	
	
	
	<div class="page-container" style="margin:10px 0px;">
		<div class="page-header">
			<div class="div_bigtitle">Asset Files</span></div> 
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-sm-4 col-md-3">
					<input type="file" accept=".zip" name="assetFile" id="assetFile"></input>
					<div style="margin-top:5px;"></div>
					<div class="uploadResult div_alert hidden"></div>
					<button name="btn-fileUpload">Upload</button>
				</div>
			</div>
			<div class="assetFilesList hidden">
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding:10px 0px;"></div>
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<table id="mainList" class="table-standard">
							<thead>
								<tr>
									<th>#</th>
									<th>Filename</th>
									<th class="hidden-md">Location</th>
									<th class="hidden-xs">Size (KB)</th>
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
				<button name="btn-download">Download</button>
				<button name="btn-delete">Delete</button>
			</td>
		</tr>
	</table>
</section>
	
<!-- JS -->
<script type="text/javascript" src="_lib/pages/asset/asset_detail.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/login/login.css">


