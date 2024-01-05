<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-users"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">User Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="uploadUsers" method="post" data-form-valid="saveUsers">
				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<div class="form-group my-0 py-0">
								<label>Name</label>
								<input type="hidden" name="update_id" id="update_id">
								<input type="text" class="form-control" name="user_name" id="user_name"
									   data-valid="required" data-msg="Enter Company name">
							</div>
							<div class="form-group my-0 py-0">
								<label>Email</label>
								<input type="text" class="form-control" name="mail_id" id="mail_id"
									   data-valid="required" data-msg="Enter Correct Email">
							</div>
							<div class="form-group my-0 py-0">
								<label>Company</label>
								<select class="form-control" name="company_id" id="company_id" data-valid="required" data-msg="Select Company">
								</select>
							</div>
							<div class="form-group my-0 py-0">
								<label>User Access Type</label>
								<select class="form-control" name="userType" id="userType" data-valid="required" data-msg="Select User Type">
									<option value="1">Admin User</option>
									<option value="2">Normal User</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4" type="button" onclick="CreateUser()">Submit</button>
					<button class="btn btn-secondary roundCornerBtn4" type="reset">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-permissions"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">User Permissions</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="uploadUserspermission" method="post" data-form-valid="saveUsersPermission">

				<input type="hidden" name="userIdPermission" id="userIdPermission">
				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<div class="form-group my-0 py-0">
								<label>Subisidiary Account</label>
								<select class="form-control" name="branch_id[]" multiple id="branch_id" data-valid="required" data-msg="Select Company">
								</select>
							</div>
						</div>
					</div>
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<div id="permissionDiv"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4" type="button" onclick="saveUsersPermission()">Submit</button>
					<button class="btn btn-secondary roundCornerBtn4" type="reset">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
