<?php
$this->load->view('_partials/header');
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
	#template_detail_div{
		list-style:none;
	}
	#template_detail_div li{
		background-color: #f2f4f6;
		margin-bottom: 2px;
		padding: 2px 12px;
	}

	/*header stylesheet*/
	#myDropdown
	{
		width: 523px!important;
	}
	#side-padding{
		padding-left: 0!important;
	}
	.app-theme-white.fixed-header .app-header__logo {
		background: none !important;
	}

	::-webkit-scrollbar {
		height: 20px !important;
		background-color: #f5f4f4 !important;
		width: 6px !important;
		overflow: visible !important;
		display: block !important;

	}

	::-webkit-scrollbar-thumb {
		-webkit-border-radius: 10px;
		border-radius: 10px;
		background: gray !important;
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
	}

</style>

<script>
	$(function () {
		$(window).resize(function () {
			if (window.matchMedia("(max-width: 768px)").matches) {
				window.location.replace("<?= base_url('templatetool'); ?>");
			} else {


			}
		});
		if (window.matchMedia("(max-width: 768px)").matches) {

			window.location.replace("<?= base_url('templatetool'); ?>");
		} else {

		}
	});
</script>
<!-- <body onclick="closeNav()">-->
<div class="content-page">
	<div class="content">
		<div class="">

			<div class="">
				<div class="">
					<div class="page-title-box">
						<h4 class="page-title">SpreadSheets Templates</h4>
						<input type="hidden" id="charLetter" name="charLetter" value="C">
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<div class="card-header ">
							<div class="card-title ">
								<h4 class="m-t-0 m-b-20 header-title"><b>SpreadSheets</b></h4>

							</div>
						</div><br>

						<div class="card">
							<div class="row">
								<div class="col-lg-12">
									<div class="card-box">
										<div class="card-header ">
											<div class="card-title m-b-10 " style="display: flex;">
												<div class="mr-3">
											<select class="form-control" id="yearSelect">
												<option selected disabled>Select Year</option>
												<option year="2018">2018</option>
												<option year="2019">2019</option>
												<option year="2020">2020</option>
												<option year="2021">2021</option>
												<option year="2022">2022</option>
												<option year="2023">2023</option>
												<option year="2024">2024</option>
												<option year="2025">2025</option>
												<option year="2026">2026</option>
											</select>
												</div>
												<div style="margin-left: 10px">
											<select class="form-control" id="monthSelect">
												<option selected disabled>Select Month</option>
												<option  value='1'>Janaury</option>
												<option value='2'>February</option>
												<option value='3'>March</option>
												<option value='4'>April</option>
												<option value='5'>May</option>
												<option value='6'>June</option>
												<option value='7'>July</option>
												<option value='8'>August</option>
												<option value='9'>September</option>
												<option value='10'>October</option>
												<option value='11'>November</option>
												<option value='12'>December</option>
											</select>
											</div>
												<div style="margin-left: 10px">
													<button type="button" onclick="showData()"  class="btn btn-primary btn-sm roundCornerBtn4" style="">show</button>
												</div>
											</div>
											<div class="card-title m-b-10 card-actions" style="display: flex;">

												<button type="button" onclick="openaddModal()"  class="btn btn-primary btn-sm roundCornerBtn4" style="margin-left: auto;margin-right: 20px;"><i class="fa fa-plus"></i> New Spreadsheet</button>
												<button type="button" onclick="openaddModal2()"  class="btn btn-danger btn-sm roundCornerBtn4" style="margin-left: auto;margin-right: 20px;"><i class="fa fa-users"></i> Assign To Subsidiary Account</button>
											</div>
										</div><br>

										<div class="card">
											<table id="table_lists" class="display">
												<thead>
												<tr>
													<th>#</th>
													<th>Spreadsheet Name</th>
													<th>Month/Year</th>
													<th>Action</th>
													<th>Edit</th>
													<th>Schedule Account Mapping</th>
													<th>Currency Rate Mapping</th>
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
</div>
<div class="modal fade" id="Mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h3 id="myModalLabel">Add SpreadSheet</h3>
			</div>
			<div class="modal-body">
				<form id="template" method="post">
					<div class="row" id="template_master_div">
						<div class="col-md-3 form-group">
							<input type="hidden" id="template_count" name="template_count" value="0">
							<input type="hidden" id="template_id" name="template_id">
							<select id="template_name" name="template_name" class="form-control"></select>
							<span id="template_error"></span>
						</div>
						<div class="col-md-3 form-group">
							<select class="form-control" id="yearCre" name="yearCre">
								<option selected disabled>Select Year</option>
								<option year="2018">2018</option>
								<option year="2019">2019</option>
								<option year="2020">2020</option>
								<option year="2021">2021</option>
								<option year="2022">2022</option>
								<option year="2023">2023</option>
								<option year="2024">2024</option>
								<option year="2025">2025</option>
								<option year="2026">2026</option>
							</select>
						</div>
						<div class="col-md-3 form-group" >
							<select class="form-control" id="monthCre" name="monthCre">
								<option selected disabled>Select Month</option>
								<option  value='1'>Janaury</option>
								<option value='2'>February</option>
								<option value='3'>March</option>
								<option value='4'>April</option>
								<option value='5'>May</option>
								<option value='6'>June</option>
								<option value='7'>July</option>
								<option value='8'>August</option>
								<option value='9'>September</option>
								<option value='10'>October</option>
								<option value='11'>November</option>
								<option value='12'>December</option>
							</select>
						</div>
						<div class="col-md-3 form-group">
							<div class="col-md-12">
								<select class="form-control" id="company_id" name="company_id" onchange="getGlAccountList()">
									<option selected disabled>Select Company</option>
								</select>

							</div>
						</div>
						<div class="col-md-3 form-group"><label> <b>Prefill</b> : </label>
							<input type="radio" name="prefill" id="prefillyes" value="1"> <label for="prefillyes">Yes</label>
							<input type="radio" name="prefill" id="prefillno" value="0" checked> <label for="prefillno">No</label>
						</div>
