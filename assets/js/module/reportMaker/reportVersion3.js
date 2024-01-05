let templateList=[];
let schedulelist=[];
function GetReportView1(type,tableid,reportType) {
	$.LoadingOverlay("show");

	let formData = new FormData();
	formData.set('type',type);
	formData.set('reportType',reportType);
	if(type==3)
	{
		formData.set('filter',$("#filterIFRS").val());
	}
	else if(type==2)
	{
		formData.set('filter',$("#filterUSD").val());
	}
	else {
		formData.set('filter',$("#filterIND").val());
	}
	app.request(baseURL + "GetTableReportVersion3View",formData).then(res=>{
		$.LoadingOverlay("hide");
		$("#"+tableid).DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[
				{data: 0},
				{data: 2},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<a href="${base_url}reportMakerByMonthVersion3?id=${d}&templateName=${r[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`


					}
				},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<a href="${base_url}tableReportMakerVarsion3/${d}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`


					}
				},
				{
					data: 3,
					render: (d, t, r, m) => {
						let status='Inactive';
						let statusType=1;
						if(r[3]==1)
						{
							status='Active';
							statusType=2;
						}
						return `<div id="statusDiv_${r[0]}"><a onclick="changeStatus(${r[1]},${statusType},${r[0]})" class="btn btn-link">${status}</a></div>`;

					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {


				$('td:eq(2)', nRow).html(`<a href="${base_url}reportMakerByMonthVersion3?id=${aData[1]}&templateName=${aData[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`);
				$('td:eq(3)', nRow).html(`<a href="${base_url}tableReportMakerVarsion3/${aData[1]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`);


			}
		});
	});
}

function GetReportView(type,tableid,reportType) {
	$.LoadingOverlay("show");

	let formData = new FormData();
	formData.set('type',type);
	formData.set('reportType',reportType);
	if(type==3)
	{
		formData.set('filter',$("#filterIFRS").val());
	}
	else if(type==2)
	{
		formData.set('filter',$("#filterUSD").val());
	}
	else {
		formData.set('filter',$("#filterIND").val());
	}
	app.request(baseURL + "GetTableReportVersion3View",formData).then(res=>{
		$.LoadingOverlay("hide");
		$("#"+tableid).DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[
				{data: 0},
				{data: 2},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<a href="${base_url}reportMakerByMonthVersion3?id=${d}&templateName=${r[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`


					}
				},
				/*{
					data: 1,
					render: (d, t, r, m) => {
						return `<a href="${base_url}tableReportMakerVarsion3/${d}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`


					}
				},
				{
					data: 3,
					render: (d, t, r, m) => {
						let status='Inactive';
						let statusType=1;
						if(r[3]==1)
						{
							status='Active';
							statusType=2;
						}
						return `<div id="statusDiv_${r[0]}"><a onclick="changeStatus(${r[1]},${statusType},${r[0]})" class="btn btn-link">${status}</a></div>`;

					}
				},*/
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {


				$('td:eq(2)', nRow).html(`<a href="${base_url}reportMakerByMonthVersion3?id=${aData[1]}&templateName=${aData[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`);
				//$('td:eq(3)', nRow).html(`<a href="${base_url}tableReportMakerVarsion3/${aData[1]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>`);


			}
		});
	});
}

