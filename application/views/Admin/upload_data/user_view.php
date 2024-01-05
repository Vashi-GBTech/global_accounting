<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">User View</h4>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<div class="row">
					<div class="col-md-12">
						<div id="excel_view"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


</div>
<?php $this->load->view('_partials/footer'); ?>
<script>
	const urlParams = new URLSearchParams(window.location.search);
	const id = urlParams.get('id');

	function loadData() {
		$.LoadingOverlay("show");
		let formData = new FormData();
		formData.set("id", id);
		app.request("getUserViewData", formData).then(res => {
		$.LoadingOverlay("hide");
			if(res.status===200){
				loadHandSon(document.getElementById("excel_view"),res.data,res.header);
			}else{
				console.log(res.body);
			}
		})
	}

	loadData();
	function loadHandSon(element, columnRows, columnsHeader) {
		var hotDiv = new Handsontable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			manualColumnResize: true,
			manualRowResize: true,
			beforeChange: function (changes, source) {
				var row = changes[0][0];

				var prop = changes[0][1];

				var value = changes[0][3];
				if (prop == 1) {

					this.setDataAtRowProp(row, 2, "supriya");
				}
				console.log(changes, row, prop, value);

			},
			stretchH: 'all',
			colWidths: '100%',
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			//  hiddenColumns: {
			//   // specify columns hidden by default
			//   columns: [0]
			// },
			dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		hotDiv.validateCells();
	}
</script>
</div>
