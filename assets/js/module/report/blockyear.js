$( document ).ready(function() {
	getBlockList()
});
function uploadBlockData()
{
		$.LoadingOverlay("show");
	if($("#year").val()!="" && $("#month").val()!="")
	{
		var form=document.getElementById('blockFormRowUpload');
		var formData=new FormData(form);
		app.request(baseURL + "blockFormRowUpload",formData).then(res=>{
		$.LoadingOverlay("hide");
			if(res.status==200)
			{
				toastr.success(res.body);
				getBlockList();
			}
			else
			{
				toastr.error(res.body);
				getBlockList();
			}

		});
	}
	else{
		toastr.erro('select year and month');
	}
}
function uploadDefaultData() {
	$.LoadingOverlay("show");
	if($("#year").val()!="" && $("#month").val()!="")
	{
		var form=document.getElementById('defaultFormRowUpload');
		var formData=new FormData(form);
		app.request(baseURL + "defaultFormRowUpload",formData).then(res=>{
			$.LoadingOverlay("hide");
			if(res.status==200)
			{
				toastr.success(res.body);
				getDefaultList();
			}
			else
			{
				toastr.error(res.body);
				getDefaultList();
			}

		});
	}
	else{
		toastr.erro('select year and month');
	}
}
// $("#blockFormRowUpload").validate({
// 		rules: {
// 			year: {
// 				required: true
// 			},
// 			month: {
// 				required: true
// 			}
// 		},
// 		messages: {
// 			year: {
// 				required: "Please select year",
// 			},
// 			month: {
// 				required: "Please select month",
// 			}
// 		},
// 		errorElement: 'span',
// 		submitHandler: function (form) {
// 			// $.LoadingOverlay("show");

// 			var formData=new FormData(form);
// 			$.ajax({
// 				url: base_url+"blockFormRowUpload",
// 				type: "POST",
// 				dataType: "json",
// 				data: formData,
// 				success: function (result) {
// 					if (result.status === 200) {
// 		                var id=result.body;
// 						// getBlockList();
// 		            }
// 		            else
// 		            {
// 		            	alert(result.body);
// 		            }
// 				}, error: function (error) {
// 					// $.LoadingOverlay("hide");
// 					toastr.error("Something went wrong please try again");
// 				}

// 			});
// 		}
// 	});
function getBlockList() {
		$.LoadingOverlay("show");
	app.request(baseURL + "getBlockYearList",null).then(res=>{
		$.LoadingOverlay("hide");
		$("#ReportTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				{data: 1},
				{data: 2},
				{
					data: 3,
					render: (d, t, r, m) => {
						var status="Inactive";
						if(r[5]==1)
						{
							return `<a class="btn btn-link" style="color:forestgreen;" onclick="activeInactiveStatus(${r[3]},${r[5]})">Active</a>`
						}else
						{
							return `<a class="btn btn-link" style="color: red" onclick="activeInactiveStatus(${r[3]},${r[5]})">Inactive</a>`
						}
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				var status="Inactive";
						if(aData[5]==1)
						{
							status='Active';
						}
				$('td:eq(5)', nRow).html(`<button type="button" onclick="activeInactiveStatus(${aData[3]},${aData[5]})" class="btn btn-primary">${status}</button>`);
			}
		});
	});
}
function getDefaultList() {
	$.LoadingOverlay("show");
	app.request(baseURL + "getDefaultYearList",null).then(res=>{
		$.LoadingOverlay("hide");
		$("#DefaultReportTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				{data: 1},
				{data: 2},
				{
					data: 3,
					render: (d, t, r, m) => {
						var status="Inactive";
						if(r[5]==1)
						{
							return `<a class="btn btn-link" style="color:forestgreen;" onclick="activeInactiveStatusDefaultYear(${r[3]},${r[5]})">Active</a>`
						}else
						{
							return `<a class="btn btn-link" style="color: red" onclick="activeInactiveStatusDefaultYear(${r[3]},${r[5]})">Inactive</a>`
						}
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				var status="Inactive";
				if(aData[5]==1)
				{
					status='Active';
				}
				$('td:eq(5)', nRow).html(`<button type="button" onclick="activeInactiveStatusDefaultYear(${aData[3]},${aData[5]})" class="btn btn-primary">${status}</button>`);
			}
		});
	});
}
function activeInactiveStatus(id,status)
{
		$.LoadingOverlay("show");
		var formData=new FormData();
		formData.set('id',id);
		formData.set('status',status);
	app.request(baseURL + "activeInactiveStatus",formData).then(res=>{
		$.LoadingOverlay("hide");
		if(res.status==200)
		{
			toastr.success(res.body);
			getBlockList();
		}
		else
		{
			toastr.error(res.body);
		}
	});
}
function getNoBlockMonth(year)
	{
		$("#month").html('');
		// $.LoadingOverlay("show");
		var formData=new FormData();
		formData.set('year',year);
		app.request(baseURL + "getNoBlockMonth",formData).then(res=>{
			// $.LoadingOverlay("hide");
			if(res.status==200)
			{
				$("#month").append(res.body);
				
			}
			else
			{
				toastr.error(res.body);
			}
		});
	}

function activeInactiveStatusDefaultYear(id,status)
{
	$.LoadingOverlay("show");
	var formData=new FormData();
	formData.set('id',id);
	formData.set('status',status);
	app.request(baseURL + "activeInactiveStatusDefaultYear",formData).then(res=>{
		$.LoadingOverlay("hide");
		if(res.status==200)
		{
			toastr.success(res.body);
			getDefaultList();
		}
		else
		{
			toastr.error(res.body);
		}
	});
}
