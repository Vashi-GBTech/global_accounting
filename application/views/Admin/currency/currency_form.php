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
								<input type="hidden" id="update_id" name="update_id">
								<label>Subsidiary Account</label>
								<select class="form-control" name="branch_id" id="branch_id" data-valid="required" data-msg="Select Branch">
								</select>
							</div>
							<div class="form-group my-0 py-0">
								<label>Country</label>
								<select class="form-control" name="country" onchange="getCurrencyfromCountry()" id="country" data-valid="required" data-msg="Select Branch">
								</select>
							</div>
							<div class="form-group my-0 py-0">
								<label>Currency</label>
								<input type="text" class="form-control" name="currency" id="currency"
									   data-valid="required" data-msg="Enter Type">
							</div>
							<div class="form-group my-0 py-0">
								<label>Conversion Rate in Rupees</label>
								<input type="text" class="form-control" name="convertRate" id="convertRate"
									   data-valid="required" data-msg="Enter Type">
							</div>
							<div class="form-group my-0 py-0">
								<label>Year</label>
								<select class="form-control" name="year" id="year" data-valid="required" data-msg="Select Branch">
									<option selected disabled></option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
								</select>
							</div>
							<div class="form-group my-0 py-0">
								<label>Month</label>
								<select class="form-control" name="quarter" id="quarter" data-valid="required" data-msg="Select Branch">
									<option selected disabled></option>
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

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4" type="submit" >Submit</button>
					<button class="btn btn-secondary roundCornerBtn4" type="reset">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
