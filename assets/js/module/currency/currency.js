
$("#formCurrencyConversion").validate({
	rules: {
		month: 'required',
		year: 'required',

	},
	errorElement: 'span',
	submitHandler: function (form) {
		$.LoadingOverlay("show");
		//	var form_data = document.getElementById('uploadCompany');
		let formData = new FormData(form);

		app.request(base_URL + "saveCurrencyConversion",formData).then(res=>{
		$.LoadingOverlay("hide");
			if(res.status == 200){
				toastr.success(res.body);
				$("#fire-modal-company").modal('hide');
				// getCurrencyListDT();
				$("#cc_id").val(res.id);
				window.location.href = base_URL+'viewCurrencyDetails/'+res.id;
				// getDataMainCC();
			}else{
				toastr.error(res.body);
			}
		});
	}
});
function getCurrencyListDT() {
	app.request(base_URL + "getCurrencyDataDT",null).then(res=>{
	$.LoadingOverlay("hide");
		$("#currencyTableDT").DataTable({
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
						// var btn_desable = '';
						// if (r[4] == 0)
						// {
						// 	var btn_desable = 'disabled';
						// 	return `<a href="JavaScript:Void(0);" class="btn btn-primary"><i class="fa fa-eye"></i></a>`
						// }else{
							return `<a href="${base_URL}viewCurrencyDetails/${d}" class="btn btn-link"><i class="fa fa-eye"></i></a>`
						// }
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				// var btn_desable = '';
				// if (aData[4] == 0) {
				// 	var btn_desable = 'disabled';
				// 	$('td:eq(4)', nRow).html(`<a href="JavaScript:Void(0);" class="btn btn-primary" ${btn_desable}><i class="fa fa-eye"></i></a>`);
				// }else{
					$('td:eq(4)', nRow).html(`<a href="${base_URL}viewCurrencyDetails/${aData[1]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`);
				// }

			}
		});
	});
}