<!--						<div class="col-md-2 form-group">-->
<!--							<label> <b>Value Sign In </b> : </label>-->
<!--						</div>-->
<!--						<div class="col-md-2 form-group">-->
<!---->
<!--							<select name="valueSignIN" id="valueSignIN" class="form-control">-->
<!--								<option value="0">Normal</option>-->
<!--								<option value="1">Positive</option>-->
<!--								<option value="2">Negative</option>-->
<!--								<option value="3">Reverse</option>-->
<!--							</select>-->
<!--						</div>-->
					</div>

					<div class="row-fluid"  id="sortable_div">
						<ul id="template_detail_div"></ul>
					</div>

					<div id="add_more_div">
						<button type="button" id="btn_add_more" class="btn btn-info roundCornerBtn4 xs_btn" onclick="createAddTemplateRow()"><i class="fa fa-plus"></i></button>
					</div>

				</form>
			</div>
			<div class="modal-footer" id="template_footer">
				<button class="btn btn-default roundCornerBtn4" data-dismiss="modal" aria-hidden="true">Cancel</button>
				<button id="create_template1" class="btn btn-primary pull-right roundCornerBtn4" type="button" onclick="CreateTemplate()"><i class="fa fa-save"></i> Save</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="MymodalCopy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h3 id="myModalLabel">Copy SpreadSheet</h3>
			</div>
			<div class="modal-body">
				<form id="templateCopy" method="post">
					<div class="row" id="template_master_div">
						<div class="col-md-4 form-group">
							<input type="hidden" id="template_id_copy" name="template_id_copy">
							<input type="readonly" id="template_name_copy" name="template_name_copy" class="form-control" placeholder="Spreadsheet Name">
							<span id="template_error"></span>
						</div>
								<div class="col-md-4">
									<select class="form-control" id="yearCopy" name="yearCopy">
										<option selected disabled>Select Year</option>
										<option year="2018">2018</option>
										<option year="2019">2019</option>
										<option year="2020">2020</option>
										<option year="2021">2021</option>
										<option year="2022">2022</option>
										<option year="2023">2023</option>
										<option year="2024">2024</option>
										<option year="2025">2025</option>
										<option year="2026">2026</option>
									</select>
								</div>
								<div class="col-md-4" >
									<select class="form-control" id="monthCopy" name="monthCopy">
										<option selected disabled>Select Month</option>
										<option  value='1'>Janaury</option>
										<option value='2'>February</option>
										<option value='3'>March</option>
										<option value='4'>April</option>
										<option value='5'>May</option>
										<option value='6'>June</option>
										<option value='7'>July</option>
										<option value='8'>August</option>
										<option value='9'>September</option>
										<option value='10'>October</option>
										<option value='11'>November</option>
										<option value='12'>December</option>
									</select>
								</div>



					</div>



				</form>
			</div>
			<div class="modal-footer" id="template_footer">
				<button class="btn btn-default roundCornerBtn4" data-dismiss="modal" aria-hidden="true">Cancel</button>
				<button id="create_template1" class="btn btn-primary pull-right roundCornerBtn4" type="button" onclick="CreateTemplateCopy()"><i class="fa fa-save"></i> Save</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="handonTableModal" tabindex="-1" role="dialog" aria-labelledby="spreadsheetTemplate" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form id="spreadsheetForm" name="spreadsheetForm">
				<div class="modal-header" style="display: flex;">
					<h5 class="modal-title" id="spreadsheetTemplate">SpreadSheet Table</h5>
						<button type="button" class="btn btn-primary btn-sm filterBtn" id="spreadSheetBtn" style="margin-left: auto;margin-right: 10px;" onclick="saveSpreadSheetTool()">Save</button>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

				</div>

				<div class="modal-body">
					<input type="hidden" id="spreadsheetTemplateId">
					<input type="hidden" id="spreadsheetTemplateName">

					<div id="" class="to-bottom" style="height:100%;overflow: auto;">

						<div id="spreadSheetDiv"></div>

					</div>
					<div id="toolsortable_div">

					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="AssignModal" tabindex="-1" role="dialog" aria-labelledby="spreadsheetTemplate" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form id="spreadsheetFormAssign" name="spreadsheetFormAssign">
				<div class="modal-header" style="display: flex;">
					<h5 class="modal-title" id="spreadsheetTemplate">Assign To Subsidiary Account</h5>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

				</div>

				<div class="modal-body">
						<div class="row">
							<!--<div class="col-md-12">
								<label>Company</label>
								<select class="form-control" id="company_id" name="company_id" onchange="getBranchList()">
									<option selected disabled>Select Company</option>
								</select>

							</div>
							<div class="col-md-12">
								<label>Subsidiary Account</label>
								<select class="form-control" id="branch_id" name="branch_id">
									<option selected disabled>Select Subsidiary Account</option>
								</select>
							</div>-->
							<div class="col-md-12">
								<label>Spreadsheet Name</label>
								<select class="form-control" id="sheet_id" name="sheet_id">
									<option selected disabled>Select Spreadsheet Name</option>
								</select>
							</div>
						</div>
						<div class="row"><br>
						<button type="button"
								class="btn btn-primary btn-sm" id="spreadSheetBtn" style="float:right;margin-right: 20px;" onclick="saveSpreadSheetAssignment()">Save</button>
						</div>

				</div>
			</form>
		</div>
	</div>
