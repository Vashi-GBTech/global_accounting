<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-company"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Company Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="uploadCompany" method="post" data-form-valid="saveCompany">
				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<div class="form-group my-0 py-0">
								<label>Name</label>
								<input type="hidden" name="update_id" id="update_id">
								<input type="text" class="form-control" name="company_name" id="company_name"
									   data-valid="required" data-msg="Enter Company name">
							</div>
							<div class="form-group my-0 py-0">
								<label>Email</label>
								<input type="text" class="form-control" name="mail_id" id="mail_id"
									   data-valid="required" data-msg="Enter Type">
							</div>
							<div class="form-group my-0 py-0">
								<label>Type</label>
								<input type="text" class="form-control" name="type" id="type"
									   data-valid="required" data-msg="Enter Type">
							</div>

							<div class="form-group my-0 py-0">
								<label>Start Month of Financial Year</label>
								<select class="form-control" name="month" id="month" data-valid="required" data-msg="Enter Type">
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
							</div>

							<div class="row">
								<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
									<div class="form-group my-0 py-0">
										<label>Country</label>
										<select class="form-control" onchange="getCurrencyCountry();" name="country" id="country">
										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
									<div class="form-group my-0 py-0">
										<label>Currency</label>
										<input type="text" readonly class="form-control" name="currency" id="currency"
											   data-valid="required" data-msg="Enter Type">
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4" type="button" onclick="CreateCompany()">Submit</button>
					<button class="btn btn-secondary roundCornerBtn4" type="reset">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
