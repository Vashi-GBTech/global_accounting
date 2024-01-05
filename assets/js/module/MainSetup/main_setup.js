$(document).ready(function () {
	//getMainSetupList();
	$.LoadingOverlay("show");
	getDataMainBalanceSheet();
});

function getMainSetupList() {
	app.request(baseURL + "getMainSetupData", null).then(res => {
		$.LoadingOverlay("hide");
		$("#MainAccountSetup").DataTable({
			destroy: true,
			order: [],
			data: res.data,
			"pagingType": "simple_numbers",
			columns: [

				{data: 0},
				{data: 2},
				{data: 3},
				{data: 5},
				{data: 6},
				{data: 7},
				{data: 8},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<button type="button" onclick="editfun(${d})" class="btn btn-primary"><i class="fa fa-pencil"></i></button>`
					}
				},
			],
			fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(7)', nRow).html(`<button type="button" onclick="editfun(${aData[1]})" class="btn btn-primary"><i class="fa fa-pencil"></i></button>`);
			}
		});
	}).catch(e => {
		console.log(e);
	});
}

function CreateMainSetup() {
	$.LoadingOverlay("show");
	var form_data = document.getElementById('uploadMainSetup');
	let formData = new FormData(form_data);
	app.request(baseURL + "CreateUpdateMainSetup", formData).then(res => {
		$.LoadingOverlay("hide");
		if (res.status == 200) {
			toastr.success(res.body);
			$("#fire-modal-main_setup").modal('hide');
			getMainSetupList();
		} else {
			toastr.error(res.body);
		}
	});
}

function openModal() {
	$("#main_name").val("");
	$("#gl_no").val("");
	$('#calculation_method').val("");
	$('#type1').val('');
	$('#type2').val('');
	$('#type3').val('');
	$('#sequence_number').val('');
	$('#update_id').val("");
}


function editfun(id) {
	$.LoadingOverlay("show");
	$("#fire-modal-main_setup").modal('show');
	$("#update_id").val(id);
	let formData = new FormData();
	formData.set("id", id);
	app.request(baseURL + "getMainSetupbyId", formData).then(res => {
		$.LoadingOverlay("hide");
		if (res.status == 200) {
			$("#main_name").val(res.data.name);
			$("#gl_no").val(res.data.main_gl_number);
			$('#calculation_method').val(res.data.calculation_method);
			$('#type0').val(res.data.type0);
			$('#type1').val(res.data.type1);
			$('#type2').val(res.data.type2);
			$('#type3').val(res.data.type3);
			$('#sequence_number').val(res.data.sequence_number);
		} else {
			$("#main_name").val("");
			$("#gl_no").val("");
			$('#calculation_method').val("");
			$('#type0').val('');
			$('#type1').val('');
			$('#type2').val('');
			$('#type3').val('');
			$('#sequence_number').val('');
		}
	});
}

let data = [];


//////////Accounts Handsontable///////////////////////////
function getDataMainBalanceSheet() {

	// $.LoadingOverlay("show");
	var formData = new FormData();
	formData.set('type', $("#mainSetupType").val());
	app.request(baseURL + "getMainAccountData", formData).then(res => {
		$.LoadingOverlay("hide");
		data = res.data2;
		let group = res.group;
		let columnsHeader = [
			"Parent Code",
			"Detail",
			"Group",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Schedule Number",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [3, 8];
		let columnsRows = res.data2;
		let columnTypes = [
			{
				type: 'text',
			},
			{type: 'text'},
			{type: 'dropdown', source: group},
			{
				type: 'text',
				readOnly: true
			},
			{
				type: 'text',
				readOnly: true
			},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'numeric'},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'example', hiddenColumns, 1,group);
	});
}

function getDataMainProfitLoss() {
	var formData = new FormData();
	formData.set('type', $("#mainSetupType").val());
	app.request(baseURL + "getMainAccountData", formData).then(res => {
		$.LoadingOverlay("hide");
		data = res.data2;
		let group = res.group;
		let columnsHeader = [
			"Parent Code",
			"Detail",
			"Group",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Schedule Number",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [3, 6, 8, 9];
		let columnsRows = res.data2;
		let columnTypes = [
			{type: 'text'},
			{type: 'text'},
			{type: 'dropdown', source: group},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'numeric'},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'examplePl', hiddenColumns, 2,group);
	});
}


function getUSDataMainBalanceSheet() {

	// $.LoadingOverlay("show");
	var formData = new FormData();
	formData.set('type', $("#mainSetupType").val());
	app.request(baseURL + "getUSMainAccountData", formData).then(res => {
		$.LoadingOverlay("hide");
		data = res.data2;
		let group = res.group;
		let columnsHeader = [
			"Parent Code",
			"Detail",
			"Group",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Schedule Number",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [3, 8];
		let columnsRows = res.data2;
		let columnTypes = [
			{type: 'text'},
			{type: 'text'},
			{type: 'dropdown', source: group},
			{
				type: 'text',
				readOnly: true
			},
			{
				type: 'text',
				readOnly: true
			},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'numeric'},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'us_bs', hiddenColumns, 11,group);
	});
}

function getUSDataMainProfitLoss() {
	var formData = new FormData();
	formData.set('type', $("#mainSetupType").val());
	app.request(baseURL + "getUSMainAccountData", formData).then(res => {
		$.LoadingOverlay("hide");
		data = res.data2;
		let group = res.group;
		let columnsHeader = [
			"Parent Code",
			"Detail",
			"Group",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Schedule Number",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [3, 6, 8, 9];
		let columnsRows = res.data2;
		let columnTypes = [
			{type: 'text'},
			{type: 'text'},
			{type: 'dropdown', source: group},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'numeric'},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'us_pl', hiddenColumns, 12,group);
	});
}


function getIFRSDataMainBalanceSheet() {

	// $.LoadingOverlay("show");
	var formData = new FormData();
	formData.set('type', $("#mainSetupType").val());
	app.request(baseURL + "getIFRSMainAccountData", formData).then(res => {
		$.LoadingOverlay("hide");
		data = res.data2;
		let group = res.group;
		let columnsHeader = [
			"Parent Code",
			"Detail",
			"Group",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Schedule Number",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [3, 8];
		let columnsRows = res.data2;
		let columnTypes = [
			{type: 'text'},
			{type: 'text'},
			{type: 'dropdown', source: group},
			{
				type: 'text',
				readOnly: true
			},
			{
				type: 'text',
				readOnly: true
			},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'numeric'},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'ifrs_bs', hiddenColumns, 21,group);
	});
}

function getIFRSDataMainProfitLoss() {
	var formData = new FormData();
	formData.set('type', $("#mainSetupType").val());
	app.request(baseURL + "getIFRSMainAccountData", formData).then(res => {
		$.LoadingOverlay("hide");
		data = res.data2;
		let group = res.group;
		let columnsHeader = [
			"Parent Code",
			"Detail",
			"Group",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Schedule Number",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [3, 6, 8, 9];
		let columnsRows = res.data2;
		let columnTypes = [
			{type: 'text'},
			{type: 'text'},
			{type: 'dropdown', source: group},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
			{type: 'numeric'},
			{type: 'text', readOnly: true},
			{type: 'text', readOnly: true},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'ifrs_pl', hiddenColumns, 22,group);
	});
}

////////////////////////////////////////////////


//////////GROUPING HANDSONTABLE//////////////

function getIndiaGroupBS(type) {
	var formData = new FormData();
	formData.set('type', type);
	app.request(baseURL + "getIndiaGroupData", formData).then(res => {
		$.LoadingOverlay("hide");
		let columnsHeader = [
			"g_id",
			"id",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [0, 2];
		let columnsRows = res.data;
		let columnTypes = [
			{type: 'numeric', readOnly: true},
			{type: 'text'},
			{type: 'dropdown', source: ['BS', 'PL']},
			{type: 'dropdown', source: ['EQUITY AND LIABILITIES', 'ASSETS','SPECIAL TYPE1']},
			{
				type: 'text'
			},
			{type: 'text'},
			{type: 'dropdown', source: sourceData},
			{type: 'dropdown', source: ['Yes', 'No']},
			{type: 'dropdown', source: ['Yes', 'No']},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'ind_group', hiddenColumns, 3);
	});
}

function getIndiaGroupPL(type) {
	var formData = new FormData();
	formData.set('type', type);
	app.request(baseURL + "getIndiaGroupData", formData).then(res => {
		$.LoadingOverlay("hide");
		let columnsHeader = [
			"g_id",
			"id",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [0, 2, 7];
		let columnsRows = res.data;
		let columnTypes = [
			{type: 'numeric', readOnly: true},
			{type: 'text'},
			{type: 'dropdown', source: ['BS', 'PL']},
			{type: 'dropdown', source: ['REVENUE', 'EXPENSES']},
			{
				type: 'text'
			},
			{type: 'text'},
			{type: 'dropdown', source: sourceData},
			{type: 'dropdown', source: ['Yes', 'No']},
			{type: 'dropdown', source: ['Yes', 'No']},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'ind_pl_grouping', hiddenColumns, 3);
	});
}

function getUSGroupBS(type) {
	var formData = new FormData();
	formData.set('type', type);
	app.request(baseURL + "getUSGroupingData", formData).then(res => {
		$.LoadingOverlay("hide");
		let columnsHeader = [
			"g_id",
			"id",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [0, 2];
		let columnsRows = res.data;
		let columnTypes = [
			{type: 'text', readOnly: true},
			{type: 'text'},
			{type: 'dropdown', source: ['BS', 'PL']},
			{type: 'dropdown', source: ['EQUITY AND LIABILITIES', 'ASSETS','SPECIAL TYPE1']},
			{
				type: 'text'
			},
			{type: 'text'},
			{type: 'dropdown', source: sourceData},
			{type: 'dropdown', source: ['Yes', 'No']},
			{type: 'dropdown', source: ['Yes', 'No']},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'us_bs_grouping', hiddenColumns, 13);
	});
}

function getUSGroupPL(type) {
	var formData = new FormData();
	formData.set('type', type);
	app.request(baseURL + "getUSGroupingData", formData).then(res => {
		$.LoadingOverlay("hide");
		let columnsHeader = [
			"g_id",
			"id",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [0, 2, 7];
		let columnsRows = res.data;
		let columnTypes = [
			{type: 'text', readOnly: true},
			{type: 'text'},
			{type: 'dropdown', source: ['BS', 'PL']},
			{type: 'dropdown', source: ['REVENUE', 'EXPENSES']},
			{
				type: 'text'
			},
			{type: 'text'},
			{type: 'dropdown', source: sourceData},
			{type: 'dropdown', source: ['Yes', 'No']},
			{type: 'dropdown', source: ['Yes', 'No']},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'us_pl_grouping', hiddenColumns, 13);
	});
}

function getIfrsGroupBS(type) {
	var formData = new FormData();
	formData.set('type', type);
	app.request(baseURL + "getIfrsGroupingData", formData).then(res => {
		$.LoadingOverlay("hide");
		let columnsHeader = [
			"g_id",
			"id",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [0, 2];
		let columnsRows = res.data;
		let columnTypes = [
			{type: 'text', readOnly: true},
			{type: 'text'},
			{type: 'dropdown', source: ['BS', 'PL']},
			{type: 'dropdown', source: ['EQUITY AND LIABILITIES', 'ASSETS','SPECIAL TYPE1']},
			{
				type: 'text'
			},
			{type: 'text'},
			{type: 'dropdown', source: sourceData},
			{type: 'dropdown', source: ['Yes', 'No']},
			{type: 'dropdown', source: ['Yes', 'No']},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'ifrs_bs_grouping', hiddenColumns, 23);
	});
}

function getIfrsGroupPL(type) {
	var formData = new FormData();
	formData.set('type', type);
	app.request(baseURL + "getIfrsGroupingData", formData).then(res => {
		$.LoadingOverlay("hide");
		let columnsHeader = [
			"g_id",
			"id",
			"Type 0",
			"Type 1",
			"Type 2",
			"Type 3",
			"Calculation Method",
			"Monitory/Non Monitory",
			"is Divide"
		];
		let sourceData = ['Addition', 'Parent', 'Ignore'];
		let hiddenColumns = [0, 2, 7];
		let columnsRows = res.data;
		let columnTypes = [
			{type: 'text', readOnly: true},
			{type: 'text'},
			{type: 'dropdown', source: ['BS', 'PL']},
			{type: 'dropdown', source: ['REVENUE', 'EXPENSES']},
			{
				type: 'text'
			},
			{type: 'text'},
			{type: 'dropdown', source: sourceData},
			{type: 'dropdown', source: ['Yes', 'No']},
			{type: 'dropdown', source: ['Yes', 'No']},
		];
		handson(columnsHeader, columnsRows, columnTypes, 'ifrs_pl_grouping', hiddenColumns, 23);
	});
}

////////////////////////////////////////////

let hosController;

function handson(columnsHeader, columnsRows, columnTypes, divId, hiddenColumns, dropType,group=null) {
	$(".filterBtn").show();
	if (columnsRows.length === 0) {
		columnsRows = [
			['', '', '', '', '', '', '', '', '', ''],
		];
	}


	const container = document.getElementById(divId);
	hosController != null ? hosController.destroy() : "";
	hosController = new Handsontable(container, {
		data: columnsRows,
		colHeaders: columnsHeader,
		manualColumnResize: true,
		manualRowResize: true,
		columns: columnTypes,
		minSpareRows: 1,

		beforeChange: function (changes, source) {
			var row = changes[0][0];
			var prop = changes[0][1];
			var value = changes[0][3];
		},
		afterChange: function (changes, src) {
			if (dropType == 1) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 0){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 0, value);
							this.render();
						}
					}
					if (prop == 3) {
						this.setCellMeta(row, 4, 'type', 'dropdown');
						var data = getBalanceSheetType2(value).then(e => {
							this.setCellMeta(row, 4, 'source', e);
						});
						this.render();
					}
					if (prop == 2) {
						var data = value.split('-');
						var id = "";
						if (data.length > 1) {
							id = data[0];
						}
						var data_array = getIndGroupData(id, 1).then(e => {

							this.setDataAtRowProp(row, 4, e[0]['type1']);
							this.setDataAtRowProp(row, 5, e[0]['type2']);
							this.setDataAtRowProp(row, 6, e[0]['type3']);
							this.setDataAtRowProp(row, 7, e[0]['calculation_method']);
							this.setDataAtRowProp(row, 9, e[0]['monitory_status']);
							this.setDataAtRowProp(row, 10, e[0]['is_divide']);
						});
						this.render();
					}
				}
			}
			if (dropType == 2) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 0){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 0, value);
							this.render();
						}
					}
					if (prop == 2) {
						var data = value.split('-');
						var id = "";
						if (data.length > 1) {
							id = data[0];
						}
						var data_array = getIndGroupData(id, 2).then(e => {
							this.setDataAtRowProp(row, 3, e[0]['type0']);
							this.setDataAtRowProp(row, 4, e[0]['type1']);
							this.setDataAtRowProp(row, 5, e[0]['type2']);
							this.setDataAtRowProp(row, 6, e[0]['type3']);
							this.setDataAtRowProp(row, 7, e[0]['calculation_method']);
							this.setDataAtRowProp(row, 9, e[0]['monitory_status']);
							this.setDataAtRowProp(row, 10, e[0]['is_divide']);
						});
						this.render();
					}
				}
			}
			if (dropType == 3) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 1){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 1, value);
							this.render();
						}
					}
					// if (prop == 2 || prop == 3 || prop == 4) {
					// 	var data = this.getSourceDataAtRow(row);
					// 	if (data[2] != null && data[3] != null && data[4] != null) {
					// 		var data_array = getIndGroupValid(data).then(e => {
					// 			console.log(e);
					// 			if (e == 1) {
					// 				this.setCellMeta(row, 4, 'className', 'group_validate');
					// 				this.render();
					// 			} else {
					// 				this.setCellMeta(row, 4, 'className', 'group_valid');
					// 				this.render();
					// 			}
					// 		});
					// 	}
					// }
					if (prop === 4 || prop === 5 || prop === 6 || prop === 7) {
						var data = this.getSourceDataAtRow(row);
						if (data[0] != null) {
							UpdateIndGroup(data[0], data[5], data[6], data[7], data[8]);
							this.render();
						}
					}
				}
			}

			if (dropType == 11) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 0){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 0, value);
							this.render();
						}
					}
					if (prop == 3) {
						this.setCellMeta(row, 4, 'type', 'dropdown');
						var data = getBalanceSheetType2(value).then(e => {
							this.setCellMeta(row, 4, 'source', e);
						});
						this.render();
					}
					if (prop == 2) {
						var data = value.split('-');
						var id = "";
						if (data.length > 1) {
							id = data[0];
						}
						var data_array = getUSGroupData(id, 1).then(e => {

							this.setDataAtRowProp(row, 4, e[0]['type1']);
							this.setDataAtRowProp(row, 5, e[0]['type2']);
							this.setDataAtRowProp(row, 6, e[0]['type3']);
							this.setDataAtRowProp(row, 7, e[0]['calculation_method']);
							this.setDataAtRowProp(row, 9, e[0]['monitory_status']);
							this.setDataAtRowProp(row, 10, e[0]['is_divide']);
						});
						this.render();
					}
				}
			}
			if (dropType == 12) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 0){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 0, value);
							this.render();
						}
					}
					if (prop == 2) {
						var data = value.split('-');
						var id = "";
						if (data.length > 1) {
							id = data[0];
						}
						var data_array = getUSGroupData(id, 2).then(e => {
							this.setDataAtRowProp(row, 3, e[0]['type0']);
							this.setDataAtRowProp(row, 4, e[0]['type1']);
							this.setDataAtRowProp(row, 5, e[0]['type2']);
							this.setDataAtRowProp(row, 6, e[0]['type3']);
							this.setDataAtRowProp(row, 7, e[0]['calculation_method']);
							this.setDataAtRowProp(row, 9, e[0]['monitory_status']);
							this.setDataAtRowProp(row, 10, e[0]['is_divide']);
						});
						this.render();
					}
				}
			}
			if (dropType == 13) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 1){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 1, value);
							this.render();
						}
					}
					// if (prop == 2 || prop == 3 || prop == 4) {
					// 	var data = this.getSourceDataAtRow(row);
					//
					// 	if (data[2] != null && data[3] != null && data[4] != null) {
					//
					// 		var data_array = getUSGroupValid(data).then(e => {
					// 			console.log(e);
					// 			if (e == 1) {
					// 				this.setCellMeta(row, 4, 'className', 'group_validate');
					// 				this.render();
					// 			} else {
					// 				this.setCellMeta(row, 4, 'className', 'group_valid');
					// 				this.render();
					// 			}
					// 		});
					// 	}
					// }
					if (prop === 4 || prop === 5 || prop === 6 || prop === 7) {
						var data = this.getSourceDataAtRow(row);
						if (data[0] != null) {
							UpdateUSGroup(data[0], data[5], data[6], data[7], data[8]);
							this.render();
						}
					}
				}
			}

			if (dropType == 21) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 0){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 0, value);
							this.render();
						}
					}
					if (prop == 3) {
						this.setCellMeta(row, 4, 'type', 'dropdown');
						var data = getBalanceSheetType2(value).then(e => {
							this.setCellMeta(row, 4, 'source', e);
						});
						this.render();
					}
					if (prop == 2) {
						var data = value.split('-');
						var id = "";
						if (data.length > 1) {
							id = data[0];
						}
						var data_array = getIfrsGroupData(id, 1).then(e => {

							this.setDataAtRowProp(row, 4, e[0]['type1']);
							this.setDataAtRowProp(row, 5, e[0]['type2']);
							this.setDataAtRowProp(row, 6, e[0]['type3']);
							this.setDataAtRowProp(row, 7, e[0]['calculation_method']);
							this.setDataAtRowProp(row, 9, e[0]['monitory_status']);
							this.setDataAtRowProp(row, 10, e[0]['is_divide']);
						});
						this.render();
					}
				}
			}
			if (dropType == 22) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 0){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 0, value);
							this.render();
						}
					}
					if (prop == 2) {
						var data = value.split('-');
						var id = "";
						if (data.length > 1) {
							id = data[0];
						}
						var data_array = getIfrsGroupData(id, 2).then(e => {
							this.setDataAtRowProp(row, 3, e[0]['type0']);
							this.setDataAtRowProp(row, 4, e[0]['type1']);
							this.setDataAtRowProp(row, 5, e[0]['type2']);
							this.setDataAtRowProp(row, 6, e[0]['type3']);
							this.setDataAtRowProp(row, 7, e[0]['calculation_method']);
							this.setDataAtRowProp(row, 9, e[0]['monitory_status']);
							this.setDataAtRowProp(row, 10, e[0]['is_divide']);
						});
						this.render();
					}
				}
			}
			if (dropType == 23) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 1){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 1, value);
							this.render();
						}
					}
					// if (prop == 2 || prop == 3 || prop == 4) {
					// 	var data = this.getSourceDataAtRow(row);
					//
					// 	if (data[2] != null && data[3] != null && data[4] != null) {
					//
					// 		var data_array = getIfrsGroupValid(data).then(e => {
					// 			console.log(e);
					// 			if (e == 1) {
					// 				this.setCellMeta(row, 4, 'className', 'group_validate');
					// 				this.render();
					// 			} else {
					// 				this.setCellMeta(row, 4, 'className', 'group_valid');
					// 				this.render();
					// 			}
					// 		});
					// 	}
					// }
					if (prop === 4 || prop === 5 || prop === 6 || prop === 7) {
						var data = this.getSourceDataAtRow(row);
						if (data[0] != null) {
							UpdateIfrsGroup(data[0], data[5], data[6], data[7], data[8]);
							this.render();
						}
					}
				}
			}
			if (dropType == 24) {
				if (changes) {
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];
					if(prop == 0){
						if(value !== "" && value !== null){
							value = value.replace(/[^a-z0-9]/gi, '');
							this.setSourceDataAtCell(row, 0, value);
							this.render();
						}
					}
					if (prop == 2) {
						var data = value.split('-');
						var id = "";
						var grp_id="";
						if (data.length > 1) {
							id = data[0];
							grp_id = data[1];
						}
						var data_array = getIndSchedulingData(id, grp_id,1).then(e => {
							this.setDataAtRowProp(row, 3, e[0]['type0']);
							this.setDataAtRowProp(row, 4, e[0]['calculation_method']);
							this.setDataAtRowProp(row, 6, e[0]['monitory_status']);
							this.setDataAtRowProp(row, 5, e[0]['sequence_no']);
							this.setDataAtRowProp(row, 7, e[0]['is_divide']);
						});
						this.render();
					}
				}
			}
		},
		beforePaste: (data, coords) => {
			if(dropType == 3){
				for (let i = 0; i < data.length; i++) {
					var c = 0;
					for (let j = 0; j < data[i].length; j++) {
						if (coords[0].startCol == 1) {
							if(c != 1){
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							}
							data[i][j] = data[i][j].trim();
							c++;
						}
						if(coords[0].startCol == 3){
							data[i][j] = data[i][j].trim();
						}
					}
				}
			}
			if(dropType == 13){
				for (let i = 0; i < data.length; i++) {
					var c = 0;
					for (let j = 0; j < data[i].length; j++) {
						if (coords[0].startCol == 1) {
							if(c != 1){
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							}
							data[i][j] = data[i][j].trim();
							c++;
						}
						if(coords[0].startCol == 3){
							data[i][j] = data[i][j].trim();
						}
					}
				}
			}
			if(dropType == 23){
				for (let i = 0; i < data.length; i++) {
					var c = 0;
					for (let j = 0; j < data[i].length; j++) {
						if (coords[0].startCol == 1) {
							if(c != 1){
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							}
							data[i][j] = data[i][j].trim();
							c++;
						}
						if(coords[0].startCol == 3){
							data[i][j] = data[i][j].trim();
						}
					}
				}
			}
			for (let i = 0; i < data.length; i++) {
				var c = 0;
				for (let j = 0; j < data[i].length; j++) {
					if (coords[0].startCol == c) {
						// data[i][j] = data[i][j].replace(/[^A-Z0-9]/ig, '');
						data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
						c++;
					}
					if(coords[0].startCol == 2)
					{
						if(!isNaN(data[i][j]))
						{
							data[i][j] = data[i][j].trim();
							for(g=0;g < group.length;g++)
							{
								var splitvalue = group[g].split('-')
								var split = splitvalue.indexOf(data[i][j]);
								if(split != -1){
									data[i][j] = group[g];
									break;
								}
							}
						}
					}
				}
			}
		},
		beforeRemoveRow: (index,amount,physicalRows) => {
			physicalRows.map(e=>{
				var data = hosController.getDataAtRow(e);
				if (data.length !== 0) {
					if (dropType === 3) {
						if(data[0] !== null){
							RemoveRowData(data[0], 1);
						}
					}
					if (dropType === 13) {
						if(data[0] !== null) {
							RemoveRowData(data[0], 2);
						}
					}
					if (dropType === 23) {
						if(data[0] !== null) {
							RemoveRowData(data[0], 3);
						}
					}
				}
			});
			// if(data.length !== 0)
			// {
			// 	RemoveRowData(data,1);
			// }
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
		width: '100%',
		stretchH: 'all',
		height: 320,
		rowHeights: 23,
		rowHeaders: true,
		filters: true,
		contextMenu: true,
		hiddenColumns: {
			columns: hiddenColumns,
			copyPasteEnabled: false,
			// specify columns hidden by default

		},
		dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
		licenseKey: 'non-commercial-and-evaluation'
	});
	hosController.validateCells();
	hosController.updateSettings({
		cells: function (row, col, prop) {
			const cellProperties = {};
			/*if ((hosController.getData()[row][0] === 'SP1001' && col==0)) {
				cellProperties.readOnly = true;
			}
			else {
				cellProperties.readOnly = false;
			}*/
			return cellProperties;
		},
		contextMenu: {
			items: {
				"row_above":{},
				"row_below":{},
				"hsep1": "---------",
				"cut":{},
				"copy":{},
				"hsep2": "---------",
				"make_read_only":{},
				"alignment":{},
				"hsep3": "---------",
				"remove_row": {
					name: "remove_row",
					hidden: function () {
						let rowR=hosController.getSelected()[0][0];
						if(hosController.getData()[rowR][0] === 'SP1001' || hosController.getData()[rowR][1] === 'SP1001')
						{
							// hosController.getData()[row][0] === 'SP1001';
							//if first row, disable this option
							return  (hosController.getSelected()[0][0] || hosController.getSelected()[0][1])
						}
					}
				},

			}
		}
	});
}

function saveExcelData() {
	$.LoadingOverlay("show");
	var array = hosController.getData();
	let type = $("#mainSetupType").val();
	if (confirm("Are You Sure You want to upload?")) {
		$.ajax({
			url: baseURL + "InsertMainAccountData",
			type: "POST",
			dataType: "json",
			data: {value: array, type: type},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					if (type == 'BS') {
						getDataMainBalanceSheet();
					} else {
						getDataMainProfitLoss();
					}
				} else {
					toastr.error(result.body);
					// if (type == 'BS') {
					// 	getDataMainBalanceSheet();
					// } else {
					// 	getDataMainProfitLoss();
					// }
				}
			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}
	$.LoadingOverlay("hide");
}


function saveUSExcelData() {
	$.LoadingOverlay("show");
	var array = hosController.getData();
	let type = $("#mainSetupType").val();
	if (confirm("Are You Sure You want to upload?")) {
		$.ajax({
			url: baseURL + "InsertUSAccountData",
			type: "POST",
			dataType: "json",
			data: {value: array, type: type},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					if (type == 'BS') {
						getUSDataMainBalanceSheet();
					} else {
						getUSDataMainProfitLoss();
					}
				} else {
					toastr.error(result.body);
					// if (type == 'BS') {
					// 	getUSDataMainBalanceSheet();
					// } else {
					// 	getUSDataMainProfitLoss();
					// }
				}
			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}
	$.LoadingOverlay("hide");
}

function saveIFRSExcelData() {
	$.LoadingOverlay("show");
	var array = hosController.getData();
	let type = $("#mainSetupType").val();
	if (confirm("Are You Sure You want to upload?")) {
		$.ajax({
			url: baseURL + "InsertIFRSAccountData",
			type: "POST",
			dataType: "json",
			data: {value: array, type: type},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					if (type == 'BS') {
						getIFRSDataMainBalanceSheet();
					} else {
						getIFRSDataMainProfitLoss();
					}
				} else {
					toastr.error(result.body);
					// if (type == 'BS') {
					// 	getIFRSDataMainBalanceSheet();
					// } else {
					// 	getIFRSDataMainProfitLoss();
					// }
				}
			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}
	$.LoadingOverlay("hide");
}


function getMainSetupType(type) {
	$("#mainSetupType").val(type);
}

function getBalanceSheetType2(value) {
	return new Promise(function (resolve, reject) {
		let Type2array = [];
		if (value == 'EQUITY AND LIABILITIES') {
			Type2array = ['SHAREHOLDERS FUNDS', 'NON-CURRENT LIABILITIES', 'CURRENT LIABILITIES'];
		}
		if (value == 'ASSETS') {
			Type2array = ['NON-CURRENT ASSETS', 'CURRENT ASSETS'];
		}
		resolve(Type2array);
	});

}


/////////INDIA GROUPING FUNCTIONS//////////
function getIndGroupData(id, type) {
	$.LoadingOverlay("show");
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "getIndGroupData",
			type: "POST",
			dataType: "json",
			data: {id: id, type: type},
			success: function (result) {
				$.LoadingOverlay("hide");
				var data1 = [result.data];
				resolve(data1);
			},
			error: function (error) {
				console.log(error);
				toastr.error(result.body);
				// $.LoadingOverlay("hide");
			}
		});
	});
}

function getIndGroupValid(data) {
	$.LoadingOverlay("show");
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "CheckIndGroup",
			type: "POST",
			dataType: "json",
			data: {data: data},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					resolve(result.data);
				} else {
					resolve(result.data);
				}
			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	});
}

function SaveIndGroup(type) {
	$.LoadingOverlay("show");
	var array = hosController.getData();
	$.ajax({
		url: baseURL + "InsertIndGroupData",
		type: "POST",
		dataType: "json",
		data: {value: array, type: type},
		success: function (result) {
			$.LoadingOverlay("hide");
			if (result.status == 200) {
				toastr.success(result.body);
				if (type === 1) {
					getIndiaGroupBS(1);
				} else {
					getIndiaGroupPL(2);
				}
			} else {
				toastr.error(result.body);
				// if (type === 1) {
				// 	getIndiaGroupBS(1);
				// } else {
				// 	getIndiaGroupPL(2);
				// }
			}
		},
		error: function (error) {
			$.LoadingOverlay("hide");
			console.log(error);
		}
	});
}

function UpdateIndGroup(grp_id, type3, cm, monitory, divide) {
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "UpdateIndGroup",
			type: "POST",
			dataType: "json",
			data: {id: grp_id, type3: type3, cm: cm, monitory: monitory, divide: divide},
			success: function (result) {
				if (result.status == 200) {
					console.log(result.body);
				}
			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	});
}


/////////US GROUPING FUNCTIONS//////////
function getUSGroupData(id, type) {
	$.LoadingOverlay("show");
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "getUSGroupData",
			type: "POST",
			dataType: "json",
			data: {id: id, type: type},
			success: function (result) {
				$.LoadingOverlay("hide");
				var data1 = [result.data];
				resolve(data1);
			},
			error: function (error) {
				console.log(error);
				toastr.error(result.body);
				// $.LoadingOverlay("hide");
			}
		});
	});
}

function getUSGroupValid(data) {
	$.LoadingOverlay("show");
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "CheckUSGroup",
			type: "POST",
			dataType: "json",
			data: {data: data},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					resolve(result.data);
				} else {
					resolve(result.data);
				}
			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	});
}

function SaveUSGroup(type) {
	$.LoadingOverlay("show");
	var array = hosController.getData();
	$.ajax({
		url: baseURL + "InsertUSGroupData",
		type: "POST",
		dataType: "json",
		data: {value: array, type: type},
		success: function (result) {
			$.LoadingOverlay("hide");
			if (result.status == 200) {
				toastr.success(result.body);
				if (type === 1) {
					getUSGroupBS(1);
				} else {
					getUSGroupPL(2);
				}
			} else {
				toastr.error(result.body);
				// if (type === 1) {
				// 	getUSGroupBS(1);
				// } else {
				// 	getUSGroupPL(2);
				// }
			}
		},
		error: function (error) {
			$.LoadingOverlay("hide");
			console.log(error);
		}
	});
}

function UpdateUSGroup(grp_id, type3, cm, monitory, divide) {
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "UpdateUSGroup",
			type: "POST",
			dataType: "json",
			data: {id: grp_id, type3: type3, cm: cm, monitory: monitory, divide: divide},
			success: function (result) {
				if (result.status == 200) {
					console.log(result.body);
				}
			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	});
}


/////////IFRS GROUPING FUNCTIONS//////////
function getIfrsGroupData(id, type) {
	$.LoadingOverlay("show");
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "getIfrsGroupData",
			type: "POST",
			dataType: "json",
			data: {id: id, type: type},
			success: function (result) {
				$.LoadingOverlay("hide");
				var data1 = [result.data];
				resolve(data1);
			},
			error: function (error) {
				console.log(error);
				toastr.error(result.body);
				// $.LoadingOverlay("hide");
			}
		});
	});
}

function getIfrsGroupValid(data) {
	$.LoadingOverlay("show");
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "CheckIfrsGroup",
			type: "POST",
			dataType: "json",
			data: {data: data},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					resolve(result.data);
				} else {
					resolve(result.data);
				}
			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	});
}

function SaveIfrsGroup(type) {
	$.LoadingOverlay("show");
	var array = hosController.getData();
	$.ajax({
		url: baseURL + "InsertIfrsGroupData",
		type: "POST",
		dataType: "json",
		data: {value: array, type: type},
		success: function (result) {
			$.LoadingOverlay("hide");
			if (result.status == 200) {
				toastr.success(result.body);
				if (type === 1) {
					getIfrsGroupBS(1);
				} else {
					getIfrsGroupPL(2);
				}
			} else {
				toastr.error(result.body);
				// if (type === 1) {
				// 	getIfrsGroupBS(1);
				// } else {
				// 	getIfrsGroupPL(2);
				// }
			}
		},
		error: function (error) {
			$.LoadingOverlay("hide");
			console.log(error);
		}
	});
}

function UpdateIfrsGroup(grp_id, type3, cm, monitory, divide) {
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "UpdateIfrsGroup",
			type: "POST",
			dataType: "json",
			data: {id: grp_id, type3: type3, cm: cm, monitory: monitory, divide: divide},
			success: function (result) {
				if (result.status == 200) {
					console.log(result.body);
				}
			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	});
}


//////////////////REMOVE GROUP DATA/////////////////
function RemoveRowData(value, type) {
	let formData = new FormData();
	var branch_id = $("#branch_id").val();
	formData.set('id', value);
	formData.set('type', type);
	app.request(base_url + "RemoveGroupData", formData).then(res => {
		if (res.status === 200) {
			if (type === 1) {
				getDataMain();
			}
			if (type === 2) {
				getUSData();
			}
			if (type === 3) {
				getIFRSData();
			}
			console.log(res.data);
		} else {
			console.log(res.data);
		}
	});
}


//////////////////// SCHEDULE ACCOUNT SETUP MASTER////////////////
function getDataMainScheduleAccount(type,divId) {
	// $.LoadingOverlay("show");
	var formData = new FormData();
	formData.set('type', $("#mainSetupType").val());
	formData.set('countryType', type);
	app.request(baseURL + "getMainScheduleAccountData", formData).then(res => {
		$.LoadingOverlay("hide");
		data = res.data2;
		let group = res.group;
		let columnsHeader = [
			"Schedule Account",
			"Detail"
		];
		let hiddenColumns = [5];
		let columnsRows = res.data2;
		let columnTypes = [
			{
				type: 'text',
			},
			{type: 'text'}
		];
		handson(columnsHeader, columnsRows, columnTypes, divId, hiddenColumns, 24,group);
	});
}
function getIndSchedulingData(id,grp_id, type) {
	$.LoadingOverlay("show");
	return new Promise(function (resolve, reject) {
		$.ajax({
			url: base_url + "getIndSchedulingData",
			type: "POST",
			dataType: "json",
			data: {id: id,grp_id:grp_id,type: type},
			success: function (result) {
				$.LoadingOverlay("hide");
				var data1 = [result.data];
				resolve(data1);
			},
			error: function (error) {
				console.log(error);
				toastr.error(result.body);
				// $.LoadingOverlay("hide");
			}
		});
	});
}

function saveIndSchedule(countrytype,divId) {
	$.LoadingOverlay("show");
	var array = hosController.getData();
	let type = $("#mainSetupType").val();
	if (confirm("Are You Sure You want to upload?")) {
		$.ajax({
			url: baseURL + "InsertMainScheduleAccountData",
			type: "POST",
			dataType: "json",
			data: {value: array, type: type,countryType:countrytype},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					toastr.success(result.body);
					getDataMainScheduleAccount(1,divId);
				} else {
					toastr.error(result.body);
					// if (type == 'BS') {
					// 	getDataMainBalanceSheet();
					// } else {
					// 	getDataMainProfitLoss();
					// }
				}
			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}
	$.LoadingOverlay("hide");
}
