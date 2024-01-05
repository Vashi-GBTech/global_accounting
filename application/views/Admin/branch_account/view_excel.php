<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$branch_id = $_GET['id'];
?>
<style>
	.nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
		border-bottom-color: #fff;
		background-color: #f7e3ad;
		color: black;
		text-shadow: 0px 4px 5px #00000055 !important;
	}

	.nav-tabs > li.active > a{
		color:black;
		background-color: #f7e3ad;
	}

	.nav-tabs > li.active > a{
		background-color: #f2d1767a!important;
		color: #473504 !important;
		text-shadow: 0px 1px 2px #00000055!important;
	}
	.nav-tabs > li {
		border-radius: 6px;
		border-right: 1px solid #80808029;
	}

	.nav-item{
		width: 150px;
		text-align: center;
	}
</style>
<!-- Main Content -->
<div class="content-page">
	<div class="content">
		<input type="hidden" id="branch_id" name="branch_id" value="<?php echo $branch_id ?>">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">

						<div class="page-title-box">
							<div class="" style="    display: flex; flex-direction: row;">
								<button class="btn btn-link "><a href="<?php echo base_url(); ?>SubsidiarySetup"><i class="fa fa-arrow-left"></i></a></button>
								<h4 class="">Subsidairy Account Setup</h4>
								<button class="btn btn-primary roundCornerBtn4 xs_btn" style="float:right;margin-left: auto" onclick="show_upload()"><i class="fa fa-plus"></i></button>
								<div class="clearfix"></div>
							</div>
							<!-- <a href="<?php echo base_url(); ?>Mapping?id=<?= $branch_id ?>" class="btn btn-primary" style="float: right">Mapping</a> -->
							<input type="hidden" name="filterTable" id="filterTable" value="0">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<div class="row" id="branch_data">
					<div class="col-md-12">
						<ul class="nav nav-tabs  m-b-20" id="ex1" role="tablist">
							<li class="nav-item match active" role="presentation">
								<a data-toggle="tab" href="#AS" class="nav-link active" role="tab"
								   aria-selected="true" aria-expanded="true">INDIAN AS</a>
							</li>
