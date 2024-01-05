<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.badge-danger {
	    background-color: #f96a74!important;
	}
	.badge-success {
	    background-color: #32c861!important;
	}
	#FinancialTable .panel-heading{
		    padding: 5px 10px;
	}
	#FinancialTable .panel-body {
	    padding: 7px;
	}
	#FinancialTable .panel-group {
	    margin-bottom: 5px;
	}
	#FinancialTable .panel-title
	{
		font-weight: 500;
	}
	#FinancialTable .f_right
	{
		float: right;
	}
	#FinancialTable .m_right
	{
		margin-left: auto;
    	margin-right: auto;
	}
	#FinancialTable .h3_right
	{
		display: flex;
		align-items: center;
	}
	#FinancialTable .m_left_1
	{
		margin-left: 10px;
	}
	#FinancialTable .year_color
	{
		background-color: #ff00001c;
	}
	#FinancialTable .month_color
	{
		background-color: #f3f0f0;
	}
	#FinancialTable .branch_color
	{
		background-color: #eed79678;
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

							<h4 class="page-title">Financial Data</h4>
							<button class="btn btn-icon btn-primary roundCornerBtn4 xs_btn" style="float: right"
									onclick="$('#financialFormRow').toggle()"><i class="fa fa-plus"></i></button>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="financialFormRow" style="display: none">
		<div class="col-lg-12">
			<div class="card-box">
				<form method="post" id="exportexcelsheet">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label>Select Year</label>
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
							</div>
							<div class="col-md-6">
								<div class="form-group">
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
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php if ($this->session->userdata('user_type') == 2) { ?>
								<div class="col-md-6">
									<div class="form-group">
										<label>Subsidiary Account</label>
										<!--										<input type="file" class="form-control" id="userfile" name="userfile" >-->
										<select name="branch_id" id="branch_id" class="form-control">

										</select>
									</div>
								</div>
							<?php } ?>
							<!-- <div class="col-md-6">
								<div class="form-group">
									<label>Excel File</label>
								<input type="file" class="form-control" id="userfile" name="userfile" >
								</div>
							</div> -->
							<!--							<div class="col-md-6">-->
							<!--								<div class="form-group">-->
							<!--									<label>Select Template</label>-->
							<!--									<select name="select_template" id="select_template" class="form-control">-->
							<!--										<option disabled selected>select template</option>-->
							<!--										-->
							<!--									</select>-->
							<!--								</div>-->
							<!--							</div>-->
							<div class="col-md-6">

								<button type="submit" class="btn btn-primary roundCornerBtn4" style="margin-top: 27px;">Create Table
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top: -10px;">
		<div class="col-ms-12">
			<input type="hidden" name="insertID" id="insertID">
			<input type="hidden" name="branchID" id="branchID">


		</div>
		<div class="row " style="padding: 0 0 0px 0;">
			<div class="col-md-6 " id="checkBoxDiv" style="display: none;">
				<input type="checkBox" name="removeDebit" id="removeDedit" value="1" onclick="getHandonOnchange()">
				Remove Debit, Credit & Opening Balance
			</div>
			<div class="col-md-6" style="text-align: end">
				<button type="button" class="btn btn-primary" id="finacialBtn" onclick="saveCopyFiancialData()"
						style="display: none;">Save
				</button>
				<a onclick="excelUploadPage()" type="button" class="btn btn-primary" id="explodeUploadBtn"
				   style="display: none;">Upload Excel</a>
			</div>
		</div>
		<div class="col-md-12" id="newDiv"></div>

		<div class="col-md-12" id="example"></div>
		
	</div>
	<div class="row" style="padding: 2rem 1rem 0rem 1rem;">
		<div class="col-md-4">
			<div class="form-group" style="width: 90%; margin: 0rem auto 1.3rem auto;">
				<label>Filter By Year</label>
				<select name="year" id="filteryear" class="form-control" onchange="getFinancialList()">
					<option value="-1" selected>All</option>
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
			<div class="form-group" style="width: 90%; margin: 0rem auto 1.3rem auto;">
				<label>Filter By Month</label>
				<select name="quarter" id="filterquarter" class="form-control" onchange="getFinancialList()">
					<option value="-1" selected>All</option>
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
			<div class="form-group" style="width: 90%; margin: 0rem auto 1.3rem auto">
				<label>Filter By Status</label>
				<select name="quarter" id="filterStatus" class="form-control" onchange="getFinancialList()">
					<option value="-1" selected>All</option>
					<option value="1">Approve</option>
					<option value="0">Not Approve</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<table class="table table-striped" id="FinancialTable">
					<thead>
					<tr>
						<!-- <td>#</td> -->
						<td>Month</td>
						<!-- <td>Subsidiary Account</td>
						<td>Company</td> -->
						<!-- <td>File</td> -->
						<!-- <td>Year</td>
						<td>Month</td>
						<td>Approve Status</td>
						<td>Completion State</td>
						<td>Action</td> -->
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
<?php $this->load->view('_partials/footer'); ?>

</div>

<script src="<?php echo base_url(); ?>assets/js/module/upload_data/financial_data.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
	$(document).ready(function () {
		$.LoadingOverlay("show");
		getTemplates();
		getFinancialList();
		getBranchList();
	});
	function setarrow(ele)
	{
		// console.log(ele.children[0]);
		 const tgt = ele.children[0];

		  tgt.classList.toggle('fa-chevron-down');
		  tgt.classList.toggle('fa-chevron-up');
		 // $(ele+" i").toggleClass('fa-chevron-down fa-chevron-up');
	}
	function getBranchList() {
		app.request(baseURL + "getCompanyBranchList", null).then(res => {
			$.LoadingOverlay("hide");
			if (res.status == 200) {
				$('#branch_id').append(res.data);
				$('#branch_id').select2();
			}
		}).catch(e => {
			console.log(e);
		});
	}

	$("#exportexcelsheet").validate({
		rules: {
			year: {
				required: true
			},
			quarter: {
				required: true
			},
			branch_id:
					{
						required: true
					}
		},
		messages: {
			year: {
				required: "Please select year",
			},
			quarter: {
				required: "Please select quarter",
			},
			branch_id: {
				required: "Please select branch",
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
			// $.LoadingOverlay("show");

			var formData = new FormData(form);
			console.log(formData);
			$.ajax({
				url: base_url + "ExportToTable",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					if (result.status === 200) {
						toastr.success('Table has been Created Successfully! Click on the Edit Button to Enter Data');
						var id = result.body;
						var branch_id = result.branch_id;
						$("#insertID").val(id);
						$("#branchID").val(branch_id);
						// loadEditableTable(id, branch_id);
						getFinancialList();
						// $("#finacialBtn").show();
						// $("#checkBoxDiv").show();
						// $("#explodeUploadBtn").show();
						if(result.type==1)
						{
							toastr.error('Already created for this month and year');
						}
					} else {
						toastr.error(result.body);
					}
				}, error: function (error) {
					// $.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});
	let debitCheck = 0;
	// let creditCheck=0;
	// let columnRows=[];
	// let columnsHeader=[];
	function loadEditableTable(id, branch_id) {
		$.ajax({
			url: base_url + "getExportToTableData",
			type: "POST",
			dataType: "json",
			data: {id: id, branch_id: branch_id},
			success: function (result) {
				var rows = [
					['', '', '', '', '',],
				];
				if (result.status === 200) {
					// var columns=result.columns;
					if (result.rows.length > 0) {
						rows = result.rows;
					}
					// var types=result.types;
					// columnRows=rows;
					// columnsHeader=columns;

				} else {

					rows = [
						['', '', '', '', ''],
					];
				}
				var types = [
					{type: 'text',},
					// { type: 'numeric',numericFormat: {
					// 		pattern: {
					// 			thousandSeparated: true,
					// 			forceSign: true,
					// 			trimMantissa: true
					// 		}
					//
					// 	},},
					{type: 'text'},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
				];
				var hideArra = [];
				var columns = ['gl_ac', 'detail', 'Opening Balance', 'debit', 'credit', 'total'];
				if (debitCheck == 1) {

					hideArra.push(2, 3, 4);
				}
				//         if(creditCheck==1)
				//         {

				// hideArra.push(3);

				//         }

				hideColumn = {
					// specify columns hidden by default
					columns: hideArra,
					copyPasteEnabled: false,
				};
				createHandonTable(columns, rows, types, 'newDiv', hideColumn);

			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});

	}

	let hotDiv;

	function createHandonTable(columnsHeader, columnRows, columnTypes, divId, hideColumn = true) {
		console.log(columnsHeader);
		var element = document.getElementById(divId);
		hotDiv != null ? hotDiv.destroy() : '';
		hotDiv = new Handsontable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			formulas: true,
			manualColumnResize: true,
			manualRowResize: true,

			// ],
			columns: columnTypes,
			beforeChange: function (changes, source) {
				var row = changes[0][0];

				var prop = changes[0][1];

				var value = changes[0][3];

			},
			beforePaste: (data, coords) => {
				for (let i = 0; i < data.length; i++) {
					for (let j = 0; j < data[i].length; j++) {
						if (coords[0].startCol == 0) {
							data[i][j] = data[i][j].replace(/[^A-Z0-9]/ig, '');
							data[i][j] = data[i][j].replace(/\D/g, '');
						}
					}
				}
			},
			stretchH: 'all',
			colWidths: '100%',
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,

			hiddenColumns: hideColumn,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		hotDiv.validateCells();
	}

	function saveCopyFiancialData() {
		$.LoadingOverlay("show");
		var data = hotDiv.getData();
		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('insertID', $("#insertID").val());
		formData.set('branchID', $("#branchID").val());
		formData.set('debitCheck', debitCheck);
		// formData.set('creditCheck', creditCheck);
		app.request(base_url + "saveCopyFiancialData", formData).then(res => {
			$.LoadingOverlay("hide");
			// data=res.data2;
			// console.log(res);
			if (res.status == 200) {
				toastr.success(res.body);
				$("#insertID").val('');
				$("#branchID").val('');
				document.getElementById("exportexcelsheet").reset();
				$("#newDiv").html('');
				document.getElementById('newDiv').style.height = null;
				$("#finacialBtn").hide();
				$("#checkBoxDiv").hide();
				$("#explodeUploadBtn").hide();
				document.getElementById("removeDedit").checked = false;
				// document.getElementById("removeCredit").checked = false;
				debitCheck = 0;
				// creditCheck=0;
				hideArra = [];
			} else {
				toastr.error(res.body);
			}

		});
	}

	function getHandonOnchange() {
		var checkBoxDebit = document.getElementById("removeDedit");

		if (checkBoxDebit.checked == true) {
			debitCheck = 1;
		} else {
			debitCheck = 0;
		}
		var id = $("#insertID").val();
		var branch_id = $("#branchID").val();
		loadEditableTable(id, branch_id);

	}
</script>
<script type="text/javascript">
	function getTemplates() {
		app.request(base_url + "getTemplates", null).then(res => {
			$.LoadingOverlay("hide");
			if (res.status == 200) {
				app.selectOption('select_template', 'select template', res.data);
			} else {
			}
		});
	}

	function excelUploadPage() {
		var id = $("#insertID").val();
		window.location.href = base_url + 'excelUploadValidation?id=' + id;
	}
</script>
