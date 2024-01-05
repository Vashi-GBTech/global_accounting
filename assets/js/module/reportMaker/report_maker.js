function GetReportView(type,tableid) {
 $.LoadingOverlay("show");
	
 	let formData = new FormData();
 	formData.set('type',type);
	app.request(baseURL + "GetReportView",formData).then(res=>{
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
								return `<a href="${base_url}reportMaker/${d}" class="btn btn-link"><i class="fa fa-pencil"></i></a>
								<a href="${base_url}reportMakerByMonth?id=${d}&templateName=${r[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`
					

					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				
					
						$('td:eq(2)', nRow).html(`<a href="${base_url}reportMaker/${aData[1]}" class="btn btn-link"><i class="fa fa-pencil"></i></a>
							<a href="${base_url}reportMakerByMonth?id=${aData[1]}&templateName=${aData[2]}" class="btn btn-link"><i class="fa fa-eye"></i></a>`);
				

			}
		});
	});
}
function uploadTemplateData()
{
	 // $.LoadingOverlay("show");
	 var tinydata=tinyMCE.activeEditor.getContent();
	 if($("#templateName").val()!="" && $("#type").val()!="")
	 {
	 	let form=document.getElementById('reportForm');
	 	let formData = new FormData(form);
	 	var number_conversion = $('#number_conversion').val();
	 	formData.set('templateBody',tinydata);
	 	formData.set('number_conversion',number_conversion);
	 	app.request(base_url + "uploadTemplateData",formData).then(res=>{
			// $.LoadingOverlay("hide");
			if(res.status==200)
			{
				toastr.success(res.body);
				window.location.href=base_url+'reportMakerList';
			}
			else
			{
				toastr.error(res.body);
			}
		});
	 }
	 else
	 {
	 	toastr.error('Please Enter Template name and select Type');
	 }
}
function getReportTemplateData()
{
	var template_id=$("#template_id").val();
	if(template_id!=0)
	{
	 	let formData = new FormData();
	 	formData.set('template_id',template_id);
	 	app.request(base_url + "getReportTemplateData",formData).then(res=>{
			// $.LoadingOverlay("hide");
			if(res.status==200)
			{
				// console.log(res.body);
				var userData=res.body;
				$("#templateName").val(userData.template_name);
				$('select[name^="type"] option[value="'+userData.type+'"]').attr("selected","selected");
				getGlAccountData(userData.type);
				var template_body=userData.template_body;
				// template_body=template_body.replaceAll('&lt;f&gt;','<f>');
				// template_body=template_body.replaceAll('&lt;/f&gt;','</f>');
				console.log(template_body);
				$("#mytextarea").html(template_body);
				$("#template_id").val(userData.id);
				$('#number_conversion').val(userData.number_conversion);
				// toastr.success(res.body);
			}
			else
			{
				toastr.error(res.body);
			}
		});
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
