<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Financial Data</h4>
							<input type="hidden" name="insertID" id="insertID" value="<?php echo $id; ?>">
							<input type="hidden" name="branchID" id="branchID">
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="financialFormRow" style="">
		<div class="col-lg-12">
			<div class="card-box">
				<form method="post" id="exportexcelsheet">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label>Select Year</label>
									<select name="year" id="year" class="form-control">
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
							<div class="col-md-6">
								<div class="form-group">
									<label>Select Month</label>
									<select name="month" id="month" class="form-control">
										<option disabled selected>select month</option>
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
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<button type="button" onclick="getPdfData()" class="btn btn-primary" style="margin-top: 27px;">Create Pdf
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top: 50px;">
		<div class="col-md-12">
			<button class="btn btn-danger" type="button" style="float: right;" id="printButton" onclick="print_div()">Make Pdf
			</button>
		</div>
		
		<div class="pdfDiv" id="pdfDiv">
			
		</div>
		
			<div id="piechart" style="page-break-inside: avoid;">
			<div id="graph_head" class="text-center" style="padding-bottom:20px;"></div>
		</div>
	</div>
	
	
</div>



<?php $this->load->view('_partials/footer'); ?>



<script src="<?php echo base_url(); ?>assets/js/module/reportMaker/report_maker.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
	$(document).ready(function () {
	google.charts.load("visualization", "1", {packages:["corechart"]});
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
	let graphArray=[];
	
		function getPdfData()
		{
			$("#printButton").hide();
			var form=document.getElementById('exportexcelsheet');
			var formData = new FormData(form);
			formData.set('template_id',$("#insertID").val());
			// console.log(formData);
			$.ajax({
				url: base_url + "createReportMonthPdf",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					if (result.status === 200) {
						$("#printButton").show();
						$("#pdfDiv").html(result.body);
						
						// google.setOnLoadCallback(drawChart);
						graphArray=result.graphArray;
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
					// $.LoadingOverlay("hide");
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
		function print_div() {
			
			let divName=".pdfDiv";
			// $('#printButton').toggleClass('d-none');
			var printContents = document.querySelector(divName).innerHTML;

			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
			// $('#printButton').toggleClass('d-none');
		}
	function drawChart()
  	{
  		graphArray.map(function(e){
					let category1=e.cat;
					let value1=e.val;
					let divId1=e.id;
					console.log(category1);
					let data = new google.visualization.DataTable();
			  		data.addColumn('string', 'Category');
					data.addColumn('number', 'Values');
					let float_var=[];
					value1.forEach(v=>{
						float_var.push(parseFloat(v));
					});
					category1.forEach((c,i)=>{
						data.addRows([[c, float_var[i]]]);
					});
					let options = {
					 title : 'test graph',
					 hAxis: {title: "Category"},
					vAxis: {title: "values"},
					 chartArea:{left:'20%',top:'10%',width:'80%',height:'50%',padding:'10px'}
					};
					
					let chart_area = document.getElementById(divId1);
					if (typeof(chart_area) != 'undefined' && chart_area != null)
					{
						let chart = new google.visualization.ColumnChart(chart_area);
						google.visualization.events.addListener(chart, 'ready', function(){
						 chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
						});
						chart.draw(data, options);
					}
				});
  		
		

     			
					
   	}
</script>

