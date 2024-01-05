<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">

	* {
		-webkit-print-color-adjust: exact !important; /* Chrome, Safari, Edge */
		color-adjust: exact !important; /*Firefox*/
	}

	/* width */
	#pdfDiv::-webkit-scrollbar {
		width: 8px;
		border-radius: 8px;
	}

	/* Track */
	#pdfDiv::-webkit-scrollbar-track {
		background: #f1f1f1;
	}

	/* Handle */
	#pdfDiv::-webkit-scrollbar-thumb {
		background: #aea8a8;
		border-radius: 15px;
	}

	/* Handle on hover */
	#pdfDiv::-webkit-scrollbar-thumb:hover {
		background: #e7e0e0;
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
		padding: 5px 10px!important;
	}

	.nav-item {
		width: auto;
		text-align: center;
	}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title" id="temp_text"><?php echo $templateName; ?></h4>
							<input type="hidden" name="insertID" id="insertID" value="<?php echo $id; ?>">
							<input type="hidden" name="tempName" id="tempName" value="<?php echo $templateName; ?>">
							<input type="hidden" name="branchID" id="branchID">
							<input type="hidden" name="valuesIn" id="valuesIn">
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="" id="financialFormRow" style="">
		<div class="col-lg-12">
			<div class="card-box">
				<form method="post" id="exportexcelsheet">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Year</label>
									<select name="year" id="year" onchange="getYearConsolidatedMonth(this.value)" class="form-control year">
										<option disabled selected>select year</option>
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
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Month</label>
									<select name="month" id="month" class="form-control month">
										<option disabled selected>select month</option>

									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Subsidiary Accounts</label>
									<select name="branch" id="branch" class="form-control">
										<option  selected>All</option>

									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Download For All Subsidiaries</label>
									<button type="button" class="btn btn-primary" id="downloadBtn" onclick="getAllBranchesDownload()"><i class="fa fa-download"></i> Download</button>
								</div>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<button type="button" onclick="getHandsonData()" class="btn btn-primary roundCornerBtn4"
										style="margin-top: 27px;">View Report
								</button>

							</div>
							<div class="col-md-6" id="DownloadButton" style="display: none">
								<label>Download View Report</label>
								<button id="excelDownload" type="button" class="btn btn-link" style="">
									<i
											class="fa fa-download" style="font-size: 18px"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top: 50px;">
		<div class="col-md-12 bg-white" id="handsonreport"></div>
		<!--		<div class="col-md-12 text-right">-->
		<!--			-->
		<!--			<button class="btn btn-danger" type="button" style="float: right;margin: 0px 10px;display: none;" id="printButton"-->
		<!--					onclick="print_div()">Make Word-->
		<!--			</button>-->
		<!--		</div>-->
		<!---->
		<!--		<div class="col-md-12 pdfDiv bg-white" id="pdfDiv"-->
		<!--			 style="margin: 1rem auto; width: 595.3pt; height:841.9pt;border: solid 2px #2c2c2c;padding:8px;-->
		<!--			  margin:0 25%;overflow-y: auto;overflow-x: hidden;border-radius:2px">-->
		<!---->
		<!--		</div>-->


	</div>
</div>


</div>

<div class="modal" id="newModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-full" role="document">
		<div class="modal-content">
			<div class="modal-header" style="display: flex;">
				<h5 class="modal-title col-md-4" id="templateName">Details</h5>
					<div class="col-md-8">
					<ul class="nav nav-tabs" id="TransTabUl" role="tablist" style="float: right;">

						<li class="nav-item match active transTab" role="presentation" id="">
							<a data-toggle="tab" href="#RupCon" class="nav-link active" id="RupconTab" role="tab" aria-selected="true" aria-expanded="true" onclick="getscheduleTrnsactions(2)">Rupees Conversion</a>
						</li>
						<li class="nav-item match  transTab" role="presentation" id="transTabid">
							<a data-toggle="tab" href="#TranTab" class="nav-link  " id="Trantab"  role="tab" aria-selected="false" aria-expanded="false" onclick="getscheduleTrnsactions(1)">Transaction</a>
						</li>
					</ul>
					</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="schedule_temp_id" value="">
				<input type="hidden" id="schedule_temp_name" value="">

				<div class="col-md-12 bg-white" id="handsonreportModal"></div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
