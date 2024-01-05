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
								<button class="btn btn-link "><a href="<?php base_url(); ?> derivedAccountSetup"><i class="fa fa-arrow-left"></i></a></button>
								<h4 class="">Derived Report of <?php echo $month . " " . $year; ?></h4>
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
<!--						<li class="nav-item unmatch" role="presentation">-->
<!--							<a data-toggle="tab" href="#FUS" class="nav-link" role="tab" aria-selected="false"-->
<!--							   aria-expanded="false" onclick="getFinalDataFromDB('FinalReportSheetUS');getErrorLog(2);">US GAAP</a>-->
<!--						</li>-->
<!--						<li class="nav-item unmatch" role="presentation">-->
<!--							<a data-toggle="tab" href="#IFFRS" class="nav-link" role="tab" aria-selected="false"-->
<!--							   aria-expanded="false" onclick="getFinalDataFromDB('FinalReportSheetIFRS');getErrorLog(3);">IFRS</a>-->
<!--						</li>-->
					</ul>
					<div class="tab-content" style="padding:0;">
						<div class="tab-pane active" id="FAS">

						<div class="tab-pane " id="FUS">

							<button id="excelDownload" type="button" class="btn btn-primary" style="float: right">
								Download <i class="fa fa-download" style="font-size: 18px"></i></button>

							<div class="" id="derviedTable"></div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('_partials/footer'); ?>
	<script>
		$(document).ready(function () {
			getDataFromDB('derviedTable');
			//	getFinalDataFromDB('FinalReportSheetIND');
		});

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
			return app.request("getTotalDerivedFormulaReport", formData)
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
	</script>
</div>