</div>
<!--subsidiary account mapping-->
<div class="modal fade" id="ScheduleAccountMapp" role="dialog" aria-labelledby="ScheduleAccountMappLable" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h3>Schedule Account Mapping </h3>
				<h5 id="ScheduleAccountMappLable"></h5>
			</div>
			<div class="modal-body">
				<input type="hidden" name="scheduleTemplateID" id="scheduleTemplateID">
				<input type="hidden" name="scheduleTemplateName" id="scheduleTemplateName">
				<div class="row">
					<div class="col-md-4">
						<select name="scheduleCompany" id="scheduleCompany" onchange="getScheduleAccountMapping(this.value)"></select>
					</div>
					<div class="col-md-8">
						<b>#P_</b> - Previous year &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<b>#PP_</b> - Previous of previous year
					</div>
					<div class="col-md-12">
						<button class="btn btn-primary btn-sm" type="button" id="clearSubMapp" onclick="clearScheduleSubsidiaryMapp()" style="display: none;">Refresh data</button>
						<div id="SubMappDiv"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default roundCornerBtn4" data-dismiss="modal" aria-hidden="true">Cancel</button>
				<button id="create_template4" class="btn btn-primary pull-right roundCornerBtn4" type="button" onclick="saveSubMappData()"><i class="fa fa-save"></i> Save</button>
			</div>
		</div>
	</div>
</div>
<!--subsidiary account mapping-->
<!--Currency rate mapping-->
<div class="modal fade" id="CurrencyRateMapp" role="dialog" aria-labelledby="CurrencyRateMappLable" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h3>Currency Rate Mapping </h3>
				<h5 id="CurrencyRateMappLable"></h5>
			</div>
			<div class="modal-body">
				<input type="hidden" name="currencyTemplateID" id="currencyTemplateID">
				<input type="hidden" name="currencyTemplateName" id="currencyTemplateName">
				<div class="row">
					<div class="col-md-4">
						<select name="CurrencyRateCompany" id="CurrencyRateCompany" onchange="getCurrencyRateMapping(this.value)"></select>
					</div>
					<div class="col-md-12">
						<button class="btn btn-primary btn-sm" type="button" id="clearCurrencyRate" onclick="clearCurrencyRateMapp()" style="display: none;">Refresh data</button>
						<div id="CurrencyRateMappDiv"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default roundCornerBtn4" data-dismiss="modal" aria-hidden="true">Cancel</button>
				<button id="create_template4" class="btn btn-primary pull-right roundCornerBtn4" type="button" onclick="saveCurrencyRateMappData()"><i class="fa fa-save"></i> Save</button>
			</div>
		</div>
	</div>
</div>
<!--Currency rate mappingg-->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.js"></script>
<!-- <script src="<?= base_url(); ?>assets/js/custom.js" type="text/javascript"></script> -->

