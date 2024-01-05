<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	.error{
		color:red;
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
		width: 250px;
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
							<h4 class="page-title">Special Rate</h4>
							<!--<button class="btn btn-icon btn-primary roundCornerBtn4 xs_btn" style="float: right" onclick="openModal();" data-id="0" id="companyFormButton"><i
									class="fa fa-plus"></i></button>-->
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
						<ul class="nav nav-tabs m-b-20" id="ex1" role="tablist">
							<li class="nav-item match active" role="presentation">
								<a data-toggle="tab" href="#exchangeRate" class="nav-link active" role="tab"
								   aria-selected="true" aria-expanded="true" onclick="getExchangeRateTable()">Special Exchange Rate</a>
							</li>
							<li class="nav-item unmatch" role="presentation">
								<a data-toggle="tab" href="#additionGl" class="nav-link" role="tab"
								   aria-selected="false" aria-expanded="false" onclick="getAdditionGLRateTable()">Addition To GL</a>
							</li>
							<li class="nav-item unmatch" role="presentation">
								<a data-toggle="tab" href="#auditorGl" class="nav-link" role="tab"
								   aria-selected="false" aria-expanded="false" onclick="getAuditorGLRateTable()">Auditor After Adjustment</a>
							</li>
						</ul>
					</div>
				</div>

<!--				/////////////////////-->
				<div class="tab-content" style="padding:0;">
					<div id="exchangeRate" class="tab-pane active">
						<div class="row">
							<form  id="saveExchangeData">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
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
										<div class="col-md-4">
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
										<div class="col-md-4">

											<div class="form-group">
												<label>Select Subsidiary</label>
												<select name="subsidiary" id="subsidiary" class="form-control subsidiary" onchange="getGlnumber(this.value)">
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label>Gl</label>
												<select name="gl" id="gl" class="form-control">
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Exchange rate(INR)</label>
												<input type="number" class="form-control" name="amount" id="amount">

											</div>
										</div>
										<div class="col-md-3">

											<button type="submit" class="btn btn-primary roundCornerBtn4" style="margin-top: 27px;">Save  <i class="fa fa-save"></i></button>

										</div>
									</div>
								</div>
							</form>
						</div>

						<div class="row">
							<table class="table table-striped" id="ExchangeRateTable">
								<thead>
								<tr>
									<td>#</td>
									<td>Month</td>
									<td>year</td>
									<td>Subsidiary</td>
									<td>GL Account Number</td>
									<td>Exchange Rate</td>
									<td>Action</td>
								</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
					<div id="additionGl" class="tab-pane">
						<div class="row">
							<form  id="saveAdditionGLData">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label>Select Year</label>
												<select name="year" id="glyear" class="form-control">
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
										<div class="col-md-4">
											<div class="form-group">
												<label>Select Month</label>
												<select name="month" id="glmonth" class="form-control">
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
										<div class="col-md-4">

											<div class="form-group">
												<label>Select Subsidiary</label>
												<select name="subsidiary" id="glsubsidiary" class="form-control subsidiary" onchange="getAdditionGlnumber(this.value)">
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label>Gl</label>
												<select name="gl" id="glaccount" class="form-control">
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Addition rate(INR)</label>
												<input type="number" class="form-control" name="amount" id="glamount">
												<input type="hidden" id="addtype" name="addtype" value="1">
											</div>
										</div>
<!--										<div class="col-md-4">-->
<!--											<div class="form-group">-->
<!--												<label>Type</label>-->
<!--												<select name="addtype" id="addtype" class="form-control">-->
<!--													<option value="1">Default</option>-->
<!--													<option value="2">Adjust by auditor</option>-->
<!--												</select>-->


<!--											</div>-->
<!--										</div>-->
										<div class="col-md-4">
											<div class="form-group">
												<label>Comment</label>
												<textarea class="form-control" name="comment" id="comment"></textarea>

											</div>
										</div>
										<div class="col-md-3">

											<button type="submit" class="btn btn-primary roundCornerBtn4 m-b-20" style="margin-top: 27px;">Save  <i class="fa fa-save"></i></button>

										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="row">
							<table class="table table-striped" id="AdditionaGLRateTable">
								<thead>
								<tr>
									<td>#</td>
									<td>Month</td>
									<td>year</td>
									<td>Subsidiary</td>
									<td>GL Account Number</td>
									<td>Addition Rate</td>
									<td>Type</td>
									<td>Action</td>
								</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
					<div id="auditorGl" class="tab-pane">
						<div class="row">
							<form  id="saveAuditorGLData">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label>Select Year</label>
												<select name="year" id="auditoryear" class="form-control">
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
										<div class="col-md-4">
											<div class="form-group">
												<label>Select Month</label>
												<select name="month" id="auditormonth" class="form-control">
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
										<div class="col-md-4">

											<div class="form-group">
												<label>Select Subsidiary</label>
												<select name="subsidiary" id="auditorsubsidiary" class="form-control subsidiary" onchange="getAuditorGlNumber(this.value)">
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label>Gl</label>
												<select name="gl" id="auditoraccount" class="form-control">
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Adjustment rate(Local)</label>
												<input type="number" class="form-control" name="amount" id="auditoramount">
											</div>
										</div>
										<div class="col-md-3">

											<button type="submit" class="btn btn-primary roundCornerBtn4" style="margin-top: 27px;">Save  <i class="fa fa-save"></i></button>

										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="row">
							<table class="table table-striped" id="AuditorGLRateTable">
								<thead>
								<tr>
									<td>#</td>
									<td>Month</td>
									<td>year</td>
									<td>Subsidiary</td>
									<td>GL Account Number</td>
									<td>Adjustment Rate</td>
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
<?php //$this->load->view('Admin/branch/branch_form'); ?>
<?php
$this->load->view('_partials/footer');
?>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<script>
	$( document ).ready(function() {
		getSubdiary();
		getExchangeRateTable();

	});

	function getSubdiary(){
		app.request("getSubsidiaryData",null).then(resp=>{
			if(resp.status==200)
			{
				$('.subsidiary').html(resp.body);
				$('.subsidiary').select2();
			}
		});
	}
	function getGlnumber(branchId)
	{
		let base_url1 = '<?php echo base_url(); ?>';
		let formData = new FormData();
		formData.set("branchId", branchId);
		app.request(base_url1 + "getGlDataByBranchID",formData).then(res=> {
			if(res.status==200){
                $('#gl').html(res.body);
				$('#gl').select2();
			}
		});
	}


	$("#saveExchangeData").validate({

		rules: {
			year: 'required',
			month: 'required',
			subsidiary: 'required',
			gl:'required',
			amount: 'required'
		},
		errorElement: 'span',
		submitHandler: function (form) {

			$.LoadingOverlay("show");
			//let form = document.getElementById('saveExchangeData');
			let formData1 = new FormData(form);
			app.request("saveGlDataByBranchID",formData1).then(res=> {
				$.LoadingOverlay("hide");
				if(res.status==200){
					toastr.success(res.body);
					document.getElementById("saveExchangeData").reset();
					getExchangeRateTable();
				}else{
					toastr.error(res.body);
				}

			});

		}
	});

	function getExchangeRateTable()
	{
		app.request("getExchangeRateDateList",null).then(res=>{
			console.log(res.data);
			$("#ExchangeRateTable").DataTable({
				destroy: true,
				order: [],
				data:res.data,
				"pagingType": "simple_numbers",
				columns:[
					{data: 0},
					{data: 1},
					{data: 2},
					{data: 3},
					{data: 4},
					{data: 5},

					{
						data: 6,
						render: (d, t, r, m) => {
							return `<button type="button" onclick="delexchangeRate(${d})" class="btn btn-link"><i class="fa fa-trash"></i></button>`
						}
					},
				],
				/*fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

					$('td:eq(9)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
				}*/
			});

		});
	}

	function delexchangeRate(id)
	{
		let formData = new FormData();
		formData.set("id", id);
		app.request("delexchangeRate",formData).then(res=>{
           if(res.status==200)
		   {
			   toastr.success(res.body);
			   getExchangeRateTable();
		   }else{
			   toastr.error(res.body);
		   }
		});
	}


	// Addition GL start
	$("#saveAdditionGLData").validate({

		rules: {
			year: 'required',
			month: 'required',
			subsidiary: 'required',
			gl:'required',
			amount: 'required',
			addtype: 'required'
		},
		errorElement: 'span',
		submitHandler: function (form) {

			$.LoadingOverlay("show");
			//let form = document.getElementById('saveExchangeData');
			let formData1 = new FormData(form);
			app.request("saveAdditionGlDataByBranchID",formData1).then(res=> {
				$.LoadingOverlay("hide");
				if(res.status==200){
					toastr.success(res.body);
					document.getElementById("saveAdditionGLData").reset();
					$("#glsubsidiary").select2({allowClear: true});
					$("#glaccount").select2({allowClear: true});
					getAdditionGLRateTable();
				}else{
					toastr.error(res.body);
				}

			});

		}
	});
	function getAdditionGLRateTable()
	{
		app.request("getAdditionGLRateTable",null).then(res=>{
			$("#AdditionaGLRateTable").DataTable({
				destroy: true,
				order: [],
				data:res.data,
				"pagingType": "simple_numbers",
				columns:[
					{data: 0},
					{data: 1},
					{data: 2},
					{data: 3},
					{data: 4},
					{data: 5},
					{data: 7},

					{
						data: 6,
						render: (d, t, r, m) => {
							return `<button type="button" onclick="deleteAdditionGLRate(${d})" class="btn btn-link"><i class="fa fa-trash"></i></button>`
						}
					},
				],
				/*fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

					$('td:eq(9)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
				}*/
			});

		});
	}
	function getAdditionGlnumber(branchId)
	{
		let base_url1 = '<?php echo base_url(); ?>';
		let formData = new FormData();
		formData.set("branchId", branchId);
		app.request(base_url1 + "getGlDataByBranchID",formData).then(res=> {
			if(res.status==200){
				$('#glaccount').html(res.body);
				$('#glaccount').select2();
			}
		});
	}
	function deleteAdditionGLRate(id)
	{
		let formData = new FormData();
		formData.set("id", id);
		app.request("deleteAdditionGLRate",formData).then(res=>{
			if(res.status==200)
			{
				toastr.success(res.body);
				getAdditionGlnumber();
			}else{
				toastr.error(res.body);
			}
		});
	}
	// Addition GL end

	//Auditor after adjustment
	function getAuditorGlNumber(branchId)
	{
		let base_url1 = '<?php echo base_url(); ?>';
		let formData = new FormData();
		formData.set("branchId", branchId);
		app.request(base_url1 + "getGlDataByBranchID",formData).then(res=> {
			if(res.status==200){
				$('#auditoraccount').html(res.body);
				$('#auditoraccount').select2();
			}
		});
	}
	$("#saveAuditorGLData").validate({

		rules: {
			year: 'required',
			month: 'required',
			subsidiary: 'required',
			gl:'required',
			amount: 'required'
		},
		errorElement: 'span',
		submitHandler: function (form) {

			$.LoadingOverlay("show");
			//let form = document.getElementById('saveExchangeData');
			let formData1 = new FormData(form);
			app.request("saveAuditorGlDataByBranchID",formData1).then(res=> {
				$.LoadingOverlay("hide");
				if(res.status==200){
					toastr.success(res.body);
					document.getElementById("saveAuditorGLData").reset();
					$("#auditorsubsidiary").select2({allowClear: true});
					$("#auditoraccount").select2({allowClear: true});
					getAuditorGLRateTable();
				}else{
					toastr.error(res.body);
				}

			});

		}
	});
	function getAuditorGLRateTable()
	{
		app.request("getAuditorGLRateTable",null).then(res=>{
			$("#AuditorGLRateTable").DataTable({
				destroy: true,
				order: [],
				data:res.data,
				"pagingType": "simple_numbers",
				columns:[
					{data: 0},
					{data: 1},
					{data: 2},
					{data: 3},
					{data: 4},
					{data: 5},

					{
						data: 6,
						render: (d, t, r, m) => {
							return `<button type="button" onclick="deleteAuditorAdjustmnetGLRate(${d})" class="btn btn-link"><i class="fa fa-trash"></i></button>`
						}
					},
				],
				/*fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

					$('td:eq(9)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
				}*/
			});

		});
	}
	function deleteAuditorAdjustmnetGLRate(id) {
		let formData = new FormData();
		formData.set("id", id);
		app.request("deleteAuditorAdjustmnetGLRate",formData).then(res=>{
			if(res.status==200)
			{
				toastr.success(res.body);
				getAuditorGLRateTable();
			}else{
				toastr.error(res.body);
			}
		});
	}
	//Auditor after adjustment
</script>
</div>
