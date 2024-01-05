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
		width: 220px;
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
							<h4 class="page-title">Consolidate Report of <?php echo $month . " " . $year; ?></h4>
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
					<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
						<li class="nav-item match active" role="presentation">
							<a data-toggle="tab" href="#final_level" class="nav-link active" role="tab"
							   aria-selected="true" aria-expanded="true">Final Level Consolidation</a>
						</li>
						<li class="nav-item unmatch" role="presentation">
							<a data-toggle="tab" href="#branch_level" class="nav-link" role="tab"
							   aria-selected="false" onclick="getDataFromDB('ReportSheet');" aria-expanded="false">Branch Level Consolidation</a>
						</li>
					</ul>

					<div class="tab-content" style="padding:0;">
						<div class="tab-pane active" id="final_level">
							<ul class="nav nav-tabs nav-justified m-b-20" id="ex1" role="tablist">
								<li class="nav-item match active" role="presentation">
									<a data-toggle="tab" href="#FAS" id="FASTAB" class="nav-link active" role="tab"
									   aria-selected="true" aria-expanded="true" onclick="getFinalDataFromDB('FinalReportSheetIND');">INDIAN
										GAAP</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#FUS" class="nav-link" role="tab" aria-selected="false"
									   aria-expanded="false" onclick="getFinalDataFromDB('FinalReportSheetUS');">US GAAP</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#IFFRS" class="nav-link" role="tab" aria-selected="false"
									   aria-expanded="false" onclick="getFinalDataFromDB('FinalReportSheetIFRS');">IFRS</a>
								</li>
							</ul>
							<div class="tab-content" style="padding:0;">

								<div class="tab-pane active" id="FAS">
									<button class="btn btn-primary btn-sm" style="margin-left:10px;float: right;margin-bottom: 10px;"
											onclick="saveDataFinal('FinalReportSheetIND',1);">
										Run to get Final Level Consolidation
									</button>

									<div id="FinalReportSheetIND"  ></div>
								</div>
								<div class="tab-pane" id="US">
									<button class="btn btn-primary btn-sm " style="margin-left:10px;float: right"
											onclick="saveDataFinal('FinalReportSheetUS',2);">
										Run to get Final Level Consolidation
									</button>
								</div>
								<div class="tab-pane" id="IFRS">
									<button class="btn btn-primary btn-sm" style="margin-left:10px;float: right"
											onclick="saveDataFinal('FinalReportSheetIFRS',3);">
										Run to get Final Level Consolidation
									</button>
								</div>
							</div>

						</div>
						<div class="tab-pane" id="branch_level">
							<ul class="nav nav-tabs nav-justified m-b-20" id="ex1" role="tablist">
								<li class="nav-item match active" role="presentation">
									<a data-toggle="tab" href="#branch_as" id="ASTAB" class="nav-link active" role="tab"
									   aria-selected="true" aria-expanded="true">INDIAN
										GAAP</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#branch_us" class="nav-link" role="tab" aria-selected="false"
									   aria-expanded="false">US GAAP</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#branch_ifrs" class="nav-link" role="tab" aria-selected="false"
									   aria-expanded="false">IFRS</a>
								</li>
							</ul>
							<div class="tab-content" style="padding:0;">
								<div class="tab-pane active" id="branch_as">
									<button class="btn btn-primary btn-sm" style="margin-left:10px;float: right"
											onclick="loadData('ReportSheet');">
										Run to get Updated Sheet
									</button>
									<button id="excelDownload" type="button" class="btn btn-link" style="float: right"><i
											class="fa fa-download" style="font-size: 18px"></i></button>
									<!--									<div class="form-group" style="padding-bottom: 30px;">-->
									<!--										<button class="btn btn-primary btn-sm" style="margin-left:10px;float: right"-->
									<!--												onclick="view_bs(1);">-->
									<!--											View Balance Sheet-->
									<!--										</button>-->
									<!--										<button class="btn btn-primary btn-sm" style="float: right" onclick="view_pl(1);">-->
									<!--											View P&L-->
									<!--										</button>-->
									<!--										<button class="btn btn-primary btn-sm" style="margin-right:10px;float: right"-->
									<!--												onclick="view_schedule(1);">-->
									<!--											View Schedule-->
									<!--										</button>-->
									<!--									</div>-->
									<div id="ReportSheet"></div>
								</div>
								<div class="tab-pane" id="branch_us">
									<button class="btn btn-primary btn-sm" style="margin-left:10px;float: right"
											onclick="loadData('ReportSheet');">
										Run to get Updated Sheet
									</button>
									<button id="excelDownload" type="button" class="btn btn-link" style="float: right"><i
											class="fa fa-download" style="font-size: 18px"></i></button>
									<!--									<div class="form-group" style="padding-bottom: 30px;">-->
									<!--										<button class="btn btn-primary btn-sm" style="margin-left:10px;float: right"-->
									<!--												onclick="view_bs(2);">-->
									<!--											View Balance Sheet-->
									<!--										</button>-->
									<!--										<button class="btn btn-primary btn-sm" style="float: right" onclick="view_pl(2);">-->
									<!--											View P&L-->
									<!--										</button>-->
									<!--										<button class="btn btn-primary btn-sm" style="margin-right:10px;float: right"-->
									<!--												onclick="view_schedule(2);">-->
									<!--											View Schedule-->
									<!--										</button>-->
									<!--									</div>-->
									<div id="ReportSheetUS"></div>
								</div>
								<div class="tab-pane" id="branch_ifrs">
									<button class="btn btn-primary btn-sm" style="margin-left:10px;float: right"
											onclick="loadData('ReportSheet');">
										Run to get Updated Sheet
									</button>
									<button id="excelDownload" type="button" class="btn btn-link" style="float: right"><i
											class="fa fa-download" style="font-size: 18px"></i></button>
									<!--									<div class="form-group" style="padding-bottom: 30px;">-->
									<!--										<button class="btn btn-primary btn-sm" style="margin-left:10px;float: right"-->
									<!--												onclick="view_bs(3);">-->
									<!--											View Balance Sheet-->
									<!--										</button>-->
									<!--										<button class="btn btn-primary btn-sm" style="float: right" onclick="view_pl(3);">-->
									<!--											View P&L-->
									<!--										</button>-->
									<!--										<button class="btn btn-primary btn-sm" style="margin-right:10px;float: right"-->
									<!--												onclick="view_schedule(3);">-->
									<!--											View Schedule-->
									<!--										</button>-->
									<!--									</div>-->
									<div id="ReportSheetIFRS"></div>
								</div>
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
			getDataFromDB('ReportSheet');
			getFinalDataFromDB('FinalReportSheetIND');
		});

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
			$.LoadingOverlay("show");
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
					$.LoadingOverlay("hide");
				} else {
					$.LoadingOverlay("hide");
					alert("Something Went Wrong");
				}

			}).catch((e)=>{
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
			console.log(element);
			hotDiv = app.getHandSonTable(element, {
				data: columnRows,
				colHeaders: columnsHeader,
				hiddenColumns: {
					columns: hideColumn
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
		function saveDataFinal(div,id) {
			$.LoadingOverlay("show");
			if(id == 1){
				var tableCons='consolidate_report_transaction';
				var tableSave='consolidate_report_all_data_ind';
				var tablemainAccount='main_account_setup_master';
			}
			if(id==2){
				var tableCons='consolidate_report_transaction_us';
				var tableSave='consolidate_report_all_data_us';
				var tablemainAccount='main_account_setup_master_us';
			}
			if(id==3){
				var tableCons='consolidate_report_transaction_ifrs';
				var tableSave='consolidate_report_all_data_ifrs';
				var tablemainAccount='main_account_setup_master_ifrs';
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
					getFinalDataFromDB(div);
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
			window.location.href = "BalanceSheet?month=" + month + "&year=" + year + "&type=" +type;
		}

		function view_pl(type) {
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			window.location.href = "PL?month=" + month + "&year=" + year + "&type=" +type;
		}

		function view_schedule(type) {
			const urlParams = new URLSearchParams(window.location.search);
			const year = urlParams.get('year');
			const month = urlParams.get('month');
			window.location.href = "scheduleView?month=" + month + "&year=" + year + "&type=" +type ;
		}
	</script>
</div>