<!--							<li class="nav-item unmatch" role="presentation">-->
<!--								<a data-toggle="tab" href="#US" class="nav-link" role="tab"-->
<!--								   aria-selected="false" aria-expanded="false" onclick="getUSData()">US GAAP</a>-->
<!--							</li>-->
<!--							<li class="nav-item unmatch" role="presentation">-->
<!--								<a data-toggle="tab" href="#IFRS" class="nav-link" role="tab"-->
<!--								   aria-selected="false" aria-expanded="false" onclick="getIFRSData()">IFRS</a>-->
<!--							</li>-->
						</ul>

						<div class="tab-content" style="padding:0;">
							<div class="tab-pane active" id="AS">

									<ul class="nav nav-tabs  m-b-20" id="ex1" role="tablist">
										<li class="nav-item match active" role="presentation">
											<a data-toggle="tab" href="#AST" class="nav-link active" role="tab"
											   aria-selected="true" aria-expanded="true" onclick="getDataMain()">Account Setup</a>
										</li>
										<li class="nav-item unmatch" role="presentation">
											<a data-toggle="tab" href="#PHT" class="nav-link" role="tab"
											   aria-selected="false" aria-expanded="false" onclick="getPercentageHoldingData()">Percentage Holding Type</a>
										</li>
									</ul>
								<div class="tab-content" style="padding:0;">
									<div class="tab-pane active" id="AST">
										<div class="row" >
											<div class="col-md-6">
												<button class="btn btn-primary roundCornerBtn4 filterBtn" onclick="saveExcelData()"
														style="float:right;margin-bottom: 10px;">Save
												</button>
												<button class="btn btn-primary roundCornerBtn4 m-r-10" onclick="clearData()"
														style="float:right;margin-bottom: 10px;">Clear Data
												</button>
												<div class="col-md-12" id="newErrorDiv"></div>
												<div class="col-md-12" id="example"></div>
											</div>
											<div class="col-md-6" id="ImageDiv">
												<a href="<?php echo base_url(); ?>Mapping?id=<?= $branch_id ?>&type=1"><img
															src="<?php echo base_url(); ?>assets/images/branchSubdirectory.png" alt="logo"
															class="thumbnail" style="height: 400px;width: 100%;"></a>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="PHT">
										<button class="btn btn-primary roundCornerBtn4 filterBtn" onclick="savePercentageHoldData()"
												style="float:right;margin-bottom: 10px;">Save
										</button>
										<button class="btn btn-primary roundCornerBtn4 m-r-10" onclick="clearPercentageHoldData()"
												style="float:right;margin-bottom: 10px;">Clear Data
										</button>
										<div class="col-md-12" id="newPercentageHoldType"></div>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="US">
								<div class="row">
									<div class="col-md-6">
										<button class="btn btn-primary roundCornerBtn4 filterBtn" onclick="saveUSExcelData()"
												style="float:right;margin-bottom: 10px;">Save
										</button>
										<button class="btn btn-primary roundCornerBtn4 m-r-10" onclick="clearData()"
												style="float:right;margin-bottom: 10px;">Clear Data
										</button>
										<div class="col-md-12" id="us_newErrorDiv"></div>
										<div class="col-md-12" id="us_example"></div>
									</div>
									<div class="col-md-6" id="ImageDiv">
										<a href="<?php echo base_url(); ?>Mapping?id=<?= $branch_id ?>&type=2"><img
													src="<?php echo base_url(); ?>assets/images/branchSubdirectory.png" alt="logo"
													class="thumbnail" style="height: 400px;width: 100%;"></a>
									</div>
								</div>
							</div>


							<div class="tab-pane" id="IFRS">
								<div class="row">
									<div class="col-md-6">
										<button class="btn btn-primary roundCornerBtn4 filterBtn" onclick="saveIFRSExcelData()"
												style="float:right;margin-bottom: 10px;">Save
										</button>
										<button class="btn btn-primary roundCornerBtn4 m-r-10" onclick="clearData()"
												style="float:right;margin-bottom: 10px;">Clear Data
										</button>
										<div class="col-md-12" id="ifrs_newErrorDiv"></div>
										<div class="col-md-12" id="ifrs_example"></div>
									</div>
									<div class="col-md-6" id="ImageDiv">
										<a href="<?php echo base_url(); ?>Mapping?id=<?= $branch_id ?>&type=3"><img
													src="<?php echo base_url(); ?>assets/images/branchSubdirectory.png" alt="logo"
													class="thumbnail" style="height: 400px;width: 100%;"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="Upload" style="display: none;">
					<div class="tab-content" style="padding:0;">
						<div class="row" id="MainData">
							<div class="col-lg-12 m-t-10">
								<div class="card-box">
									<form method="post" id="branch_excel">
										<input type="hidden" name="unmatchStatus" id="unmatchStatus" value="0">
										<div class="row">
											<div class="col-md-12">
												<div><label>Upload Excel File</label><hr></div>
												<div class="col-md-2">
													<input type="file" name="userfile" id="userfile" class="form_control" style="display: none;">
													<label for="userfile" style="margin-top:10px;"> <i class="fa fa-upload uploadLable"></i> Upload</label>
												</div>
												<div class="col-md-4"><button type="submit" class="btn btn-primary roundCornerBtn4">Save</button></div>
											</div>
											<div class="col-md-12" id="validateDiv"></div>
											<div class="col-md-12">
												<input type="hidden" name="count" id="count" class="form_control" value="0">
												<button type="button" class="btn btn-primary roundCornerBtn4" id="saveExcelColumnsBtn" onclick="saveExcelColumns()" style="display: none;float: right; margin-top: 10px;">Save</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top: -10px;background-color: white;padding: 10px 30px 10px 30px">
							<div class="col-md-12" id="errorDiv">

							</div>
							<div class="col-md-12" id="tableDiv" style="height: 500px;overflow: auto"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


