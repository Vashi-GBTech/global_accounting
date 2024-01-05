<?php
$this->load->view('_partials/header');
?>

<div class="content-page">
	<div class="content">
		<div class="container">

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">Templates</h4>

						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<div class="card-header clearfix">
							<div class="card-title clearfix">
								<h4 class="m-t-0 m-b-20 header-title"><b>Assign Templates</b></h4>
								<button type="button" onclick="openaddModal()"  class="btn btn-primary roundCornerBtn4"><i class="fa fa-plus"></i> Assign Template</button>
							</div>
						</div><br>

						<div class="card">
							<table id="table_lists" class="display">
								<thead>
								<tr>
									<th>#</th>
									<th>Company Name</th>
									<th>Subsidiary Account Name</th>
									<th>Template Name</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>


			<div class="modal small fade" id="Mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h3 id="myModalLabel">Assign Template</h3>
						</div>
						<div class="modal-body">
<!--							<form id="template" method="post">-->
								<div class="row" id="template_master_div">
									<div class="col-md-6 form-group">
<!--										<input type="hidden" id="hdn_template_id" name="hdn_template_id">-->
<!--										<input type="hidden" id="hdn_table_name" name="hdn_table_name">-->
<!--										<label>Template Name</label><br>-->
<!--										<input type="text" id="template_name" name="template_name" class="form-control" placeholder="Template Name">-->
									</div>
									<div class="col-md-6 form-group">
									</div>
								</div>

								<div class="row-fluid"  id="template_detail_div">
									<form id="assignTemplateForm" name="assignTemplateForm" method="post">
										<div class="row form-group">
											<div class="col-md-6">
												<select name="company_name" class="form-control" id="company_name" onchange="getBranchData(this);">
													<option value="">Please select company</option>
												</select>
											</div>
											<div class="col-md-6">
												<select name="branch_name[]" class="form-control" id="branch_name" multiple style="height: 38px;">
													<option value="">Please select branch</option>
												</select>
											</div>
										</div>

										<div class="row form-group">
											<div class="col-md-12">
												<select name="template_name" class="form-control" id="template_name">
													<option value="">Please select Template</option>
												</select>
											</div>
										</div>
									</form>

								</div>
								<div id="add_more_div">
<!--									<button type="button" id="btn_add_more" class="btn btn-info"><i class="fa fa-plus"></i></button>-->
								</div>

<!--							</form>-->
						</div>
						<div class="modal-footer" id="template_footer">
							<button class="btn btn-default roundCornerBtn4" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button id="create_template" class="btn btn-primary pull-right roundCornerBtn4" type="button"  onclick="assignTemplate()"><i class="fa fa-save"></i>Save</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$this->load->view('_partials/footer');
