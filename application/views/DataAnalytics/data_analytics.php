<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	.type1{
		padding: 10px;
		border: 1px solid #34d3eb40;
		background-color: #34d3eb40;
		color: black;
	}
	.type2{
		padding: 10px;
		border: 1px solid #34d3eb40;
		background-color: #34d3eb0f;
		color: black;
		/*padding-left: 30px;*/
	}
	.type3{
		padding: 10px;
		border: 1px solid #34d3eb40;
		background-color: white;
		color: black;
		/*padding-left: 60px;*/
	}
	.rightValue
	{
		float: right;
	}
	.plusButton
	{
		padding: 0px 5px!important;
	}
	.valueButton
	{
		background-color: #f3fcfe!important;
		color: #34d3eb!important;
		padding: 0px 5px!important;
		float: right;
	}
	.glTransaction
	{    padding: 5px;
		border: 1px solid #ccf4fa;
		/*padding-left: 60px;*/
	}
	.tableDiv
	{
		padding: 10px;
	}

</style>
<style>


	#DataAnaylyticsDiv table {
		border-collapse: collapse;
		font-family: helvetica;
		caption-side: top;
		text-transform: capitalize;
	}
	#DataAnaylyticsDiv caption {
		text-align: left; position: fixed; left: 0; top:0
	}
	#DataAnaylyticsDiv td, #DataAnaylyticsDiv th {
		border:  1px solid #ccf4fa;
		padding: 10px;
		min-width: 200px;
		background: white;
		box-sizing: border-box;
		text-align: left;
	}

	#DataAnaylyticsDiv th {
		box-shadow: 0 0 0 1px black;
	}
	#DataAnaylyticsDiv .table-container {
		position: relative;
		max-height:  70vh;
		width: 100%;
		overflow: scroll;
	}

	#DataAnaylyticsDiv thead th,
	#DataAnaylyticsDiv tfoot th {
		position: -webkit-sticky;
		position: sticky;
		top: 0;
		z-index: 2;
		/*background: hsl(20, 50%, 70%);*/
	}

	#DataAnaylyticsDiv thead th:first-child,
	#DataAnaylyticsDiv tfoot th:first-child {
		left: 0;
		z-index: 3;
	}

	#DataAnaylyticsDiv tfoot {
		position: -webkit-sticky;
		bottom: 0;
		z-index: 2;
	}

	#DataAnaylyticsDiv tfoot th {
		position: sticky;
		bottom: 0;
		z-index: 2;
		background: hsl(20, 50%, 70%);
	}

	#DataAnaylyticsDiv tfoot td:first-child {
		z-index: 3;
	}

	#DataAnaylyticsDiv tbody {
		overflow: scroll;
		height: 200px;
	}

	/* MAKE LEFT COLUMN FIXEZ */
	#DataAnaylyticsDiv tr > :first-child {
		position: -webkit-sticky;
		position: sticky;
		/*background: hsl(180, 50%, 70%);*/
		left: 0;
	}
	/* don't do this */
	#DataAnaylyticsDiv tr > :first-child {
		/*box-shadow: inset 0px 1px black;*/
	}


	.first_th
	{
		background-color: white!important;
	}
	.type1
	{
		background-color: #ccf4fa!important;
	}
	.type2
	{
		background-color: #f3fcfe!important;
		font-size: 13px!important;
	}
	.type3{
		font-size: 11px!important;
	}
	.glTr
	{
		padding-left: 40px!important;
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
		border-right: 1px solid #80808029;
	}

	.nav-item {
		width: 150px;
		text-align: center;
	}
	.glDetail
	{
		font-size: 10px;
		font-weight: 700;
	}
	.type3value
	{
		font-weight: 700;
	}
	#TransferDataTable thead th,
	#TransferDataTable tfoot th {
		position: -webkit-sticky;
		position: sticky;
		top: 0;
		z-index: 2;
		background-color: white;
	}
	#TransferDataTable .table-container {
		position: relative;
		max-height:  70vh;
		width: 100%;
		overflow: scroll;
	}
	#TransferDataTable tfoot {
		position: -webkit-sticky;
		bottom: 0;
		z-index: 2;
	}

	#TransferDataTable tfoot th {
		position: sticky;
		bottom: 0;
		z-index: 2;
		background-color: white;
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
							<h4 class="page-title">Data Analytics</h4>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="DataAnaylyticsDiv">
		<input type="hidden" id="analyticType" value="BS">
		<div class="col-lg-12">
			<div class="card-box">
				<div class="row m-b-5">
					<form id="DataAnaylytics" method="post" data-form-valid="">
						<div class="col-lg-3">
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
						<div class="col-lg-3">
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
						<div class="col-lg-2">
							<div class="" style="">
								<button class="btn btn-primary mr-1 roundCornerBtn4" type="button" onclick="getDataAnalyticsData()" >Submit</button>
							</div>
						</div>
					</form>

				</div>

				<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
					<li class="nav-item match active" role="presentation">
						<a data-toggle="tab" href="#BS" class="nav-link active" role="tab"
						   aria-selected="true" aria-expanded="true" onclick="getAnalyticalTab('BS')">Balance Sheet</a>
					</li>
					<li class="nav-item unmatch" role="presentation">
						<a data-toggle="tab" href="#PL" class="nav-link" role="tab"
						   aria-selected="false" aria-expanded="false" onclick="getAnalyticalTab('PL')">Profit & Loss</a>
					</li>
					<li class="nav-item unmatch" role="presentation">
						<a data-toggle="tab" href="#TD" class="nav-link" role="tab"
						   aria-selected="false" aria-expanded="false" onclick="getAnalyticalTab('TD')">Transfer</a>
					</li>

					<div class="col-lg-3" style="float: right;">
						<select name="valueIn" id="valueIn" class="form-control" onchange="getDataAnalyticsData()">
							<option value="1">Original Value</option>
							<option value="2">Millions</option>
							<option value="3">Crores</option>
						</select>
					</div>
					<div class="col-lg-1 text-right text-dark"  style="float: right;"><label for="">Values In</label></div>
				</ul>

				<div class="tab-content">

					<div class="tab-pane active" id="BS">
						<div class="row">

							<div class="table-container" id="bsTable">


							</div>
						</div>
					</div>
					<div class="tab-pane " id="PL">
						<div class="row">
							<div class="table-container" id="plTable">


							</div>
						</div>
					</div>
					<div class="tab-pane " id="TD">
						<div class="row">
							<div class="table-container" id="tdTable">


							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>

