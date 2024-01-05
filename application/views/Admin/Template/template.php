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
								<h4 class="m-t-0 m-b-20 header-title"><b>Templates</b></h4>
								<button type="button" onclick="openaddModal()"  class="btn btn-primary roundCornerBtn4"><i class="fa fa-plus"></i> New Template</button>
							</div>
						</div><br>

						<div class="card">
							<table id="table_lists" class="display">
								<thead>
								<tr>
									<th>#</th>
									<th>Table Name</th>
									<th>Edit</th>
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
							<h3 id="myModalLabel">Add Template</h3>
						</div>
						<div class="modal-body">
							<form id="template" method="post">
								<div class="row" id="template_master_div">
									<div class="col-md-6 form-group">
										<input type="hidden" id="hdn_template_id" name="hdn_template_id">
										<input type="hidden" id="hdn_table_name" name="hdn_table_name">
<!--										<label>Template Name</label><br>-->
										<input type="text" id="template_name" name="template_name" class="form-control" placeholder="Template Name">
									</div>
									<div class="col-md-6 form-group">
									</div>
								</div>

								<div class="row-fluid"  id="template_detail_div">

								</div>
								<div id="add_more_div">
									<button type="button" id="btn_add_more" class="btn btn-info roundCornerBtn4 xs_btn"><i class="fa fa-plus"></i></button>
								</div>

							</form>
						</div>
						<div class="modal-footer" id="template_footer">
							<button class="btn btn-default roundCornerBtn4" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button id="create_template" class="btn btn-primary pull-right roundCornerBtn4" type="button" onclick="CreateTemplate()"><i class="fa fa-save"></i> Save</button>
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
		getTableList();
		// $("#table_lists").dataTable();
		// alert("test");
		$("#btn_add_more").click(function () {
			// $('div.new_attr_row').remove();
			var more_field = '<div class="row new_attr_row">\n' +
				'<div class="col-md-3 form-group">\n' +
				'<input type="hidden" name="hdn_update_id[]" value="0">' +
				'<input type="text" name="attribute_name[]" class="form-control" placeholder="Attrbute Name">\n' +
				'</div>\n' +
				'<div class="col-md-3 form-group">\n' +

				'<select name="attribute_type[]" class="form-control">\n' +
					'<option value="">Please select type</option>\n' +
					'<option value="numeric">Numeric</option>\n' +
					'<option value="alpha_numeric">Alpha Numeric</option>\n' +
					'<option value="text">Text</option>\n' +
					'<option value="date">Date</option>\n' +
					'</select>' +
					// '<input type="text" name="attribute_type[]" class="form-control" placeholder="Attrbute Type">\n' +
				'</div>\n' +
				'<div class="col-md-3 form-group">\n' +

				'<input type="text" name="attribute_query[]" class="form-control" placeholder="Attrbute Query">\n' +
				'</div>\n' +
					'<div class="col-md-2 form-group">\n' +
					'<input type="text" name="sequence[]" class="form-control"  placeholder="Sequence">\n' +
					'</div>' +
					'<div class="col-md-1 form-group">\n' +
				'<button type="button" onclick="remove_div(this);" class="btn btn-danger remove_row roundCornerBtn4 xs_btn"><i class="fa fa-times"></i></button>\n' +
				'</div>\n' +
				'</div>';

			$("#template_detail_div").append(more_field);
		});


	})

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
							return `<button type="button" onclick="editfun(${d})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`
						}
					},
				],
				fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

					$('td:eq(3)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
				}
			});
		});
	}

	function remove_div(elm){
		$(elm).closest('div.new_attr_row').remove();
	}
	function openaddModal(){
		$("#Mymodal").modal('show');
		$("#hdn_template_id").val('');
		$("#hdn_table_name").val('');
		$("#template_name").val('');
		$("#create_template").remove();
		$("#template_footer").append('<button id="create_template" class="btn btn-primary pull-right roundCornerBtn4" type="button"  onclick="CreateTemplate()"><i class="fa fa-save"></i>Save</button>');

		// $('div.new_attr_row').remove();
		$('div#template_detail_div').empty();
		var template_detail = '<div class="row">\n' +
				'<div class="col-md-3 form-group">\n' +
				'<input type="text" name="attribute_name[]" class="form-control" placeholder="Attribute Name">\n' +
				'</div>\n' +
				'<div class="col-md-3 form-group">\n' +
				'<select name="attribute_type[]" class="form-control">\n' +
				'<option value="">Please select type</option>\n' +
				'<option value="numeric">Numeric</option>\n' +
				'<option value="alpha_numeric">Alpha Numeric</option>\n' +
				'<option value="text">Text</option>\n' +
				'<option value="date">Date</option>\n' +
				'</select>' +
				// '<input type="text" name="attribute_type[]" class="form-control" placeholder="Attribute Type">\n' +
				'</div>\n' +
				'<div class="col-md-3 form-group">\n' +
				'<input type="text" name="attribute_query[]" class="form-control" placeholder="Attribute Query">\n' +
				'</div>\n' +
				'<div class="col-md-2 form-group">\n' +
				'<input type="text" name="sequence[]" class="form-control" placeholder="Sequence">\n' +
				'</div>\n' +
				'<div class="col-md-1 form-group">\n' +
				'\n' +
				'</div>\n' +
				'</div>';
		$("#template_detail_div").append(template_detail);
	}

	function CreateTemplate() {
		var form_data = document.getElementById('template');
		let formData = new FormData(form_data);
		app.request(baseURL + "addtemplate",formData).then(res=>{
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