?>
<script>
	$(document).ready(function(){
		// getCompanyList();
		// getTemplateList();
		getTemplateBranchAssignList();
	})


	function getTemplateBranchAssignList() {
		app.request(baseURL + "getTemplateBranchAssignList",null).then(res=>{
			console.log("table lists response = "+res);
			$("#table_lists").DataTable({
				destroy: true,
				order: [],
				data:res.data,
				"pagingType": "simple_numbers",
				columns:[

					{data: 0},
					{data: 4},
					{data: 3},
					{data: 2},

				],

			});
		});
	}

	function getCompanyList() {
		app.request(baseURL + "getTemplateCompanyData",null).then(res=>{
			console.log("Company lists response = "+res.data);
			var options = '';
			$.each(res.data, function (val,key) {
				options += `<option value="${key.id}">${key.name}</option>`;
				// console.log("Company lists response = "+key +" "+val);
			})
			$("#company_name").append(options);
			// console.log(options);
		});
	}
	function getTemplateList() {
		app.request(baseURL + "getTemplateData",null).then(res=>{
			console.log("Template lists response = "+res.data);
			var options = '';
			$.each(res.data, function (val,key) {
				options += `<option value="${key.id}">${key.name}</option>`;
				// console.log("Company lists response = "+key +" "+val);
			})
			$("#template_name").append(options);
			// $("#template_name").select2();
			// console.log(options);
		});
	}

	function getBranchData() {
		$("#branch_name").empty();
		var company_id = $("#company_name").val();
		// alert(company_id);
		let formData = new FormData();
		formData.set("company_id", company_id);
		var options = '';
		app.request(baseURL + "getTemplateBranchData",formData).then(res=>{
			console.log("branch lists response = "+res.data);
			if(res.status == 200){
				var options = '';
				$.each(res.data, function (val,key) {
					options += `<option value="${key.id}">${key.name}</option>`;
					// console.log("Company lists response = "+key +" "+val);
				})
				$("#branch_name").empty().append(options);
				$("#branch_name").select2();
			}
		});
	}

	function getBranchList() {
		app.request(baseURL + "getBranchList",null).then(res=>{
			console.log("table lists response = "+res);
			$("#table_lists").DataTable({
				destroy: true,
				order: [],
				data:res.data,
				"pagingType": "simple_numbers",
				columns:[

					{data: 0},
					{data: 1},
					{
						data: 2,
						render: (d, t, r, m) => {
							return `<button type="button" onclick="editfun(${d})" class="btn btn-primary"><i class="fa fa-pencil"></i></button>`
						}
					},
				],
				fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

					$('td:eq(3)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-primary"><i class="fa fa-pencil"></i></button>`);
				}
			});
		});
	}

	function getTableList() {
		app.request(baseURL + "getTablesList",null).then(res=>{
			console.log("table lists response = "+res);
			$("#table_lists").DataTable({
				destroy: true,
				order: [],
				data:res.data,
				"pagingType": "simple_numbers",
				columns:[

					{data: 0},
					{data: 1},
					{
						data: 2,
						render: (d, t, r, m) => {
							return `<button type="button" onclick="editfun(${d})" class="btn btn-primary"><i class="fa fa-pencil"></i></button>`
						}
					},
				],
				fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

					$('td:eq(3)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-primary"><i class="fa fa-pencil"></i></button>`);
				}
			});
		});
	}

	function remove_div(elm){
		$(elm).closest('div.new_attr_row').remove();
	}
	function openaddModal(){
		$("#Mymodal").modal('show');
		$('#company_name').empty().append('<option>Select Company</option>');
		$('#branch_name').empty().append('<option>Select Branch</option>');
		$('#template_name').empty().append('<option>Select Template</option>');
		getCompanyList();
		getTemplateList();
	}

	function assignTemplate() {
		// console.log($("#branch_name"));
		var company_name = $('#company_name').val();
		var branch_id = $('#branch_name').val();
		var template_id = $('#template_name').val();
		let formData = new FormData();
		formData.set("company_name", company_name);
		formData.set("branch_id", branch_id);
		formData.set("template_id", template_id);
		if(company_name != '' && branch_id != '' && template_id !=''){
			app.request(baseURL + "assignTemplateToBranch",formData).then(res=>{
				console.log(res);
				if(res.status == 200){
					toastr.success(res.body);
					$("#Mymodal").modal('hide');
					getTemplateBranchAssignList();
					// getTableList();
				}else{
					toastr.error(res.body);
				}
			});
		}else{
			toastr.error("Please fill all the details.");
		}
	}

	function editfun(template_id){
		// alert(template_id);
		// var form_data = document.getElementById('template');
		let formData = new FormData();
		formData.append('id', template_id);

		app.request(baseURL + "edittemplate",formData).then(res=>{
			console.log("edit template "+res);
			if(res.status == 200){

				toastr.success(res.body);
				$("#Mymodal").modal('show');

				$('div#template_detail_div').empty();
				$("#create_template").remove();
				$("#template_footer").append('<button id="create_template" class="btn btn-primary pull-right roundCornerBtn4" type="button"  onclick="updateTemplate()"><i class="fa fa-save"></i>Update</button>');

				$("#hdn_template_id").val('').val(res.template_master.id);
				$("#hdn_table_name").val('').val(res.template_master.Template_table_name);
				$("#template_name").val('').val(res.template_master.template_name);

				// $.each(data.programs, function (i) {
					$.each(res.data, function (key, val) {
						// val.attribute_type == "numeric" ? "selected" : '';
						var template_detail = `<div class="row">
							<div class="col-md-3 form-group">
							<input type="hidden" name="hdn_update_id[]" value="${val.id}">
							<input type="text" name="attribute_name[]" class="form-control" placeholder="Attribute Name" value="${val.attribute_name}">
							</div>
							<div class="col-md-3 form-group">
							<select name="attribute_type[]" class="form-control">
							<option value="">Please select type</option>
							<option value="numeric" ${val.attribute_type == 'numeric' ? 'selected' : ''}>Numeric</option>
							<option value="alpha_numeric"  ${val.attribute_type == 'alpha_numeric' ? 'selected' : ''}>Alpha Numeric</option>
							<option value="text"  ${val.attribute_type == 'text' ? 'selected' : ''}>Text</option>
							<option value="date"  ${val.attribute_type == 'date' ? 'selected' : ''}>Date</option>
							</select>
							</div>
							<div class="col-md-3 form-group">
							<input type="text" name="attribute_query[]" class="form-control" placeholder="Attribute Query" value="${val.attribute_query}">
							</div>
							<div class="col-md-2 form-group">
							<input type="text" name="sequence[]" class="form-control" placeholder="Sequence" value="${val.sequence}">
							</div>
							<div class="col-md-1 form-group">
							</div>
							</div>`;
						$("#template_detail_div").append(template_detail);
						// alert(val.id);
					});
				// });
				// getTableList();
			}else{
				toastr.error(res.body);
			}
		});
	}
	function updateTemplate() {
		var form_data = document.getElementById('template');
		let formData = new FormData(form_data);
		// formData.append('temp_id', template_id);
		app.request(baseURL + "updatetemplate",formData).then(res=>{
			console.log(res);
			if(res.status == 200){
				toastr.success(res.body);
				$("#Mymodal").modal('hide');
				getTableList();
			}else{
				toastr.error(res.body);
			}
		});
	}

</script>
</div>
