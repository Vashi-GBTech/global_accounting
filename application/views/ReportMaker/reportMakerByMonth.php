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
							<input type="hidden" name="branchID" id="branchID">
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
									<select name="year" id="year" onchange="getYearConsolidatedMonth(this.value)" class="form-control">
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
									<select name="month" id="month" class="form-control">
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
									<label>Select Amount Type</label>
									<select name="amount_type" id="amount_type" class="form-control">
										<option value="1">Local</option>
										<option value="2">In Rupees</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<button type="button" onclick="getPdfData()" class="btn btn-primary roundCornerBtn4"
										style="margin-top: 27px;">View Report
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top: 50px;">
		<div class="col-md-12 text-right">
			<!-- <input type="radio" name="pageSize" value="portrait" checked> Portrait <input type="radio" name="pageSize"
																						  value="landscape"> LandScape -->
			<button class="btn btn-danger" type="button" style="float: right;margin: 0px 10px;display: none;" id="printButton"
					onclick="print_div()">Make Word
			</button>
		</div>

		<div class="col-md-12 pdfDiv bg-white" id="pdfDiv"
			 style="margin: 1rem auto; width: 595.3pt; height:841.9pt;border: solid 2px #2c2c2c;padding:8px;
			  margin:0 25%;overflow-y: auto;overflow-x: hidden;border-radius:2px">

		</div>


	</div>
</div>


</div>


<?php $this->load->view('_partials/footer'); ?>


<script src="<?= base_url("assets/js/FileSaver.js") ?> "></script>
<script src="<?= base_url("assets/js/jquery.wordexport.js") ?> "></script>
<script src="<?php echo base_url(); ?>assets/js/module/reportMaker/report_maker.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
	$(document).ready(function () {
		google.charts.load("visualization", "1", {packages: ["corechart"]});
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

	function getPdfData() {
		$.LoadingOverlay("show");
		$("#printButton").hide();
		var form = document.getElementById('exportexcelsheet');
		var formData = new FormData(form);
		formData.set('template_id', $("#insertID").val());
		// console.log(formData);
		$.ajax({
			url: base_url + "createReportMonthPdf",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {
					$("#printButton").show();
					$("#pdfDiv").html(result.body);

					// google.setOnLoadCallback(drawChart);
					graphArray = result.graphArray;
					// graphArray.map(function(e){
					// 	// drawChart(e.cat,e.val,e.id);
					// 	category1=e.cat;
					// 	value1=e.val;
					// 	divId1=e.id;
					// 	google.charts.setOnLoadCallback(drawChart);
					// });
					google.charts.setOnLoadCallback(drawChart);

				} else {
					toastr.error(result.body);
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				toastr.error("Something went wrong please try again");
			}

		});
	}
	function getYearConsolidatedMonth(year) {
		var formData = new FormData();
		formData.set('template_id', $("#insertID").val());
		formData.set('year', year);
		$.ajax({
			url: base_url + "getConsolidatedMonth",
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
					$("#branch").prepend('<option value="All" selected>All</option>');
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
</script>

