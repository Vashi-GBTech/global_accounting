$( document ).ready(function() {
		$.LoadingOverlay("show");
	getCompanyList();
	getCurrencyList();
});
function getCompanyList() {
	app.request(baseURL + "getCompanyData",null).then(res=>{
		//$.LoadingOverlay("show");
		$("#companyTable").DataTable({
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
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(5)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
			}
		});
		$.LoadingOverlay("hide");
	});
}
function CreateCompany() {
		$.LoadingOverlay("show");
	var form_data = document.getElementById('uploadCompany');
	let formData = new FormData(form_data);
	app.request(baseURL + "CreateUpdateCompany",formData).then(res=>{
		$.LoadingOverlay("hide");
		if(res.status == 200){
			toastr.success(res.body);
			$("#fire-modal-company").modal('hide');
			getCompanyList();
		}else{
			toastr.error(res.body);
		}
	});
}
function openModal() {
	$("#company_name").val("");
	$("#mail_id").val("");
	$("#type").val("");
	$('#month').val("");
	$('#country').val("");
	$('#currency').val("");
	$("#update_id").val("");
}


function editfun(id) {
		$.LoadingOverlay("show");
	$("#fire-modal-company").modal('show');
	$("#update_id").val(id);
	let formData = new FormData();
	formData.set("id", id);
	app.request(baseURL + "getDataCompanyByID",formData).then(res=>{
		$.LoadingOverlay("hide");

		if(res.status == 200){
			$("#company_name").val(res.data.name);
			$("#mail_id").val(res.data.email_id);
			$("#type").val(res.data.type);
			$('#month').val(res.data.start_month);
			$('#country').val(res.data.country);
			$('#currency').val(res.data.currency);
		}else{
			$("#company_name").val("");
			$("#mail_id").val("");
			$("#type").val("");
			$('#month').val("");
			$('#country').val("");
			$('#currency').val("");
		}
	});
}

let currency=[];
let country=[];
function getCurrencyList() {
	app.request(baseURL + "getCurrencyCountry",null).then(res=>{
		$("#country").html(res.options);
		currency=res.currency;
		country=res.country;
		$.LoadingOverlay("hide");
	});
}
function getCurrencyCountry() {
	var con=$("#country").val();
	$("#currency").val(currency[con]);
}
