$( document ).ready(function() {
	$.LoadingOverlay("show");
	getBranchList();
	getBranchList2();
	getListCompany();
	getCurrencyList();
	getReportList();
	getFinancialList();
});
function getBranchList() {
	app.request(baseURL + "getBranchData",null).then(res=>{

	$.LoadingOverlay("hide");
		$("#BranchTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				{data: 2},
				{data: 4},
				{data: 5},
				{data: 6},
				{data: 7},
				{data: 9},
				{data: 8},
				{data: 3},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<button type="button" onclick="editfun(${d})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(9)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
			}
		});
	});
}


function getBranchList2() {
	var formdata = new FormData();
	var type = $('#type').val();
	formdata.set('type',type);
	app.request(baseURL + "getBranchData",formdata).then(res=>{
	$.LoadingOverlay("hide");
		$("#BranchTable2").DataTable({
			searching: false,
			ordering: false,
			info: false,
			lengthChange: false,
			destroy: true,
			order: [],
			data:res.data,
			paging : true,
			pageLength : 3,
			lengthMenu: [[3, 3, 3, 3], [3, 3, 3, 'Todos']],
			// "pagingType": "simple_numbers",
			columns:[

				// {data: 0},
				{data: 2},
				{data: 4},
				{data: 5},
				{data: 9},
				{data: 10},
				// {data: 9},
				// {data: 8},
				{data: 7},
				// {
				// 	data: 1,
				// 	render: (d, t, r, m) => {
				// 		return `<a type="button" onclick="editfun(${d})" class="btn btn-xs"><i class="fa fa-pencil text-info"></i></a>`
				// 	}
				// },
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(9)', nRow).html(`<a type="button" onclick="editfun(${aData[1]})" class="btn btn-xs"><i class="fa fa-pencil text-info"></i></a>`);
			}
		});
	});
}
$("#uploadBranch").validate({
	
	rules: {
		dcompany_id: 'required',
		branch_name: 'required',
		currency: 'required',
		default_currency_rate:'required',
		country: 'required',
		type: 'required',
		percentage: 'required',
		status: 'required',
		month: 'required',

	},
	errorElement: 'span',
	submitHandler: function (form) {
	
					$.LoadingOverlay("show");
	//	var form_data = document.getElementById('uploadCompany');
		let formData = new FormData(form);

		app.request(baseURL + "CreateUpdateBranch",formData).then(res=>{
		$.LoadingOverlay("hide");
			if(res.status == 200){
					// $.LoadingOverlay("hide");
				toastr.success(res.body);
				if($("#dcompany_id").is("select")) {
				    $("#dcompany_id").val("");
				}
				$("#branch_name").val("");
				$("#country").val("");
				$("#currency").val("");
				$("#default_currency_rate").val("");
				$("#type").val("");
				$("#percentage").val("");
				$("#branch_user_id").val("");
				$("#status").val("");
				$("#update_id").val("");
				$("#isSpecialSub").val("");
				$("#transferType").val("");
				$("#fire-modal-company").modal('hide');
				getBranchList();

			}else{
				toastr.error(res.body);
			}
		});
	}
});
function openModal() {
	$("#fire-modal-company").modal('show');
	if($("#dcompany_id").is("select")) {
	    $("#dcompany_id").val("");
	}
	// 
	$("#branch_name").val("");
	$("#currency").val("");
	$("#country").val("");
	$("#default_currency_rate").val("");
	$("#type").val("");
	$("#percentage").val("");
	$("#status").val(1);
	$("#branch_user_id").val("");
	$("#month").val(4);
	$("#update_id").val("");

}
function editfun(id) {
		$.LoadingOverlay("show");
	$("#fire-modal-company").modal('show');
	$("#update_id").val(id);
	let formData = new FormData();
	formData.set("id", id);
	app.request(baseURL + "getDataBranchByID",formData).then(res=>{
		$.LoadingOverlay("hide");

		if(res.status == 200){
			$("#dcompany_id").val(res.data.company_id);
			$("#branch_name").val(res.data.name);
			$("#currency").val(res.data.currency);
			$("#default_currency_rate").val(res.data.default_currency_rate);
			$("#country").val(res.data.country);
			$("#type").val(res.data.type);
			$("#month").val(res.data.start_with);
			$("#percentage").val(res.data.percentage);
			$("#branch_user_id").val(res.data.branch_Userid);
			$("#status").val(res.data.status);
			$("#isSpecialSub").val(res.data.is_special_branch);
			$("#transferType").val(res.data.transfer_type);
		}else{
			$("#dcompany_id").val("");
			$("#branch_name").val("");
			$("#currency").val("");
			$("#default_currency_rate").val(res.data.default_currency_rate);
			$("#country").val("");
			$("#type").val("");
			$("#percentage").val("");
			$("#branch_user_id").val("");
			$("#month").val("");
			$("#isSpecialSub").val("");
			$("#transferType").val("");
		}
	});
}

