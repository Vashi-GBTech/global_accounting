<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-main_setup"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Main Setup Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="uploadMainSetup" method="post" data-form-valid="saveMainSetup">
				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<div class="form-group my-0 py-0">
								<label>Name</label>
								<input type="hidden" name="update_id" id="update_id">
								<input type="text" class="form-control" name="main_name" id="main_name"
									   data-valid="required" data-msg="Enter name">
							</div>
							<div class="form-group my-0 py-0">
								<label>GL Account no</label>
								<input type="text" class="form-control" name="gl_no" id="gl_no"
									   data-valid="required" data-msg="Enter GL Account No">
							</div>

							<div class="form-group my-0 py-0">
								<label>Calculation Method</label>
								<select class="form-control" name="calculation_method" id="calculation_method"
										data-valid="required" data-msg="Enter GL Account No">
									<option selected disabled></option>
									<option value="Addition">Addition</option>
									<option value="Calculated">Calculated</option>
									<option value="Parent">Parent</option>
									<option value="Ignore">Ignore</option>
								</select>
							</div>

							<div class="form-group my-0 py-0">
								<label>Type 1</label>
								<input type="text" class="form-control" name="type1" id="type1"
									   data-valid="required" data-msg="Enter Type">
							</div>
							<div class="form-group my-0 py-0">
								<label>Type 2</label>
								<input type="text" class="form-control" name="type2" id="type2"
									   data-valid="required" data-msg="Enter Type">
							</div>
							<div class="form-group my-0 py-0">
								<label>Type 3</label>
								<input type="text" class="form-control" name="type3" id="type3"
									   data-valid="required" data-msg="Enter Type">
							</div>

							<div class="form-group my-0 py-0">
								<label>Sequence No</label>
								<input type="text" class="form-control" name="sequence_number" id="sequence_number"
									   data-valid="required" data-msg="Enter Sequence No">
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4" type="button" onclick="CreateMainSetup()">Submit</button>
					<button class="btn btn-secondary roundCornerBtn4" type="reset">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
