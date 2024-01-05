<?php
$this->load->view('_partials/header');
?>

<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
	#template_detail_div{
		list-style:none;
	}
	#template_detail_div li{
		background-color: #f2f4f6;
		margin-bottom: 2px;
		padding: 2px 12px;
	}
	/*header stylesheet*/
	#myDropdown
	{
		width: 523px!important;
	}
	#side-padding{
		padding-left: 0!important;
	}
	.app-theme-white.fixed-header .app-header__logo {
		background: none !important;
	}

	::-webkit-scrollbar {
		height: 20px !important;
		background-color: #f5f4f4 !important;
		width: 6px !important;
		overflow: visible !important;
		display: block !important;

	}

	::-webkit-scrollbar-thumb {
		-webkit-border-radius: 10px;
		border-radius: 10px;
		background: gray !important;
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
	}
	.nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
		border-bottom-color: #fff;
		background-color: #f7e3ad;
		color: black;
		text-shadow: 0px 4px 5px #00000055 !important;
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
		border: 1px solid #80808029;
	}
	.nav-tabs > li >a {
		margin-right: 0px;
	}

	.nav-item {
		width: auto;
		text-align: center;
	}
</style>

<script>
	$(function () {
		$(window).resize(function () {
			if (window.matchMedia("(max-width: 768px)").matches) {
				window.location.replace("<?= base_url('templatetool'); ?>");
			} else {


			}
		});
		if (window.matchMedia("(max-width: 768px)").matches) {

			window.location.replace("<?= base_url('templatetool'); ?>");
		} else {

		}
	});
</script>
<!-- <body onclick="closeNav()">-->
<div class="content-page">
	<div class="content">
		<div class="">
			<input type="hidden" id="company_id" value="<?php echo $this->session->userdata('company_id'); ?>">

			<div class="">
				<div class="">
					<div class="page-title-box">
						<h4 class="page-title">Scheduled Templates</h4>
						<div class="" style="float: right">
<!--							<button class="btn btn-info" id="AllBranches1" style="" type="button" onclick="downlodAllbranch()">Download for all branch(Transaction)</button>-->
<!--							<button class="btn btn-info" id="AllBranches1" style="" type="button" onclick="OpenModal()">Download for all branch(Rupees Conversion)</button>-->
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<div class="card-header ">
							<div class="row m-b-10">
<!--								<div class="col-md-6">-->
<!--									<label for="">-->
<!--										Download for all Subsidiary(Transaction)-->
<!--									</label>-->
<!--									<button class="btn btn-info" id="AllBranches1" style="" type="button" onclick="downlodAllbranch(1)"><i class="fa fa-download"></i> PDF</button>-->
<!--									<button class="btn btn-info" id="AllBranches1" style="" type="button" onclick="downlodAllbranchExcel(1)"><i class="fa fa-download"></i> EXCEL</button>-->
<!--									<hr/>-->
<!--								</div>-->
								<div class="col-md-6">
									<label for="">
										Download for all Subsidiary(Rupees Conversion)
									</label>
									<button class="btn btn-info" id="AllBranches1" style="" type="button" onclick="OpenModal()"><i class="fa fa-download"></i></button>
