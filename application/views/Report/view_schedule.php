<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$branch_id = $this->session->userdata('branch_id');
$company_id = $this->session->userdata('company_id');
?>
<style type="text/css">
	.divBadge {
		border: 1px solid lightgrey;
		box-shadow: 0px 3px 2px 0px #fdeeee;
		margin-bottom: 5px;
	}
	@media print {
		@page { margin: 0; }
		body { margin: 1.6cm;}
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
							<h4 class="page-title">Schedule Report of <?php echo $month . " " . $year; ?></h4>
							<button class="btn btn-primary roundCornerBtn4" style="float: right" onclick="printDiv();">Print</button>
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
				<div class="row" id="report">
					<div class="row company_details">
						<div class="col-md-12 text-center">
							<h4 style="margin-bottom: 10px;"><?php echo $company; ?></h4>
							<h4>Schedule Report of <?php echo $month . " " . $year ?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 card-body" id="balanceSheet">

							<div>
								<h3>Schedule 1</h3>
								<div class="col-md-12">
									<div class="col-md-4">type 3</div>
									<div class="col-md-4">type 4</div>
									<div class="col-md-4 text-right">total</div>
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
</div>
<script type="text/javascript">
	$(document).ready(function () {
		getDataMainBalanceSheet();
	});

	function getDataMainBalanceSheet() {
		const urlParams = new URLSearchParams(window.location.search);
		$.LoadingOverlay("show");
		$("#balanceSheet").html('');
		const type = urlParams.get('type');
		var formdata = new FormData();
		formdata.set('type',type);
		app.request(baseURL + "getScheduleReportDataWithSequence", formdata).then(res => {
			var data = res.columnRows;
			var columns = Object.entries(data);
			console.log(columns);
			if (columns.length > 0) {

				scheduleView(columns, 'balanceSheet', 1);
			}

			$.LoadingOverlay("hide");
		});
	}

	function scheduleView(data, divId, type) {
		var template = ``;
		data.map(function (e, index) {

			let scheduleNO = ``;
			if (typeof e[0] !== 'undefined') {
				scheduleNO = `<b>Schedule ${e[0]}</b>`;
			}
			let childTemp = ``;
			if (typeof e[1] !== 'undefined') {

				var e = Object.entries(e[1]);

				e.map(function (el, ind) {
					let type3 = ``;
					if (typeof el[0] !== 'undefined') {
						type3 = ` ${el[0]}`;
					}
					childTemp += `<div class=""></div>
								<div class="col-md-12" style="margin-left: 20px;">
											<div class="col-md-2" title="${type3}"><b>${type3}</b></div>
											<div class="col-md-2"><b>Op</b></div>
											<div class="col-md-2"><b>Cr</b></div>
											<div class="col-md-2"><b>Dr</b></div>
											<div class="col-md-2"><b>Total</b></div>
										</div>`;
					if (typeof el[1] !== 'undefined') {
						var tcnt = 0;
						el[1].map(function (ele, i) {
							let type4 = ``;
							if (typeof ele[1] !== 'undefined') {
								type4 = `${ele[1]}`;
							}

							let credit = ``;
							if (typeof ele[4] !== 'undefined') {
								credit = `${ele[4]}`;
							}
							let debit = ``;
							if (typeof ele[5] !== 'undefined') {
								debit = `${ele[5]}`;
							}
							let opening_b = ``;
							if (typeof ele[6] !== 'undefined') {
								opening_b = `${ele[6]}`;
							}
							let total = ``;
							let totalValue = 0;
							if (typeof ele[7] !== 'undefined') {
								total = `${ele[7].toFixed().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
								totalValue = ele[7];
							}
							// console.log(tcnt);
							tcnt = ((tcnt * 1) + (totalValue * 1));
							childTemp += `<div class="col-md-12" style="font-size: 13px;">
											<div class="col-md-2" style="margin-left: 20px;" title="${type4}">${type4.substr(0, 25)}</div>
											<div class="col-md-2">${opening_b}</div>
											<div class="col-md-2">${credit}</div>
											<div class="col-md-2">${debit}</div>
											<div class="col-md-2"><b>${total}</b></div>
										</div>`;


						});
					}
					childTemp += `<div class="col-md-12" style="margin-left: 20px;">
											<div class="col-md-2" style="border-top: 1px solid lightgrey;"><b>Total</b></div>
											<div class="col-md-2" style="border-top: 1px solid lightgrey;"></div>
											<div class="col-md-2" style="border-top: 1px solid lightgrey;"></div>
											<div class="col-md-2" style="border-top: 1px solid lightgrey;"></div>
											<div class="col-md-2" style="border-top: 1px solid lightgrey;"><b>${tcnt.toFixed().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</b></div>
										</div>`;

				});
			}
			var randomColor = generateRandomColor();
			template += `<div class="col-md-12 divBadge">
							<div class="col-md-12" style="display:flex;">
								<div class="" style="color:${randomColor};font-size: 16px;width:120px;">${scheduleNO} - </div>
								<div class="col-md-11" style="padding-top:3px;font-size: 14px;">
									
									${childTemp}
								</div>
							</div>
								 
								 
							</div>`;
			// console.log(ele[0]);
		})
		$("#balanceSheet").append(template);
	}

	function generateRandomColor() {
		var letters = '0123456789ABCDEF';
		var color = '#';
		for (var i = 0; i < 6; i++) {
			color += letters[Math.floor(Math.random() * 14)];
		}
		return color;
	}


	function printDiv() {
		var printContents = document.getElementById('report').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;

	}
</script>
