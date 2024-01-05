<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.alert.alert-light {
		background-color: #e3eaef;
		color: #191d21;
	}
	.alert.alert-has-icon {
		display: flex;
	}
	.alert {
		color: #fff;
		border: none;
		padding: 15px 20px;
	}
	.alert.alert-has-icon .alert-icon {
		margin-top: 4px;
		width: 30px;
	}
	.alert.alert-has-icon .alert-body {
		flex: 1;
	}
	.alert .alert-title {
		font-size: 15px;
		font-weight: 500;
		margin-bottom: 5px;
	}
	.alert-light {
		color: #818182;
		background-color: #fefefe;
		border-color: #fdfdfe;
	}
	.alert {
		position: relative;
		padding: 0.75rem 1.25rem;
		margin-bottom: 1rem;
		border: 1px solid transparent;
		border-radius: 0.25rem;
	}

	.tableHead
	{
		background-color: #f2d176;
	}
	.uploadLable
	{
		font-size: 18px;
	}
	.nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover {
		border-bottom-color: #fff;
		background-color: #f7e3ad;
		color: black;
		text-shadow: 0px 4px 5px #00000055!important;
	}
	/*.handsontable
	{
		height: 70vh!important;
	}*/
</style>
<!-- Main Content -->
<div class="content-page">
	<div class="content">
<!--		<input type="hidden" name="insertID" id="insertID" value="--><?php //echo $id;?><!--">-->
<!--		<input type="hidden" name="branchID" id="branchID" value="--><?php //echo $branch_id;?><!--">-->
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<div class="" style="    display: flex; flex-direction: row;">
								<h4 class="">Upload Data</h4>
								<button type="button" class="btn btn-primary" style="margin-left: auto;" data-toggle="modal" data-target="#uploadFinancialModal"><i class="fa fa-plus"></i> Upload Financial data</button>
								<button type="button" class="btn btn-primary m-l-10" style="" data-toggle="modal" data-target="#uploadFilesModal"><i class="fa fa-plus"></i> Upload Other Files</button>
							</div>

							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 bg-white">




				<div class="row" style="margin-top: -10px;background-color: white;padding: 10px 30px 10px 30px">
					<div class="col-md-12">
						<table class="table" id="UploadedFilesTable">
							<thead>
							<tr>
								<th>Sr No.</th>
								<th>Company</th>
								<th>Year</th>
								<th>Month</th>
								<th>File</th>
								<th>Description</th>
								<th>#</th>
							</tr>
							</thead>
							<tbody id="">

							</tbody>
						</table>
					</div>

				</div>

		</div>


</div>


</div>
<!--uppload modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="uploadFinancialModal"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload Financial Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="post" id="exportexcelsheet" name="exportexcelsheet">
				<div class="modal-body py-0">
					<div class="card my-0 shadow-none" >
						<div class="row">

						<div class="form-group col-md-6">
							<label for="">Subsidiary</label>
							<select name="branchID" id="branchID" class="form-control">

							</select>
							<input type="hidden" id="insertID" name="insertID">
							<input type="hidden" name="unmatchStatus" id="unmatchStatus" value="0">
						</div>
						<div class="form-group col-md-6">
							<label for="">Year</label>
							<select name="year" id="year" class="form-control year">
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
						<div class="form-group col-md-6">
							<label>Select Month</label>
							<select name="quarter" id="quarter" class="form-control month">
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
							<div class="form-group col-md-6">
								<label for="">Upload File</label>
								<input type="file" name="userfile[]" id="userfile" class="form-control">
								<a href="<?php base_url() ?>assets/imp_sample_excels/upload_financial_data.xlsx" download><i class="fa fa-download"></i> Sample File</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4 submit_button" type="submit">Submit</button>
					<button class="btn btn-secondary roundCornerBtn4 submit_button" type="reset">Reset</button>
					<div class="col-md-12 m-b-10" id="validateDiv"></div>
						<input type="hidden" name="count" id="count" class="form_control" value="0">
						<button type="button" class="btn btn-primary roundCornerBtn4 " id="saveExcelColumnsBtn" onclick="saveExcelColumns()" style="display: none;">Save</button>

				</div>
			</form>
		</div>
	</div>