<!--									<button class="btn btn-info" id="AllBranches1" style="" type="button" onclick="downlodAllbranchRupees(1)"><i class="fa fa-download"></i>  PDF</button>-->
<!--									<button class="btn btn-info" id="AllBranches1" style="" type="button" onclick="downlodAllbranchExcel(2)"><i class="fa fa-download"></i>  EXCEL</button>-->
									<hr/>
								</div>

							</div>
							<div class="row">

								<div class="col-md-4">

									<select id="branch_id" name="branch_id" class="form-control" onchange="getDownloadButtons()">
										<option value="" selected disabled>Select Subsidiary Account</option>
									</select>
								</div>
								<div class="col-md-2">
									<select name="year" id="year" class="form-control year">
										<option disabled="" selected="" value="">select year</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
										<option value="2023">2023</option>
										<option value="2024">2024</option>
										<option value="2025">2025</option>
										<option value="2026">2026</option>
										<option value="2027">2027</option>
										<option value="2028">2028</option>
										<option value="2029">2029</option>
										<option value="2030">2030</option>
									</select>
								</div>
								<div class="col-md-2">
									<select name="month" id="month" class="form-control month">
										<option disabled="" selected="" value="">select month</option>
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
<!--								<div class="col-md-2">-->
<!--									<select name="valuesIn" id="valuesIn" class="form-control">-->
<!--										<option disabled="" selected="" value="1">Select Values In</option>-->
<!--										<option value="1">Thousand</option>-->
<!--										<option value="2">Lakhs</option>-->
<!--										<option value="4">Millions</option>-->
<!--										<option value="3">Crores</option>-->
<!--									</select>-->
<!--								</div>-->

							<div class="col-md-4">
								<button class="btn btn-primary" type="button" onclick="getTableList();">Show</button>
								<button class="btn btn-primary" id="transactionBtn" type="button" onclick="downlodAllbranch(2)" style="display: none;"><i class="fa fa-download"></i> Transaction</button>
								<button class="btn btn-primary" id="rupeesConversionBtn" type="button" onclick="downlodAllbranchRupees(2)" style="display: none;"><i class="fa fa-download"></i> Rupees Conversion</button>
							</div>

							</div>
							<ul class="nav nav-tabs m-b-20 m-t-10" id="scheduleTab" role="tablist">
								
							</ul>
						</div>

						<div class="card">
							<div class="row">
								<div class="col-lg-12">
									<div class="card-box">


										<div  id="schedulePanel" style="padding:0;display: none;">


											<input type="hidden" id="spreadsheetTemplateId">
											<input type="hidden" id="spreadsheetTemplateValueSignIn" value="0">

											<div id="" class="to-bottom m-t-10" style="height:100%;">
												<ul class="nav nav-tabs m-b-20 m-t-10" id="TransTabUl" role="tablist">
													<li class="nav-item match active transTab" role="presentation" id="transTabid">
														<a data-toggle="tab" href="#OgTab" class="nav-link active "  role="tab" aria-selected="true" aria-expanded="true" onclick="fetch_template_handson()">Transaction</a>
													</li>
													<li class="nav-item match  transTab" role="presentation" id="">
														<a data-toggle="tab" href="#CurTab" class="nav-link " role="tab" aria-selected="false" aria-expanded="false" onclick="getCurrencyData();">Currency Rate</a>
													</li>
													<li class="nav-item match  transTab" role="presentation" id="">
														<a data-toggle="tab" href="#RupCon" class="nav-link " role="tab" aria-selected="false" aria-expanded="false" onclick="getRupeesData()">Rupees Conversion</a>
													</li>
													<li class="nav-item match  transTab" role="presentation" id="">
														<a data-toggle="tab" href="#GlMapp" class="nav-link " role="tab" aria-selected="false" aria-expanded="false" onclick="getGlAccountMappingData()">Gl Account Mapping</a>
													</li>
													<li class="nav-item match  transTab" role="presentation" id="">
														<a data-toggle="tab" href="#SubMapp" class="nav-link " role="tab" aria-selected="false" aria-expanded="false" onclick="getSubsidiaryAccountMappingData()">Schedule Account Mapping</a>
													</li>
												</ul>

												<div class="tab-content" style="padding:0;">
												<div id="OgTab" class="tab-pane active">
													<div class="row">
														<div class="col-md-12">
															<!--<button class="btn btn-primary" style="" type="button" >Check</button>-->
															<button type="button" class="btn btn-primary filterBtn" id="spreadSheetBtn" onclick="saveSpreadSheetTool1()"
																	style="margin-left: auto;    margin-right: 10px;display:none;"  >Save
															</button>
															<button type="button" class="btn btn-danger" id="ClearAllButton" onclick="ClearTemplateTransactionData()"
																	style="margin-left: auto;    margin-right: 10px;display:none;float: right;">Refresh Transaction data</button>
															<button type="button" class="btn btn-danger" id="ClearTrancationButton" onclick="ClearTemplateData()"
																	style="margin-left: auto;    margin-right: 10px;display:none;float: right;">Refresh All data</button>

															<button id="excelDownload" type="button" class="btn btn-link" style="margin-left: auto;    margin-right: 10px;display:none;">
																<i
																		class="fa fa-download" style="font-size: 18px"></i></button>
														</div>
													</div><br>
													<div class="row">
														<div class="col-lg-12">
																<div id="spreadSheetDiv" style="height:100%!important;overflow: auto;"></div>
														</div>
													</div>
												</div>
													<div id="CurTab" class="tab-pane "> 
														<div class="row">
															<div class="col-md-12">
																<button type="button" class="btn btn-primary filterBtn" id="CurencySheetBtn" onclick="saveCurrencyConversion()"
																		style="margin-left: auto;    margin-right: 10px;"  >Save
																</button>

																<button type="button" class="btn btn-danger" id="CurrencyClearAllButton" onclick="ClearTemplateCurrencyRateData()"
																		style="margin-left: auto;    margin-right: 10px;display:none;float: right;">Refresh Currency Rate data</button>
																<button id="excelDownload" type="button" class="btn btn-link" style="margin-left: auto;    margin-right: 10px;display:none;">
																	<i class="fa fa-download" style="font-size: 18px"></i></button>
															</div>
														</div><br>
														<div class="row">
															<div class="col-lg-12">
																<div id="CurrencyDiv" style="height:100%!important;overflow: auto;"></div>
															</div>
														</div>
													</div>
													<div id="RupCon" class="tab-pane ">
														<div class="row">
															<div class="col-md-12">
																<button type="button" class="btn btn-primary filterBtn" id="RupeesSheetBtn" onclick="saveRupeesData(1)"
																		style="margin-left: auto;    margin-right: 10px;"  >Save
																</button>


																<button id="excelDownload" type="button" class="btn btn-link" style="margin-left: auto;    margin-right: 10px;display:none;">
																	<i class="fa fa-download" style="font-size: 18px"></i></button>