</div>
<?php $this->load->view('_partials/footer'); ?>

</div>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>
<script type="text/javascript">

	function show_upload()
	{
		if ($('#Upload').css('display') == 'none') {
			$('#Upload').show();
			$('#branch_data').hide();

		} else {
			$('#Upload').hide();
			$('#branch_data').show();
		}
	}

	$("#exportexcelsheet").validate({
		rules: {
			year: {
				required: true
			},
			quarter: {
				required: true
			},
			userfile:
					{
						required: true
					}
		},
		messages: {
			year: {
				required: "Please select year",
			},
			quarter: {
				required: "Please select quarter",
			},
			userfile: {
				required: "Please select file",
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
			$.LoadingOverlay("show");
			// $.LoadingOverlay("show");

			var formData = new FormData(form);
			$.ajax({
				url: base_url + "ExportToTable",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status === 200) {
						var id = result.body;
						loadEditableTable(id);
					} else {
						alert(result.body);
					}
				}, error: function (error) {
					$.LoadingOverlay("hide");
					// $.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});
	$(document).ready(function () {

		// $.LoadingOverlay("show");
		getDataMain();
	});

	function loadEditableTable(id) {
		$.LoadingOverlay("show");
		$.ajax({
			url: base_url + "getExportToTableData",
			type: "POST",
			dataType: "json",
			data: {id: id},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {
					var columns = result.columns;
					var rows = result.rows;

				} else {
					alert(result.body);
				}

			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});

	}

	let sourceData = [];
	let data = [];
	let scheduleParentMapp=[];

	function getDataMain() {
		$.LoadingOverlay("show");
		var branch_id = $("#branch_id").val();
		$.ajax({
			url: base_url + "getDataMain",
			type: "POST",
			dataType: "json",
			data: {branch_id: branch_id},
			success: function (result) {
				$.LoadingOverlay("hide");
				sourceData = result.data;
				data = result.data2;
				scheduleParentMapp = result.scheduleParentMapp;
				handson();
			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}

	function getUSData() {
		$.LoadingOverlay("show");
		var branch_id = $("#branch_id").val();
		$.ajax({
			url: base_url + "getUSData",
			type: "POST",
			dataType: "json",
			data: {branch_id: branch_id},
			success: function (result) {
				$.LoadingOverlay("hide");
				sourceData = result.data;
				data = result.data2;
				us_handson();
			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}


	function getIFRSData() {
		$.LoadingOverlay("show");
		var branch_id = $("#branch_id").val();
		$.ajax({
			url: base_url + "getIFRSData",
			type: "POST",
			dataType: "json",
			data: {branch_id: branch_id},
			success: function (result) {
				$.LoadingOverlay("hide");
				sourceData = result.data;
				data = result.data2;
				ifrs_handson();
			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}


		// Empty validator
		emptyValidator = function(value, callback) {
		  if (value !== 0) {
			  callback(true);
			  console.log('true');
		  } else {
			  console.log('false');
			  callback(false);
		  }
		};
	let hosController;

	function handson() {
		$(".filterBtn").show();
		/*const data = [
			['','', '', '', ''],

		];*/
		if (data.length == 0) {
			data = [
				['','', '', '', '', '',''],

			];
		}

		const container = document.getElementById('example');
		hosController != null ? hosController.destroy() : "";
		hosController = new Handsontable(container, {
			data: data,
			colHeaders: [
					"ID",
				"GL Code(A)",
				"Detail(B)",
				"Parent Code(C)",
				"Detail(D)",
				"Is Ignore(E)",
				"Schedule Account(F)",
				"Schedule Detail(G)"
			],
			manualColumnResize: true,
			manualRowResize: true,
			stretchH: 'all',
			columns: [
				{type:'numeric'},
				{type: 'text',validator: emptyValidator,},
				{type: 'text'},
				{
					type: 'dropdown',
					source: sourceData,
				},
				{type: 'text'},
				{type: 'dropdown',source:['Yes','No']},
				{type: 'dropdown',source: scheduleParentMapp},
				{type: 'text'},
			],
			beforeChange: function (changes, source) {

				var row = changes[0][0];

				var prop = changes[0][1];

				var value = changes[0][3];
				if (prop == 3) {
					getDataSet(value,1).then(e => {
						this.setDataAtRowProp(row, 4, e);
					});
				}

			},
			afterChange: function (changes,source) {
				if(changes){
					var row = changes[0][0];
					var prop = changes[0][1];
					var value = changes[0][3];
					if(prop == 1){
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						this.setSourceDataAtCell(row,1,value);
						this.render();
					}
					if(prop == 3){
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						if($("#filterTable").val()!=1)
						{
							this.setSourceDataAtCell(row,3,value);
						}
						this.render();
					}
					if (prop == 6) {
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						getScheduleDataSet(value,1).then(e => {
							this.setDataAtRowProp(row,7,e);
						});
						this.render();
					}

				}
			},
			beforePaste: (data, coords) => {
				for (let i = 0; i < data.length; i++) {
					var c=0;
					for (let j = 0; j < data[i].length; j++) {
						if(coords[0].startCol===1)
						{
							if(c==0 || c==2)
							{
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							}
							c++;
						}
						if(coords[0].startCol == 3){
							data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							data[i][j] = data[i][j].trim();
						}
						if(coords[0].startCol == 2){
							if(c==1){
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
								data[i][j] = data[i][j].trim();
							}
							c++;
						}
					}
				}
			},
			beforeRemoveRow :(index,amount,physicalRows) => {
				physicalRows.map(e=> {
					var data = hosController.getDataAtRow(e);
					if (data.length !== 0) {
						if(data[0] != ""){
							RemoveRowData(data[0], 1);
						}
					}

				});
			},
			afterFilter: function (conditionsStack) {
				if(conditionsStack.length>0)
				{
					$("#filterTable").val(1);
					$(".filterBtn").hide();
				}
				else {
					$("#filterTable").val(0);
					$(".filterBtn").show();
				}
			},
			stretchH: 'all',

			trimWhitespace:true,
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			hiddenColumns: {
				columns:[0],
				copyPasteEnabled:false,
			},
			dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation',
		});
		hosController.validateCells();
	}

	function us_handson() {
		/*const data = [
			['','', '', '', ''],

		];*/
		if (data.length == 0) {
			data = [
				['','', '', '', '', '',''],

			];
		}

		const container = document.getElementById('us_example');
		hosController != null ? hosController.destroy() : "";
		hosController = new Handsontable(container, {
			data: data,
			colHeaders: [
					"ID",
				"GL Code(A)",
				"Detail(B)",
				"Parent Code(C)",
				"Detail(D)",
				"Is Ignore(E)",
				"Schedule Account(F)",
				"Schedule Detail(G)"
			],
			manualColumnResize: true,
			manualRowResize: true,
			columns: [
				{type:'numeric'},
				{type: 'text',validator: emptyValidator,},
				{type: 'text'},
				{
					type: 'dropdown',
					source: sourceData,
				},
				{type: 'text'},
				{type: 'dropdown',source:['Yes','No']},
				{
					type: 'text'
				},{type: 'text'},
			],
			beforeChange: function (changes, source) {
				var row = changes[0][0];

				var prop = changes[0][1];

				var value = changes[0][3];
				if (prop == 3) {
					getDataSet(value,2).then(e => {
						this.setDataAtRowProp(row, 4, e);
					});
				}
			},
			afterChange: function (changes,source) {
				if(changes){
					var row = changes[0][0];
					var prop = changes[0][1];
					var value = changes[0][3];
					if(prop == 1){
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						this.setSourceDataAtCell(row,1,value);
						this.render();
					}
					if(prop == 3){
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						if($("#filterTable").val()!=1)
						{
							this.setSourceDataAtCell(row,3,value);
						}
						this.setCellMeta(row, 6, 'type', 'dropdown');
						var data = getParentSchedulingAccount(value).then(e => {
							this.setCellMeta(row, 6, 'source', e);
						});
						this.render();
					}
					if (prop == 6) {
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						getScheduleDataSet(value,1).then(e => {
							this.setSourceDataAtCell(row,7,e);
						});
						this.render();
					}
				}
			},
			beforePaste: (data, coords) => {
				for (let i = 0; i < data.length; i++) {
					var c=0;
					for (let j = 0; j < data[i].length; j++) {
						if(coords[0].startCol===1)
						{
							if(c==0 || c==2)
							{
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							}
							c++;
						}
						if(coords[0].startCol == 3){
							data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							data[i][j] = data[i][j].trim();
						}
						if(coords[0].startCol == 2){
							if(c==1){
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
								data[i][j] = data[i][j].trim();
							}
							c++;
						}
					}
				}
			},
			beforeRemoveRow :(index,amount,physicalRows) => {
				physicalRows.map(e=> {
					var data = hosController.getDataAtRow(e);
					if (data.length !== 0) {
						if(data[0] != ""){
							RemoveRowData(data[0], 2);
						}
					}

				});
			},
			afterFilter: function (conditionsStack) {
				if(conditionsStack.length>0)
				{
					$("#filterTable").val(1);
					$(".filterBtn").hide();
				}
				else {
					$("#filterTable").val(0);
					$(".filterBtn").show();
				}
			},
			stretchH: 'all',
			trimWhitespace:true,
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			hiddenColumns: {
				columns:[0],
				copyPasteEnabled:false,
			},
			dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		hosController.validateCells();
	}

	function ifrs_handson() {
		/*const data = [
			['','', '', '', ''],

		];*/
		if (data.length == 0) {
			data = [
				['','', '', '', '', '',''],

			];
		}

		const container = document.getElementById('ifrs_example');
		hosController != null ? hosController.destroy() : "";
		hosController = new Handsontable(container, {
			data: data,
			colHeaders: [
					"ID",
				"GL Code(A)",
				"Detail(B)",
				"Parent Code(C)",
				"Detail(D)",
				"Is Ignore(E)",
				"Schedule Account(F)",
				"Schedule Detail(G)"
			],
			manualColumnResize: true,
			manualRowResize: true,
			columns: [
				{type:'numeric'},
				{type: 'text',validator: emptyValidator,},
				{type: 'text'},
				{
					type: 'dropdown',
					source: sourceData,
				},
				{type: 'text'},
				{type: 'dropdown',source:['Yes','No']},
				{
					type: 'text'
				},{type: 'text'},
			],
			beforeChange: function (changes, source) {
				var row = changes[0][0];

				var prop = changes[0][1];

				var value = changes[0][3];
				if (prop == 3) {
					getDataSet(value,3).then(e => {
						this.setDataAtRowProp(row, 4, e);
					});
				}
			},
			afterChange: function (changes,source) {
				if(changes){
					var row = changes[0][0];
					var prop = changes[0][1];
					var value = changes[0][3];
					if(prop == 1){
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						this.setSourceDataAtCell(row,1,value);
						this.render();
					}
					if(prop == 3){
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						if($("#filterTable").val()!=1)
						{
							this.setSourceDataAtCell(row,3,value);
						}
						this.setCellMeta(row, 6, 'type', 'dropdown');
						var data = getParentSchedulingAccount(value).then(e => {
							this.setCellMeta(row, 6, 'source', e);
						});
						this.render();
					}
					if (prop == 6) {
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.trim();
						getScheduleDataSet(value,1).then(e => {
							this.setSourceDataAtCell(row,7,e);
						});
						this.render();
					}
				}
			},
			beforePaste: (data, coords) => {
				for (let i = 0; i < data.length; i++) {
					var c=0;
					for (let j = 0; j < data[i].length; j++) {
						if(coords[0].startCol===1)
						{
							if(c==0 || c==2)
							{
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							}
							c++;
						}
						if(coords[0].startCol == 3){
							data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
							data[i][j] = data[i][j].trim();
						}
						if(coords[0].startCol == 2){
							if(c==1){
								data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
								data[i][j] = data[i][j].trim();
							}
							c++;
						}
					}
				}
			},
			beforeRemoveRow :(index,amount,physicalRows) => {
				physicalRows.map(e=> {
					var data = hosController.getDataAtRow(e);
					if (data.length !== 0) {
						if(data[0] != ""){
							RemoveRowData(data[0], 3);
						}
					}
				});
			},
			afterFilter: function (conditionsStack) {
				if(conditionsStack.length>0)
				{
					$("#filterTable").val(1);
					$(".filterBtn").hide();
				}
				else {
					$("#filterTable").val(0);
					$(".filterBtn").show();
				}
			},
			stretchH: 'all',
			trimWhitespace:true,
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			hiddenColumns: {
				columns:[0],
				copyPasteEnabled:false,
			},
			dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		hosController.validateCells();
	}

	function getDataSet(value,key) {
		$.LoadingOverlay("show");
		return new Promise(function (resolve, reject) {
			$.ajax({
				url: base_url + "getValueDetail",
				type: "POST",
				dataType: "json",
				data: {value: value,type : key},
				success: function (result) {
					if(result.status === 200)
					{
						$.LoadingOverlay("hide");
						resolve(result.data);
					}else
					{
						$.LoadingOverlay("hide");
						reject();
					}

				},
				error: function (error) {
					$.LoadingOverlay("hide");
					console.log(error);
					// $.LoadingOverlay("hide");
				}
			});
		});
	}

	function saveExcelData() {
		$.LoadingOverlay("show");
		$("#newErrorDiv").html('');
		var array=hosController.getData();
		var branch_id = $("#branch_id").val();
		if (confirm("Are You Sure You want to upload?")) {
			$.ajax({
				url: base_url + "InsertDataBranchSetup",
				type: "POST",
				dataType: "json",
				data: {value: array, branch_id: branch_id},
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status == 200) {
						toastr.success(result.body);
						getDataMain();
					} else {
						toastr.error(result.body);
						if (result.type == 1) {
							$("#newErrorDiv").html(`<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-exclamation-circle"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
						                         ${result.body}
						                      </div>
						                    </div></div>`);
						}
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
		$("#newErrorDiv").html('');
		var array=hosController.getData();
		var branch_id = $("#branch_id").val();
		if (confirm("Are You Sure You want to upload?")) {
			$.ajax({
				url: base_url + "InsertUSBranchSetup",
				type: "POST",
				dataType: "json",
				data: {value: array, branch_id: branch_id},
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status == 200) {
						toastr.success(result.body);
						getUSData();
					} else {
						if(result.type==1)
						{
							$("#newErrorDiv").html(`<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-exclamation-circle"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
						                         ${result.body}
						                      </div>
						                    </div></div>`);
						}
						else
						{
							toastr.error(result.body);
						}

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
		$("#newErrorDiv").html('');
		var array=hosController.getData();
		// console.log(array);
		var branch_id = $("#branch_id").val();
		if (confirm("Are You Sure You want to upload?")) {
			$.ajax({
				url: base_url + "InsertIFRSBranchSetup",
				type: "POST",
				dataType: "json",
				data: {value: array, branch_id: branch_id},
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status == 200) {
						toastr.success(result.body);
						getIFRSData();
					} else {
						if(result.type==1)
						{
							$("#newErrorDiv").html(`<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-exclamation-circle"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
						                         ${result.body}
						                      </div>
						                    </div></div>`);
						}
						else
						{
							toastr.error(result.body);
						}

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




	$("#branch_excel").validate({
		rules: {
			userfile: {
				required: true
			}
		},
		messages: {
			userfile: {
				required: "Please select file",
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
			$.LoadingOverlay("show");
			$("#validateDiv").html('');
			$("#saveExcelColumnsBtn").hide();
			var formData=new FormData(form);
			$.ajax({
				url: base_url+"branch_excelupload",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status === 200) {
						$("#validateDiv").html(result.body);
						$("#saveExcelColumnsBtn").show();
						$("#count").val(result.count);
					}
					else
					{
						$("#count").val(0);
						toastr.error(result.body);
					}
				}, error: function (error) {
					$.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});


	function saveExcelColumns()
	{
		$.LoadingOverlay("show");
		var form_data = document.getElementById('branch_excel');
		let formData = new FormData(form_data);
		var branch_id = $("#branch_id").val();
		formData.set('branch_id',branch_id);
		app.request(base_url + "SaveBranchExcel",formData).then(res=>{
			$.LoadingOverlay("hide");
			$("#unmatchStatus").val(0);
			if(res.status==200)
			{
				toastr.success(res.body);
				$("#validateDiv").html('');
				$("#errorDiv").html('');
				$("#tableDiv").html('');
				window.location.href=base_url+"Excel?id="+branch_id;
			}
			else
			{
				if(res.type==1)
				{
					var template=`<div class="col-md-12">

									`;
					if(res.MandatoryData!="")
					{
						template+= `
										<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
						                         ${res.MandatoryData}
						                      </div>
						                    </div></div>`;
					}
					else
					{
						template+= `
										<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">Total Row - </b> ${res.TotalRowUpload-1}</div>
						                        <div class="alert-title">Match - </b> ${res.MatchedData}</div>
						                        <div class="alert-title">UnMatch - </b> ${res.UmatchedData}</div>
						                      </div>
						                    </div></div>`;
						if(res.NoText!="")
						{
							template+= `
											<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">At this Position Only <b>Numeric Value</b> allowed</div>
							                         ${res.NoText}
							                      </div>
							                    </div></div>`;

						}
						else if(res.UmatchedData!="")
						{
							$("#excel-modal-company").modal('show');
							$("#unmatch").html(`
											<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-film"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">There Was an <b>${res.UmatchedData} Unmatch/ ${res.TotalRowUpload-1} Total Row </b> data Do you want to proceed </div>
							                      </div>
							                    </div></div>`);
						}
					}


					template+= `

								</div>`;
					$("#errorDiv").html(template);
					$("#tableDiv").html(res.table);
				}
				else
				{
					$.LoadingOverlay("hide");
					toastr.error(res.body);
				}
			}

		});
		$.LoadingOverlay("hide");
	}


	function  RemoveRowData(value,type) {
		let formData = new FormData();
		var branch_id = $("#branch_id").val();
		formData.set('id',value);
		formData.set('type',type);
		formData.set('branch_id',branch_id);
		app.request(base_url + "RemoveSubsidiaryData",formData).then(res=>{
			if(res.status === 200)
			{
				if(type === 1)
				{
					getDataMain();
				}
				if(type === 2)
				{
					getUSData();
				}
				if(type ===3)
				{
					getIFRSData();
				}
				console.log(res.data);
			}
			else
			{
				console.log(res.data);
			}
		});
	}


	function clearData() {
		if (confirm("Are You Sure You want to Delete Data?")) {
			var branch_id = $('#branch_id').val();
			let formdata = new FormData();
			formdata.set('branch_id', branch_id);
			app.request(base_url + 'clearData', formdata).then(res => {
				if (res.status === 200) {
					toastr.success(res.body);
					window.location.href = base_url + "Excel?id=" + branch_id;
				} else {
					toastr.error(res.body);
				}
			}).catch(error => console.log(error));
		}
	}

	function getParentSchedulingAccount(pID) {
		$.LoadingOverlay("show");
		return new Promise(function (resolve, reject) {
			$.ajax({
				url: base_url + "getParentSchedulingAccount",
				type: "POST",
				dataType: "json",
				data: {id: pID},
				success: function (result) {
					$.LoadingOverlay("hide");
					var data1 = result.data;
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
	function getScheduleDataSet(value,key) {
		$.LoadingOverlay("show");
		return new Promise(function (resolve, reject) {
			$.ajax({
				url: base_url + "getScheduleDataSet",
				type: "POST",
				dataType: "json",
				data: {value: value,type : key},
				success: function (result) {
					if(result.status === 200)
					{
						$.LoadingOverlay("hide");
						resolve(result.data);
					}else
					{
						$.LoadingOverlay("hide");
						reject();
					}

				},
				error: function (error) {
					$.LoadingOverlay("hide");
					console.log(error);
					// $.LoadingOverlay("hide");
				}
			});
		});
	}
	function getPercentageHoldingData() {
		$.LoadingOverlay("show");
		var branch_id = $("#branch_id").val();
		$.ajax({
			url: base_url + "getPercentageHoldingData",
			type: "POST",
			dataType: "json",
			data: {branch_id: branch_id},
			success: function (result) {
				$.LoadingOverlay("hide");
				sourceData = result.data;
				data = result.data2;
				getPercentageHoldHandson();
			},
			error: function (error) {
				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}
	function getPercentageHoldHandson() {
		$(".filterBtn").show();
		/*const data = [
			['','', '', '', ''],

		];*/
		if (data.length == 0) {
			data = [
				['','', '', '', '', '',''],

			];
		}

		const container = document.getElementById('newPercentageHoldType');
		hosController != null ? hosController.destroy() : "";
		hosController = new Handsontable(container, {
			data: data,
			colHeaders: [
				"GL Code(A)",
				"Detail(B)",
				"Type(C)",
			],
			manualColumnResize: true,
			manualRowResize: true,
			stretchH: 'all',
			columns: [
				{
					type: 'dropdown',
					source: sourceData,
				},
				{type: 'text'},
				{type: 'dropdown',source:['','Majority','Minority']},
			],
			minSpareRows: 1,
			beforeChange: function (changes, source) {

				var row = changes[0][0];

				var prop = changes[0][1];

				var value = changes[0][3];
				if (prop == 0) {
					getDataSet(value,1).then(e => {
						this.setDataAtRowProp(row, 1, e);
					});
				}

			},
			beforeRemoveRow :(index,amount,physicalRows) => {
				physicalRows.map(e=> {
					var data = hosController.getDataAtRow(e);
					if (data.length !== 0) {
						if(data[0] != ""){
							RemoveRowData(data[0], 1);
						}
					}

				});
			},
			afterFilter: function (conditionsStack) {
				if(conditionsStack.length>0)
				{
					$("#filterTable").val(1);
					$(".filterBtn").hide();
				}
				else {
					$("#filterTable").val(0);
					$(".filterBtn").show();
				}
			},
			stretchH: 'all',

			trimWhitespace:true,
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation',
		});
		hosController.validateCells();
	}
	function savePercentageHoldData() {
		$.LoadingOverlay("show");
		$("#newPercentageHoldType").html('');
		var array=hosController.getData();
		var branch_id = $("#branch_id").val();
		if (confirm("Are You Sure You want to upload?")) {
			$.ajax({
				url: base_url + "InsertPercentageHoldData",
				type: "POST",
				dataType: "json",
				data: {value: array, branch_id: branch_id},
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status == 200) {
						toastr.success(result.body);
						getPercentageHoldingData();
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
	function clearPercentageHoldData() {
		if (confirm("Are You Sure You want to Delete Data?")) {
			var branch_id = $('#branch_id').val();
			let formdata = new FormData();
			formdata.set('branch_id', branch_id);
			app.request(base_url + 'clearPercentageHoldData', formdata).then(res => {
				if (res.status === 200) {
					toastr.success(res.body);
					getPercentageHoldingData();
				} else {
					toastr.error(res.body);
				}
			}).catch(error => console.log(error));
		}
	}
</script>