function getListCompany() {
	app.request(baseURL + "getLisCompany",null).then(res=>{

	$.LoadingOverlay("hide");

		if(res.status == 200){
			if($("#dcompany_id").is("select")) {
			    $("#dcompany_id").html(res.data);
			}
			
		}else{
			if($("#dcompany_id").is("select")) {
			    $("#dcompany_id").html(res.data);
			}
			
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
	});
}
function getCurrencyCountry() {
	var con=$("#country").val();
	$("#currency").val(currency[con]);
}


function getReportList() {
	app.request(baseURL + "getReportList",null).then(res=>{
	$.LoadingOverlay("hide");
		$("#ReportTable2").DataTable({
			searching: false,
			ordering:false,
			info: false,
			lengthChange: false,
			destroy: true,
			order: [],
			data:res.data,
			paging : true,
			pageLength : 3,
			lengthMenu: [[3, 3, 3, 3], [3, 3, 3, 'Todos']],
			// "pagingType": "simple_numbers",
			columns:[
				// {data: 0},
				{data: 1},
				{data: 2},
				{
					data: 4,
					render: (d, t, r, m) => {
						return `<a href="${baseURL}update_report?year=${r[1]}&month=${r[4]}" type="button" class="btn btn-xs"><i class="fa fa-eye text-info"></i></a>`
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(5)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-xs"><i class="fa fa-eye text-info"></i></button>`);
			}
		});
	});
}


function getFinancialList() {
	app.request(baseURL + "getFinancialData_list",null).then(res=>{
	$.LoadingOverlay("hide");
		$("#FinancialData2").DataTable({
			searching: false,
			ordering: false,
			info: false,
			lengthChange: false,
			destroy: true,
			order: [],
			data:res.data,
			paging : true,
			pageLength : 5,
			lengthMenu: [[3, 3, 3, 3], [3, 3, 3, 3]],
			columns:[

				// {data: 0},
				// {data: 2,},
				// {data: 3},
				// {data: 4},
				{data: 6,
					render:(d,t,r,m) => {
						if(r[12] === 1){
							return `<button class="btn btn-link btn-xs"><i class="fa fa-database text-success"></i> </button> ${d}`;
						}else{
							return `<button class="btn btn-link btn-xs"><i class="fa fa-database text-danger"></i> </button> ${d}`;
						}
					}
				},
				{data: 7},
				// {data: 8},
				// {data: 9},
				{
					data: 1,
					render: (d, t, r, m) => {
						if(r[10] == 2){
							return `<a href="upload_data?id=${d}&template=1" class="btn btn-xs"><i class="fa fa-eye text-info"></i></a>`
						}else{
							return `<a href="user_excel_view?id=${d}" class="btn btn-xs"><i class="fa fa-eye text-info"></i></a>`

						}

					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				if(aData[10] == 2){
					$('td:eq(9)', nRow).html(`<a href="upload_data?id=${aData[1]}&template=1" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>`);
				}else{

					$('td:eq(9)', nRow).html(`<a href="user_excel_view?id=${aData[1]}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>`);
				}

			}
		});
	});
}
