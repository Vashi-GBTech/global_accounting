function GetReportView(type,tableid) {
 $.LoadingOverlay("show");
	
 	let formData = new FormData();
 	formData.set('type',type);
	app.request(baseURL + "GetTableReportView",formData).then(res=>{
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
								return `<a href="${base_url}tableReportMaker/${d}" class="btn btn-link"><i class="fa fa-pencil"></i></a>
								<a href="${base_url}tablereportMakerByMonth?id=${d}&templateName=${r[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`
					

					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				
					
						$('td:eq(2)', nRow).html(`<a href="${base_url}tableReportMaker/${aData[1]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>
							<a href="${base_url}tablereportMakerByMonth?id=${aData[1]}&templateName=${aData[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`);
				

			}
		});
	});
}

function getReportTemplateData()
{
	var template_id=$("#template_id").val();

	 	let formData = new FormData();
	 	formData.set('template_id',template_id);
	 	app.request(base_url + "getTableReportTemplateData",formData).then(res=>{
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
			}
				let columnsHeader =res.header;
				let columnTypes = res.columnType;
				let columnsRows = res.rows;
				let hiddenColumns = [];
				handson(columnsHeader, columnsRows, columnTypes, 'handsontable', hiddenColumns, 23);
				hosController.updateSettings({
				afterSelectionEnd: function(r, c, r2, c2) {
					var rc=r+","+c;
					var getData=containsObjectGetValue(rc,StyleArray);
					$("#styleDiv").show();
					$("#selectedColumn").html('('+r+','+c+')');
					var numrowcol=r+","+c;
					$("#numrowcol").val(numrowcol);
				}
				})
		});

}

let StyleArray=[];
function ChangeStyleRow(){
	//numrowcol backgroundColor textColor isbold
	var numrowcol=$("#numrowcol").val();
	var backgroundColor=$("#backgroundColor").val();
	var textColor=$("#textColor").val();
	var isbold=$("#isbold").val();
	const style = {RowCol:numrowcol, Background:backgroundColor, textColor:textColor,isBold:isbold};
	if(containsObject(style, StyleArray) == true){
		StyleArray.push(style);
		toastr.success('Saved');
	}

}
function containsObject(obj, list) {
	var i;
	for (i = 0; i < list.length; i++) {
		if (list[i].RowCol === obj.RowCol) {
			removeByAttr(StyleArray,'RowCol',list[i].RowCol);
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
			$("#isbold").val(list[i].isBold);
			return;
		}else{
			$("#numrowcol").val('');
			$("#backgroundColor").val('');
			$("#textColor").val('');
			$("#isbold").val('');
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

let hosController;
function handson(columnsHeader, columnsRows, columnTypes, divId, hiddenColumns, dropType,group=null) {
	if (columnsRows.length === 0) {
		columnsRows = [
			['', '', '', '', '', '', '', '', '', '','','','','',''],
		];
	}
	const container = document.getElementById(divId);
	hosController != null ? hosController.destroy() : "";
	hosController = new Handsontable(container, {
		data: columnsRows,
		colHeaders: true,
		manualColumnResize: true,
		manualRowResize: true,
		columns: columnTypes,
		minSpareRows: 1,
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
		cells(row, col) {
			const cellProperties = {};
			const data = this.instance.getData();
			if(row==0 && col==1){
				cellProperties.renderer = 'negativeValueRenderer'; // uses lookup map
			}

			return cellProperties;
		},
		dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
		licenseKey: 'non-commercial-and-evaluation'
	});
	hosController.validateCells();

}
Handsontable.renderers.registerRenderer('negativeValueRenderer', negativeValueRenderer);
function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties) {
	Handsontable.renderers.TextRenderer.apply(this, arguments);

	td.style.background = '#EEE';
	td.style.color = 'red';
	td.style.fontWeight = 'Bold';

}

function uploadTemplateData()
{
	// $.LoadingOverlay("show");

	var reportData = hosController.getData();
	if($("#templateName").val()!="" && $("#type").val()!="")
	{
		let form=document.getElementById('reportForm');
		let formData = new FormData(form);
		var number_conversion = $('#number_conversion').val();
		formData.set('templateBody',JSON.stringify(reportData));
		formData.set('number_conversion',number_conversion);
		app.request(base_url + "uploadTableTemplateData",formData).then(res=>{
			// $.LoadingOverlay("hide");
			if(res.status==200)
			{
				app.successToast(res.body);
				window.location.href=base_url+'tableReportMakerList';
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