<script type="text/javascript">
	$(document).ready(function () {


		getcompanyList();
		getListsheet();

		$('#handonTableModal').on('shown.bs.modal', function(event) {
			var temp_id = $("#spreadsheetTemplateId").val();
			fetch_template_handson(temp_id);
			var temp_name=$("#spreadsheetTemplateName").val();
			$("#spreadsheetTemplate").html(temp_name);
		});
		$( "#template_detail_div" ).sortable({});
	});
	function showData() {
		var year=$('#yearSelect').val();
		var month=$('#monthSelect').val();
		getTableList(year,month);
	}
	const monthNames = ["January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"
	];
	function getTableList(year,month) {
		let formData = new FormData();
		formData.set('company_id', 'all');
		formData.set('year', $('#yearSelect').val());
		formData.set('month', $('#monthSelect').val());
		requestToAjax("getTablesList",formData).then(res=>{
			console.log("table lists response = "+res);
			$("#table_lists").DataTable({
				destroy: true,
				order: [],
				data:res.data,
				"pagingType": "simple_numbers",
				columns:[

					{data: 0},
					{data: 1},
					{data: 5,
						render: (d, t, r, m) => {
						month =monthNames[r[6] - 1];
							return month+` / ${d}`;
						}
					},
					{data: 3,
						render: (d, t, r, m) => {
							var status='Active';
							if(d==1)
							{
								status='Active';
							}
							else
							{
								status='Inactive';
							}
							return `<button type="button" onclick="changeStatus(${r[2]},${d})" class="btn btn-link">${status}</button>`
						}
					},
					{
						data: 2,
						render: (d, t, r, m) => {
							return `<button type="button" onclick="editfun(${d},'${r[1]}',${r[4]},${r[7]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>
<button type="button" onclick="copyfun(${d},'${r[1]}',${r[4]})" class="btn btn-link"><i class="fa fa-copy"></i></button>`;
						}
					},
					{
						data:0,
						render: (d, t, r, m) => {
							return `<button type="button" onclick="editSubsidiaryAccountfun(${r[2]},'${r[1]}')" class="btn btn-link"><i class="fa fa-pencil"></i></button>`;
						}
					},
					{
						data:0,
						render: (d, t, r, m) => {
							return `<button type="button" onclick="editCurrencyRatefun(${r[2]},'${r[1]}')" class="btn btn-link"><i class="fa fa-pencil"></i></button>`;
						}
					}
				],
				fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
					var status='Active';
					if(aData[3]==1)
					{
						status='Active';
					}
					else
					{
						status='Inactive';
					}
					$('td:eq(3)', nRow).html(`<button type="button" onclick="changeStatus(${aData[2]},${aData[3]})" class="btn btn-link">${status}</button>`);
					$('td:eq(4)', nRow).html(`<button type="button" onclick="editfun(${aData[2]},'${aData[1]}',${aData[4]},${aData[7]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>
<button type="button" onclick="copyfun(${aData[2]},'${aData[1]}',${aData[4]})" class="btn btn-link"><i class="fa fa-copy"></i></button>`);
					$('td:eq(5)', nRow).html(`<button type="button" onclick="editSubsidiaryAccountfun(${aData[2]},'${aData[1]}')" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
					$('td:eq(6)', nRow).html(`<button type="button" onclick="editCurrencyRatefun(${aData[2]},'${aData[1]}')" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
				}
			});
		}).
		catch((e) => {
			console.log(e);
		});
	}

	function remove_div(elm){

		$(elm).closest('li.new_attr_row').remove();
		$("#template_count").val(($("#template_count").val()*1)-1);
	}
	function openaddModal(){
		$("#Mymodal").modal('show');
		getTemplateListDropdown();
		$("#charLetter").val('C');
		$("#template_id").val('');
		// $("#hdn_table_name").val('');
		$("#template_name").val('');
		$("#template_count").val(0);
		// $("#create_template").remove();
		// $("#template_footer").append('<button id="create_template" class="btn btn-primary pull-right roundCornerBtn4" type="button"  onclick="CreateTemplate()"><i class="fa fa-save"></i>Save</button>');

		// $('div.new_attr_row').remove();
		$('ul#template_detail_div').empty();
		createAddTemplateRow();
	}
	function openaddModal2(){
		$("#AssignModal").modal('show');


	}
	let GlAccountOption='';
	function getGlAccountList() {
		GlAccountOption='';
		//GlAccountOption
		return new Promise((resolve, reject) => {
			var company_id=$("#company_id").val();
			let formData = new FormData();
			formData.set('company_id', company_id);
			requestToAjax("getGlAccountList",formData).then(res=>{
				console.log(res);
				if(res.status == 200){
					$('.glaccounts').html(res.data);
					resolve(res.data);
				}else{
					$('.glaccounts').html(res.data);
					resolve(res.data);
				}
			}).
			catch((e) => {
				console.log(e);
			});
		});

	}
	function createAddTemplateRow(data=null)
	{
		var charLetter=$("#charLetter").val();
		var template_count=$("#template_count").val();
		if(parseInt(template_count)<15)
		{

			template_count=(template_count*1)+1;
			$("#template_count").val(template_count);
			var rowClass='';
			var closeBtn='';

			var attribute_name='';
			var option_data='';
			var sequence='';
			var formula='';
			var value_type='';
			var formula_maker='';
			var formula_maker_inr='';
			var options=`<option value="numeric">Numeric</option>
					<option value="dropdown">Dropdown</option>
					<option value="text">Text</option>
					<option value="date">Date</option>`;
			var optionsValueType=`<option value="1">Manual</option>
					<option value="2">Calculated</option>`;
			var valueSignIn=`<option value="0">Normal</option>
					<option value="1">Positive</option>
					<option value="2">Negative</option>
					<option value="3">Reverse</option>`;
			if(data!=null)
			{
				attribute_name=data.column_name;
				option_data=data.option_data;
				sequence=data.sequence;
				formula_maker=data.formula_maker;
				if(formula_maker==null || formula_maker=='null')
				{
					formula_maker='';
				}
				formula_maker_inr=data.formula_maker_inr;
				if(formula_maker_inr==null || formula_maker_inr=='null')
				{
					formula_maker_inr='';
				}
				options=`<option value="numeric" ${data.column_type == 'numeric' ? 'selected' : ''}>Numeric</option>
							<option value="dropdown"  ${data.column_type == 'dropdown' ? 'selected' : ''}>Dropdown</option>
							<option value="text"  ${data.column_type == 'text' ? 'selected' : ''}>Text</option>
							<option value="date"  ${data.column_type == 'date' ? 'selected' : ''}>Date</option>`;
				optionsValueType=`<option value="1" ${data.value_type == '1' ? 'selected' : ''}>Manual</option>
							<option value="2"  ${data.value_type == '2' ? 'selected' : ''}>Calculated</option>`;
				valueSignIn=`<option value="0" ${data.value_sign == '0' ? 'selected' : ''}>Normal</option>
					<option value="1" ${data.value_sign == '1' ? 'selected' : ''}>Positive</option>
					<option value="2" ${data.value_sign == '2' ? 'selected' : ''}>Negative</option>
					<option value="3" ${data.value_sign == '3' ? 'selected' : ''}>Reverse</option>`;
				formula=data.formula;
				branchSum=data.inlcude_branch_sum;

			}
			if(template_count>1)
			{
				rowClass='new_attr_row';
				closeBtn=`<button type="button" onclick="remove_div(this);" class="btn remove_row roundCornerBtn4 xs_btn"><i class="fa fa-times-circle closeButton"></i></button>`;
			}
			GlAccountOption=GlAccountOption;
			var template_detail = `<li class="row ${rowClass} handle" id="sort_${template_count}">
					<div class="col-md-2">
					<label>Particulars (${charLetter}#)</lable>
					<input type="hidden" name="hdn_update_id[]" value="0">
					<input type="text" name="attribute_name[]" class="form-control" placeholder="Column Name" value="${attribute_name}">
					</div>
					<div class="col-md-1 ">
					<label>Select type</lable>
					<select name="attribute_type[]" class="form-control">
					<option value="">Select type</option>
					${options}
					</select>
					</div>
					<div class="col-md-2">
					<label>Attribute Value</lable>
					<input type="text" name="attribute_query[]"   class="form-control" placeholder="Attribute Value/options" value="${option_data}">
					</div>
					<div class="col-md-2">
					<label>Gl Account</lable>
					<select class="form-control glaccounts glClass${template_count}" id="GLAcct${template_count}"  name="GlAccount[]"  >
					${GlAccountOption}</select>
					</div>
					<div class="col-md-1">
					<label>Value Type</lable>
					<select class="form-control" name="valueType[]" id="valType${template_count}" onchange="ChangeEvent(this.value,${template_count})" >
					${optionsValueType}</select>
					</div>
					<div class="col-md-2">
					<label>Formula</lable>
					<select class="form-control" multiple id="formula_${template_count}" name="formulaColumns${template_count}[]" style="display: none">
					<option value="">Select Formula Columns</option>
					</select>
					</div>
					<div class="col-md-2">
<label>Subsidiary Sum</label>
<input type="radio" id="yes${template_count}" checked name="branchSum${template_count}" value="1">
<label for="html">Yes</label>
<input type="radio" id="no${template_count}" name="branchSum${template_count}" value="0">
<label for="css">No</label>
</div>
<div class="col-md-2">
				<label>Value Sign In</label>
				<select name="valueSignIN[]" id="valueSignIN${template_count}" class="form-control">
					${valueSignIn}
				</select>
</div>
<div class="col-md-4">
<label>Local Formula maker</label>
<textarea name="formulaMaker[]" id="formulaMaker${template_count}" class="form-control formulaMaker${template_count}">${formula_maker}</textarea>
</div>
<div class="col-md-4">
<label>INR Formula maker</label>
<textarea name="formulaMakerINR[]" id="formulaMakerINR${template_count}" class="form-control formulaMakerINR${template_count}">${formula_maker_inr}</textarea>
</div>
					<div class="col-md-1 ">
					${closeBtn}
					</div>
					</li>`;
			$("#template_detail_div").append(template_detail);
			ChangeEvent($('#valType'+template_count).val(),template_count,formula);
			$("#GLAcct"+template_count).val(data.gl_account);
			if(branchSum == 1){
				$("#yes"+template_count).prop('checked',true);
			}else{
				$("#no"+template_count).prop('checked',true);
			}

		}
		else
		{
			toastr.error('Can not add more than 15 columns');
		}
		charLetter=String.fromCharCode(charLetter.charCodeAt() + 1);
		$("#charLetter").val(charLetter);

	}
	function ChnageGl(hashid,valueGL) {
		$("#"+hashid).val(valueGL).trigger('change');
	}
	function ChangeEvent(value,count,formula='') {

		if(value == 2){
			var option =``;
			for(var i=count;i>1;i--){
				option +=`<option value='${i}'>Column${i}</option>`;
			}
			$("#formula_"+count).html(option);
			$("#formula_"+count).select2();
			if(formula != ''){
				var myArray = formula.split(",");
				$("#formula_"+count).val(myArray).trigger('change');
			}
			$("#formula_"+count).show();
		}else{
			$("#formula_"+count).hide();
		}

	}
	function CreateTemplate() {
		var form_data = document.getElementById('template');
		let formData = new FormData(form_data);
		// var formData=$("#template").serialize();
		// console.log($("input[name='attribute_name[]'").val());
		if($("#template_name").val()==="" || $("#monthCre").val() === ''|| $("#yearCre").val() === '')
		{

			if($("#template_name").val()=="")
			{
				$("#template_error").html('Enter Template Name and Year and Month');
			}
		}
		else if($("input[name='attribute_name[]'").val()==="")
		{
			toastr.error('Add Atleast One Attribute');
		}
		else
		{
			$.ajax({
				url: "<?= base_url("addHandsonTemplate") ?>",
				type: "POST",
				dataType: "json",
				data:formData,
				contentType: false,
				processData: false,
				success: function (res) {
					console.log(res);
					if(res.status == 200){
						toastr.success(res.body);
						document.getElementById("template").reset();
						$("#Mymodal").modal('hide');
						if(res.prefill==1)
						{
							$("#spreadsheetTemplateId").val(res.temp_id);
							$("#spreadsheetTemplateName").val(res.temp_name);
							$("#handonTableModal").modal('show');
						}
						getTableList();
						getListsheet();
					}else{
						toastr.error(res.body);
					}
				}, error: function (error) {
					toastr.error("Something went wrong please try again");
				}
			});
		}
	}
	function CreateTemplateCopy() {
		var form_data = document.getElementById('templateCopy');
		let formData = new FormData(form_data);
		// var formData=$("#template").serialize();
		// console.log($("input[name='attribute_name[]'").val());
		if($("#yearCopy").val()==="" || $('#monthCopy') == "")
		{
			toastr.error('Please Select Year and Month');

		}
		else
		{
			$.ajax({
				url: "<?= base_url("copyHandsonTemplate") ?>",
				type: "POST",
				dataType: "json",
				data:formData,
				contentType: false,
				processData: false,
				success: function (res) {
					console.log(res);
					if(res.status == 200){
						toastr.success(res.body);
						$('#MymodalCopy').modal('hide');
					}else{
						toastr.error(res.body);
					}
				}, error: function (error) {
					toastr.error("Something went wrong please try again");
				}
			});
		}
	}

	function editfun(template_id,template_name,prefill,valueSignIn){
		$("#template_count").val(0);
		let formData = new FormData();
		formData.append('id', template_id);
		formData.append('template_name', template_name);

		requestToAjax("edithandsontemplate",formData).then(res=>{
			if(res.status == 200){
				$("#Mymodal").modal('show');
				$('ul#template_detail_div').empty();
				getTemplateListDropdown().then(result=>{
					$("#template_name").val('').val(res.template_name);
				});

				$("#template_id").val('').val(template_id);
				$("#company_id").val('').val(res.company_id);
				$("#valueSignIN").val('').val(valueSignIn);
				console.log(getGlAccountList());
				getGlAccountList().then(result=>{
					GlAccountOption=result;
					$('.glaccounts').html(result);
					$.each(res.body, function (key, val) {
						createAddTemplateRow(val);

					});
				});
				// $("#template_count").val('').val(res.body.length);
				if(prefill!="")
				{
					$("input[name=prefill][value=" + prefill + "]").prop('checked', true);
				}

			}else{
				toastr.error(res.body);
			}
		}).
		catch((e) => {
			console.log(e);
		});
	}

	function copyfun(template_id,template_name,prefill){
		$("#MymodalCopy").modal('show');
		$('#template_name_copy').val(template_name);
		$('#template_id_copy').val(template_id);
	}
	function changeStatus(template_id,status) {
		let formData = new FormData();
		formData.set('template_id', template_id);
		formData.set('status', status);
		requestToAjax("changeHandsonTemplateStatus",formData).then(res=>{
			console.log(res);
			if(res.status == 200){
				toastr.success(res.body);
				// $("#Mymodal").modal('hide');
				getTableList();
			}else{
				toastr.error(res.body);
			}
		}).
		catch((e) => {
			console.log(e);
		});
	}
	function requestToAjax(routeItem,itemObject) {
		return new Promise((resolve, reject) => {
			$.ajax({
				url: "<?= base_url() ?>"+routeItem,
				type: "POST",
				dataType: "json",
				data: itemObject,
				contentType:false,
				processData:false,
				success: function (result) {
					resolve(result);
				}, error: function (error) {
					toastr.error("Something went wrong please try again");
					reject(error);
				}
			});
		});
	}
	let hotDiv;
	function fetch_template_handson(temp_id)
	{
		$("#spreadSheetDiv").html('');
		$("#spreadSheetDiv").show();
		$("#spreadSheetBtn").show();
		$("#spreadsheetTemplateId").val(temp_id);
		var form_data=new FormData();
		form_data.set('temp_id',temp_id);
		$.ajax({
			type: "POST",
			url: "<?= base_url("fetch_templatesToolHandsonData") ?>",
			dataType: "json",
			data: form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {

					//console.log(result.columnHeaders);

					result.columnHeaders.push("Value Type","Select Addition Sequence","Select Substration Sequence","Is Opening Balance","Closing Balance Column","Manual currency conversion value");
					var columns=result.columnHeaders;
					var rows=[
						['', '', '', '', ''],
					];
					if(result.columnRows!="")
					{
						rows=result.columnRows;
						rows.push(['', '', '', '', '']);
					}
					if(columns.length<3)
					{
						$("#spreadSheetBtn").hide();
						$("#spreadSheetDiv").hide();
					}
					var types=result.columnTypes;
					var arraySource=['Manual','Calculated'];
					var arraySource1=['Yes','No'];
					types.push({type: 'dropdown',source:arraySource},{type: 'text'},{type: 'text'},{type: 'dropdown',source:arraySource1},{type: 'text'},{type: 'dropdown',source:arraySource1});
					var hideArra = result.hideArra;
					var hideColumn={
						columns: hideArra,
						copyPasteEnabled: false,
					};
					var readonlyArray=result.readonlyArray;
					createHandonTable(columns, rows, types, 'spreadSheetDiv', hideColumn,readonlyArray);

				} else {
				}
			}
		});
	}


	function createHandonTable(columnsHeader, columnRows, columnTypes, divId, hideColumn = true,readonlyArray) {
		$(".filterBtn").show();
		var element = document.getElementById(divId);
		hotDiv != null ? hotDiv.destroy() : '';
		hotDiv = new Handsontable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			formulas: true,
			manualColumnResize: true,
			manualRowResize: true,
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
			afterFilter: function (conditionsStack) {
				if(conditionsStack.length>0)
				{
					$(".filterBtn").hide();
				}
				else {
					$(".filterBtn").show();
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
			minSpareRows: 1,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'

		});
		hotDiv.validateCells();
	}

	function saveSpreadSheetTool()
	{
		// $.LoadingOverlay("show");
		var data = hotDiv.getData();
		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('temp_id',$("#spreadsheetTemplateId").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("savePrefillTemplateTool") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					$("#handonTableModal").modal('hide');
				} else {
					toastr.error(result.body);
				}

			}
		});
	}

	function saveSpreadSheetAssignment() {
		var form_data = document.getElementById('spreadsheetFormAssign');
		let formData = new FormData(form_data);
		$.ajax({
			type: "POST",
			url: "<?= base_url("SaveSpreadSheetAssignment") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					$("#AssignModal").modal('hide');
				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	function getcompanyList() {
		$.ajax({
			type: "POST",
			url: "<?= base_url("getLisCompany") ?>",
			dataType: "json",
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					$("#company_id").html(result.data);
				} else {

				}

			}
		});
	}
	function getListsheet() {
		$.ajax({
			type: "POST",
			url: "<?= base_url("getListsheet") ?>",
			dataType: "json",
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					$("#sheet_id").html(result.data);
				} else {

				}

			}
		});
	}
	function getBranchList() {
		var company_id=$("#company_id").val();
		let formData = new FormData();
		formData.set('company_id', company_id);
		$.ajax({
			type: "POST",
			url: "<?= base_url("getTemplateBranchData") ?>",
			dataType: "json",
			data:formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");

				if (result.status == 200) {
					var option=``;
					var res=result.data;
					$(res).each(function( index,data ) {
						option += `<option value="${data['id']}">${data['name']}</option>`;
					});
					$("#branch_id").html(option);
				} else {

				}

			}
		});
	}
	function editSubsidiaryAccountfun(template_id,template_name){
		$("#ScheduleAccountMapp").modal('show');
		$("#scheduleTemplateID").val(template_id);
		$("#scheduleTemplateName").val(template_name);
		$("#ScheduleAccountMappLable").html(template_name);
		$("#SubMappDiv").html('');
		$("#clearSubMapp").hide();
		getScheduleCompany();
	}
	function getScheduleCompany() {
		$.ajax({
			type: "POST",
			url: "<?= base_url("getScheduleCompany") ?>",
			dataType: "json",
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					$("#scheduleCompany").html(result.body);
					$("#scheduleCompany").select2();
				} else {
					$("#scheduleCompany").html(result.body);
					$("#scheduleCompany").select2();
				}
			}
		});
	}
	function getScheduleAccountMapping(companyId) {
		let formData = new FormData();
		formData.set('company_id', companyId);
		formData.set('temp_id', $("#scheduleTemplateID").val());
		formData.set('month', $("#monthSelect").val());
		formData.set('year', $("#yearSelect").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("getSubsidiaryAccountMappingData	") ?>",
			dataType: "json",
			data:formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status === 200) {
					$("#clearSubMapp").show();
					// $("#handonTableModal").modal('show');
					var columns = result.columnHeaders;
					var rows = [
						['', '', '', '', ''],
					];
					if (result.columnRows != "") {
						rows = result.columnRows;
						rows.push(['', '', '', '', '']);
					}
					var types = result.columnTypes;
					var hideArra = result.hideArra;
					var hideColumn = {
						// specify columns hidden by default
						columns: hideArra,
						copyPasteEnabled: false,
					};
					var readonlyArray = result.readonlyArray;
					createHandonTable(columns, rows, types, 'SubMappDiv', hideColumn, readonlyArray);

				} else {
					// $("#handonTableModal").modal('hide');
					// $('#tempatetoolBox').hide();
				}
			}
		});
	}
	function saveSubMappData() {
		var company_id= $("#scheduleCompany").val();
		var data = hotDiv.getData();
		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('company_id', company_id);
		formData.set('temp_id', $("#scheduleTemplateID").val());
		formData.set('year', $("#yearSelect").val());
		formData.set('month', $("#monthSelect").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveSubMappData") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	$('#Mymodal').on('shown.bs.modal', function (e) {
		$("#charLetter").val('C');
	})
	function clearScheduleSubsidiaryMapp() {
		var company_id= $("#scheduleCompany").val();
		let formData = new FormData();
		formData.set('company_id', company_id);
		formData.set('temp_id', $("#scheduleTemplateID").val());
		formData.set('year', $("#yearSelect").val());
		formData.set('month', $("#monthSelect").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("clearScheduleSubsidiaryMapp") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					getScheduleAccountMapping(company_id);
				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	function editCurrencyRatefun(template_id,template_name){
		$("#CurrencyRateMapp").modal('show');
		$("#currencyTemplateID").val(template_id);
		$("#currencyTemplateName").val(template_name);
		$("#CurrencyRateMappLable").html(template_name);
		$("#CurrencyRateMappDiv").html('');
		$("#clearCurrencyRate").hide();
		getCurrencyrateCompany();
	}
	function getCurrencyrateCompany() {
		$.ajax({
			type: "POST",
			url: "<?= base_url("getScheduleCompany") ?>",
			dataType: "json",
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					$("#CurrencyRateCompany").html(result.body);
					$("#CurrencyRateCompany").select2();
				} else {
					$("#CurrencyRateCompany").html(result.body);
					$("#CurrencyRateCompany").select2();
				}
			}
		});
	}
	function getCurrencyRateMapping(company_id) {
		let formData = new FormData();
		formData.set('company_id', company_id);
		formData.set('temp_id', $("#currencyTemplateID").val());
		formData.set('month', $("#monthSelect").val());
		formData.set('year', $("#yearSelect").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("getCurrencyRateMapping	") ?>",
			dataType: "json",
			data:formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status === 200) {
					$("#clearCurrencyRate").show();
					// $("#handonTableModal").modal('show');
					var columns = result.columnHeaders;
					var rows = [
						['', '', '', '', ''],
					];
					if (result.columnRows != "") {
						rows = result.columnRows;
						rows.push(['', '', '', '', '']);
					}
					var types = result.columnTypes;
					var hideArra = result.hideArra;
					var hideColumn = {
						// specify columns hidden by default
						columns: hideArra,
						copyPasteEnabled: false,
					};
					var readonlyArray = result.readonlyArray;
					createHandonTable(columns, rows, types, 'CurrencyRateMappDiv', hideColumn, readonlyArray);

				} else {
					// $("#handonTableModal").modal('hide');
					// $('#tempatetoolBox').hide();
				}
			}
		});
	}
	function saveCurrencyRateMappData() {
		var company_id= $("#CurrencyRateCompany").val();
		var data = hotDiv.getData();
		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('company_id', company_id);
		formData.set('temp_id', $("#currencyTemplateID").val());
		formData.set('year', $("#yearSelect").val());
		formData.set('month', $("#monthSelect").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveCurrencyRateMappData") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	function clearCurrencyRateMapp() {
		var company_id= $("#CurrencyRateCompany").val();
		let formData = new FormData();
		formData.set('company_id', company_id);
		formData.set('temp_id', $("#currencyTemplateID").val());
		formData.set('year', $("#yearSelect").val());
		formData.set('month', $("#monthSelect").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("clearCurrencyRateMapp") ?>",
			dataType: "json",
			data: formData,
			contentType: false,
			processData: false,
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					getScheduleAccountMapping(company_id);
				} else {
					toastr.error(result.body);
				}

			}
		});
	}
	function getTemplateListDropdown() {
		$("#template_name").html('');
		return new Promise((resolve, reject) => {
		let formData = new FormData();
		$.ajax({
			type: "POST",
			url: "<?= base_url("getTemplateListDropdown") ?>",
			dataType: "json",
			success: function (result) {
				// $.LoadingOverlay("hide");
				if (result.status == 200) {
					$("#template_name").append(result.body);
					resolve(true);
				} else {
					$("#template_name").html('');
					resolve(true);
				}

			}
		});
		});
	}
</script>