let StyleArray=[];
let ReportArray=[];
let hosController;
function getReportTemplateData()
{
	var template_id=$("#template_id").val();

	let formData = new FormData();
	formData.set('template_id',template_id);
	app.request(base_url + "getTableReportVersion3TemplateData",formData).then(res=>{
		if(res.status==200)
		{
			var userData=res.body;
			$("#templateName").val(userData.template_name);
			$('select[name^="type"] option[value="'+userData.type+'"]').attr("selected","selected");
			getGlAccountData(userData.type);
			var template_body=userData.template_body;
			$("#mytextarea").html(template_body);
			$("#template_id").val(userData.id);
			$('#number_conversion').val(userData.number_conversion);
			$('#currencytype').val(userData.currency_type);
			$('#reportSection').val(userData.report_type);
			if(res.style!=null)
			{
				StyleArray=res.style;
			}
			if(res.reportArray!=null)
			{
				ReportArray=res.reportArray;
			}

		}
		let columnsHeader =res.header;
		let columnTypes = res.columnType;
		let columnsRows = res.rows;
		let hiddenColumns = [];
		handson(columnsHeader, columnsRows, columnTypes, 'handsontable', hiddenColumns, 23);
		hosController.updateSettings({
			afterSelectionEnd: function(r, c, r2, c2) {
				console.log('hiiii');
				var rc=r+","+c;
				var getData=containsObjectGetValue(rc,StyleArray);
				$("#styleDiv").show();
				$("#selectedColumn").html('('+r+','+c+')');
				var numrowcol=r+","+c;
				$("#numrowcol").val(numrowcol);
				if(c==1)
				{
					let d1=this.getDataAtCell(r,1);
					if(d1!="")
					{
						var reportData=reportcontainsObjectGetValue(rc,ReportArray);
						$("#attachReportDiv").show();
						$("#selectedvalue").html(d1);
					}
					else {
						$("#attachReportDiv").hide();
					}
				} else {
					$("#attachReportDiv").hide();
				}

			}
		})
	});

}

