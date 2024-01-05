<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.card-box {
		border-bottom: none !important;
	}

	.top_button {
		float: right;
		margin-bottom: 10px;
	}

	.nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
		border-bottom-color: #fff;
		background-color: #f7e3ad;
		color: black;
		text-shadow: 0px 4px 5px #00000055 !important;
	}

	.toggle {
		float: right;
	}

	.toggle.btn {
		min-width: 140px !important;
	}

	.btn-success {
		background-color: #2db457 !important;
		border-color: #2db457 !important;
	}

	.handsontable .group_validate {
		background-color: red !important;
	}

	.handsontable .group_valid {
		background-color: white !important;
	}

</style>

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
		background-color: green;
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
		background-color: #2196F3;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
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
		justify-content: end;
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

<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Main Account Setup</h4>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row bg-white">
		<input type="hidden" name="mainSetupType" id="mainSetupType" value="BS">

		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
					<li class="nav-item match active" role="presentation">
						<a data-toggle="tab" href="#AS" class="nav-link active" role="tab"
						   aria-selected="true" aria-expanded="true" onclick="openIndiaAS()">INDIAN AS</a>
					</li>
<!--					<li class="nav-item unmatch" role="presentation">-->
<!--						<a data-toggle="tab" href="#US" class="nav-link" role="tab"-->
<!--						   aria-selected="false" aria-expanded="false" onclick="openUS()">US GAAP</a>-->
<!--					</li>-->
<!--					<li class="nav-item unmatch" role="presentation">-->
<!--						<a data-toggle="tab" href="#IFRS" class="nav-link" role="tab"-->
<!--						   aria-selected="false" aria-expanded="false" onclick="openIfrs()">IFRS</a>-->
<!--					</li>-->
				</ul>

				<div class="tab-content" style="padding:0;">
					<div class="tab-pane active" id="AS">
						<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
							<li class="nav-item active" role="presentation">
								<a data-toggle="tab" href="#AS_account" class="nav-link active" role="tab"
								   aria-selected="true" aria-expanded="true" onclick="openInd_account()">Accounts</a>
							</li>
							<li class="nav-item" role="presentation">
								<a data-toggle="tab" href="#as_group" class="nav-link" role="tab"
								   aria-selected="false" aria-expanded="false" onclick="openInd_group()">Grouping</a>
							</li>
							<li class="nav-item" role="presentation">
								<a data-toggle="tab" href="#as_scheduling" class="nav-link" role="tab"
								   aria-selected="false" aria-expanded="false" onclick="open_schedule(1,'ind_schedule')">Scheduling</a>
							</li>
						</ul>

						<div class="tab-content">

							<div class="tab-pane active" id="AS_account">
								<div class="form-group" style="padding-right: 20px">
									<button class="btn btn-primary excelbtn xs_btn roundCornerBtn5"
											style="float: left;margin: -10px 0 0 25px;"
											onclick="show_upload(1)"><i
												class="fa fa-plus"></i></button>

									<button class="btn btn-primary excelbtn xs_btn roundCornerBtn5"
											style="float: left;margin: -10px 0 0 25px;"
											onclick="showIndMapping(1)">Mapping
									</button>

									<span class="check_toggle">
									<h5 class="m-t-0">Profit & Loss</h5>
									<label class="switch" style="margin:0px 20px;">
										<input id="type0" type="checkbox" checked>
										<span class="slider round"></span>
									</label>
									<h5 class="m-t-0">Balance Sheet</h5>
									</span>
								</div>
								<div class="tab-content" style="padding:0;" id="as_data">
									<div id="matched" class="tab-pane active">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																onclick="saveExcelData()">
															Save <i class="fa fa-save"></i></button>
													</div>
													<div class="col-md-12" id="example"></div>
												</div>
											</div>
										</div>
									</div>
									<div id="unmatched" class="tab-pane">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																onclick="saveExcelData()" >
															Save <i class="fa fa-save"></i></button>
													</div>
													<div class="col-md-12" id="examplePl"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="as_group">
								<div class="form-group" style="padding-right: 20px">
									<span class="check_toggle">
									<h5 class="m-t-0">Profit & Loss</h5>
								<label class="switch" style="margin:0px 20px;">
									<input id="ind_grouping" type="checkbox" checked>
									<span class="slider round"></span>
								</label>
									<h5 class="m-t-0">Balance Sheet</h5>
									</span>
								</div>
								<div class="tab-content" style="padding:0;" id="as_data">
									<div id="ind_bs_grp" class="tab-pane active">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																style="float: right"
																onclick="SaveIndGroup(1)">Save
														</button>
													</div>
													<div class="col-md-12" id="ind_group"></div>
												</div>
											</div>
										</div>
									</div>
									<div id="ind_pl_grp" class="tab-pane">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																style="float: right"
																onclick="SaveIndGroup(2)">Save
														</button>
													</div>
													<div class="col-md-12" id="ind_pl_grouping"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="as_scheduling">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div class="col-md-12">
												<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
														style="float: right"
														onclick="saveIndSchedule(1,'ind_schedule')">Save
												</button>
											</div>
											<div class="col-md-12" id="ind_schedule"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="US">
						<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
							<li class="nav-item active" role="presentation">
								<a data-toggle="tab" href="#US_account" class="nav-link active" role="tab"
								   aria-selected="true" aria-expanded="true" onclick="openUS_account()">Accounts</a>
							</li>
							<li class="nav-item" role="presentation">
								<a data-toggle="tab" href="#us_group" class="nav-link" role="tab"
								   aria-selected="false" aria-expanded="false" onclick="openUS_group()">Grouping</a>
							</li>
							<li class="nav-item" role="presentation">
								<a data-toggle="tab" href="#us_scheduling" class="nav-link" role="tab"
								   aria-selected="false" aria-expanded="false" onclick="open_schedule(2,'us_schedule')">Scheduling</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="US_account">
								<div class="form-group" style="padding-right: 20px">
									<button class="btn btn-primary excelbtn xs_btn roundCornerBtn5"
											style="float: left;margin: -10px 0 0 25px;"
											onclick="show_upload(2)"><i
												class="fa fa-plus"></i></button>

									<button class="btn btn-primary excelbtn xs_btn roundCornerBtn5"
											style="float: left;margin: -10px 0 0 25px;"
											onclick="showIndMapping(2)">Mapping
									</button>


									<span class="check_toggle">
									<h5 class="m-t-0">Profit & Loss</h5>
								<label class="switch" style="margin:0px 20px;">
									<input id="UStype0" type="checkbox" checked>
									<span class="slider round"></span>
								</label>
									<h5 class="m-t-0">Balance Sheet</h5>
									</span>
								</div>
								<div class="tab-content" style="padding:0;" id="us_tab">
									<div id="us_matched" class="tab-pane active">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button  roundCornerBtn4 filterBtn"
																onclick="saveUSExcelData()">
															Save <i class="fa fa-save"></i></button>
													</div>
													<div class="col-md-12" id="us_bs"></div>
												</div>
											</div>
										</div>
									</div>
									<div id="us_unmatched" class="tab-pane">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button  roundCornerBtn4 filterBtn"
																onclick="saveUSExcelData()">
															Save <i class="fa fa-save"></i></button>
													</div>
													<div class="col-md-12" id="us_pl"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="us_group">
								<div class="form-group" style="padding-right: 20px">
									<span class="check_toggle">
									<h5 class="m-t-0">Profit & Loss</h5>
								<label class="switch" style="margin:0px 20px;">
									<input id="us_grouping" type="checkbox" checked>
									<span class="slider round"></span>
								</label>
									<h5 class="m-t-0">Balance Sheet</h5>
									</span>
								</div>
								<div class="tab-content" style="padding:0;">
									<div id="us_bs_grp" class="tab-pane active">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																style="float: right"
																onclick="SaveUSGroup(1)">Save
														</button>
													</div>
													<div class="col-md-12" id="us_bs_grouping"></div>
												</div>
											</div>
										</div>
									</div>
									<div id="us_pl_grp" class="tab-pane">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																style="float: right"
																onclick="SaveUSGroup(2)">Save
														</button>
													</div>
													<div class="col-md-12" id="us_pl_grouping"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="us_scheduling">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div class="col-md-12">
												<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
														style="float: right"
														onclick="saveIndSchedule(2,'us_schedule')">Save
												</button>
											</div>
											<div class="col-md-12" id="us_schedule"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="IFRS">

						<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
							<li class="nav-item active" role="presentation">
								<a data-toggle="tab" href="#IFRS_account" class="nav-link active" role="tab"
								   aria-selected="true" aria-expanded="true" onclick="openIfrs_account()">Accounts</a>
							</li>
							<li class="nav-item" role="presentation">
								<a data-toggle="tab" href="#ifrs_group" class="nav-link" role="tab"
								   aria-selected="false" aria-expanded="false" onclick="openIfrs_group()">Grouping</a>
							</li>
							<li class="nav-item" role="presentation">
								<a data-toggle="tab" href="#ifrs_scheduling" class="nav-link" role="tab"
								   aria-selected="false" aria-expanded="false" onclick="open_schedule(3,'ifrs_schedule')">Scheduling</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="IFRS_account">
								<div class="form-group" style="padding-right: 20px">
									<button class="btn btn-primary excelbtn xs_btn roundCornerBtn5"
											style="float: left;margin: -10px 0 0 25px;"
											onclick="show_upload(3)"><i
												class="fa fa-plus"></i></button>

									<button class="btn btn-primary excelbtn xs_btn roundCornerBtn5"
											style="float: left;margin: -10px 0 0 25px;"
											onclick="showIndMapping(3)">Mapping
									</button>

									<span class="check_toggle">
									<h5 class="m-t-0">Profit & Loss</h5>
								<label class="switch" style="margin:0px 20px;">
									<input id="IFtype0" type="checkbox" checked>
									<span class="slider round"></span>
								</label>
									<h5 class="m-t-0">Balance Sheet</h5>

									</span>
								</div>
								<div class="tab-content" style="padding:0;" id="ifrs_tab">
									<div id="ifrs_matched" class="tab-pane active">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																onclick="saveIFRSExcelData()">
															Save <i class="fa fa-save"></i></button>
													</div>
													<div class="col-md-12" id="ifrs_bs"></div>
												</div>
											</div>
										</div>
									</div>
									<div id="ifrs_unmatched" class="tab-pane">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																onclick="saveIFRSExcelData()">
															Save <i class="fa fa-save"></i></button>
													</div>
													<div class="col-md-12" id="ifrs_pl"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="ifrs_group">
								<div class="form-group" style="padding-right: 20px">
									<span class="check_toggle">
									<h5 class="m-t-0">Profit & Loss</h5>
								<label class="switch" style="margin:0px 20px;">
									<input id="ifrs_grouping" type="checkbox" checked>
									<span class="slider round"></span>
								</label>
									<h5 class="m-t-0">Balance Sheet</h5>
									</span>
								</div>
								<div class="tab-content" style="padding:0;">
									<div id="ifrs_bs_grp" class="tab-pane active">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																style="float: right"
																onclick="SaveIfrsGroup(1)">Save
														</button>
													</div>
													<div class="col-md-12" id="ifrs_bs_grouping"></div>
												</div>
											</div>
										</div>
									</div>
									<div id="ifrs_pl_grp" class="tab-pane">
										<div class="row">
											<div class="col-lg-12">
												<div class="card-box" style="border: none">
													<div class="col-md-12">
														<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
																style="float: right"
																onclick="SaveIfrsGroup(2)">Save
														</button>
													</div>
													<div class="col-md-12" id="ifrs_pl_grouping"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="ifrs_scheduling">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div class="col-md-12">
												<button class="btn btn-primary top_button roundCornerBtn4 filterBtn"
														style="float: right"
														onclick="saveIndSchedule(3,'ifrs_schedule')">Save
												</button>
											</div>
											<div class="col-md-12" id="ifrs_schedule"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="Upload" style="display: none">
					<div class="tab-content" style="padding:0;">
						<div class="row m-t-50" id="MainData">
							<div class="col-lg-12 m-t-10">
								<div class="card-box">
									<form method="post" id="main_excel" enctype="multipart/form-data">
										<input type="hidden" name="unmatchStatus" id="unmatchStatus" value="0">
										<div class="row">
											<div class="col-md-12">
												<div><label id="upload_label"></label>
													<hr>
												</div>
												<input type="hidden" class="form-control" name="main_type"
													   id="main_type">
												<input type="hidden" class="form-control" name="main_type0"
													   id="main_type0">
												<div class="col-md-2">
													<input type="file" name="userfile" id="userfile"
														   class="form_control" style="display: none;">
													<label for="userfile" style="margin-top:10px;"> <i
																class="fa fa-upload uploadLable"></i> Upload</label>
												</div>
												<div class="col-md-4">
													<button type="submit" class="btn btn-primary roundCornerBtn4">Save
													</button>
												</div>
											</div>
											<div class="col-md-12" id="validateDiv"></div>
											<div class="col-md-12">
												<input type="hidden" name="count" id="count" class="form_control"
													   value="0">
												<button type="button" class="btn btn-primary roundCornerBtn4"
														id="saveExcelColumnsBtn" onclick="saveExcelColumns()"
														style="display: none;float: right; margin-top: 10px;">Save
												</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
						<div class="row"
							 style="margin-top: -10px;background-color: white;padding: 10px 30px 10px 30px">
							<div class="col-md-12" id="errorDiv">

							</div>
							<div class="col-md-12" id="tableDiv" style="height: 500px;overflow: auto"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