</div>
<!-- end uppload modal-->
<!--uppload Files modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="uploadFilesModal"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload Files</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="post" id="uploadOtherFiles" name="uploadOtherFiles">
				<div class="modal-body py-0">
					<div class="card my-0 shadow-none" >
						<div class="row">

						<div class="form-group col-md-6">
							<label for="">Subsidiary</label>
							<select name="branch_id" id="branch_id" class="form-control">

							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="">Year</label>
							<select name="year" id="year1" class="form-control year">
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
						<div class="form-group col-md-6">
							<label>Select Month</label>
							<select name="quarter" id="quarter1" class="form-control month">
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
							<div class="form-group col-md-6">
								<label for="">Upload File</label>
								<input type="file" name="userfile[]" id="userfile1" class="form-control">
							</div>
							<div class="form-group col-md-6">
								<label for="">Description</label>
								<textarea name="desc" id="desc" class="form-control"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4 submit_button" type="submit">Submit</button>
					<button class="btn btn-secondary roundCornerBtn4 submit_button" type="reset">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end uppload Files modal-->
<!--unmatch modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="excel-modal-company"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Unmatch Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body py-0">
				<div class="card my-0 shadow-none" id="unmatch">

				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary mr-1 roundCornerBtn4" type="button" onclick="unmatchStatus()">Submit</button>
				<button class="btn btn-secondary roundCornerBtn4" type="reset">Reset</button>
			</div>

		</div>
	</div>
</div>
<!-- end unmatch modal-->
<?php $this->load->view('_partials/footer'); ?>

</div>

<script src="<?php echo base_url();?>assets/js/module/upload_data/financial_data.js"></script>
<script type="text/javascript">
	var base_url='<?php echo base_url(); ?>';
