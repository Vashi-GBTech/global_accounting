<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	.nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover {
		border-bottom-color: #fff;
		background-color: #f7e3ad;
		color: black;
		text-shadow: 0px 4px 5px #00000055!important;
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
							<h4 class="page-title">Year Details</h4>
							
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		<div class="row" id="blockFormRow" >
			<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
				<li class="nav-item match active" role="presentation">
					<a
							data-toggle="tab" href="#blockyear"
							class="nav-link active"
							role="tab"
							aria-selected="true" onclick="getBlockList()">Block Year</a>
				</li>
				<li class="nav-item unmatch" role="presentation">
					<a
							data-toggle="tab" href="#defaultyear"
							class="nav-link"
							href=""
							role="tab"
							aria-selected="false" onclick="getDefaultList()">Default Year</a>
				</li>

			</ul>

		<div class="col-lg-12">
			<div class="card-box">
				<div class="tab-content" style="padding:0;">
					<div id="blockyear" class="tab-pane active">
						<form method="post" id="blockFormRowUpload">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-5">
										<div class="form-group">
											<label>Select Year</label>
											<select name="year" id="year" class="form-control" onchange="getNoBlockMonth(this.value)">
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
									<div class="col-md-5">
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
									<div class="col-md-2">

										<button type="button" class="btn btn-primary roundCornerBtn4" onclick="uploadBlockData()" style="margin-top: 27px;">Save  <i class="fa fa-save"></i></button>

									</div>
								</div>
							</div>
						</form>
						<div class="row m-t-10">
							<div class="col-lg-12">
								<div class="card-box">
									<table class="table table-striped" id="ReportTable">
										<thead>
										<tr>
											<td>#</td>
											<td>Year</td>
											<td>Month</td>
											<td>Action</td>
										</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="defaultyear" class="tab-pane ">
						<form method="post" id="defaultFormRowUpload">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-5">
										<div class="form-group">
											<label>Select Year</label>
											<select name="defaultyear" id="defaultyear" class="form-control">
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
									<div class="col-md-5">
										<div class="form-group">
											<label>Select Month</label>
											<select name="defaultmonth" id="defaultmonth" class="form-control">
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
									<div class="col-md-2">

										<button type="button" class="btn btn-primary roundCornerBtn4" onclick="uploadDefaultData()" style="margin-top: 27px;">Save  <i class="fa fa-save"></i></button>

									</div>
								</div>
							</div>
						</form>
						<div class="row m-t-10">
							<div class="col-lg-12">
								<div class="card-box">
									<table class="table table-striped" id="DefaultReportTable">
										<thead>
										<tr>
											<td>#</td>
											<td>Year</td>
											<td>Month</td>
											<td>Action</td>
										</tr>
										</thead>
										<tbody>

										</tbody>
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

</div>
<script type="text/javascript">
	var base_url='<?php echo base_url();?>';
</script>
<?php $this->load->view('_partials/footer'); ?>
</div>
<script src="<?php echo base_url();?>assets/js/module/report/blockyear.js"></script>
