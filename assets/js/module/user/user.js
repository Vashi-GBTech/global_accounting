$( document ).ready(function() {
	getUserList();
	getCompanyList();
});
function getUserList() {
		$.LoadingOverlay("show");
	app.request(baseURL + "getUserData",null).then(res=>{
		$.LoadingOverlay("hide");
		$("#UserTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				{data: 2},
				{data: 3},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<button type="button" onclick="editfun(${d})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`
					}
				},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<button type="button" onclick="permissionfun(${d})" class="btn btn-link"><i class="fa fa-users"></i></button>`
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(5)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
				$('td:eq(6)', nRow).html(`<button type="button" onclick="permissionfun(${aData[1]})" class="btn btn-link"><i class="fa fa-users"></i></button>`);
			}
		});
	}).catch(e => {
		console.log(e);
	});
}

function CreateUser() {
		$.LoadingOverlay("show");
	var form_data = document.getElementById('uploadUsers');
	let formData = new FormData(form_data);
	app.request(baseURL + "CreateUpdateUsers",formData).then(res=>{
		$.LoadingOverlay("hide");
		if(res.status == 200){
			toastr.success(res.body);
			$("#fire-modal-users").modal('hide');
			getUserList();
		}else{
			toastr.error(res.body);
		}
	});
}

function openModal() {
	$("#fire-modal-users").modal("show");
	$("#user_name").val("");
	$("#mail_id").val("");
	$("#branch_id").val("");
	$("#update_id").val("");
}

function  getCompanyList() {
	app.request(baseURL + "getLisCompany",null).then(res=>{
		if(res.status == 200) {
			$('#company_id').append(res.data);
		}
	}).catch(e => {
		console.log(e);
	});
}


function editfun(id) {
		$.LoadingOverlay("show");
	$("#fire-modal-users").modal('show');
	$("#update_id").val("").val(id);
	let formData = new FormData();
	formData.set("id", id);
	app.request(baseURL + "getDataUserByID",formData).then(res=>{
		$.LoadingOverlay("hide");

		if(res.status == 200){
			$("#user_name").val(res.data.name);
			$("#mail_id").val(res.data.user_name);
			$("#company_id").val(res.data.company_id);
			$("#userType").val(res.data.user_access_type);
		}else{
			$("#user_name").val("");
			$("#mail_id").val("");
			$("#company_id").val("");
			$("#userType").val("");
		}
	});
}
function permissionfun(id) {
		$.LoadingOverlay("show");
	$("#fire-modal-permissions").modal('show');
	let formData = new FormData();
	formData.set("id", id);
	$("#userIdPermission").val(id);
	getPermissionDiv(formData);

}
function getPermissionDiv(formData) {
	app.request(baseURL + "getAllPermissions",formData).then(res=>{
		$.LoadingOverlay("hide");

		if(res.status == 200){
			$("#permissionDiv").html(res.data);
			$("#branch_id").html(res.branch_options); //selectedBranch
		}else{
			$("#permissionDiv").html(res.data);
			$("#branch_id").html(res.branch_options); //selectedBranch
		}
		$("#branch_id").select2();
	});
}

function checkall() {
	let isChecked = $('#allCheck').is(':checked');
	if(isChecked){
		$('.permissionscheck').prop('checked', true);
	}else{
		$('.permissionscheck').prop('checked', false);
	}

}

function saveUsersPermission() {
	if($("#branch_id").val() != null || $("#branch_id").val() != ""){
		$.LoadingOverlay("show");
		var form_data = document.getElementById('uploadUserspermission');
		let formData = new FormData(form_data);
		app.request(baseURL + "saveUsersPermission",formData).then(res=>{
			$.LoadingOverlay("hide");
			if(res.status == 200){
				toastr.success(res.body);
				$("#fire-modal-permissions").modal('hid');
			}else{
				toastr.error(res.body);
			}
		});
	}else{
		toastr.success("Select Branch!");
	}
}
