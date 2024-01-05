<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Currency Details</h4>
							<!-- <button class="btn btn-icon btn-primary" style="float: right" data-toggle="modal"
									data-target="#fire-modal-company" data-id="0" onclick="openModal()" id="companyFormButton"><i
									class="fa fa-plus"></i></button> -->
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row card-box">
		<form id="formCurrencyConversion" method="post" data-form-valid="saveCurrencyConversion">

		<div class="col-lg-4">
			<div class="" style="">
				<select name="year" id="year" class="form-control year">
					<option value="">Please select Year</option>
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
		<div class="col-lg-4">
			<div class="" style="">
				<select name="month" id="month" class="form-control month">
					<option value="">Please select Month</option>
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
		<div class="col-lg-4">
			<div class="" style="">
				<button class="btn btn-primary mr-1 roundCornerBtn4" type="submit" >Submit</button>
			</div>
		</div>
		</form>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card-box" style="">
				<table class="table table-striped" id="currencyTableDT" >
					<thead>
					<tr>
						<td>#</td>
						<td>Month</td>
						<td>Year</td>
						<td>Action</td>
					</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>

		<input type="hidden" id="cc_id" name="cc_id" value="">
<!--		 <div class="col-lg-12" style="background-color: white;">-->
<!--			<div class="">-->
<!--				<div class="col-md-12" id="example" style="margin: 50px;"></div>-->
<!--				<button class="btn btn-primary" style="display: none" onclick="saveExcelData()">Save</button>-->
<!--			</div>-->
<!--		</div>-->
	</div>
</div>

<?php $this->load->view('Admin/currency/currency_form'); ?>
</div>
<?php $this->load->view('_partials/footer'); ?>
<script src="<?=base_url();?>assets/js/module/currency/currency.js" type="text/javascript"></script>
<script>
	const base_URL ='<?= base_url() ?>';
</script>
<script>
	$( document ).ready(function() {
	$.LoadingOverlay("show");
		getCurrencyList();
		getListBranch();
		getCurrency();
		getDataMain();
		getCurrencyListDT();

	});
</script>
</div>
