$( document ).ready(function() {
	getBranchList();
});
function getBranchList() {
	$.LoadingOverlay("show");
	app.request(baseURL + "getBranchData",null).then(res=>{
	$.LoadingOverlay("hide");
		$("#BranchTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				{data: 2},
				{data: 4},
				{data: 5},
				{data: 7},
				{data: 9},
				{data: 8},
				{data: 3},
				{
					data: 1,
					render: (d, t, r, m) => {
						return `<a href="Excel?id=${d}"><i class="fa fa-eye"></i></a>`
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				$('td:eq(8)', nRow).html(`<a href="Excel?id=${aData[1]}"><i class="fa fa-eye"></i></a>`);
			}
		});
	});
}
