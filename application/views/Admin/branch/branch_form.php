
<style>
	.switch {
		position: relative;
		display: inline-block;
		width: 45px;
		height: 15px;
	}

	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0px;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: red;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		border: 1px solid;
		content: "";
		height: 20px;
		width: 20px;
		left: 1px;
		bottom: -3px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: green;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px green;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(23px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}

	.check_toggle {
		display: flex;
		justify-content: left;
	}

	.nav-tabs > li.active > a {
		color: black;
		background-color: #f7e3ad;
	}

	.nav-tabs > li.active > a {
		background-color: #f2d1767a !important;
		color: #473504 !important;
		text-shadow: 0px 1px 2px #00000055 !important;
	}

	.nav-tabs > li {
		border-radius: 6px;
		border-right: 1px solid #80808029;
	}

	.nav-item {
		width: 150px;
		text-align: center;
	}
</style>
<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-company"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Subsidiary Accounts Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="uploadBranch" method="post" data-form-valid="saveCompany" >
				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<?php if($this->session->userdata('user_type')==1){?>
									<div class="form-group my-0 py-0">
										<label>Select Company</label>
										<select class="form-control" required="" name="dcompany_id" id="dcompany_id" tabindex="1"
												data-valid="required"
												data-msg="Select Company name"
												required autofocus>
										</select>
									</div>
									<?php } else{ ?>
										<div class="form-group my-0 py-0">
											<input type="hidden" class="form-control" name="dcompany_id" id="dcompany_id" value="<?php echo $company_id; ?>">
										</div>
									<?php }?>
									<div class="form-group my-0 py-0">
										<label>Name</label>
										<input type="hidden" name="update_id" id="update_id">
										<input type="text" class="form-control" name="branch_name" required=""id="branch_name" data-valid="required"   data-msg="Enter Branch name">
									</div>
									<div class="form-group my-0 py-0">
										<label>Country</label>
										<select type="text" class="form-control"  name="country" onchange="getCurrencyCountry();" required="" id="country" data-valid="required"   data-msg="Enter Country name"></select>
									</div>
									<div class="form-group my-0 py-0">
										<label>Currency</label>
										<input type="text" class="form-control"  required="" name="currency" id="currency" data-valid="required"   data-msg="Enter Currency name">
									</div>
									<div class="form-group my-0 py-0">
										<label>Default Currency Rate</label>
										<input type="number" class="form-control" required="" name="default_currency_rate" id="default_currency_rate" data-valid="required"   data-msg="Enter Default Currency Rate">
									</div>
									<div class="form-group my-0 py-0">
										<label>Is Special Subsidiary</label>
										<select class="form-control" name="isSpecialSub" id="isSpecialSub" onchange="is_subsidiary(this.value)" data-valid="required" data-msg="Enter Type">
											<option value="0">No</option>
											<option value="1">Yes</option>
										</select>
									</div>
									<div class="form-group my-0 py-0" id="transferTypeDiv"  style="display: none">
										<label>Transfer Type</label>
										<select class="form-control" name="transferType" id="transferType" data-valid="required" data-msg="Enter Type">
											<option value="">Select Transfer Company</option>
											<option value="2">Inter Company Transfer</option>
											<option value="1">Intra Company Transfer</option>
										</select>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<?php if($this->session->userdata('user_type')!=1){?>
									<div class="form-group my-0 py-0">
										
									</div>
									<?php } ?>
									<div class="form-group my-0 py-0">
										<label>Type</label>
										<select class="form-control" required="" id="type" name="type">
											<option selected disabled value="">Select Type</option>
											<option value="parent">Parent</option>
											<option value="subsidiary">Subsidiary</option>
											<option value="associate">Associate</option>
										</select>
									</div>
									<div class="form-group my-0 py-0">
										<label>Percentage of Share Holder</label>
										<input type="number" class="form-control" name="percentage" id="percentage" required=""   data-msg="Enter Percentage">
									</div>
									<div class="form-group my-0 py-0">
										<label>Subsidiary Account ID</label>
										<input type="text" class="form-control" name="branch_user_id" id="branch_user_id"   data-msg="Enter Branch ID">
									</div>
									<div class="form-group my-0 py-0">
										<label>Start Month of Financial Year</label>
										<select class="form-control" name="month" id="month" data-valid="required" data-msg="Enter Type">
											<option value="1">January</option>
											<option value="2">February</option>
											<option value="3">March</option>
											<option value="4" >April</option>
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
									<div class="form-group my-0 py-0" required="">
										<label>Status</label>
										<!-- <select class="form-control" id="status" name="status">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select> -->
										<span class="check_toggle">
											<h5 class="m-t-0">Inactive</h5>
											<label class="switch" style="margin:0px 20px;">
												<input id="type0" type="checkbox" checked>
												<span class="slider round"></span>
											</label>
											<h5 class="m-t-0">Active</h5>
										</span>
										<input type="hidden" id="status" name="status" value="0">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<?php if( $this->session->userdata('user_access_type')==1){ ?>
					<button class="btn btn-primary mr-1 roundCornerBtn4" type="submit" >Submit</button>
					<?php } ?>
					<button class="btn btn-secondary roundCornerBtn4" type="reset">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#type0").change(function () {
			if ($(this).prop("checked") == true) {
				$('#status').val(1);
			} else {
				$('#status').val(0);
			}
		});
	});
	function is_subsidiary(id) {
		if(id == 1){
			$("#transferTypeDiv").show();
		}else{
			$("#transferTypeDiv").hide();
		}
	}
</script>
