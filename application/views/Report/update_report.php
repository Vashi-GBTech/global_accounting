<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>


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
		border-right: 1px solid #80808029;
	}

	.nav-item {
		width: 300px;
		text-align: center;
	}

	.alert-title {
		line-height: 20px;
	}
	.alert
	{
		color: black!important;
		padding: 0.2rem 0.5rem!important;
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
							<div class="" style="    display: flex; flex-direction: row;">
							<button class="btn btn-link "><a href="view_consolidate_report"><i class="fa fa-arrow-left"></i></a></button>
							<h4 class="">Consolidate Report of <?php echo $month . " " . $year; ?></h4>
							</div>
							<!--<button class="btn btn-primary" style="margin-top: 27px;margin-left:10px;float: right" onclick="saveData();">
								Re-Run
							</button>-->
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row m-t-10">
			<div class="col-lg-12 bg-white">
				<div class="card-box" style="border: none">


					<div id="errorDiv" class="errorDiv">

					</div>
					<ul class="nav nav-tabs nav-justified m-b-20" id="ex1" role="tablist">
						<li class="nav-item match active" role="presentation">
							<a data-toggle="tab" href="#FAS" id="FASTAB" class="nav-link active" role="tab"
							   aria-selected="true" aria-expanded="true"
							   onclick="getFinalDataFromDB('FinalReportSheetIND');getErrorLog(1);">INDIAN
								GAAP</a>
						</li>
						<li class="nav-item unmatch" role="presentation">
							<a data-toggle="tab" href="#FUS" class="nav-link" role="tab" aria-selected="false"
							   aria-expanded="false" onclick="getFinalDataFromDB('FinalReportSheetUS');getErrorLog(2);">US GAAP</a>
						</li>
						<li class="nav-item unmatch" role="presentation">
							<a data-toggle="tab" href="#IFFRS" class="nav-link" role="tab" aria-selected="false"
							   aria-expanded="false" onclick="getFinalDataFromDB('FinalReportSheetIFRS');getErrorLog(3);">IFRS</a>
						</li>
					</ul>
					<div class="tab-content" style="padding:0;">
					<div class="tab-pane active" id="FAS">
							<!--<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
								<li class="nav-item match active" role="presentation">
									<a data-toggle="tab" href="#final_level1" class="nav-link active" role="tab"
									   aria-selected="true" aria-expanded="true"
									   onclick="getFinalDataFromDB('FinalReportSheetIND');">Final Level
										Consolidation</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#branch_level1" class="nav-link" role="tab"
									   aria-selected="false" onclick="getDataFromDB('ReportSheet');"
									   aria-expanded="false">Subsidiary Account Level Consolidation</a>
								</li>
							</ul>-->
<!--							<div class="tab-content" style="padding:0;">-->
								<!--<div class="tab-pane active" id="final_level1">



									<div id="FinalReportSheetIND"></div>

								</div>-->
<!--								<div class="tab-pane " id="branch_level1">-->
									<button class="btn btn-primary btn-sm roundCornerBtn4"
											id="final_ind_derived"
											style="margin-left:10px;float: right;margin-bottom: 10px;"
											onclick="setDerivedFormulaData();">
										Run to get Final Derived
									</button>
									<button class="btn btn-primary btn-sm roundCornerBtn4"
											id="final_ind"
											style="margin-left:10px;float: right;margin-bottom: 10px;"
											onclick="saveDataFinal('FinalReportSheetIND',1);">
										Run to get Final Level Consolidation
									</button>
									<button class="btn btn-primary btn-sm roundCornerBtn4"
											id="branch_ind"
											style="margin-left:10px;float: right"
											onclick="loadData('ReportSheet');">
										Run to get Updated Sheet
									</button>
									<button id="excelDownload" type="button" class="btn btn-link" style="float: right">
										<i
												class="fa fa-download" style="font-size: 18px"></i></button>
									<div id="ReportSheet"></div>
<!--								</div>-->
<!--							</div>-->
						</div>
						<div class="tab-pane " id="FUS">
							<!--<ul class="nav nav-tabs m-b-20" id="ex2" role="tablist">
								<li class="nav-item match active" role="presentation">
									<a data-toggle="tab" href="#final_level2" class="nav-link active" role="tab"
									   aria-selected="true" aria-expanded="true"
									   onclick="getFinalDataFromDB('FinalReportSheetUS');">Final Level Consolidation</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#branch_level2" class="nav-link" role="tab"
									   aria-selected="false" onclick="getDataFromDB('ReportSheet');"
									   aria-expanded="false">Subsidiary Account Level Consolidation</a>
								</li>
							</ul>-->
							<!--<div class="tab-content" style="padding:0;">
								<div class="tab-pane " id="final_level2">-->


<!--								<div class="tab-pane " id="branch_level2">-->


									<button class="btn btn-primary btn-sm roundCornerBtn4"
											id="branch_us"
											style="margin-left:10px;float: right"
											onclick="loadData('ReportSheet');">
										Run to get Updated Sheet
									</button>
									<button class="btn btn-primary btn-sm  roundCornerBtn4"
											id="final_us"
											style="margin-left:10px;float: right"
											onclick="saveDataFinal('FinalReportSheetUS',2);">
										Run to get Final Level Consolidation
									</button>
									<button id="excelDownload" type="button" class="btn btn-link" style="float: right">
										<i
												class="fa fa-download" style="font-size: 18px"></i></button>
									<div id="ReportSheetUS"></div>
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
						<div class="tab-pane " id="IFFRS">
							<!--<ul class="nav nav-tabs m-b-20" id="ex3" role="tablist">
								<li class="nav-item match active" role="presentation">
									<a data-toggle="tab" href="#final_level3" class="nav-link active" role="tab"
									   aria-selected="true" aria-expanded="true"
									   onclick="getFinalDataFromDB('FinalReportSheetIFRS');">Final Level
										Consolidation</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#branch_level3" class="nav-link" role="tab"
									   aria-selected="false" onclick="getDataFromDB('ReportSheet');"
									   aria-expanded="false">Subsidiary Account Level Consolidation</a>
								</li>
							</ul>-->
							<!--<div class="tab-content" style="padding:0;">
								<div class="tab-pane " id="final_level3">-->

<!--								</div>-->
<!--								<div class="tab-pane " id="branch_level3">-->
									<button class="btn btn-primary btn-sm roundCornerBtn4"
											id="branch_ifrs"
											style="margin-left:10px;float: right"
											onclick="loadData('ReportSheet');">
										Run to get Updated Sheet
									</button>
									<button class="btn btn-primary btn-sm roundCornerBtn4"
											id="final_ifrs"
											style="margin-left:10px;float: right"
											onclick="saveDataFinal('FinalReportSheetIFRS',3);">
										Run to get Final Level Consolidation
									</button>
									<button id="excelDownload" type="button" class="btn btn-link" style="float: right">
										<i
												class="fa fa-download" style="font-size: 18px"></i></button>
									<div id="ReportSheetIFRS"></div>
<!--								</div>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('_partials/footer'); ?>
	<script>
		$(document).ready(function () {
			getErrorLog(1);
			getDataFromDB('ReportSheet');
		//	getFinalDataFromDB('FinalReportSheetIND');
		});

		function getErrorLog(type) {
			let formData = new FormData();
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			formData.set("year", year);
			formData.set("month", month);
			formData.set('type',type);
			app.request('getErrors', formData).then(res => {
				if (res.status === 200) {
					$('#errorDiv').empty();
					let uploadData = res.uploadData;
					let parentdata = res.parent;
					let main_data = res.main;
					let BlockYear = res.BlockYear;
					let parent = `Parent Mapping is not Done for Following Subsidiary Accounts : <br>`;
					for (var i = 0; i < parentdata.length; i++) {
						if (parentdata[i].branch != "") {
							parent += ` ${parentdata[i].branch},  `;
						}
					}

					let main = `Following Main Gl Number Does Not Exists : <br>`;
					for(var m = 0;m < main_data.length;m++)
					{
						if(main_data[m].main != ""){
							main += ` ${main_data[m].main}, `;
						}
					}

					let name = [];
					let upload = `Data is not Uploaded for Following Subsidiary Accounts : <br>`;
					for (let i = 0; i < uploadData.length; i++) {
						upload += ` ${uploadData[i].Name},`;
					}
					var currency = 'Currency Conversion is not Done for this Month';
					let uploadClass=`<div class="col-md-12 alert alert-light" style="border-bottom: 1px solid #0000002b;">
										<div class="col-md-3">
										<b>Financial Data</b>
										</div>
										<div class="col-md-9" style="font-size: 13px">${upload}</div>
										</div>`;

					let currencyClass=`<div class="col-md-12 alert alert-light" style="border-bottom: 1px solid #0000002b;">
										<div class="col-md-3">
										<b>Currency</b>
										</div>
										<div class="col-md-9" style="font-size: 13px">${currency}</div>
										</div>`;
					let parentClass=`<div class="col-md-12 alert alert-light" style="border-bottom: 1px solid #0000002b;">
										<div class="col-md-3">
										<b style="font-size: 13px;">Parent Mapping</b>
										</div>
										<div class="col-md-9" style="font-size: 13px">${parent}</div>
										</div>`;

					let mainClass = `<div class="col-md-12 alert alert-light" style="border-bottom: 1px solid #0000002b;">
									<div class="col-md-3">
									<b style="font-size: 13px">Main Account Existence Check</b>
									</div>
									<div class="col-md-9" style="font-size: 13px">${main}</div>
									</div>`;


					if (uploadData === 0) {
						upload = '<i class="fa fa-check"></i>';
						uploadClass=`<div class="col-md-3 alert alert-success" style="border-bottom: 1px solid #0000002b;    border-right: 1px solid lightgray;">
										<div class="col-md-8">
										<b>Financial Data</b>
										</div>
										<div class="col-md-4" style="font-size: 13px">${upload}</div>
										</div>`;
					}
					if (res.Currency === 0) {
						currency = '<i class="fa fa-check"></i>';
						currencyClass=`<div class="col-md-3 alert alert-success" style="border-bottom: 1px solid #0000002b;    border-right: 1px solid lightgray;">
										<div class="col-md-8">
										<b>Currency</b>
										</div>
										<div class="col-md-4" style="font-size: 13px">${currency}</div>
										</div>`;
					}
					if(parentdata === 0)
					{
						parent = '<i class="fa fa-check"></i>';
						parentClass=`<div class="col-md-3 alert alert-success" style="border-bottom: 1px solid #0000002b;    border-right: 1px solid lightgray;">
										<div class="col-md-8">
										<b style="font-size: 13px">Parent Mapping</b>
										</div>
										<div class="col-md-4" style="font-size: 13px">${parent}</div>
										</div>`;
					}

					if(main_data == 0)
					{
						main = '<i class="fa fa-check"></i>';
						mainClass = `<div class="col-md-3 alert alert-success" style="border-bottom: 1px solid #0000002b;    border-right: 1px solid lightgray;">
										<div class="col-md-8">
										<b style="font-size: 13px">Main Account Existence Check</b>
										</div>
										<div class="col-md-4" style="font-size: 13px">${main}</div>
										</div>`;
					}


					var template = `<div class="col-md-12"><div><div class="alert-has-icon">
				                    <div class="alert-body">
				                      <div class="alert-title" style="color: black">
										<div class="row">
										${uploadClass}
										${currencyClass}
										${parentClass}
										${mainClass}
										</div>
										</div>
				                    </div>
				                  </div></div></div>`;
					$('#errorDiv').append(template);


					/*if(uploadData === 0 && parentdata === 0 && main_data === 0 && res.Currency === 0)
					{
						if(type === 1)
						{
							$('#final_ind').attr("disabled", false);
							$('#branch_ind').attr("disabled", false);
						}
						if(type === 2)
						{
							$('#final_us').attr("disabled", false);
							$('#branch_us').attr("disabled", false);
						}
						if(type === 3)
						{
							$('#final_ifrs').attr("disabled", false);
							$('#branch_ifrs').attr("disabled", false);
						}
					}
					else
					{
						if(type === 1)
						{
							$('#final_ind').attr("disabled", true);
							$('#branch_ind').attr("disabled", true);
						}
						if(type === 2)
						{
							$('#final_us').attr("disabled", true);
							$('#branch_us').attr("disabled", true);
						}
						if(type === 3)
						{
							$('#final_ifrs').attr("disabled", true);
							$('#branch_ifrs').attr("disabled", true);
						}
					}*/
					if(BlockYear ==1){
						alert('This Year and month is blocked! You are not allowed to Run Consolidation.');
						$('#final_ifrs').attr("disabled", true);
						$('#branch_ifrs').attr("disabled", true);
					}
				} else {
					console.log(res.data);
				}
			})
		}

		function getUpdateReportData() {
			let formData = new FormData();
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			formData.set("year", year);
			formData.set("month", month);
			app.request('getUpdateReportData', formData).then(res => {
				if (res.status === 200) {
					hide = [2, 3];
					loadHandSon(document.getElementById("ReportSheet"),
							res.data,
							["GL Number", "Total", "Year", "Month"], hide)
				} else {
					alert(res.message);
				}
			})
		}


		function loadData(div) {
			// $.LoadingOverlay("show");
			$('#excelDownload').hide();
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			let formData = new FormData();
			formData.set("year", year);
			formData.set("month", month);
			formData.set("update", true);
			app.request("getTotalData", formData).then(hData => {
				if (hData.status === 200) {
					$('#report_body').show();
					$("#ReportSheet").html("");
					$("#ASTAB").click();
					alert('Subsidiary Account Level Consolidation Done Successfully!');
					getDataFromDB('ReportSheet');
					// $.LoadingOverlay("hide");
				} else {
					// $.LoadingOverlay("hide");
					alert(hData.message);
				}
			}).catch((e) => {
				console.log(e)
			})


		}

		function getDataFromDB(div) {
			//$.LoadingOverlay("show");
			let formData = new FormData();
			formData.set("branch_id", 3);
			// app.request('getDataMain', formData).then(res => {
			getSumValueDB(div).then(hData => {
				if (hData.status === 200) {
					$.LoadingOverlay("hide");
					$('#report_body').show();
					$('#excelDownload').show();
					$("#" + div).html("");

					loadHandSon(document.getElementById(div),
							hData.data,
							hData.headers, hData.hideColumn
					);
				} else {
					$("#" + div).html("");
					$("#" + div).html("<center><h5>No Data Available</h5></center>");
					$.LoadingOverlay("hide");
				}
			})
			// })


		}

		function getFinalDataFromDB(div) {
			//$.LoadingOverlay("show");
			let formData = new FormData();
			formData.set("branch_id", 3);
			// app.request('getDataMain', formData).then(res => {
			getFinalSumValueDB(div).then(hData => {
				if (hData.status === 200) {
					$.LoadingOverlay("hide");
					$('#report_body').show();
					$('#excelDownload').show();
					$("#" + div).html("");

					loadHandSon(document.getElementById(div),
							hData.data,
							hData.headers, hData.hideColumn
					);
				} else {
					$("#" + div).html("");
					$("#" + div).html("<center><h5>No Data Available</h5></center>");
					$.LoadingOverlay("hide");
				}
			})
			// })


		}


		const button = document.querySelector('#excelDownload');

		function loadHandSon(element, columnRows, columnsHeader, hideColumn, type = "") {
			hotDiv = app.getHandSonTable(element, {
				data: columnRows,
				colHeaders: columnsHeader,
				hiddenColumns: {
					columns: hideColumn,
					copyPasteEnabled: false,
				},
				beforeCopy: (columnsHeader, coords) => {
					columnsHeader.splice(0, 1);

				}


			})
			hotDiv.validateCells();
			const exportPlugin = hotDiv.getPlugin('exportFile');

			button.addEventListener('click', () => {
				exportPlugin.downloadFile('csv', {
					bom: false,
					columnDelimiter: ',',
					columnHeaders: true,
					exportHiddenColumns: false,
					exportHiddenRows: true,
					fileExtension: 'csv',
					filename: 'ConsolidateReport-file_[YYYY]-[MM]-[DD]',
					mimeType: 'text/csv',
					rowDelimiter: '\r\n',
					rowHeaders: true
				});
			});
			if (type == 1) {
				saveData();
			}
		}

		function saveData() {
			$.LoadingOverlay("show");
			let reportData = hotDiv.getData();
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			let formData = new FormData();
			formData.set("data", JSON.stringify(reportData));
			formData.set("year", year);
			formData.set("month", month);
			app.request("saveConsolidationReport", formData).then(res => {
				$.LoadingOverlay("hide");
				//	window.location.href="view_consolidate_report";
			});
		}

		function saveDataFinal(div, id) {
			$.LoadingOverlay("show");
			if (id == 1) {
				var tableCons = 'consolidate_report_transaction';
				var tableSave = 'consolidate_report_all_data_ind';
				var tablemainAccount = 'main_account_setup_master';
			}
			if (id == 2) {
				var tableCons = 'consolidate_report_transaction_us';
				var tableSave = 'consolidate_report_all_data_us';
				var tablemainAccount = 'main_account_setup_master_us';
			}
			if (id == 3) {
				var tableCons = 'consolidate_report_transaction_ifrs';
				var tableSave = 'consolidate_report_all_data_ifrs';
				var tablemainAccount = 'main_account_setup_master_ifrs';
			}
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			let formData = new FormData();
			formData.set("year", year);
			formData.set("month", month);
			formData.set("tableSave", tableSave);
			formData.set("main_account_master", tablemainAccount);
			formData.set("tableConsolidate", tableCons);
			app.request("RunFinalConsolidation", formData).then(res => {
				if (res.status === 200) {
					alert(res.body);
					$.LoadingOverlay("hide");
					// setDerivedFormulaData();
				//	getFinalDataFromDB(div);
				} else {
					alert(res.body);
				}
			});
		}

		function getSumValue() {

		}

		function getSumValueDB(div) {
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			let formData = new FormData();
			formData.set("year", year);
			formData.set("month", month);
			formData.set("update", true);
			formData.set("div", div);
			return app.request("getTotalDataDB", formData)
		}

		function getFinalSumValueDB(div) {
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			let formData = new FormData();
			formData.set("year", year);
			formData.set("month", month);
			formData.set("div", div);
			return app.request("getFinalTotalDataDB", formData)
		}

		function view_bs(type) {
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			window.location.href = "BalanceSheet?month=" + month + "&year=" + year + "&type=" + type;
		}

		function view_pl(type) {
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			window.location.href = "PL?month=" + month + "&year=" + year + "&type=" + type;
		}

		function view_schedule(type) {
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			window.location.href = "scheduleView?month=" + month + "&year=" + year + "&type=" + type;
		}
		// To set Derived formula value
		function setDerivedFormulaData() {
			$.LoadingOverlay("show");
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			let formData = new FormData();
			formData.set("year", year);
			formData.set("month", month);
			app.request("setDerivedFormulaData", formData).then(res => {
				$.LoadingOverlay("hide");
				//	window.location.href="view_consolidate_report";
			});
		}
	</script>
</div>
