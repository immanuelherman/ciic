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
							<div class="subtitle">Asset Type</div>
							<select class="register_input" type="text" name="assetType" id="assetType" disabled>
								<option value="posm">POSM</option>
								<option value="product">Product</option>
								<option value="store">Store</option>
								<option value="executable">Executable</option>
							</select>
						</div>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Asset Thumbnail</div>
							<input type="file" accept="image/*" name="assetThumbnail" id="assetThumbnail" multiple></input>
						</div>
					</div>
				</div>
				<div class="assetThumbnailList hidden">
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-6 col-lg-6" >
							<div class="div_smalltext"><span>Note: Uploading new thumbnail with overwrite the current</span></div>
							<div class="assetContent thumbnailContainer" style="border:solid 1px #ccc; padding:10px;">
							</div>
						</div>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Asset File (.zip)</div>
							<input type="file" accept=".zip" name="assetFile" id="assetFile"></input>
						</div>
					</div>
				</div>
				<div class="assetFilesList hidden">
					<div class="row">
						<div class="col-sm-12 col-md-8 col-lg-6" >
							<div class="div_smalltext"><span>Note: Uploading new asset file (.zip) will overwrite old files</span></div>
							<iframe class="hidden" name="assetFilesIframe"></iframe>
							<div class="assetContent" style="border:solid 1px #ccc; padding:10px;">
								<table id="mainList" class="table-standard">
									<thead>
										<tr>
											<th>#</th>
											<th>Filename</th>
											<th class="hidden-md">Type</th>
											<th class="hidden-xs">Size (KB)</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<button class="btn-blue" name="btn-downloadAll"><i class="fa fa-download"></i> Download All (zip)</button>
						</div>
					</div>
				</div>
				
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Title</div>
							<input class="register_input" type="text" name="title" id="title" placeholder="Title"></input>
						</div>
						<div>
							<div class="subtitle">Organizer</div>
							<input class="register_input" type="text" name="organizer" id="organizer" placeholder="Organizer"></input>
						</div>
						<div>
							<div class="subtitle">Objective</div>
							<input class="register_input" type="text" name="objective" id="objective" placeholder="Objective"></input>
						</div>
						<div>
							<div class="subtitle">Background</div>
							<textarea class="register_input" type="text" name="background" id="background" placeholder="Background"></textarea>
						</div>
					</div>
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Content</div>
							<input class="register_input" type="text" name="content" id="content" placeholder="Content"></input>
						</div>
						<div>
							<div class="subtitle">Outcome</div>
							<input class="register_input" type="text" name="outcome" id="outcome" placeholder="Outcome"></input>
						</div>
						<div>
							<div class="subtitle">Repeatable Model</div>
							<input class="register_input" type="text" name="repeatable_model" id="repeatable_model" placeholder="Yes / No"></input>
						</div>
						<div>
							<div class="subtitle">Additional Comment</div>
							<textarea class="register_input" type="text" name="additional_comment" id="additional_comment" placeholder="Additional Comment"></textarea>
						</div>
					</div>
				</div>
				
				<div style="border-top:solid 1px #ddd; margin-top:10px; padding-top:10px;"></div>
				
				<div class="row">
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Project Type</div>
							<input class="register_input" type="number" name="phone" id="phone" placeholder="658881234"></input>
						</div>
						<div>
							<div class="subtitle">Brand</div>
							<input class="register_input" type="text" name="brand" id="brand" placeholder="Brand"></input>
						</div>
						<div>
							<div class="subtitle">Developer Contact</div>
							<input class="register_input" type="text" name="contact" id="contact" placeholder="Contact"></input>
						</div>
						<div>
							<div class="subtitle">Country</div>
							<input class="register_input" type="text" name="country" id="country" placeholder="Country"></input>
						</div>	
						<div>
							<div class="subtitle">Channel</div>
							<input class="register_input" type="text" name="channel" id="channel" placeholder="Channel"></input>
						</div>
					</div>
					
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Audience</div>
							<input class="register_input" type="text" name="audience" id="audience" placeholder="Audience"></input>
						</div>
						<div>
							<div class="subtitle">Category</div>
							<input class="register_input" type="text" name="category" id="category" placeholder="Category"></input>
						</div>	
						<div>
							<div class="subtitle">Original Store</div>
							<input class="register_input" type="text" name="original_store" id="original_store" placeholder="Original Store"></input>
						</div>
						<div>
							<div class="subtitle">Unilever Contact</div>
							<input class="register_input" type="text" name="unilever_contact" id="unilever_contact" placeholder="Unilever Contact"></input>
						</div>	
						<div>
							<div class="subtitle">Key Objective</div>
							<input class="register_input" type="text" name="key_objective" id="key_objective" placeholder="Key Objective"></input>
						</div>
					</div>
					
					<div class="col-sm-4 col-md-3">
						<div>
							<div class="subtitle">Status</div>
							<input class="register_input" type="text" name="status" id="status" placeholder="Status"></input>
						</div>
						<div>
							<div class="subtitle">Owner</div>
							<input class="register_input" type="text" name="owner" id="owner" placeholder="Owner"></input>
						</div>
						<div>
							<div class="subtitle">Privacy Status</div>
							<input class="register_input" type="text" name="pivacy_status" id="pivacy_status" placeholder="Privacy Status"></input>
						</div>
						<div>
							<div class="subtitle">Workspace</div>
							<input class="register_input" type="text" name="workspace" id="workspace" placeholder="Workspace"></input>
						</div>
					</div>
				</div>
				
				
				
				
				
				<div class="div_smalltext">*Required</div>
				<div class="submissionBar">
					<div class="submissionResult div_alert hidden"></div>
					<button name="btn-create" class="hidden">Create Another Asset</button>
					<button name="btn-save">Update</button>
					<button name="btn-reset">Reset</button>
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
<script type="text/javascript" src="_lib/pages/asset/asset_detail.js"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="_lib/pages/login/login.css">


