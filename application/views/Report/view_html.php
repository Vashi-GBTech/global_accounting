<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$branch_id = $this->session->userdata('branch_id');
$company_id = $this->session->userdata('company_id');
?>
<style>
	.printtable{
		border: 1px solid #0000001a;
		width: 60%;
	}
	.table{
		page-break-before: always;
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
							<h4 class="page-title">Consolidate Report of <?php echo $month." ".$year;?></h4>
							<button class="btn btn-primary roundCornerBtn4" onclick="printDiv()" style="float: right">Print</button>
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
				<div class="row" id="BalanceSheet">
				</div>
			</div>
		</div>
	</div>
</div>


</div>
<?php $this->load->view('_partials/footer'); ?>
</div>
<script>var base_url = '<?=base_url()?>'</script>
<script>
	$(document).ready(function () {
		getBalanceSheet();
	});

	function getBalanceSheet() {
		$.LoadingOverlay("show");
		const urlParams = new URLSearchParams(window.location.search);
		const year = urlParams.get('year');
		const month = urlParams.get('month');
		const type = urlParams.get('type');
		var formdata = new FormData();
		formdata.set('year',year);
		formdata.set('month',month);
		formdata.set('type',type);
		app.request(base_url + "BalanceSheetData", formdata).then(res => {
			if (res.status == 200) {
				$.LoadingOverlay("hide");
				$('#BalanceSheet').append(res.data);
			} else {
				toastr.error(res.body);
			}
		});
	}
	function printDiv() {
		var printContents = document.getElementById('BalanceSheet').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
</script>
