$("#uploadDerivedSetup").validate({

	rules: {
		derivedGL: 'required',
		glDetail: 'required',
		derived_formula: 'required',
	},
	errorElement: 'span',
	submitHandler: function (form) {

		$.LoadingOverlay("show");
		//	var form_data = document.getElementById('uploadCompany');
		let formData = new FormData(form);

		app.request(baseURL + "uploadDerivedSetup",formData).then(res=>{
			$.LoadingOverlay("hide");
			if(res.status == 200){
				$("#uploadDerivedSetup")[0].reset();
				getDerivedGlList();
				toastr.success(res.body);
			}else{
				toastr.error(res.body);
			}
		});
	}
});
function copyText(id)
{
	var $temp = $("<input>");
	$(".modal-body").append($temp);
	$temp.val($('#'+id).text()).select();
	document.execCommand("copy");
	$temp.remove();
}
function copyTextFormula(id,type)
{
	var $temp = $("<input>");
	$(".modal-body").append($temp);
	//"/#+[\w\s\-]*@+/i"
	var data=$('#'+id).val();
	var matches = data.match(/#+[\w\s\-]*@+/g);
	for(var i=0;i<matches.length;i++){
		if(data.indexOf(matches[i]) !== -1){
			var value= "("+ matches[i] +")";
			data=data.replace(matches[i],value)
		}
	}
	// var copyText='<code>'+data+'</code>';
	$temp.val(data).select();
	document.execCommand("copy");
	$temp.remove();
	if(type==2)
	{
		$('#'+id).val('');
	}
}
function pasteText(id,sign)
{
	// console.log($('#'+id).val()+sign);
	$('#'+id).val($('#'+id).val() + sign);
}
function getGlAccountData(type)
{
	$("#gl_table").html('');
	if(type!="")
	{
		let formData = new FormData();
		formData.set('type',type);
		app.request(base_url + "getGlAccountData",formData).then(res=>{
			if(res.status==200)
			{
				$("#gl_table").append(res.body);

			}
			else
			{
				toastr.error(res.body);
			}
		});
	}
	else
	{
		toastr.error('select type');
	}
}
function groupYearData(type)
{
	$("#groupYearData").html('');
	if(type!="")
	{
		let formData = new FormData();
		formData.set('type',type);
		app.request(base_url + "getGroupYearData",formData).then(res=>{
			if(res.status==200)
			{
				$("#groupYearData").append(res.body);

			}
			else
			{
				toastr.error(res.body);
			}
		});
	}
	else
	{
		toastr.error('select type');
	}
}
function groupYearData2(type)
{
	$("#groupYearData2").html('');
	if(type!="")
	{
		let formData = new FormData();
		formData.set('type',type);
		app.request(base_url + "getGroupYearData2",formData).then(res=>{
			if(res.status==200)
			{
				$("#groupYearData2").append(res.body);

			}
			else
			{
				toastr.error(res.body);
			}
		});
	}
	else
	{
		toastr.error('select type');
	}
}
function groupYearData1(type)
{
	$("#groupYearData1").html('');
	if(type!="")
	{
		let formData = new FormData();
		formData.set('type',type);
		app.request(base_url + "getGroupYearData1",formData).then(res=>{
			if(res.status==200)
			{
				$("#groupYearData1").append(res.body);

			}
			else
			{
				toastr.error(res.body);
			}
		});
	}
	else
	{
		toastr.error('select type');
	}
}
function getDerivedGlList() {
	app.request(baseURL + "getDerivedGlList",null).then(res=>{
		console.log(res)
		$("#derivedMappingTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[
				{data: 0},
				{data: 1},
				{
					data: 2
				},
				{
					data: 3
				},
				{
					data: 4,
					render: (d, t, r, m) => {
								return `<a type="button" onclick="editDerivedGL(${d})" class="btn btn-xs"><i class="fa fa-edit text-primary"></i></a>
										<a type="button" onclick="deleteDerivedGL(${d})" class="btn btn-xs"><i class="fa fa-trash text-danger"></i></a>`
							}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {


				// $('td:eq(2)', nRow).html(`<a href="${base_url}reportMakerByMonthVersion3?id=${aData[1]}&templateName=${aData[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`);
				$('td:eq(5)', nRow).html(`<a href="${base_url}tableReportMakerVarsion3/${aData[1]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`);


			}
		});
	});
}
function editDerivedGL(id) {
	let formData = new FormData();
	formData.set('id',id);
	app.request(base_url + "editDerivedGL",formData).then(res=>{
		if(res.status==200)
		{
			$("#update_id").val(res.data.id);
			$("#derivedGL").val(res.data.derived_account_gl);
			$("#glDetail").val(res.data.detail);
			$("#derived_formula").val(res.data.formula);
		}
		else
		{
			toastr.error(res.data);
		}
	});
}
function deleteDerivedGL(id) {
	let formData = new FormData();
	formData.set('id',id);
	app.request(base_url + "deleteDerivedGL",formData).then(res=>{
		if(res.status==200)
		{
			toastr.success(res.data);
			getDerivedGlList();
		}
		else
		{
			toastr.error(res.data);
		}
	});
}
function getConsolidatedMonths() {
	app.request(baseURL + "getReportList",null).then(res=>{
		console.log(res)
		$("#consoldateMonthsForDerivedFormula").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[
				{data: 0},
				{data: 1},
				{
					data: 2
				},
				{
					data: 3,
					render: (d, t, r, m) => {
						return `<a href="${base_url}derived_report?year=${r[1]}&month=${r[4]}" class="btn btn-xs"><i class="fa fa-eye text-primary"></i></a>`
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {


				// $('td:eq(2)', nRow).html(`<a href="${base_url}reportMakerByMonthVersion3?id=${aData[1]}&templateName=${aData[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`);
				$('td:eq(3)', nRow).html(`<a href="${base_url}derived_report?year=${aData[1]}&month=${aData[4]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`);


			}
		});
	});
}