<!--																<b>(Transaction + Currency Rate) + Additional GL</b>-->
															</div>
														</div><br>
														<div class="row">
															<div class="col-lg-12">
																<div id="RupeesDiv" style="height:100%!important;overflow: auto;"></div>
															</div>

														</div>
													</div>
													<div id="GlMapp" class="tab-pane ">
														<div class="row">
															<div class="col-md-12">
																<button type="button" class="btn btn-primary filterBtn" id="GlMappSheetBtn" onclick="saveGlMappData()" style="margin-left: auto;    margin-right: 10px;"  >Save
																</button>
																<button id="excelDownloadGlMapp" type="button" class="btn btn-link" style="margin-left: auto;    margin-right: 10px;display:none;">
																	<i class="fa fa-download" style="font-size: 18px"></i></button>
															</div>
														</div><br>
														<div class="row">
															<div class="col-lg-12">
																<div id="GlMappDiv" style="height:100%!important;overflow: auto;"></div>
															</div>
														</div>
													</div>
													<div id="SubMapp" class="tab-pane">
														<div class="row">
															<div class="col-md-12">
<!--																<button type="button" class="btn btn-primary filterBtn" id="SubMappSheetBtn" onclick="saveSubMappData()" style="margin-left: auto;    margin-right: 10px;"  >Save-->
<!--																</button>-->
																<button id="excelDownloadSubMapp" type="button" class="btn btn-link" style="margin-left: auto;    margin-right: 10px;display:none;">
																	<i class="fa fa-download" style="font-size: 18px"></i></button>
															</div>
														</div><br>
														<div class="row">
															<div class="col-lg-12">
																<div id="SubMappDiv" style="height:100%!important;overflow: auto;"></div>
															</div>
														</div>
													</div>
												</div>
											</div>


										</div>


									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>



		</div>
	</div>
</div>

<!--Download All Branch Ruppes Conversion-->
<div class="modal fade" id="downLoadAllBranchData" role="dialog" aria-labelledby="ScheduleAccountMappLable" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h3>Download All Branch Data </h3>
				<h5 id="ScheduleAccountMappLable"></h5>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-2">
						<select name="allByear" id="allByear" class="form-control year" onchange="getTemplateListOFMonthYear()">
							<option disabled="" selected="" value="">select year</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
							<option value="2022">2022</option>
							<option value="2023">2023</option>
							<option value="2024">2024</option>
							<option value="2025">2025</option>
							<option value="2026">2026</option>
							<option value="2027">2027</option>
							<option value="2028">2028</option>
							<option value="2029">2029</option>
							<option value="2030">2030</option>
						</select>
					</div>
					<div class="col-md-2">
						<select name="allBmonth" id="allBmonth" class="form-control month" onchange="getTemplateListOFMonthYear()">
							<option disabled="" selected="" value="">select month</option>
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
					<div class="col-md-6">
						<select name="allBtemplates" id="allBtemplates"></select>
					</div>
					<div class="col-md-2">
						<select name="downloadvaluesIn" id="downloadvaluesIn" class="form-control">
							<option disabled="" selected="" value="1">Select Values In</option>
							<option value="1">Thousand</option>
							<option value="2">Lakhs</option>
							<option value="4">Millions</option>
							<option value="3">Crores</option>
						</select>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-primary" onclick="downlodRupeesConversionAllbranch()"><i class="fa fa-download"></i> Download</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default roundCornerBtn4" data-dismiss="modal" aria-hidden="true">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!--Download All Branch Ruppes Conversion-->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hyperformula/dist/hyperformula.full.min.js"></script>

<?php
$this->load->view('_partials/footer');
?>
<!-- <script src="<?= base_url(); ?>assets/js/custom.js" type="text/javascript"></script> -->

