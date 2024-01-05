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
</style>
<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Consolidate Report</h4>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Year</label>
										<select name="year" id="year" class="form-control year">
											<option disabled="" selected="">Select year</option>
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
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Month</label>
										<select name="quarter" id="quarter" class="form-control month">
											<option disabled="" selected="">Select month</option>
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
								<div class="col-md-4">
									<div class="form-group">
										<button class="btn btn-primary roundCornerBtn4" style="margin-top: 27px;" onclick="loadData();">
											Save
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="card-box" id="report_body" style="border: none;display: none">
<!--								<button class="btn btn-primary" type="button" style="margin: 10px;" onclick="saveData();">-->
<!--									save-->
<!--								</button>-->
<!--								<div id="ReportSheet">-->
<!--								</div>-->
									<ul class="nav nav-tabs nav-justified m-b-20" id="ex1" role="tablist">
										<li class="nav-item match active" role="presentation">
											<a data-toggle="tab" href="#AS" id="ASTAB" class="nav-link active" role="tab"
											   aria-selected="true" aria-expanded="true" >INDIAN
												AS</a>
										</li>
										<li class="nav-item unmatch" role="presentation">
											<a data-toggle="tab" href="#US" class="nav-link" role="tab" aria-selected="false"
											   aria-expanded="false" >US GAAP</a>
										</li>
										<li class="nav-item unmatch" role="presentation">
											<a data-toggle="tab" href="#IFRS" class="nav-link" role="tab" aria-selected="false"
											   aria-expanded="false">IFRS</a>
										</li>
									</ul>
									<div class="tab-content" style="padding:0;">
										<div class="tab-pane active" id="AS">
											<div id="ReportSheet"></div>
										</div>
										<div class="tab-pane" id="US">

											<div id="ReportSheetUS"></div>
										</div>
										<div class="tab-pane" id="IFRS">
											<div id="ReportSheetIFRS"></div>
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
<?php $this->load->view('_partials/footer'); ?>
<script>


	function loadData() {
		//$('#report_body').show();
		$.LoadingOverlay("show");
		var year = $("#year").val();
		var quarter = $("#quarter").val();
		let formData = new FormData();
		formData.set("branch_id", 3);
		formData.set("year", year);
		formData.set("month", quarter);
		app.request('getTotalData', formData).then(res => {
			if (res.status === 200){
				$.LoadingOverlay("hide");
				window.location.href ='view_consolidate_report';

				/*getSumValue().then(hData => {
					if(hData.status === 200){
						$('#report_body').show();
						loadHandSon(document.getElementById("ReportSheet"),
								hData.data,
								hData.headers,hData.hideColumn
						);
						loadHandSon(document.getElementById("ReportSheetUS"),
								hData.data_us,
								hData.headers,hData.hideColumn
						);
						loadHandSon(document.getElementById("ReportSheetIFRS"),
								hData.data_ifrs,
								hData.headers,hData.hideColumn
						);

						// saveData(hData.data,hData.data_us,hData.data_ifrs);
					}else
					{
						$.LoadingOverlay("hide");
						alert(hData.message);
					}
				})*/
			}else{
				$.LoadingOverlay("hide");
				alert(res.message);
			}

		})


	}

	let hotDiv;

	function loadHandSon(element, columnRows, columnsHeader,hideColumn) {
	//	console.log(hideColumn);

		hotDiv = app.getHandSonTable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			hiddenColumns: {
				columns: hideColumn,
				copyPasteEnabled: false,
			}
		})
		hotDiv.validateCells();
	}

	// function saveData(ind,us,ifrs) {
	// 	$.LoadingOverlay("show");
	// 	let reportData = hotDiv.getData();
	// 	let year = $('#year').val();
	// 	let month = $('#quarter').val();
	// 	let formData = new FormData();
	// 	formData.set('india',ind);
	// 	formData.set('us',us);
	// 	formData.set('ifrs',ifrs);
	// 	formData.set("data", JSON.stringify(reportData));
	// 	formData.set("year", year);
	// 	formData.set("month", month);
	// 	app.request("saveConsolidationReport", formData).then(res => {
	// 		$.LoadingOverlay("hide");
	// 			// window.location.href="view_consolidate_report";
	// 	});
	//
	// }

	function getSumValue() {
		let year = $('#year').val();
		let month = $('#quarter').val();
		let formData = new FormData();
		formData.set("year", year);
		formData.set("month", month);
		return app.request("getTotalData", formData)
	}

	function getDataFromDB(div) {
		$.LoadingOverlay("show");
		let formData = new FormData();
		formData.set("branch_id", 3);
		app.request('getDataMain', formData).then(res => {
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
		});

	}

	function getSumValueDB(div) {
		let year = $('#year').val();
		let month = $('#quarter').val();
		let formData = new FormData();
		formData.set("year", year);
		formData.set("month", month);
		formData.set("update", true);
		formData.set("div", div);
		return app.request("getTotalDataDB", formData)
	}
</script>
</div>