function getCurrencyList() {
	app.request(base_URL + "getCurrencyData",null).then(res=>{
	$.LoadingOverlay("hide");
		$("#currencyTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				{data: 2},
				{data: 3},
				{data: 4},
				{data: 5},
				{data: 6},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<button type="button" onclick="editfun(${d})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(6)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-link"><i class="fa fa-pencil"></i></button>`);
			}
		});
	});
}
$("#uploadCompany").validate({
	rules: {
		branch_id: 'required',
		country: 'required',
		currency: 'required',
		convertRate: 'required',
		quarter: 'required',
		year: 'required',

	},
	errorElement: 'span',
	submitHandler: function (form) {
		$.LoadingOverlay("show");
		//	var form_data = document.getElementById('uploadCompany');
		let formData = new FormData(form);

		app.request(base_URL + "CreateUpdateCurrency",formData).then(res=>{
	$.LoadingOverlay("hide");
			if(res.status == 200){
				toastr.success(res.body);
				$("#fire-modal-company").modal('hide');
				getDataMain();
			}else{
				toastr.error(res.body);
			}
		});
	}
});
function openModal() {
	$("#branch_id").val("");
	$("#country").val("");
	$("#currency").val("");
	$("#convertRate").val("");
	$("#quarter").val("");
	$("#year").val("");
	$("#update_id").val("");
	$("#currency").prop('readonly',true);
}
function editfun(id) {
		$.LoadingOverlay("show");
	$("#fire-modal-company").modal('show');
	$("#update_id").val(id);
	let formData = new FormData();
	formData.set("id", id);
	app.request(base_URL + "getDataCurrencyByID",formData).then(res=>{
	$.LoadingOverlay("hide");

		if(res.status == 200){
			$("#branch_id").val(res.data.branch_id);
			$("#country").val(res.data.country);
			$("#currency").val(res.data.currency);
			$("#currency").prop('readonly',true);
			$("#convertRate").val(res.data.rate);
			$("#quarter").val(res.data.quarter);
			$("#year").val(res.data.year);
		}else{
			$("#branch_id").val("");
			$("#country").val("");
			$("#currency").val("");
			$("#convertRate").val("");
			$("#quarter").val("");
			$("#year").val("");
		}
	});
}

function getListBranch() {
	app.request(base_URL + "getBranchList",null).then(res=>{
		if(res.status == 200){
			$("#branch_id").html(res.data);
		}else{
			$("#branch_id").html(res.data);
		}
	});
}
// Empty validator
	emptyValidator = function(value, callback) {
	  if (!value && value!==0) {
	    console.log('false');
	    callback(false);
	  } else {
	    console.log('true');
	    callback(true);
	  }
	};
let currency=[];
let country=[];
function getCurrency() {
	app.request(base_URL + "getCurrencyCountry",null).then(res=>{
	// $.LoadingOverlay("hide");
		$("#country").html(res.options);
		currency=res.currency;
		country=res.country;
	});
}
function getCurrencyfromCountry() {
	var con=$("#country").val();
	$("#currency").val(currency[con]);
}
let  data=[];
let hiddenColumn=[];
let columnsS=[];
let contextMenuD=true;
function getDataMain() {
	app.request(base_URL + "getCurrencyDataH",null).then(res=>{
	$.LoadingOverlay("hide");
		data=res.data2;
		hiddenColumn=[6];
		columnsS=[
			{ type: 'text' },
			{ type: 'text'},
			{ type: 'text'},
			{ type: 'numeric'},
			{ type: 'text' },
			{ type: 'text' },
			{ type: 'text' },
			{ type: 'text' },
			{ type: 'numeric' },
		];
		handson();
	});
}

function getDataMainCC() {
	var id= $("#cc_id").val();
	let formData = new FormData();
	formData.set("cc_id", id);
	app.request(base_URL + "getCurrencyDataHCC",formData).then(res=>{
	$.LoadingOverlay("hide");
		console.log("CC data "+res.data2);
		data=res.data2;
		hiddenColumn=[0,4,5,6,7];
		columnsS=[
			{ type: 'text' },
			{ type: 'text',readOnly:true},
			{ type: 'text',readOnly:true},
			{ type: 'numeric',validator: emptyValidator},
			{ type: 'text' },
			{ type: 'text' },
			{ type: 'text' },
			{ type: 'text' },
			{ type: 'numeric',validator: emptyValidator},
		];

		// columnsS=res.source;

		contextMenuD=true;
		handson();
	});
}

let hosController;
function handson() {

	$(".filterBtn").show();
	if(data.length == 0){
		data = [
			['','', '', '', '', '','','','',''],

		];
	}


	const container = document.getElementById('example');
	hosController = new Handsontable(container, {
		data:data,
		colHeaders: [
			"Branch",
			"Country (A)",
			"Currency (B)",
			"Moving Average Rate (C)",
			"Year",
			"quarter","id","Month","Closing Rate (D)"
		],
		manualColumnResize: true,
		manualRowResize :true,
		columns:columnsS,
		beforeChange: function (changes, source) {
			var row = changes[0][0];

			var prop = changes[0][1];

			var id=this.getDataAtRowProp(row,1);

				var value = changes[0][3];
				console.log(prop);
			if(prop==1)
			{
				getDataCountry(value).then(e=>{
					this.setDataAtRowProp(row,2,e);
				});
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
		contextMenu: contextMenuD,
		hiddenColumns: {
			// specify columns hidden by default
			columns: hiddenColumn,
			copyPasteEnabled: false,
		},
		dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
		licenseKey: 'non-commercial-and-evaluation'
	});
	hosController.validateCells();
}
function getDataCountry(value) {
	return new Promise(function (resolve,reject){
		$.ajax({
			url: base_URL + "getCountryCurrencyData",
			type: "POST",
			dataType: "json",
			data:{value:value},
			success: function (result) {
				resolve(result.data);

			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	});
}
function myCheckboxRenderer() {

}
function saveHandsonData(){
		$.LoadingOverlay("show");
		$("#newErrorDiv").html('');
	var data = hosController.getData();
	let formData = new FormData();
	formData.set('arrData', JSON.stringify(data));
	formData.set('cc_id', $("#cc_id").val());
	app.request(base_URL + "saveHOSData",formData).then(res=>{
	$.LoadingOverlay("hide");
		// data=res.data2;
		// console.log(res);
		if(res.status==200)
		{
			toastr.success(res.body);
		}
		else
		{
			if(res.type==1)
			{
				$("#newErrorDiv").html(`<div><div class="alert alert-light alert-has-icon">
			                      <div class="alert-icon"><i class="fa fa-exclamation-circle"></i></div>
			                      <div class="alert-body">
			                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
			                         ${res.body}
			                      </div>
			                    </div></div>`);
			}
			else
			{
				toastr.error(res.body);
			}
		}

	});
	// formData.forEach(d as a){
	// 	console.log(a);
	// }
	// foreach(data as d){
	//
	// }
	// for (var i=0;i < data.length ; i++){
	// 	each
	// 	formData.set("cc_id", id);
	// 	console.log(formData);
	// }

}