</script>
<script type="text/javascript">
	$(document).ready(function () {

		getAllUploadedFiles();
		getsubsidiaryList();

	});
	$("#exportexcelsheet").validate({
		rules: {
			'userfile[]': {
				required: true
			},
			branchID: {
				required: true
			},
			year: {
				required: true
			},
			quarter: {
				required: true
			},
		},
		messages: {
			'userfile[]': {
				required: "Please select file",
			},
			branchID: {
				required: "Please select subsidiary",
			},
			year: {
				required: "Please select subsidiary",
			},
			quarter: {
				required: "Please select subsidiary",
			},
		},
		errorElement: 'span',
		submitHandler: function (form) {
			$.LoadingOverlay("show");
			$("#validateDiv").html('');
			$("#saveExcelColumnsBtn").hide();
			var formData=new FormData(form);
			// console.log(formData);
			$.ajax({
				url: base_url+"ExportToTableDirectValidation",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status === 200) {
						$(".submit_button").hide();
						if(result.file_already_exist==1)
						{
							if (confirm('File Already Exist For this subsidiary of month and year Do you really want to replace data') == true) {
								$("#validateDiv").html(result.body);
								$("#saveExcelColumnsBtn").show();
								$("#count").val(result.count);
								$("#insertID").val(result.id);
							}
							else {
								$("#uploadFinancialModal").modal('hide');
							}
						}
						else {
							$("#validateDiv").html(result.body);
							$("#saveExcelColumnsBtn").show();
							$("#count").val(result.count);
							$("#insertID").val(result.id);
						}
					}
					else
					{
						$("#count").val(0);
						toastr.error(result.body);
					}
				}, error: function (error) {
					$.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});
	$("#uploadOtherFiles").validate({
		rules: {
			'userfile[]': {
				required: true
			},
			branch_id: {
				required: true
			},
			year: {
				required: true
			},
			quarter: {
				required: true
			},
		},
		messages: {
			'userfile[]': {
				required: "Please select file",
			},
			branch_id: {
				required: "Please select subsidiary",
			},
			year: {
				required: "Please select subsidiary",
			},
			quarter: {
				required: "Please select subsidiary",
			},
		},
		errorElement: 'span',
		submitHandler: function (form) {
			$.LoadingOverlay("show");

			var formData=new FormData(form);
			// console.log(formData);
			$.ajax({
				url: base_url+"uploadOtherFiles",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status === 200) {
						toastr.success(result.body);
						$("#uploadFilesModal").modal('hide');
						$("#uploadOtherFiles")[0].reset();
						$("#uploadOtherFiles .select2-hidden-accessible").val(null).trigger("change");
						getAllUploadedFiles();
					}
					else
					{
						toastr.error(result.body);
					}
				}, error: function (error) {
					$.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});


	function saveExcelColumns()
	{
		$.LoadingOverlay("show");
		var form_data = document.getElementById('exportexcelsheet');
		let formData = new FormData(form_data);
		formData.set('insertID', $("#insertID").val());
		formData.set('branchID', $("#branchID").val());
		// formData.set('creditCheck', creditCheck);
		app.request(base_url + "saveExcelColumns",formData).then(res=>{
			$.LoadingOverlay("hide");
			// data=res.data2;
			// console.log(res);

			$("#unmatchStatus").val(0);
			if(res.status==200)
			{
				toastr.success(res.body);
				$("#excel-modal-company").modal('hide');
				$("#uploadFinancialModal").modal('hide');
				$("#saveExcelColumnsBtn").hide();
				$("#validateDiv").html('');
				$("#errorDiv").html('');
				$("#tableDiv").html('');
				$("#exportexcelsheet")[0].reset();
				$("#exportexcelsheet .select2-hidden-accessible").val(null).trigger("change");
				getAllUploadedFiles();
			}
			else
			{

				if(res.type==1)
				{
					var template=`<div class="col-md-12">

									`;
					if(res.MandatoryData!="")
					{
						template+= `
										<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
						                         ${res.MandatoryData}
						                      </div>
						                    </div></div>`;
					}
					else
					{
						template+= `
										<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">Total Row - </b> ${res.TotalRowUpload-1}</div>
						                        <div class="alert-title">Match - </b> ${res.MatchedData}</div>
						                        <div class="alert-title">UnMatch - </b> ${res.UmatchedData}</div>
						                      </div>
						                    </div></div>`;
						if(res.NoText!="")
						{
							template+= `
											<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">At this Position Only <b>Numeric Value</b> allowed</div>
							                         ${res.NoText}
							                      </div>
							                    </div></div>`;

						}
						else if(res.UmatchedData!="")
						{
							$("#excel-modal-company").modal('show');
							$("#unmatch").html(`
											<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-film"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">There Was an <b>${res.UmatchedData} Unmatch/ ${res.TotalRowUpload-1} Total Row </b> data Do you want to proceed </div>
							                      </div>
							                    </div></div>`);
						}
					}


					template+= `

								</div>`;
					$("#errorDiv").html(template);
					$("#tableDiv").html(res.table);
				}
				else
				{
					$.LoadingOverlay("hide");
					toastr.error(res.body);
				}
			}

		});
	}

	function unmatchStatus()
	{
		$("#unmatchStatus").val(1);
		saveExcelColumns();
	}

	function getAllUploadedFiles() {
		$.LoadingOverlay("show");
		app.request(baseURL + "getAllUploadedFiles",null).then(res=>{
			$.LoadingOverlay("hide");
			$("#UploadedFilesTable").DataTable({
				destroy: true,
				order: [],
				data:res.data,
				"pagingType": "simple_numbers",
				columns:[

					{data: 0},
					{data: 1},
					{data: 3},
					{data: 4},
					{data: 2},
					{data: 7},
					{
						data: 6
					},
				],
				fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

					$('td:eq(4)', nRow).html(`${aData[2]}`);
					$('td:eq(6)', nRow).html(`${aData[6]}`);
				}
			});
		});
	}
	function getsubsidiaryList() {
		$('#branchID').html('');
		$('#branch_id').html('');
		$.ajax({
			url: base_url+"getCompanyBranchList",
			type: "POST",
			dataType: "json",
			data: '',
			processData: false,
			contentType: false,
			success: function (res) {
				if (res.status == 200) {
					$('#branchID').append(res.data);
					$('#branchID').select2();
					$('#branch_id').append(res.data);
					$('#branch_id').select2();
				}
				else {
					$('#branchID').append(res.data);
					$('#branchID').select2();
					$('#branch_id').append(res.data);
					$('#branch_id').select2();
				}
			}, error: function (error) {
				toastr.error("Something went wrong please try again");
			}
		});
	}
	$("#uploadFinancialModal").on('hidden.bs.modal', function (e) {
		$("#saveExcelColumnsBtn").hide();
		$(".submit_button").show();
		$("#validateDiv").html('');
		$("#errorDiv").html('');
		$("#tableDiv").html('');
		$("#exportexcelsheet")[0].reset();
		$("#exportexcelsheet .select2-hidden-accessible").val(null).trigger("change");
	});
</script>