</div>
<!--transaction modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="dataAnalyticTransaction"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Gl Account Transaction Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<div class="row">
					<div class="col-md-6"><b>Subsidiary</b>  -  <span class="branchname"></span>
						<input type="hidden" id="bsPlBranchId"><input type="hidden" id="bsPlBranchName"></div>

					<div class="col-md-6"><b>Gl Number</b> - <span class="glNumber"></span>
						<input type="hidden" id="bsPlGlNumber"></div>
				</div>
			</div>

				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
								<li class="nav-item match active" role="presentation">
									<a data-toggle="tab" href="#UploadFinancialdata" class="nav-link active" role="tab"
									   aria-selected="true" aria-expanded="true" onclick="showTransactionDataTab('tansaction1')">Uploaded Financial Data</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#scheduleData" class="nav-link" role="tab"
									   aria-selected="false" aria-expanded="false" onclick="showTransactionDataTab('tansaction2')">Schedule Data</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#transferData" class="nav-link" role="tab"
									   aria-selected="false" aria-expanded="false" onclick="showTransactionDataTab('tansaction3')">Transfer Data</a>
								</li>
							</ul>
							<input type="hidden" id="transactionTabOpen" value="tansaction1">
							<div class="tab-content">

								<div class="tab-pane active" id="UploadFinancialdata">
									<div class="row table-responsive">
										<table class="table table-striped" id="UploadationDataTable" width="100%">
										<thead>
										<tr>
											<td>#</td>
											<td>Gl No.</td>
											<td>Opening Balance</td>
											<td>Debit</td>
											<td>Credit</td>
											<td>Total</td>
											<td>Month</td>
											<td>Year</td>
										</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
									</div>
								</div>
								<div class="tab-pane" id="scheduleData">
									<div class="row table-responsive">
										<table class="table table-striped" id="scheduleDataTable" width="100%">
											<thead>
											<tr>
												<td>#</td>
												<td>Template</td>
												<td>Particulars</td>
												<td>Gl No.</td>
												<td>Amount (INR)</td>
											</tr>
											</thead>
											<tbody>

											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="transferData">
									<div class="row table-responsive">
<!--										<table class="table table-striped" id="TransferBSPLDataTable" width="100%">-->
<!--										<thead>-->
<!--										<tr>-->
<!--											<td>#</td>-->
<!--											<td>From Branch</td>-->
<!--											<td>From Gl No.</td>-->
<!--											<td>To Branch</td>-->
<!--											<td>To Gl No.</td>-->
<!--											<td>Total</td>-->
<!--											<td>Month</td>-->
<!--											<td>Year</td>-->
<!--										</tr>-->
<!--										</thead>-->
<!--										<tbody>-->
<!---->
<!--										</tbody>-->
<!--									</table>-->
										<table class="table" id="TransferBSPLDataTable" width="100%">
											<thead>
											<tr>
												<th class="first_th">Subsidiary</th>
												<th>Gl No.</th>
												<th>Amount (INR)</th>
											</tr>
											</thead>
											<tbody id="TransferBSPLDataTableBody">

											</tbody>
											<tfoot>
											<tr>
												<th></th>
												<th><b>Total</b></th>
												<th id="total_amt_body"></th>
											</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>





						</div>
					</div>
				</div>

		</div>
	</div>
</div>
<!--Transfer transaction modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="dataAnalyticTransferTransaction"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Transfer Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<div class="row">
					<div class="col-md-6"><b>Subsidiary</b>  -  <span class="branchname"></span>
						<input type="hidden" id="transferBranchId"><input type="hidden" id="transferBranchName"></div>

					<div class="col-md-6"><b>Gl Number</b> - <span class="glNumber"></span>
						<input type="hidden" id="transferGlNumber"></div>
				</div>

				<div class="modal-body py-0" style="background-color: white;">

					<div class="card my-0 shadow-none">
						<div class="card-body">
									<div class="row table-responsive table-container" style="height: 70vh;">
										<table class="table" id="TransferDataTable" width="100%">
										<thead>
										<tr>
											<th class="first_th">Subsidiary</th>
											<th>Gl No.</th>
											<th>Amount (INR)</th>
										</tr>
										</thead>
										<tbody id="TransferDataTableBody">

										</tbody>
											<tfoot>
											<tr>
												<th></th>
												<th><b>Total</b></th>
												<th id="total_amt"></th>
											</tr>
											</tfoot>
									</table>
									</div>
						</div>
					</div>
				</div>

		</div>
	</div>
</div>

<?php $this->load->view('_partials/footer'); ?>
<script>var base_url = '<?=base_url();?>'</script>
<script src="<?=base_url();?>assets/js/module/DataAnalytics/data_analytics.js" type="text/javascript"></script>
</div>
