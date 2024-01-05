$( document ).ready(function() {
		$.LoadingOverlay("show");
	getHistory();
});
function getHistory() {
	app.request(baseURL + "getViewHistory",null).then(res=>{
		$.LoadingOverlay("hide");
		$("#HistoryTable").DataTable({
			destroy: true,
			order: [],
			data:res.data,
			"pagingType": "simple_numbers",
			columns:[

				{data: 0},
				{data: 2},
				{data: 3},
				{data: 4},
				// {
				// 	data: 5,
				// 	render: (d, t, r, m) => {
				// 		return `<a href="${base_url+d}" download="${d}"><i class="fa fa-lg fa-download"></i></a>`

				// 	}
				// },
				{data: 6},
				{data: 7},
				{data: 8},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				if(aData[9] == 2){
					$('td:eq(8)', nRow).html(`<a href="upload_data?id=${aData[1]}"><i class="fa fa-eye"></i></a>`);
				}else{
					$('td:eq(8)', nRow).html(`<a disabled=""><i class="fa fa-cloud-download"></i></a>`);
				}

			}
		});
	});
}
