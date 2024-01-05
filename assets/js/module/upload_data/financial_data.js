$( document ).ready(function() {
		// $.LoadingOverlay("show");
	// getFinancialList();
});
function getFinancialList() {
 $.LoadingOverlay("show");
	let filteryear = document.getElementById("filteryear").value;
	let filterquarter = document.getElementById("filterquarter").value;
	let filterStatus = document.getElementById("filterStatus").value;

	let quarter = $("#quarter option:selected").text();
	let branch = $("#branch_id option:selected").text();
	let year = $("#year option:selected").text();
	// console.log(branch);
	// let filterStatus = document.getElementById("branch_id").value;

	let formData = new FormData();
	formData.set("year",filteryear);
	formData.set("quarter",filterquarter);
	formData.set("status",filterStatus);
	
	formData.set("target_quarter",quarter);
	formData.set("target_branch",branch);
	formData.set("target_year",year);


	app.request(baseURL + "getFinancialData_upload",formData).then(res=>{
		$.LoadingOverlay("hide");
		$("#FinancialTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			 
			columns:[

				{data: 0},
				// {data: 1}
				
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				

			}
		});
	});
}
function getFinancialListDashboard() {
 $.LoadingOverlay("show");
	let filteryear = document.getElementById("filteryear").value;
	let filterquarter = document.getElementById("filterquarter").value;
	let filterStatus = document.getElementById("filterStatus").value;

	let formData = new FormData();
	formData.set("year",filteryear);
	formData.set("quarter",filterquarter);
	formData.set("status",filterStatus);

	app.request(baseURL + "getFinancialData_list",formData).then(res=>{
		$.LoadingOverlay("hide");
		$("#FinancialTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				{data: 2},
				{data: 3},
				{data: 4},
				// {
				// 	data: 5,
				// 	render: (d, t, r, m) => {
				// 			return `<a href="${base_url+d}" download="${d}"><i class="fa fa-lg fa-download"></i></a>`

				// 	}
				// },
				{data: 6},
				{data: 7},
				{data: 8},
				{data: 9},
				{
					data: 1,
					render: (d, t, r, m) => {
						if(r[10] == 2){
							// var btn_desable = '';
							// var class_disable = '';
							// if (r[11] === 0) {
							// 	btn_desable = 'disabled';
							// 	class_disable = 'disabled_element';
							// 	return `<a href="JavaScript:Void(0);" class="${class_disable}" ${btn_desable}><i class="fa fa-eye"></i></a>`
							// }else{
								return `<a href="upload_data?id=${d}&template=1"><i class="fa fa-eye"></i></a> 
										<a href="${base_url}excelUploadValidation?id=${d}&branch_id=${r[15]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`
							// }
						}else{
							// var btn_desable = '';
							// var class_disable = '';
							// if (r[11] === 0) {
							// 	btn_desable = 'disabled';
							// 	class_disable = 'disabled_element';
							// 	return `<a href="JavaScript:Void(0);" class="${class_disable}" ${btn_desable}><i class="fa fa-eye"></i></a>`
							// }else{
								return `<a href="user_excel_view?id=${d}"><i class="fa fa-eye"></i></a>
										<a href="${base_url}excelUploadValidation?id=${d}&branch_id=${r[15]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`
							// }

						}

					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				if(aData[10] == 2){
					// var btn_desable = '';
					// var class_disable = '';
					// if (aData[11] == 0) {
					// 	btn_desable = 'disabled';
					// 	class_disable = 'disabled_element';
					// 	$('td:eq(9)', nRow).html(`<a href="JavaScript:Void(0);" class="${class_disable}" ${btn_desable}><i class="fa fa-eye"></i></a>`);
					// }else{
						$('td:eq(8)', nRow).html(`<a href="upload_data?id=${aData[1]}&template=1"><i class="fa fa-eye"></i></a>
												<a href="${base_url}excelUploadValidation?id=${aData[1]}&branch_id=${aData[15]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`);
					// }
				}else{
					// var btn_desable = '';
					// var class_disable = '';
					// if (aData[11] == 0) {
					// 	btn_desable = 'disabled';
					// 	class_disable = 'disabled_element';
					// 	$('td:eq(9)', nRow).html(`<a href="JavaScript:Void(0);"  class="${class_disable}" ${btn_desable}><i class="fa fa-eye"></i></a>`);
					// }else{
						$('td:eq(8)', nRow).html(`<a href="user_excel_view?id=${aData[1]}"><i class="fa fa-eye"></i></a>
												<a href="${base_url}excelUploadValidation?id=${aData[1]}&branch_id=${aData[15]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`);
					// }

				}

			}
		});
	});
}
function getIntraCompanyList() {
 $.LoadingOverlay("show");
	app.request(baseURL + "getIntraCompanyTransfer",null).then(res=>{
		$.LoadingOverlay("hide");
		$("#intraTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				// {data: 2},
				// {data: 4},
				{data: 6},
				{data: 7},
				{
					data: 1,
					render: (d, t, r, m) => {
						// if(r[10] == 2){
							
								return `<a href="${base_url}viewIntraCompanyDetails/${d}"><i class="fa fa-eye"></i></a>`
							

						// }else{
							
								// return `<a href="user_excel_view?id=${d}"><i class="fa fa-eye"></i></a>`
							

						// }

					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				// if(aData[10] == 2){
					
						$('td:eq(6)', nRow).html(`<a href="${base_url}viewIntraCompanyDetails/${aData[1]}"><i class="fa fa-eye"></i></a>`);
					

				// }else{
					
						// $('td:eq(9)', nRow).html(`<a href="user_excel_view?id=${aData[1]}" "><i class="fa fa-eye"></i></a>`);
					
				// }
			}
		});
	});
}
function intraTransactionTable() {
 $.LoadingOverlay("show");
	var formData=new FormData();
	formData.set('insertID',$("#insertID").val());
	app.request(base_url + "getIntraTransactionTable",formData).then(res=>{
		$.LoadingOverlay("hide");
		if(res.status==200)
		{
			console.log(res.data);
			$("#intraTransactionTable").DataTable({
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
						var click=``;
						
							if(r[7]==1)
							{
								if(r[9]==1)
								{
									click=`onclick="approveIntraStatus(${d},0)"`;
								}
								return `<a class="badge badge-success" ${click}>Approved</a>`;
							}
							else
							{
								if(r[9]==1)
								{
									click=`onclick="approveIntraStatus(${d},1)"`;
								}
								return `<a class="badge badge-danger" ${click}>Not Approve</a>`;
							}
						
						
					}
				},
				{
					data: 6,
					render: (d, t, r, m) => {
						if(r[8]==1)
						{
							return `<a class="btn btn-link" onclick="deleteIntraTrasaction(${d})"><i class="fa fa-trash"></i></a>`;
						}
						else{
							return `-`;
						}
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				var click=``;
				

					if(aData[7]==1)
					{
						if(aData[9]==1)
						{
							click=`onclick="approveIntraStatus(${aData[6]},0)"`;
						}
						$('td:eq(6)', nRow).html(`<a class="badge badge-success" ${click}>Approved</a>`);
					}
					else
					{
						if(aData[9]==1)
						{
							click=`onclick="approveIntraStatus(${aData[6]},1)"`;
						}
						$('td:eq(6)', nRow).html(`<a class="badge badge-danger" ${click}>Not Approve</a>`);
					}
				
					
					if(aData[8]==1)
					{
						$('td:eq(7)', nRow).html(`<a class="btn btn-link" onclick="deleteIntraTrasaction(${aData[6]})"><i class="fa fa-trash"></i></a>`);
					}
					else
					{
						$('td:eq(7)', nRow).html(``);
					}
				}
			});
		}
		else
		{
			toastr.error(res.data);
		}
		
	});
}
function deleteIntraTrasaction(id)
{
		$.LoadingOverlay("show");
	var formData=new FormData();
		formData.set('id',id);
		app.request(base_url + "deleteIntraTrasaction",formData).then(res=>{
		$.LoadingOverlay("hide");
			if(res.status == 200) {
				toastr.success(res.data);
				intraTransactionTable();
			}
			else
			{
				toastr.error(res.data);
			}
		}).catch(e => {
 			$.LoadingOverlay("hide");
			console.log(e);
		});
}
function approveIntraStatus(id,status)
{
		$.LoadingOverlay("show");
	var formData=new FormData();
		formData.set('id',id);
		formData.set('status',status);
		app.request(base_url + "approveIntraStatus",formData).then(res=>{
		$.LoadingOverlay("hide");
			if(res.status == 200) {
				toastr.success(res.data);
				intraTransactionTable();
			}
			else
			{
				toastr.error(res.data);
			}
		}).catch(e => {
 $.LoadingOverlay("hide");
			console.log(e);
		});
}
