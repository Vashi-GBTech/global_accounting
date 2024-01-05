<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.top_button
	{
		float: right;
    	margin-bottom: 10px;
	}
	.nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover {
	    border-bottom-color: #fff;
	    background-color: #f7e3ad;
	    color: black;
	    text-shadow: 0px 4px 5px #00000055!important;
	}
</style>
<!-- Main Content -->
<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Consolidate Schedule Report of <?php echo $month." ". $year ;?></h4>
							
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<input type="hidden" name="mainSetupType" id="mainSetupType" value="BS">
			<div class="col-lg-12 bg-white">
				<div class="bg-white" style="border: none">
					<div id="ReportSheet"></div>
					<div class="col-md-12">

							<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
								<li class="nav-item match active" role="presentation">
									<a data-toggle="tab" href="#matched" class="nav-link active" id="matched_data" role="tab" aria-selected="true" aria-expanded="true" onclick="getMainSetupType('BS');getDataMainBalanceSheet()">Balance Sheet</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#unmatched" class="nav-link" id="unmatched_data" role="tab" aria-selected="false" aria-expanded="false" onclick="getMainSetupType('PL');getDataMainProfitLoss()">Profit & loss</a>
								</li>
							</ul>
							<div class="tab-content" style="padding:0;">
								<div id="matched" class="tab-pane active">
									<div class="row">
										<div class="col-lg-12">
											<div class="card-box" style="border: none">
												
												<div class="col-md-12" id="example"></div>
											</div>
										</div>
									</div>
								</div>
								<div id="unmatched" class="tab-pane">
									<div class="row">
										<div class="col-lg-12">
											<div class="card-box" style="border: none">
												
												<div class="col-md-12" id="examplePl"></div>
												
														
										</div>
									</div>
								</div>
							</div>
						</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('_partials/footer'); ?>
	<script>
		$( document ).ready(function() {
			getDataMainBalanceSheet();
		});

	
	
		
		function getMainSetupType(type)
		{
			$("#mainSetupType").val(type);
		}
		let  data=[];

		function getDataMainBalanceSheet() {
			var formData=new FormData();
			formData.set('type',$("#mainSetupType").val());
			app.request(baseURL + "getScheduleReportData",formData).then(res=>{
				var data=[['','','','','','','']];
				if(res.columnRows.length>0)
				{
					data=res.columnRows;
				}
				
				
				let columnsHeader=res.columnHeader;
				let hiddenColumns=[0];
				let columnsRows=data;
				let columnTypes=res.columnType;
				handson(columnsHeader,columnsRows,columnTypes,'example',hiddenColumns,1);
			});
		}
		function getDataMainProfitLoss() {
			var formData=new FormData();
			formData.set('type',$("#mainSetupType").val());
			app.request(baseURL + "getScheduleReportData",formData).then(res=>{
				var data=[['','','','','','','']];
				if(res.columnRows.length>0)
				{
					data=res.columnRows;
				}
				let columnsHeader=res.columnHeader;
				let hiddenColumns=[1];
				let columnsRows=data;
				let columnTypes=res.columnType;
				handson(columnsHeader,columnsRows,columnTypes,'examplePl',hiddenColumns,2);
			});
		}
		let hosController;
		function handson(columnsHeader,columnsRows,columnTypes,divId,hiddenColumns,dropType) {
			if(data.length == 0){
				data = [
					['','','', '', '', '','',''],

				];
			}
			

			const container = document.getElementById(divId);
			hosController!=null?hosController.destroy():"";
			hosController = new Handsontable(container, {
				data:columnsRows,
				colHeaders: columnsHeader,
				manualColumnResize: true,
				manualRowResize :true,
				columns: columnTypes,
				beforeChange: function (changes, source) {
					var row = changes[0][0];

					var prop = changes[0][1];

					var value = changes[0][3];


				},
				afterChange: function(changes, src){
					if(dropType==1)
					{
						if(changes){
					    	var row = changes[0][0];
					    	var value = changes[0][3];
					    	var prop = changes[0][1];
					    	if(prop==3)
					    	{
					    		this.setCellMeta(row,4, 'type', 'dropdown');
					      		var data=getBalanceSheetType2(value).then(e=>{;
					      			this.setCellMeta(row,4, 'source', e);
					      		});
					        	this.render();
					    	}
			    		}
					}
					
				},
				colWidths: '100%',
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
				dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
				licenseKey: 'non-commercial-and-evaluation'
			});
			hosController.validateCells();
		}

	</script>
</div>