<?php
$this->load->view("Admin/main_account/main_setup_form");
$this->load->view('_partials/footer'); ?>
<script src="<?php echo base_url(); ?>assets/js/module/MainSetup/main_setup.js"></script>
<script>var base_url = '<?=base_url();?>'</script>
<script>
	$("ul.nav-tabs a").click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$('#Upload').hide();
		$('#as_data').show();
		$('#us_data').show();
		$('#ifrs_data').show();
		$('.check_toggle').show();
		$('.excelbtn').find("i").addClass('fa-plus');
		$('.excelbtn').find("i").removeClass('fa-home');
	});

	$("#type0").change(function () {
		if ($(this).prop("checked") == true) {
			$('#matched').addClass('active');
			$('#unmatched').removeClass('active');
			$('.nav-tabs a[href="#matched"]').tab('show');
			getMainSetupType('BS');
			getDataMainBalanceSheet();
		} else {
			$('#unmatched').addClass('active');
			$('#matched').removeClass('active');
			$('.nav-tabs a[href="#unmatched"]').tab('show');
			getMainSetupType('PL');
			getDataMainProfitLoss();
		}
	});

	$("#ind_grouping").change(function () {
		if ($(this).prop("checked") == true) {
			$('#ind_bs_grp').addClass('active');
			$('#ind_pl_grp').removeClass('active');
			$('.nav-tabs a[href="#ind_bs_grp"]').tab('show');
			getIndiaGroupBS(1);
		} else {
			$('#ind_pl_grp').addClass('active');
			$('#ind_bs_grp').removeClass('active');
			$('.nav-tabs a[href="#ind_pl_grp"]').tab('show');
			getIndiaGroupPL(2);
		}
	});

	$("#us_grouping").change(function () {
		if ($(this).prop("checked") == true) {
			$('#us_bs_grp').addClass('active');
			$('#us_pl_grp').removeClass('active');
			$('.nav-tabs a[href="#us_bs_grp"]').tab('show');
			getUSGroupBS(1);
		} else {
			$('#us_pl_grp').addClass('active');
			$('#us_bs_grp').removeClass('active');
			$('.nav-tabs a[href="#us_pl_grp"]').tab('show');
			getUSGroupPL(2);
		}
	});

	$("#UStype0").change(function () {
		if ($(this).prop("checked") == true) {
			$('#us_matched').addClass('active');
			$('#us_unmatched').removeClass('active');
			$('.nav-tabs a[href="#us_matched"]').tab('show');
			getMainSetupType('BS');
			getUSDataMainBalanceSheet();
		} else {
			$('#us_unmatched').addClass('active');
			$('#us_matched').removeClass('active');
			$('.nav-tabs a[href="#us_unmatched"]').tab('show');
			getMainSetupType('PL');
			getUSDataMainProfitLoss();
		}
	});

	$("#ifrs_grouping").change(function () {
		if ($(this).prop("checked") == true) {
			$('#ifrs_bs_grp').addClass('active');
			$('#ifrs_pl_grp').removeClass('active');
			$('.nav-tabs a[href="#ifrs_bs_grp"]').tab('show');
			getIfrsGroupBS(1);
		} else {
			$('#ifrs_pl_grp').addClass('active');
			$('#ifrs_bs_grp').removeClass('active');
			$('.nav-tabs a[href="#ifrs_pl_grp"]').tab('show');
			getIfrsGroupPL(2);
		}
	});

	$("#IFtype0").change(function () {
		if ($(this).prop("checked") == true) {
			$('#ifrs_matched').addClass('active');
			$('#ifrs_unmatched').removeClass('active');
			$('.nav-tabs a[href="#ifrs_matched"]').tab('show');
			getMainSetupType('BS');
			getIFRSDataMainBalanceSheet();
		} else {
			$('#ifrs_unmatched').addClass('active');
			$('#ifrs_matched').removeClass('active');
			$('.nav-tabs a[href="#ifrs_unmatched"]').tab('show');
			getMainSetupType('PL');
			getIFRSDataMainProfitLoss();
		}
	});

	$("#main_excel").validate({
		rules: {
			userfile: {
				required: true
			}
		},
		messages: {
			userfile: {
				required: "Please select file",
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
			$.LoadingOverlay("show");
			$("#validateDiv").html('');
			$("#saveExcelColumnsBtn").hide();
			var formData = new FormData(form);
			$.ajax({
				url: base_url + "excelupload",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status === 200) {
						$("#validateDiv").html(result.body);
						$("#saveExcelColumnsBtn").show();
						$("#count").val(result.count);
					} else {
						$("#count").val(0);
						toastr.error(result.body);
					}
				}, error: function (error) {
					$.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});

	function saveExcelColumns() {
		$.LoadingOverlay("show");
		var form_data = document.getElementById('main_excel');
		let formData = new FormData(form_data);
		app.request(base_url + "saveMainExcelColumns", formData).then(res => {
			$.LoadingOverlay("hide");
			$("#unmatchStatus").val(0);
			if (res.status == 200) {
				toastr.success(res.body);
				$("#validateDiv").html('');
				$("#errorDiv").html('');
				$("#tableDiv").html('');
				window.location.href = base_url + "MainSetup";
			} else {
				$("#validateDiv").html('');
				$("#errorDiv").html('');
				$("#tableDiv").html('');
				if (res.type == 1) {
					var template = `<div class="col-md-12">

									`;
					if (res.MandatoryData != "") {
						template += `
										<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
						                         ${res.MandatoryData}
						                      </div>
						                    </div></div>`;
					} else {
						template += `
										<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">Total Row - </b> ${res.TotalRowUpload - 1}</div>
 												<div class="alert-title">Duplicate - </b> ${res.duplicate_msg}</div>
 												<div class="alert-title">Main GL Existence - </b> ${res.duplicate_main}</div>
						                      </div>
						                    </div></div>`;
						if (res.NoText != "") {
							template += `
											<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">At this Position Only <b>Numeric Value</b> allowed</div>
							                         ${res.NoText}
							                      </div>
							                    </div></div>`;

						} else if (res.GroupUnmatch != "") {
							template += `
											<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">At this Position Given <b>Group Id</b> Does not Exists in Database</div>
							                         ${res.GroupUnmatch}
							                      </div>
							                    </div></div>`;

						} else if (res.UmatchedData != "") {
							$("#excel-modal-company").modal('show');
							$("#unmatch").html(`
											<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-film"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">There Was an <b>${res.UmatchedData} Unmatch/ ${res.TotalRowUpload - 1} Total Row </b> data Do you want to proceed </div>
							                      </div>
							                    </div></div>`);
						}
					}


					template += `

								</div>`;
					$("#errorDiv").html(template);
					$("#tableDiv").html(res.table);
				} else {
					$.LoadingOverlay("hide");
					toastr.error(res.body);
				}
			}

		});
		$.LoadingOverlay("hide");
	}

	function show_upload(type) {

		if ($('.excelbtn').find("i").hasClass('fa-plus')) {
			$('.excelbtn').find("i").removeClass('fa-plus');
			$('.excelbtn').find("i").addClass('fa-home');
		} else {
			$('.excelbtn').find("i").addClass('fa-plus');
			$('.excelbtn').find("i").removeClass('fa-home');
		}

		$('#main_type').val('');
		$('#main_type0').val('');
		if (type == 1) {
			$('#main_type').val(1);
			$(this).find('i').toggleClass('fa-plus fa-home');
			if ($('#type0').prop("checked") == true) {
				$('#main_type0').val('BS');
			} else {
				$('#main_type0').val('PL');
			}

			if ($('#Upload').css('display') == 'none') {
				$('#upload_label').html('');
				$('#upload_label').html('Upload File for India AS');
				$('#Upload').show();
				$('#as_data').hide();
				$('.check_toggle').hide();
			} else {
				$('#Upload').hide();
				$('#as_data').show();
				$('.check_toggle').show();
			}
		} else if (type == 2) {
			$('#main_type').val(2);

			if ($('#UStype0').prop("checked") == true) {
				$('#main_type0').val('BS');
			} else {
				$('#main_type0').val('PL');
			}

			if ($('#Upload').css('display') == 'none') {
				$('#upload_label').html('');
				$('#upload_label').html('Upload File for US GAAP');
				$('#Upload').show();
				$('#us_tab').hide();
				$('.check_toggle').hide();
			} else {
				$('#Upload').hide();
				$('#us_tab').show();
				$('.check_toggle').show();
			}
		} else {
			$('#main_type').val(3);

			if ($('#IFtype0').prop("checked") == true) {
				$('#main_type0').val('BS');
			} else {
				$('#main_type0').val('PL');
			}


			if ($('#Upload').css('display') == 'none') {
				$('#upload_label').html('');
				$('#upload_label').html('Upload File for IFRS');
				$('#Upload').show();
				$('#ifrs_tab').hide();
				$('.check_toggle').hide();
			} else {
				$('#Upload').hide();
				$('#ifrs_tab').show();
				$('.check_toggle').show();
			}
		}
	}


	function openIndiaAS() {
		$('.nav-tabs a[href="#AS_account"]').tab('show');
		getDataMainBalanceSheet();
		openInd_account();
	}

	function openUS() {
		$('.nav-tabs a[href="#US_account"]').tab('show');
		getUSDataMainBalanceSheet();
		openUS_account();
	}

	function openIfrs() {
		$('.nav-tabs a[href="#IFRS_account"]').tab('show');
		getIFRSDataMainBalanceSheet();
		openIfrs_account();
	}

	function openInd_account() {
		$("#type0").prop("checked", true);
		$('#matched').addClass('active');
		$('#unmatched').removeClass('active');
		$('.nav-tabs a[href="#matched"]').tab('show');

		$('#Upload').hide();
		$('#as_tab').show();
		$('.check_toggle').show();
		getMainSetupType('BS');
		getDataMainBalanceSheet();
	}

	function openInd_group() {
		$("#ind_grouping").prop("checked", true);
		$('#ind_bs_grp').addClass('active');
		$('#ind_pl_grp').removeClass('active');
		$('.nav-tabs a[href="#ind_bs_grp"]').tab('show');
		getMainSetupType('BS');
		getIndiaGroupBS(1);

	}

	function openUS_account() {
		$("#UStype0").prop("checked", true);
		$('#us_matched').addClass('active');
		$('#us_unmatched').removeClass('active');
		$('.nav-tabs a[href="#us_matched"]').tab('show');

		$('#Upload').hide();
		$('#us_tab').show();
		$('.check_toggle').show();
		getMainSetupType('BS');
		getUSDataMainBalanceSheet();
	}

	function openUS_group() {
		$("#us_grouping").prop("checked", true);
		$('#us_bs_grp').addClass('active');
		$('#us_pl_grp').removeClass('active');
		$('.nav-tabs a[href="#us_bs_grp"]').tab('show');
		getMainSetupType('BS');
		getUSGroupBS(1);
	}

	function openIfrs_account() {
		$("#IFtype0").prop("checked", true);
		$('#ifrs_matched').addClass('active');
		$('#ifrs_unmatched').removeClass('active');
		$('.nav-tabs a[href="#ifrs_matched"]').tab('show');

		$('#Upload').hide();
		$('#ifrs_tab').show();
		$('.check_toggle').show();
		getMainSetupType('BS');
		getIFRSDataMainBalanceSheet();
	}

	function openIfrs_group() {
		$("#ifrs_grouping").prop("checked", true);
		$('#ifrs_bs_grp').addClass('active');
		$('#ifrs_pl_grp').removeClass('active');
		$('.nav-tabs a[href="#ifrs_bs_grp"]').tab('show');
		getMainSetupType('BS');
		getIfrsGroupBS(1);
	}

	function showIndMapping(id) {
		window.location.href = base_url + "MainMapping?id=" + id;
	}
	function open_schedule(type,divId) {
		getDataMainScheduleAccount(type,divId);
	}
</script>
</div>