function ChangeStyleRow(){
	//numrowcol backgroundColor textColor isbold
	var numrowcol=$("#numrowcol").val();
	var backgroundColor=$("#backgroundColor").val();
	var textColor=$("#textColor").val();
	var isbold=$("#isbold").val();
	var textSize=$("#textSize").val();
	var textAlign=$("#textAlign").val();
	const style = {RowCol:numrowcol, Background:backgroundColor, textColor:textColor,isBold:isbold,textSize:textSize,textAlign:textAlign};
	if(containsObject(style, StyleArray) == true){
		StyleArray.push(style);
		toastr.success('Saved');
	}

}
function containsObject(obj, list) {
		var i;
		for (i = 0; i < list.length; i++) {
			if (list[i].RowCol === obj.RowCol) {
				removeByAttr(StyleArray, 'RowCol', list[i].RowCol);
			}
		}
		return true;

}
function containsObjectGetValue(RowCol, list) {

		var i;
		for (i = 0; i < list.length; i++) {
			if (list[i].RowCol === RowCol) {
				console.log(list[i].Background);
				$("#numrowcol").val('');
				$("#backgroundColor").val('');
				$("#textColor").val('');
				$("#isbold").val('');
				$("#numrowcol").val(list[i].RowCol);
				$("#backgroundColor").val(list[i].Background);
				$("#textColor").val(list[i].textColor);
				$("#textSize").val(list[i].textSize);
				$("#textAlign").val(list[i].textAlign);
				$("#isbold").val(list[i].isBold);
				return;
			}else{
				$("#numrowcol").val('');
				$("#backgroundColor").val('');
				$("#textColor").val('');
				$("#isbold").val('');
				$("#textSize").val('');
				$("#textAlign").val('');
			}
		}
}
var removeByAttr = function(arr, attr, value){
	var i = arr.length;
	while(i--){
		if( arr[i]
			&& arr[i].hasOwnProperty(attr)
			&& (arguments.length > 2 && arr[i][attr] === value ) ){

			arr.splice(i,1);

		}
	}
	return arr;
}
// report row
function ChangeReportRow() {
	var numrowcol=$("#numrowcol").val();
	var reportType=$("#reportType").val();
	var reportTemp=$("#reportTemp").val();
	if(reportType!="" && reportTemp!="0" && reportTemp!="" && reportTemp!="0")
	{
		const reportObj = {RowCol:numrowcol, reportType:reportType, reportTemp:reportTemp};
		if(reportcontainsObject(reportObj, ReportArray) == true){
			ReportArray.push(reportObj);
			toastr.success('Saved');
		}
	}
	else {
		removeByAttr(ReportArray, 'RowCol', numrowcol);
	}

}
function reportcontainsObject(obj, list) {
	var i;
	for (i = 0; i < list.length; i++) {
		if (list[i].RowCol === obj.RowCol) {
			removeByAttr(ReportArray, 'RowCol', list[i].RowCol);
		}
	}
	return true;
}
function reportcontainsObjectGetValue(RowCol, list) {
	var j;
	for (j = 0; j < list.length; j++) {
		if (list[j].RowCol === RowCol) {
			$("#numrowcol").val('');
			$("#reportType").val('');
			$("#reportTemp").val('');
			$("#numrowcol").val(list[j].RowCol);
			$("#reportType").val(list[j].reportType).trigger('change');
			$("#reportTemp").val(list[j].reportTemp);
			return;
		}else{
			$("#numrowcol").val(RowCol);
			$("#reportType").val('');
			$("#reportTemp").val('');
		}
	}
}
function handson(columnsHeader, columnsRows, columnTypes, divId, hiddenColumns,group=null,columnSummary=null,style=null) {
	if (columnsRows.length === 0) {
		columnsRows = [
			['', '', '', '', '', '', '', '', '', '','','','','',''],
		];
	}
	const container = document.getElementById(divId);
	hosController != null ? hosController.destroy() : "";
	hosController = new Handsontable(container, {
		data: columnsRows,
		colHeaders: false,
		manualColumnResize: true,
		manualRowResize: true,
		columnSummary: columnSummary,
		columns: columnTypes,

		cells(row,column){
			const cellProperties = {};
			// style formatting cells
			// disable pasting data into row 1
			if (row === 6 && column < 10) {
				cellProperties.readOnly = 'true'
			}
			if(row < 6 && (column===2 || column===3 || column==4))
			{
				// cellProperties.readOnly = 'true';
			}
			if (column === 5 || column===6) {
				cellProperties.className = 'htRight'
			}
			// if(column===2 && row > 6)
			// {
			// 	cellProperties.type = 'dropdown';
			// 	cellProperties.value = 'MANUAL';
			// 	cellProperties.source = ['MANUAL', 'CALCULATED'];
			// }
			cellProperties.renderer = "negativeValueRenderer"; // uses lookup map

			return cellProperties;
		},
		afterOnCellMouseDown: function(event, coords) {
			const cellProperties1 = {};
			cellProperties1.renderer = "negativeValueRenderer"; // uses lookup map
			return cellProperties1;
		},

		minSpareRows: 1,
		width: '100%',
		stretchH: 'all',
		height: 500,
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
}
Handsontable.renderers.registerRenderer('negativeValueRenderer', negativeValueRenderer);
function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties) {
	Handsontable.renderers.TextRenderer.apply(this, arguments);
	if(StyleArray!=null)
	{
		for(var i=0;i<StyleArray.length;i++)
		{
			let styleData=StyleArray[i];
			let rowscol=styleData.RowCol;
			let rowsSplit=rowscol.split(',');
			if(rowsSplit.length>1)
			{
				if(row==rowsSplit[0] && col==rowsSplit[1]){
					td.style.background = styleData.Background;
					td.style.color = styleData.textColor;
					if(styleData.hasOwnProperty('textAlign'))
					{
						td.style.textAlign=styleData.textAlign;
					}
					if(styleData.hasOwnProperty('textSize'))
					{
						td.style.fontSize=styleData.textSize+'px';
					}
					td.style.fontWeight = styleData.isBold;
				}
			}
		}
	}
}
function uploadTemplateData()
{
	// $.LoadingOverlay("show");

	var reportData = hosController.getData();
	if($("#templateName").val()!="" && $("#type").val()!="" && $("#currencytype").val()!="")
	{
		let form=document.getElementById('reportForm');
		let formData = new FormData(form);
		var number_conversion = $('#number_conversion').val();
		formData.set('templateBody',JSON.stringify(reportData));
		formData.set('number_conversion',number_conversion);
		formData.set('StyleArray',JSON.stringify(StyleArray));
		formData.set('ReportArray',JSON.stringify(ReportArray));
		app.request(base_url + "uploadTableTemplateVersion3Data",formData).then(res=>{
			// $.LoadingOverlay("hide");
			if(res.status==200)
			{
				app.successToast(res.body);
				window.location.href=base_url+'version3Report';
			}
			else
			{
				app.errorToast(res.body);
			}
		});
	}
	else
	{
		toastr.error('Please Enter Template name and select Type');
	}
}
function copyText(id)
{
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($('#'+id).text()).select();
	document.execCommand("copy");
	$temp.remove();
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
function getGlNumber(value)
{
	$(".gl_ac_n").html();
	$("#tableDiv").hide();
	if(value!="")
	{
		var gl_divide=value.split('||');
		$(".gl_ac_n").html(gl_divide[0]);
		if(gl_divide[1]==1)
		{
			$(".gl_divide").show();
		}
		else
		{
			$(".gl_divide").hide();
		}
		$("#tableDiv").show();
	}
}
function changeYearWise(value)
{
	if(value==2)
	{
		$(".gr_year").html('P');
	}
	else if(value==3)
	{
		$(".gr_year").html('PP');
	}
	else
	{
		$(".gr_year").html('');
	}
}


function changeYearWise2(value)
{
	if(value==2)
	{
		$(".gr_year2").html('P');
	}
	else if(value==3)
	{
		$(".gr_year2").html('PP');
	}
	else
	{
		$(".gr_year2").html('');
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
function checkRadioCheck(id)
{
	var value=$("input[name='divide"+id+"']:checked").val();
	if(value==2)
	{
		$(".partC"+id).html(2);
	}
	else
	{
		$(".partC"+id).html('');
	}
}
function checkTypeRadioCheck(name,className)
{
	var value=$("input[name='"+name+"']:checked").val();
	if(value==2)
	{
		$("."+className).html(2);
	}
	else
	{
		$("."+className).html('');
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

function changeYearWise1(value)
{
	if(value==2)
	{
		$(".gr_year1").html('P');
	}
	else if(value==3)
	{
		$(".gr_year1").html('PP');
	}
	else
	{
		$(".gr_year1").html('');
	}
}

function changeYearWiseGL(value)
{
	if(value==2)
	{
		$(".GyearC").html('P');
	}
	else if(value==3)
	{
		$(".GyearC").html('PP');
	}
	else
	{
		$(".GyearC").html('');
	}
}
function copyTextFormula(id,type)
{
	var $temp = $("<input>");
	$("body").append($temp);
	//"/#+[\w\s\-]*@+/i"
	var data=$('#'+id).val();
	var matches = data.match(/#+[\w\s\-]*@+/g);
	for(var i=0;i<matches.length;i++){
		if(data.indexOf(matches[i]) !== -1){
			var value= "("+ matches[i] +")";
			data=data.replace(matches[i],value)
		}
	}
	var copyText='<code>'+data+'</code>';
	$temp.val(copyText).select();
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
function getReportTemplateList(type) {
	if(type!=0)
	{
			if(type==2)
			{
				$("#reportTemp").html('');
				$("#reportTemp").append(schedulelist);
			}
			else
			{
				$("#reportTemp").html('');
				$("#reportTemp").append(templateList);
			}
	}
	else {

	}
}

function getTemplateReportList(type)
{
	if(type!=0)
	{
		let formData = new FormData();
		formData.set('type',type);
		app.request(base_url + "getReportTemplateList",formData).then(res=>{
			if(res.status==200)
			{
				if(type==2)
				{
					schedulelist=res.data;
				}
				else {
					templateList=res.data;
				}
			}

		});
	}
	else {

	}
}
function changeStatus(id,status,divid) {
	let formData = new FormData();
	formData.set('id',id);
	formData.set('status',status);
	app.request(base_url + "changeStatusOfReport",formData).then(res=>{
		if(res.status==200)
		{
			let temp=``;
			if(status==1)
			{
				console.log(1);
				temp+=`<a onclick="changeStatus(${id},2,${divid})" class="btn btn-link">Active</a>`;
			}
			else {
				console.log(2);
				temp+=`<a onclick="changeStatus(${id},1,${divid})" class="btn btn-link">Inactive</a>`;
			}
			$("#statusDiv_"+divid).html(temp);
		}
		else {

		}
	});
}
function getDerivedGLData() {
	$("#da_table").html('');
	if(type!="")
	{
		let formData = new FormData();
		formData.set('type',type);
		app.request(base_url + "getDerivedGLData",formData).then(res=>{
			if(res.status==200)
			{
				$("#da_table").append(res.body);

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
