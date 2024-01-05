$(document).ready(function () {
	// getDataAnalyticsData();
});
function getAnalyticalTab(type) {
	$("#analyticType").val(type);
	getDataAnalyticsData();
}
function getDataAnalyticsData() {
	var formData = new FormData();
	formData.set('type', $("#analyticType").val());
	formData.set('year', $("#year").val());
	formData.set('month', $("#month").val());
	formData.set('valueIn', $("#valueIn").val());
	app.request(baseURL + "getDataAnalyticsData", formData).then(res => {
		if($("#analyticType").val()=='BS')
		{
			if(res.status===200)
			{
				$("#bsTable").html(res.data);
			}
			else {
				$("#bsTable").html('');
			}
		}else if($("#analyticType").val()=='PL')
		{
			if(res.status===200)
			{
				$("#plTable").html(res.data);
			}
			else {
				$("#plTable").html('');
			}
		}else {
			if(res.status===200)
			{
				$("#tdTable").html(res.data);
			}
			else {
				$("#tdTable").html('');
			}
		}


	});
}
// function showDataAnalyticsTransaction(branchId,Gl_number) {
// 	// console.log(branchId+'----'+Gl_number);
// 	$("#dataAnalyticTransaction").modal('show');
// 	var formData = new FormData();
// 	formData.set('branchId', branchId);
// 	formData.set('Gl_number', Gl_number);
// 	formData.set('month', $("#month").val());
// 	formData.set('year', $("#year").val());
// 	app.request(baseURL + "showDataAnalyticsTransaction", formData).then(res => {
// 		if(res.status===200)
// 		{
// 			$("#bsTable").html(res.data);
// 		}
// 		else {
//
// 		}
//
// 	});
// }
function showDataAnalyticsTransaction(branchId,Gl_number,branchName) {
	// console.log(branchId+'----'+Gl_number);
	$("#dataAnalyticTransaction").modal('show');
	// $('#dataAnalyticTransaction').on('shown.bs.modal', function (event) {
	$(".branchname").html(branchName);
	$(".glNumber").html(Gl_number);
	$("#bsPlBranchId").val(branchId);
	$("#bsPlBranchName").val(branchName);
	$("#bsPlGlNumber").val(Gl_number);

		var formData = new FormData();
		formData.set('branchId', branchId);
		formData.set('Gl_number', Gl_number);
		formData.set('month', $("#month").val());
		formData.set('year', $("#year").val());
		formData.set('valueIn', $("#valueIn").val());

		getUploadData(formData);
		getTransferdata(formData);
		getscheduleTrnsactions(formData);
	// });
}
function getUploadData(formData) {
	app.request(baseURL + "showDataAnalyticsTransaction", formData).then(res => {

		// $.LoadingOverlay("hide");
		$('#UploadationDataTable').DataTable().clear().destroy();
		$("#UploadationDataTable").DataTable({
			destroy: true,
			order: [],
			data: res.data,
			"pagingType": "simple_numbers",
			columns: [

				{data: 0},
				{data: 1},
				{data: 2},
				{data: 3},
				{data: 4},
				{data: 5},
				{data: 6},
				{data: 7},
			],
			fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {


			}
		});
	});
}
function getTransferdata(formData) {
	formData.set('transferFilter', $("#transferFilter").val());
	formData.set('branchName', $("#transferBranchName").val());
	// app.request(baseURL + "TransferDataTableTransaction", formData).then(res => {
	//
	// 	// $.LoadingOverlay("hide");
	// 	$('#TransferBSPLDataTable').DataTable().clear().destroy();
	// 	$("#TransferBSPLDataTable").DataTable({
	// 		destroy: true,
	// 		order: [],
	// 		data: res.data,
	// 		"pagingType": "simple_numbers",
	// 		columns: [
	//
	// 			{data: 0},
	// 			{data: 1},
	// 			{data: 2},
	// 			{data: 3},
	// 			{data: 4},
	// 			{data: 5},
	// 			{data: 6},
	// 		],
	// 		fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
	//
	//
	// 		}
	// 	});
	// });
	$("#TransferBSPLDataTableBody").html('');
	$("#total_amt_body").html(0);
	app.request(baseURL + "showDataAnalyticsTransferTransaction", formData).then(res => {

		// $.LoadingOverlay("hide");
		if(res.status===200)
		{
			$("#TransferBSPLDataTableBody").html(res.data);
			$("#total_amt_body").html(res.total);
		}
		else {
			$("#TransferBSPLDataTableBody").html(res.data);
		}
	});
}
function getscheduleTrnsactions(formData) {
	app.request(baseURL + "getscheduleTrnsactions", formData).then(res => {

		// $.LoadingOverlay("hide");
		$('#scheduleDataTable').DataTable().clear().destroy();
		$("#scheduleDataTable").DataTable({
			destroy: true,
			order: [],
			data: res.data,
			"pagingType": "simple_numbers",
			columns: [

				{data: 0},
				{data: 1},
				{data: 2},
				{data: 3},
				{data: 4},
			],
			fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {


			}
		});
	});
}
function showDataAnalyticsTransferTransaction(branchId,Gl_number,branchName) {
	$("#dataAnalyticTransferTransaction").modal('show');
	$(".branchname").html(branchName);
	$(".glNumber").html(Gl_number);
	$("#transferBranchId").val(branchId);
	$("#transferBranchName").val(branchName);
	$("#transferGlNumber").val(Gl_number);
	$("#transferType").val(Gl_number);
	// $('#dataAnalyticTransaction').on('shown.bs.modal', function (event) {
	getTransferTransactiondata();


	// });
}
function getTransferTransactiondata()
{
	var formData = new FormData();
	formData.set('branchId', $("#transferBranchId").val());
	formData.set('Gl_number', $("#transferGlNumber").val());
	formData.set('month', $("#month").val());
	formData.set('year', $("#year").val());
	formData.set('transferFilter', $("#transferFilter").val());
	formData.set('branchName', $("#transferBranchName").val());
	formData.set('valueIn', $("#valueIn").val());
	$("#TransferDataTableBody").html('');
	$("#total_amt").html(0);
	app.request(baseURL + "showDataAnalyticsTransferTransaction", formData).then(res => {

		// $.LoadingOverlay("hide");
		if(res.status===200)
		{
			$("#TransferDataTableBody").html(res.data);
			$("#total_amt").html(res.total);
		}
		else {
			$("#TransferDataTableBody").html(res.data);
		}
	});
}
function showTransactionDataTab(type) {
	$("#transactionTabOpen").val(type);
}