<script>
	$(document).ready(function () {


		getbranchList();
	});
	function getbranchList() {
		var company_id=$("#company_id").val();

		let formData = new FormData();
		formData.set('company_id', company_id);
		$.ajax({
			type: "POST",
			url: "<?= base_url("getTemplateBranchData") ?>",
			dataType: "json",
			data:formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");

				if (result.status == 200) {
					var option=`<option value="" selected disabled>Select Subsidiary Account</option>`;
					var res=result.data;
					$(res).each(function( index,data ) {
						option += `<option value="${data['id']}">${data['name']}</option>`;
					});
					$("#branch_id").html(option);
					$("#branch_id").select2();
				} else {

				}

			}
		});

	}

	function getTableList() {
		$("#scheduleTab").html('');
		var year=$("#year").val();
		var month=$("#month").val();
		if((year == "" ||year == null) || (month=="" || month == null)){
			toastr.error("Please add default year and month to proceed");
			return;
		}


		let formData = new FormData();
		formData.set('company_id', 'null');
		formData.set('year', year);
		formData.set('month', month);
		requestToAjax("getTablesList1",formData).then(res=>{
			console.log(res);
			if(res.status==200)
			{
				let tab=``;
				let panel=``;
				let cnt=1;
				res.data.map(e=>{
					let classT=``;
					let classT1=``;
					let aria=`false`;
					if(cnt==1)
					{
						classT=`active`;
						classT1=`activeShedule`;
						aria=`true`;
					}
					//onclick="fetch_template_handson()"
					tab=`<li class="nav-item match ${classT} ${classT1}" role="presentation" id="ScheduleTab${e.id}">
								<a data-toggle="tab" href="#AS" class="nav-link ${classT}" role="tab"
							   aria-selected="${aria}" aria-expanded="${aria}" onclick="editSheetModal(${e.id},${e.value_sign_in});fetch_template_handson();">${e.template_name}</a>
							</li>`;
					$("#scheduleTab").append(tab);
					if(cnt==1)
					{

						editSheetModal(e.id,e.value_sign_in);
					}
					cnt++;
				});

			}
			// $("#table_lists").DataTable({
			// 	destroy: true,
			// 	order: [],
			// 	data:res.data,
			// 	"pagingType": "simple_numbers",
			// 	columns:[
			//
			// 		{data: 0},
			// 		{data: 1},
			// 		{
			// 			data: 2,
			// 			render: (d, t, r, m) => {
			// 				return `<button type="button" onclick="editSheetModal(${d})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`
			// 			}
			// 		},
			// 	],
			// 	fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			// 		$('td:eq(2)', nRow).html(`<button type="button" onclick="editSheetModal(${aData[2]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
			// 	}
			// });
		}).
		catch((e) => {
			console.log(e);
		});
	}
	function requestToAjax(routeItem,itemObject) {
		return new Promise((resolve, reject) => {
			$.ajax({
				url: "<?= base_url() ?>"+routeItem,
				type: "POST",
				dataType: "json",
				data: itemObject,
				contentType:false,
				processData:false,
				success: function (result) {
					resolve(result);
				}, error: function (error) {
					toastr.error("Something went wrong please try again");
					reject(error);
				}
			});
		});
	}

	function editSheetModal(id,value_sign_in) {
	/*	$("#year").val('');
		$("#month").val('');*/
		$("#spreadsheetTemplateId").val('');
		$("#spreadSheetDiv").html('');
		$("#spreadSheetBtn").hide();
	//	$("#ClearAllButton").html('');
		$("#ClearAllButton").hide();
		$("#ClearTrancationButton").hide();
		$("#ClearCurrencyRateButton").hide();
		$("#excelDownload").hide();
		$("#AllBranches").hide();
		$("#spreadsheetTemplateId").val(id);
		$("#spreadsheetTemplateValueSignIn").val(value_sign_in);
		$("#schedulePanel").show();
		//activeShedule

		$( ".nav-item" ).removeClass( "activeShedule" );
		$( "#ScheduleTab"+id ).addClass( "activeShedule" );
		fetch_template_handson();

	}
	let hotDiv;
	function fetch_template_handson() {

		//getTableList();
		$( ".transTab" ).removeClass( "active" );
		$( "#transTabid").addClass( "active" );
		$( "#OgTab").addClass( "active" );
		$( "#GlMapp").addClass( "active" );
		$( "#CurTab").removeClass( "active" );
		$( "#RupCon").removeClass( "active" );
		$( "#GlMapp").removeClass( "active" );
		var temp_id= $("#spreadsheetTemplateId").val();
		var branch_id= $("#branch_id").val();
		var year= $("#year").val();
		var month= $("#month").val();
		var value_sign_in= $("#spreadsheetTemplateValueSignIn").val();
		// var valuesIn= $("#valuesIn").val();
		if((branch_id == "" || branch_id == null) || (year == "") || (month=="")){
			alert('Please Select Subsidiary Account,Year and Month!');
			return;
		}else{
			$("#spreadSheetBtn").hide();
			$("#ClearAllButton").hide();
			$("#ClearTrancationButton").hide();
			$("#excelDownload").hide();
			$("#AllBranches").hide();
			$("#spreadSheetDiv").html('');
			$("#spreadSheetDiv").show();


			$("#ClearAllButton").show();
			$("#ClearTrancationButton").show();
			$("#excelDownload").show();
			$("#AllBranches").show();
			var form_data = new FormData();
			form_data.set('temp_id', temp_id);
			form_data.set('branch_id', branch_id);
			form_data.set('month', month);
			form_data.set('year', year);
			form_data.set('value_sign_in', value_sign_in);
			// form_data.set('valuesIn', valuesIn);
			$.ajax({
				type: "POST",
				url: "<?= base_url("fetch_templatesHandonData") ?>",
				dataType: "json",
				data: form_data,
				contentType: false,
				processData: false,
				success: function (result) {
					if (result.status === 200) {
						/*if(count == 0){
							fetch_template_handson();
						}
						count++;*/

						$("#ClearAllButton").show();
						$("#ClearTrancationButton").show();
						$("#excelDownload").show();
						$("#AllBranches").show();
						// $("#handonTableModal").modal('show');
						var Secondlast=result.columnHeaders.length;
						result.columnHeaders.push("Is Opening Balance","Closing Balance Column");
						var columns = result.columnHeaders;
						var rows = [
							['', '', '', '', ''],
						];
						if (result.columnRows != "") {
							rows = result.columnRows;
							rows.push(['', '', '', '', '']);
						}
						if (columns.length < 3) {
							$("#spreadSheetBtn").hide();
							$("#spreadSheetDiv").hide();
							$("#ClearAllButton").hide();
							$("#ClearTrancationButton").hide();
							$("#excelDownload").hide();
							$("#AllBranches").hide();
						}

						var types = result.columnTypes;
						var hideArra = result.hideArra;
						var columnSummary = result.columnSummary;

						var last=(Secondlast*1)+1;
						hideArra.push(Secondlast,last);
						console.log(Secondlast);
						var hideColumn = {
							// specify columns hidden by default
							columns: hideArra,
							copyPasteEnabled: false,
						};

						var arraySource1=['Yes','No'];
						types.push({type: 'dropdown',source:arraySource1},{type: 'text'});
						var readonlyArray = result.readonlyArray;
						createHandonTable(columns, rows, types, 'spreadSheetDiv', hideColumn, readonlyArray,columnSummary);
						if(result.BlockYear == 1){
							$("#spreadSheetBtn").hide();
							$("#ClearAllButton").hide();
							$("#ClearTrancationButton").hide();
						}else{
							saveSpreadSheetTool1(1);
							$("#spreadSheetBtn").show();
							$("#ClearAllButton").show();
							$("#ClearTrancationButton").show();
						}

					} else {
						// $("#handonTableModal").modal('hide');
						// $('#tempatetoolBox').hide();
					}
				}
			});
		}

	}
	const hyperformulaInstance = HyperFormula.buildEmpty({
		// to use an external HyperFormula instance,
		// initialize it with the `'internal-use-in-handsontable'` license key
		licenseKey: 'internal-use-in-handsontable',
	});
	const button = document.querySelector('#excelDownload');
	
	function createHandonTable(columnsHeader, columnRows, columnTypes, divId, hideColumn = true, readonlyArray,columnSummary,prefillValueType=null) {
		$(".filterBtn").show();
		var element = document.getElementById(divId);
		hotDiv != null ? hotDiv.destroy() : '';
		hotDiv = new Handsontable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			// formulas: true,
			manualColumnResize: true,
			manualRowResize: true,
			columnSummary: columnSummary,
			formulas: {
				engine: hyperformulaInstance,
			},
			// ],
			columns: columnTypes,
			cells: function(row, col, prop) {
			      var cellProperties = {};
			      if(prefillValueType!=null)
				  {
					  for(var r=0;r<prefillValueType.length;r++)
					  {
						  if (row === prefillValueType[r]) {
							  cellProperties.readOnly = true;
						  }
					  }
				  }
			     	return cellProperties;
			   },
			beforeChange: function (changes, source) {
				var row = changes[0][0];

				var prop = changes[0][1];

				var value = changes[0][3];

			},
			beforePaste: (data, coords) => {
				for (let i = 0; i < data.length; i++) {
					for (let j = 0; j < data[i].length; j++) {
						if (coords[0].startCol == 0) {
							data[i][j] = data[i][j].replace(/(?!^-)[^A-Z0-9]/ig, '');
							data[i][j] = data[i][j].replace(/\D/g, '');
						}
						data[i][j] = data[i][j].replace(/(?!^-)[^A-Z0-9.]/ig, ''); ///[^A-Za-z.]/g
						//data[i][j] = data[i][j].replace(/\D/g, '');

					}
				}
			},
			// beforeRemoveRow :(index) => {
			// 	var data = hotDiv.getDataAtRow(index);
			// 	var user_id=$("#user_id").val();
			// 	if(data[1]==user_id)
			// 	{
			// 		return true;
			// 	}
			// 	else
			// 	{
			// 		return false;
			// 	}
			// },
			afterFilter: function (conditionsStack) {
				if(conditionsStack.length>0)
				{
					$(".filterBtn").hide();
				}
				else {
					$(".filterBtn").show();
				}
			},
			stretchH: 'all',
			colWidths: '100%',
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			// contextMenu: true,
			contextMenu: ['undo','redo', 'readonly', 'alignment','copy','cut'],
			hiddenColumns: hideColumn,
			minSpareRows: 1,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		hotDiv.validateCells();
		const exportPlugin = hotDiv.getPlugin('exportFile');
		let fileName=$('.activeShedule').text();
		fileName=fileName.replace(/\t/g,'');
		fileName=fileName.replace(/\n/g,'');
		fileName1=fileName+'[YYYY]-[MM]-[DD]';
		button.addEventListener('click', () => {
			exportPlugin.downloadFile('csv', {
				bom: false,
				columnDelimiter: ',',
				columnHeaders: true,
				exportHiddenColumns: false,
				exportHiddenRows: true,
				fileExtension: 'csv',
				filename: fileName1,
				mimeType: 'text/csv',
				rowDelimiter: '\r\n',
				rowHeaders: true
			});
		});
	}
	function saveSpreadSheetTool1(id=0) {
		// $.LoadingOverlay("show");
		var year= $("#year").val();
		var month= $("#month").val();
		var data = hotDiv.getData();
		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('branch_id', $("#branch_id").val());
		formData.set('month', month);
		formData.set('year', year);
		formData.set('temp_id', $("#spreadsheetTemplateId").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveSpreadSheetTool") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {


					if(id == 0){
						toastr.success(result.body);
						fetch_template_handson();


					}
					saveRupeesData(null,1);
				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	function saveCurrencyConversion() {
		// $.LoadingOverlay("show");
		var year= $("#year").val();
		var month= $("#month").val();
		var data = hotDiv.getData();

		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('branch_id', $("#branch_id").val());
		formData.set('month', month);
		formData.set('year', year);
		formData.set('temp_id', $("#spreadsheetTemplateId").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveCurrencyConversion1") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					getCurrencyData();
					saveRupeesData();

				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	function saveRupeesData(id=null,id1=0) {
		// $.LoadingOverlay("show");
		var year= $("#year").val();
		var month= $("#month").val();
		var data = hotDiv.getData();

		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('branch_id', $("#branch_id").val());
		formData.set('month', month);
		formData.set('year', year);
		formData.set('id', id);
		formData.set('temp_id', $("#spreadsheetTemplateId").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveRupeesData") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					if(id1 == 0){
						toastr.success(result.body);
					}

				} else {
					if(id1 == 0){
						toastr.error(result.body);
					}

				}

			}
		});
	}
	function saveGlMappData() {
		var year= $("#year").val();
		var month= $("#month").val();
		var data = hotDiv.getData();

		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('branch_id', $("#branch_id").val());
		formData.set('month', month);
		formData.set('year', year);
		formData.set('temp_id', $("#spreadsheetTemplateId").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveGlMappData") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	function ClearTemplateData() {
		var temp_id= $("#spreadsheetTemplateId").val();
		var branch_id= $("#branch_id").val();
		var year= $("#year").val();
		var month= $("#month").val();
		var form_data = new FormData();
		form_data.set('temp_id', temp_id);
		form_data.set('branch_id', branch_id);
		form_data.set('month', month);
		form_data.set('year', year);
		var confirm=window.confirm("Do you really want to clear this data?");
		if(confirm){
			$.ajax({
				type: "POST",
				url: "<?= base_url("ClearTemplateData") ?>",
				dataType: "json",
				data: form_data,
				contentType: false,
				processData: false,
				success: function (result) {
					// $.LoadingOverlay("hide");
					if (result.status == 200) {
						toastr.success(result.body);
						fetch_template_handson();

					} else {
						toastr.error(result.body);
					}

				}
			});
		}

	}
	function ClearTemplateTransactionData() {
		var temp_id= $("#spreadsheetTemplateId").val();
		var branch_id= $("#branch_id").val();
		var year= $("#year").val();
		var month= $("#month").val();
		var form_data = new FormData();
		form_data.set('temp_id', temp_id);
		form_data.set('branch_id', branch_id);
		form_data.set('month', month);
		form_data.set('year', year);
		var confirm=window.confirm("Do you really want to clear this data?");
		if(confirm){
			$.ajax({
				type: "POST",
				url: "<?= base_url("ClearTemplateTransactionData") ?>",
				dataType: "json",
				data: form_data,
				contentType: false,
				processData: false,
				success: function (result) {
					// $.LoadingOverlay("hide");
					if (result.status == 200) {
						toastr.success(result.body);
						fetch_template_handson();

					} else {
						toastr.error(result.body);
					}

				}
			});
		}

	}
	function getCurrencyData() {
		$("#CurencySheetBtn").hide();
		$("#CurrencyClearAllButton").hide();
		var temp_id= $("#spreadsheetTemplateId").val();
		var branch_id= $("#branch_id").val();
		var year= $("#year").val();
		var month= $("#month").val();
		var form_data = new FormData();
		////CurencySheetBtn CurrencyClearAllButton

		if((year == null) || (month== null) || branch_id == ""){
			alert('select Month,year & Branch!');
			return;
		}
		form_data.set('temp_id', temp_id);
		form_data.set('branch_id', branch_id);
		form_data.set('month', month);
		form_data.set('year', year);
			$.ajax({
				type: "POST",
				url: "<?= base_url("getCurrencyData") ?>",
				dataType: "json",
				data: form_data,
				contentType: false,
				processData: false,
				success: function (result) {
					// $.LoadingOverlay("hide");
					if (result.status === 200) {
						//

						$("#CurencySheetBtn").show();
						$("#CurrencyClearAllButton").show();
						// $("#handonTableModal").modal('show');
						var columns = result.columnHeaders;
						var rows = [
							['', '', '', '', ''],
						];
						if (result.columnRows != "") {
							rows = result.columnRows;
							rows.push(['', '', '', '', '']);
						}
						var types = result.columnTypes;
						var hideArra = result.hideArra;
						var columnSummary = result.columnSummary;
						var hideColumn = {
							// specify columns hidden by default
							columns: hideArra,
							copyPasteEnabled: false,
						};
						var readonlyArray = result.readonlyArray;
						createHandonTable(columns, rows, types, 'CurrencyDiv', hideColumn, readonlyArray,columnSummary);
						if(result.is_prefill == 1){
							saveCurrencyConversion();
						}
					} else {
						// $("#handonTableModal").modal('hide');
						// $('#tempatetoolBox').hide();
					}

				}
			});
	}
	function getRupeesData() {
		$("#RupeesSheetBtn").hide();
		$("#RupeesClearAllButton").hide();
		var temp_id= $("#spreadsheetTemplateId").val();
		var branch_id= $("#branch_id").val();
		var year= $("#year").val();
		var month= $("#month").val();
		var form_data = new FormData();
		////CurencySheetBtn CurrencyClearAllButton

		if((year == null) || (month== null) || branch_id == ""){
			alert('select Month,year & Branch!');
			return;
		}
		form_data.set('temp_id', temp_id);
		form_data.set('branch_id', branch_id);
		form_data.set('month', month);
		form_data.set('year', year);
			$.ajax({
				type: "POST",
				url: "<?= base_url("getRupeesData") ?>",
				dataType: "json",
				data: form_data,
				contentType: false,
				processData: false,
				success: function (result) {
					// $.LoadingOverlay("hide");
					if (result.status === 200) {
						$("#RupeesSheetBtn").show();
						$("#RupeesClearAllButton").show();
						// $("#handonTableModal").modal('show');
						var columns = result.columnHeaders;
						var rows = [
							['', '', '', '', ''],
						];
						if (result.columnRows != "") {
							rows = result.columnRows;
							rows.push(['', '', '', '', '']);
						}
						var types = result.columnTypes;
						var hideArra = result.hideArra;
						var columnSummary = result.columnSummary;
						var hideColumn = {
							// specify columns hidden by default
							columns: hideArra,
							copyPasteEnabled: false,
						};
						var readonlyArray = result.readonlyArray;
						createHandonTable(columns, rows, types, 'RupeesDiv', hideColumn, readonlyArray,columnSummary);

					} else {
						// $("#handonTableModal").modal('hide');
						// $('#tempatetoolBox').hide();
					}

				}
			});
	}
	function downlodAllbranch(type) {
		var year= $("#year").val();
		var month= $("#month").val();
		var branch_id= $("#branch_id").val();
		var temp_id= $("#spreadsheetTemplateId").val();
		var valuesIn= $("#valuesIn").val();
		if((year == "") || (month=="")){
			alert('Please Select Year and Month!');
			return;
		}else{
			if(type==2)
			{
				var base_url='<?= base_url() ?>';
				window.location.href=base_url+"DownloadAllScheduleForSubisdiary?month="+$("#month").val()+"&year="+$("#year").val()+"&temp_id="+temp_id+"&branch_id="+branch_id+"&valuesIn="+valuesIn;
			}
			else {
				var base_url='<?= base_url() ?>';
				window.location.href=base_url+"DownloadAllScheduleForSubisdiary?month="+$("#month").val()+"&year="+$("#year").val()+"&temp_id="+temp_id+"&valuesIn="+valuesIn;
			}
		}
	}
	function downlodAllbranchRupees(type) {
		var year= $("#year").val();
		var month= $("#month").val();
		var branch_id= $("#branch_id").val();
		var temp_id= $("#spreadsheetTemplateId").val();
		var valuesIn= $("#valuesIn").val();
		if((year == "") || (month=="")){
			alert('Please Select Year and Month!');
			return;
		}else{
			if(type==2)
			{
				var base_url='<?= base_url() ?>';
				window.location.href=base_url+"DownloadAllRupeesScheduleForSubsidiary?month="+$("#month").val()+"&year="+$("#year").val()+"&temp_id="+temp_id+"&branch_id="+branch_id+"&valuesIn="+valuesIn;
			}
			else {
				var base_url='<?= base_url() ?>';
				window.location.href=base_url+"DownloadAllRupeesScheduleForSubsidiary?month="+$("#month").val()+"&year="+$("#year").val()+"&temp_id="+temp_id+"&valuesIn="+valuesIn;
			}
		}
	}
	//downlodAllbranchExcel--downlodAllbranchRupeesExcel

	function downlodAllbranchExcel(type) {
		var year= $("#year").val();
		var month= $("#month").val();
		var branch_id= $("#branch_id").val();
		var temp_id= $("#spreadsheetTemplateId").val();
		if((year == "") || (month=="")){
			alert('Please Select Year and Month!');
			return;
		}else{
			/*var base_url='<?= base_url() ?>';
			window.location.href=base_url+"downlodAllbranchExcel?month="+$("#month").val()+"&year="+$("#year").val()+"&temp_id="+temp_id+"&branch_id="+branch_id;*/
			if(type==1)
			{
				var base_url='<?= base_url() ?>';
				window.location.href=base_url+"downlodAllbranchExcel?month="+$("#month").val()+"&year="+$("#year").val()+"&temp_id="+temp_id+"&branch_id="+branch_id;
			}
			else {
				var base_url='<?= base_url() ?>';
				window.location.href=base_url+"downlodAllbranchRupeesExcel?month="+$("#month").val()+"&year="+$("#year").val()+"&temp_id="+temp_id;
			}
		}
	}
	function getDownloadButtons() {
		$("#transactionBtn").show();
		$("#rupeesConversionBtn").show();
	}
	function getGlAccountMappingData() {
		$("#GlMappSheetBtn").hide();
		$("#GlMappClearAllButton").hide();
		var temp_id= $("#spreadsheetTemplateId").val();
		var branch_id= $("#branch_id").val();
		var year= $("#year").val();
		var month= $("#month").val();
		var form_data = new FormData();
		////CurencySheetBtn CurrencyClearAllButton


		form_data.set('temp_id', temp_id);
		form_data.set('branch_id', branch_id);
		form_data.set('month', month);
		form_data.set('year', year);
		$.ajax({
			type: "POST",
			url: "<?= base_url("getGlAccountMappingData") ?>",
			dataType: "json",
			data: form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status === 200) {
					$("#GlMappSheetBtn").show();
					$("#GlMappClearAllButton").show();
					// $("#handonTableModal").modal('show');
					var columns = result.columnHeaders;
					var rows = [
						['', '', '', '', ''],
					];
					if (result.columnRows != "") {
						rows = result.columnRows;
						rows.push(['', '', '', '', '']);
					}
					var types = result.columnTypes;
					var hideArra = result.hideArra;
					var columnSummary = result.columnSummary;
					var hideColumn = {
						// specify columns hidden by default
						columns: hideArra,
						copyPasteEnabled: false,
					};
					var readonlyArray = result.readonlyArray;
					var prefillValueType=result.prefillValueType;
					createHandonTable(columns, rows, types, 'GlMappDiv', hideColumn, readonlyArray,columnSummary,prefillValueType);

				} else {
					// $("#handonTableModal").modal('hide');
					// $('#tempatetoolBox').hide();
				}

			}
		});
	}
	function getSubsidiaryAccountMappingData() {
		$("#SubMappSheetBtn").hide();
		$("#SubMappClearAllButton").hide();
		var temp_id= $("#spreadsheetTemplateId").val();
		var branch_id= $("#branch_id").val();
		var year= $("#year").val();
		var month= $("#month").val();
		var form_data = new FormData();
		////CurencySheetBtn CurrencyClearAllButton


		form_data.set('temp_id', temp_id);
		form_data.set('branch_id', branch_id);
		form_data.set('month', month);
		form_data.set('year', year);
		$.ajax({
			type: "POST",
			url: "<?= base_url("getSubsidiaryAccountMappingData") ?>",
			dataType: "json",
			data: form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status === 200) {
					$("#SubMappSheetBtn").show();
					$("#SubMappClearAllButton").show();
					// $("#handonTableModal").modal('show');
					var columns = result.columnHeaders;
					var rows = [
						['', '', '', '', ''],
					];
					if (result.columnRows != "") {
						rows = result.columnRows;
						rows.push(['', '', '', '', '']);
					}
					var types = result.columnTypes;
					var hideArra = result.hideArra;
					var columnSummary = result.columnSummary;
					var hideColumn = {
						// specify columns hidden by default
						columns: hideArra,
						copyPasteEnabled: false,
					};
					var readonlyArray = result.readonlyArray;
					var prefillValueType=result.prefillValueType;
					createHandonTable(columns, rows, types, 'SubMappDiv', hideColumn, readonlyArray,columnSummary,prefillValueType);

				} else {
					// $("#handonTableModal").modal('hide');
					// $('#tempatetoolBox').hide();
				}

			}
		});
	}
	function saveSubMappData() {
		var year= $("#year").val();
		var month= $("#month").val();
		var data = hotDiv.getData();

		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('branch_id', $("#branch_id").val());
		formData.set('month', month);
		formData.set('year', year);
		formData.set('temp_id', $("#spreadsheetTemplateId").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveSubMappData") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	// Download All Branch data
	function OpenModal() {
		$("#downLoadAllBranchData").modal('show');
	}
	function getTemplateListOFMonthYear() {
		var month=$("#allBmonth").val();
		var year=$("#allByear").val();
		if(month!="" && month!=null && year!="" && year!=null)
		{
			let formData = new FormData();
			formData.set('month', month);
			formData.set('year', year);
			$.ajax({
				type: "POST",
				url: "<?= base_url("getTemplateListOFMonthYear") ?>",
				dataType: "json",
				data: formData,
				contentType: false,
				processData: false,
				success: function (result) {
					// $.LoadingOverlay("hide");
					if (result.status == 200) {
						$("#allBtemplates").append(result.body);
						$("#allBtemplates").select2();
					} else {
						toastr.error(result.body);
					}
				}
			});
		}
		else {
			// toastr.error('Select month & year');
		}
	}
	function downlodRupeesConversionAllbranch() {
		var month=$("#allBmonth").val();
		var year=$("#allByear").val();
		var temp_id=$("#allBtemplates").val();
		var valuesIn=$("#downloadvaluesIn").val();
		if(month!="" && month!=null && year!="" && year!=null && temp_id!="" && temp_id!=null) {
			var base_url='<?= base_url() ?>';
			window.location.href=base_url+"downlodRupeesConversionAllbranch?month="+month+"&year="+year+"&temp_id="+temp_id+"&valuesIn="+valuesIn;
		}
		else {
			toastr.error('Select month & year');
		}
	}
	function ClearTemplateCurrencyRateData() {
		var temp_id= $("#spreadsheetTemplateId").val();
		var branch_id= $("#branch_id").val();
		var year= $("#year").val();
		var month= $("#month").val();
		var form_data = new FormData();
		form_data.set('temp_id', temp_id);
		form_data.set('branch_id', branch_id);
		form_data.set('month', month);
		form_data.set('year', year);
		var confirm=window.confirm("Do you really want to clear this data?");
		if(confirm){
			$.ajax({
				type: "POST",
				url: "<?= base_url("ClearTemplateCurrencyRateData") ?>",
				dataType: "json",
				data: form_data,
				contentType: false,
				processData: false,
				success: function (result) {
					// $.LoadingOverlay("hide");
					if (result.status == 200) {
						toastr.success(result.body);
						getCurrencyData();

					} else {
						toastr.error(result.body);
					}

				}
			});
		}

	}
</script>
