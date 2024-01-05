$( document ).ready(function() {
	getReportList();

});
function getReportList() {
		$.LoadingOverlay("show");
	app.request(baseURL + "getReportList",null).then(res=>{
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
					data: 4,
					render: (d, t, r, m) => {
						
						return `<a href="${baseURL}update_report?year=${r[1]}&month=${r[4]}" type="button" class="btn btn-link"><i class="fa fa-eye"></i></a>
						<a href="${baseURL}scheduleView?year=${r[1]}&month=${r[4]}" type="button" class="btn btn-link"><i class="fa fa-calendar"></i></a>`
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(3)', nRow).html(`<a href="${baseURL}update_report?year=${aData[1]}&month=${aData[4]}" type="button" class="btn btn-link"><i class="fa fa-eye"></i></a>
					<a href="${baseURL}scheduleView?year=${aData[1]}&month=${aData[4]}" type="button" class="btn btn-link"><i class="fa fa-calendar"></i></a>`);
			}
		});
	});
}