</div>

	<div class="modal" id="GlDetailsModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="templateName">Details</h5>
					<button type="button" onclick="downloadTableDatafromHashKey1()" class="btn btn-primary btn-sm">Download <i class="fa fa-download"></i></button>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

					<input type="hidden" id="dataFromhashKey">
				</div>
				<div class="modal-body" id="glAccountDetailsDiv">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
				</div>
			</div>
		</div>


		<?php $this->load->view('_partials/footer'); ?>

<!---->
<!--<script src="--><?//= base_url("assets/js/FileSaver.js") ?><!-- "></script>-->
<!--<script src="--><?//= base_url("assets/js/jquery.wordexport.js") ?><!-- "></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/hyperformula/dist/hyperformula.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/module/reportMaker/reportVersion3.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
	$(document).ready(function () {

		getCompanyBranchList();
	});
	// 	$("#exportexcelsheet").validate({
	// 	rules: {
	// 		year: {
	// 			required: true
	// 		},
	// 		month: {
	// 			required: true
	// 		}
	// 	},
	// 	messages: {
	// 		year: {
	// 			required: "Please select year",
	// 		},
	// 		month: {
	// 			required: "Please select month",
	// 		}
	// 	},
	// 	errorElement: 'span',
	// 	submitHandler: function (form) {
	// 		// $.LoadingOverlay("show");
	// 		$("#printButton").hide();
	// 		var formData = new FormData(form);
	// 		formData.set('template_id',$("#insertID").val());
	// 		console.log(formData);
	// 		$.ajax({
	// 			url: base_url + "createReportMonthPdf",
	// 			type: "POST",
	// 			dataType: "json",
	// 			data: formData,
	// 			processData: false,
	// 			contentType: false,
	// 			success: function (result) {
	// 				if (result.status === 200) {
	// 					$("#printButton").show();
	// 					$("#pdfDiv").html(result.body);

	// 				} else {
	// 					toastr.error(result.body);
	// 				}
	// 			}, error: function (error) {
	// 				// $.LoadingOverlay("hide");
	// 				toastr.error("Something went wrong please try again");
	// 			}

	// 		});
	// 	}
	// });
	let graphArray = [];
	const button = document.querySelector('#excelDownload');
	function getHandsonData() {
		$.LoadingOverlay("show");
		$("#printButton").hide();
		var form = document.getElementById('exportexcelsheet');
		var formData = new FormData(form);
		formData.set('template_id', $("#insertID").val());
		formData.set('tempName', $("#tempName").val());
		// console.log(formData);
		$.ajax({
			url: base_url + "createTableReportMonthHandsonVersion3",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (result) {
				$("#valuesIn").val(result.number_conversion);
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					$("#DownloadButton").show();
					let columnsHeader =result.header;
					let columnTypes = result.columnType;
					let columnsRows = result.rows;
					let hiddenColumns = result.hideColumns;
					let columnSummary = result.columnSummary;
					let style = result.style;
					StyleArray=result.style
					handson(columnsHeader, columnsRows, columnTypes, 'handsonreport', hiddenColumns, 23,columnSummary,style);
					hosController.updateSettings({
						afterSelectionEnd: function(r, c, r2, c2) {
							var rc=r+","+c;

							if(c == 1){
								var is_report_Schedule=hosController.getDataAtCell(r,10);
								var reportScheduleID=hosController.getDataAtCell(r,11);
								var reportScheduleName=hosController.getDataAtCell(r,3);
								getdataValue(is_report_Schedule,reportScheduleID,reportScheduleName);
							}
							if(c==0 && r!=6)
							{
								var glNum=hosController.getDataAtCell(r,4);
								if(glNum!=null && glNum!="")
								{
									let hashKeycnt=( glNum.split('#').length - 1);
									if(hashKeycnt==1)
									{
										getGlAccounNumberDetails(glNum);
									}
								}

							}

						}
					});
					const exportPlugin = hosController.getPlugin('exportFile');

					button.addEventListener('click', () => {
						exportPlugin.downloadFile('csv', {
							bom: false,
							columnDelimiter: ',',
							columnHeaders: true,
							exportHiddenColumns: false,
							exportHiddenRows: true,
							fileExtension: 'csv',
							filename: 'Report-file_[YYYY]-[MM]-[DD]',
							mimeType: 'text/csv',
							rowDelimiter: '\r\n',
							rowHeaders: false,
							width: '100%',
						});
					});

				} else {
					toastr.error(result.body);
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				toastr.error("Something went wrong please try again");
			}

		});
	}

	function getdataValue(is_report_Schedule,reportScheduleID,reportScheduleName=''){
		$('#TableDiv').html('');
		if((reportScheduleID == "" || reportScheduleID == null || reportScheduleID == 0) && (is_report_Schedule == "" || is_report_Schedule == null || is_report_Schedule == 0)){

		}else{

			var html=getdatafromHashKey(is_report_Schedule,reportScheduleID,reportScheduleName);
			$('#newModal').modal('show');

		}
	}
	function getdatafromHashKey(is_report_Schedule,reportScheduleID,reportScheduleName) {
		$("#TransTabUl").hide();
		if(is_report_Schedule == 1){ //template
			getHandsonDataModal(reportScheduleID);
		}else{
			$("#TransTabUl").show();

			$("#schedule_temp_id").val(reportScheduleID);
			$("#schedule_temp_name").val(reportScheduleName);
			$("#RupconTab").click();
			// var formData = new FormData();
			// formData.set('month',$("#month").val()); //12
			// formData.set('year',$("#year").val()); //2021
			// formData.set('branch_id',$("#branch").val()); //78
			// formData.set('temp_id', reportScheduleID); //59
			// getSchedule(formData);
		}
		/*$.ajax({
			url: base_url + "getTableDatafromHashKey",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (result) {
				$.LoadingOverlay("hide");
				$('#TableDiv').html(result.body);
			}, error: function (error) {
				$.LoadingOverlay("hide");
				toastr.error("Something went wrong please try again");
			}

		});*/

	}
	function getscheduleTrnsactions(type) {
		var formData = new FormData();
		formData.set('month',$("#month").val()); //12
		formData.set('year',$("#year").val()); //2021
		formData.set('branch_id',$("#branch").val()); //78
		formData.set('temp_id', $("#schedule_temp_id").val()); //59
		formData.set('temp_name', $("#schedule_temp_name").val()); //59
		formData.set('valuesIn', $("#valuesIn").val()); //59
		$.ajax({
			url: base_url + "getscheduleTrnsactionsTemplateId",
			type: "POST",
			dataType: "json",
			data:formData,
			processData: false,
			contentType: false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {
					formData.set('temp_id', result.body);
					if(type==2)
					{
						getSchedule(formData);
					}
					else {
						getTrnsactionTable(formData);
					}
				} else {
					toastr.error('No template found');
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				toastr.error("Something went wrong please try again");
			}

		});
	}
	function getSchedule(form_data) {
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: "<?= base_url("getRupeesData") ?>",
			dataType: "json",
			data: form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {
					$("#templateName").html(result.template_name);
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
					handson2(columns, rows, types, 'handsonreportModal', hideArra, readonlyArray,columnSummary);

				} else {
					// $("#handonTableModal").modal('hide');
					// $('#tempatetoolBox').hide();
				}

			}
		});
	}
	function getTrnsactionTable(form_data) {
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: "<?= base_url("fetch_templatesHandonData") ?>",
			dataType: "json",
			data: form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {

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


					}
					var types = result.columnTypes;
					var hideArra = result.hideArra;
					var columnSummary = result.columnSummary;

					var last=(Secondlast*1)+1;
					hideArra.push(Secondlast,last);

					var hideColumn =hideArra;
					console.log(hideColumn);
					var arraySource1=['Yes','No'];
					types.push({type: 'dropdown',source:arraySource1},{type: 'text'});
					var readonlyArray = result.readonlyArray;
					handson2(columns, rows, types, 'handsonreportModal', hideColumn, readonlyArray,columnSummary);

				} else {
					// $("#handonTableModal").modal('hide');
					// $('#tempatetoolBox').hide();
				}
			}
		});

	}
	let hosController2;
	function getHandsonDataModal(template_id) {
		$.LoadingOverlay("show");
		$("#printButton").hide();
		var form = document.getElementById('exportexcelsheet');
		var formData = new FormData(form);
		formData.set('template_id', template_id);
		// console.log(formData);
		$.ajax({
			url: base_url + "createTableReportMonthHandsonVersion3",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {

					$("#templateName").html(result.template_name);
					let columnsHeader =result.header;
					let columnTypes = result.columnType;
					let columnsRows = result.rows;
					let hiddenColumns = result.hideColumns;
					let columnSummary = result.columnSummary;
					let style = result.style;
					StyleArray=result.style;
					columnsHeader=false;
					handson2(columnsHeader, columnsRows, columnTypes, 'handsonreportModal', hiddenColumns, 23,columnSummary,style);

				} else {
					toastr.error(result.body);
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				toastr.error("Something went wrong please try again");
			}
		});
	}
	const hyperformulaInstance = HyperFormula.buildEmpty({
		// to use an external HyperFormula instance,
		// initialize it with the `'internal-use-in-handsontable'` license key
		licenseKey: 'internal-use-in-handsontable',
	});

	function handson2(columnsHeader, columnsRows, columnTypes, divId, hiddenColumns,group=null,columnSummary=null,style=null) {
		if (columnsRows.length === 0) {
			columnsRows = [
				['', '', '', '', '', '', '', '', '', '','','','','',''],
			];
		}
		const container = document.getElementById(divId);
		hosController2 != null ? hosController2.destroy() : "";
		hosController2 = new Handsontable(container, {
			data: columnsRows,
			colHeaders: columnsHeader,
			manualColumnResize: true,
			manualRowResize: true,
			columnSummary: columnSummary,
			columns: columnTypes,
			formulas: {
				engine: hyperformulaInstance,
			},
			cells(row,column){
				const cellProperties = {};
				// style formatting cells
				// disable pasting data into row 1
				if (row === 6 && column < 10) {
					cellProperties.readOnly = 'true'
				}
				if(row < 6 && (column===2 || column===3 || column==4))
				{
					// cellProperties.readOnly = 'true';
				}

				cellProperties.renderer = "negativeValueRenderer"; // uses lookup map

				return cellProperties;
			},
			afterOnCellMouseDown: function(event, coords) {
				const cellProperties1 = {};
				cellProperties1.renderer = "negativeValueRenderer"; // uses lookup map
				return cellProperties1;
			},

			minSpareRows: 1,
			width: '100%',
			stretchH: 'all',
			height: 500,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			hiddenColumns: {
				columns: hiddenColumns,
				copyPasteEnabled: false,
				// specify columns hidden by default

			},
			dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		hosController2.validateCells();
	}
	function getYearConsolidatedMonth(year) {
		$("#month").html('');
		var formData = new FormData();
		formData.set('template_id', $("#insertID").val());
		formData.set('year', year);
		$.ajax({
			url: base_url + "getTableConsolidatedMonthVersion3",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {
					$("#month").html(result.option);
				} else {
					toastr.error(result.body);
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				toastr.error("Something went wrong please try again");
			}

		});

	}

	function getCompanyBranchList() {
		$.ajax({
			url: base_url + "getCompanyBranchList",
			type: "POST",
			dataType: "json",
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {

					$("#branch").html(result.data);
					$("#branch").select2();
					// $("#branch").prepend('<option value="All" selected>All</option>');
				} else {
					toastr.error(result.body);
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				toastr.error("Something went wrong please try again");
			}

		});
	}
	function getAllBranchesDownload() {
		if($("#month").val()!="" && $("#month").val()!=null && $("#year").val()!="" && $("#year").val()!=null && $("#insertID").val()!="" && $("#insertID").val()!=null)
		{
			let formData=new FormData();
			formData.set('month',$("#month").val());
			formData.set('year',$("#year").val());
			formData.set('template_id',$("#insertID").val());
			window.location.href=base_url+"getAllBranchesDownload?month="+$("#month").val()+"&year="+$("#year").val()+"&template_id="+$("#insertID").val();
		}
		else {
			toastr.error('select month & year');
		}

	}
	function getGlAccounNumberDetails(glNumKey) {
		$.LoadingOverlay("show");
		$("#glAccountDetailsDiv").html('');
		var formData = new FormData();
		formData.set('data', glNumKey);
		formData.set('year', $("#year").val());
		formData.set('month', $("#month").val());
		formData.set('branch', $("#branch").val());
		formData.set('template_id', $("#insertID").val());
		$.ajax({
			url: base_url + "getTableDatafromHashKey1",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					// console.log(result.body);
					$("#GlDetailsModal").modal('show');
					$("#dataFromhashKey").val(glNumKey);
					$("#glAccountDetailsDiv").html(result.body);
				} else {
					toastr.error(result.body);
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				toastr.error("Something went wrong please try again");
			}

		});
	}
	// function createPdf()
	// {
	// 	 var month=$("#quarter").val();
	// 	 var year=$("#year").val();
	// 	  var template_id=$("#insertID").val();
	// 	  window.location.href=base_url+'ReportMakerController/createReportMonthPdf?template_id='+template_id+'&month='+month+'&year='+year;
	// }

	// function print_div() {
	// 	var checksize=$("input[name='pageSize']:checked").val();
	// 	var css = '@page { size: '+checksize+'!important;margin: 15mm 15mm 15mm 15mm; -webkit-print-color-adjust: exact !important;}',

	// 			    style = document.createElement('style');

	// 			style.type = 'text/css';
	// 			style.media = 'print';

	// 			if (style.styleSheet){
	// 			  style.styleSheet.cssText = css;
	// 			} else {
	// 			  style.appendChild(document.createTextNode(css));
	// 			}

	// 	let divName=".pdfDiv";
	// 	// $('#printButton').toggleClass('d-none');
	// 	let ele=document.querySelector(divName);

	// 	ele.appendChild(style);

	// 	var printContents = document.querySelector(divName).innerHTML;

	// 	var originalContents = document.body.innerHTML;

	// 	document.body.innerHTML = printContents;

	// 	window.print();
	// 	document.body.innerHTML = originalContents;
	// 	// $('#printButton').toggleClass('d-none');
	// }
	function print_div() {
		let fileName=$("#temp_text").html()+'-'+$("#year").val()+'-'+$("#month").val();
		$("#pdfDiv").wordExport(fileName);
		// let formData = new FormData();
		// formData.set('data',$("#pdfDiv").html());
		// app.request(base_url + "addWordFileHtml",formData).then(res=>{
		// 	var template_id=$('#insertID').val();
		// 	var year=$('#year').val();
		// 	var month=$('#month').val();
		// 	window.location.href=base_url+'createWordFile?id='+template_id+'&year='+year+'&month='+month;
		// });
	}

	function drawChart() {
		graphArray.map(function (e) {
			let category1 = e.cat;
			let value1 = e.val;
			let divId1 = e.id;
			console.log(category1);
			let data = new google.visualization.DataTable();
			data.addColumn('string', 'Category');
			data.addColumn('number', 'Values');
			let float_var = [];
			value1.forEach(v => {
				float_var.push(parseFloat(v));
			});
			category1.forEach((c, i) => {
				data.addRows([[c, float_var[i]]]);
			});
			let options = {
				title: 'test graph',
				hAxis: {title: "Category"},
				vAxis: {title: "values"},
				chartArea: {left: '20%', top: '10%', width: '80%', height: '50%', padding: '10px'}
			};

			let chart_area = document.getElementById(divId1);
			if (typeof (chart_area) != 'undefined' && chart_area != null) {
				let chart = new google.visualization.ColumnChart(chart_area);
				google.visualization.events.addListener(chart, 'ready', function () {
					chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
				});
				chart.draw(data, options);
			}
		});
	}
	function downloadTableDatafromHashKey1() {
		var dataHash = $("#dataFromhashKey").val();
		var year = $("#year").val();
		var month =  $("#month").val();
		var branch = $("#branch").val();
		var template_id =  $("#insertID").val();
		window.location.href = base_url + "downloadTableDatafromHashKey1?year="+year+"&month="+month+"&branch="+ branch+"&template_id="+template_id+"&dataHash=" + btoa(dataHash);
	}
</script>

