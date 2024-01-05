<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.alert.alert-light {
	    background-color: #e3eaef;
	    color: #191d21;
	}
	.alert.alert-has-icon {
	    display: flex;
	}
	.alert {
	    color: #fff;
	    border: none;
	    padding: 15px 20px;
	}
	.alert.alert-has-icon .alert-icon {
	    margin-top: 4px;
	    width: 30px;
	}
	.alert.alert-has-icon .alert-body {
	    flex: 1;
	}
	.alert .alert-title {
	    font-size: 15px;
	    font-weight: 500;
	    margin-bottom: 5px;
	}
	.alert-light {
	    color: #818182;
	    background-color: #fefefe;
	    border-color: #fdfdfe;
	}
	.alert {
	    position: relative;
	    padding: 0.75rem 1.25rem;
	    margin-bottom: 1rem;
	    border: 1px solid transparent;
	    border-radius: 0.25rem;
	}
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 3px 3px!important;
}
.tableHead
{
	background-color: #f2d176;
}
.uploadLable
{
	font-size: 18px;
}
.nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover {
	    border-bottom-color: #fff;
	    background-color: #f7e3ad;
	    color: black;
	    text-shadow: 0px 4px 5px #00000055!important;
	}
	/*.handsontable
	{
		height: 70vh!important;
	}*/
</style>
<!-- Main Content -->
<div class="content-page">
	<div class="content">
	<input type="hidden" name="insertID" id="insertID" value="<?php echo $id;?>">
	<input type="hidden" name="branchID" id="branchID" value="<?php echo $branch_id;?>">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<div class="" style="    display: flex; flex-direction: row;">
								<button class="btn btn-link "><a href="handson"><i class="fa fa-arrow-left"></i></a></button>
								<h4 class="">Upload Financial Data</h4>
							</div>

							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 bg-white">

		<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
			<li class="nav-item match active" role="presentation">
				<a data-toggle="tab" href="#matched" class="nav-link active" id="matched_data" role="tab" aria-selected="true" aria-expanded="true" onclick="loadEditableTable()">Financial Data</a>
			</li>
			<li class="nav-item unmatch" role="presentation">
				<a data-toggle="tab" href="#unmatched" class="nav-link" id="unmatched_data" role="tab" aria-selected="false" aria-expanded="false" onclick="">Excel Upload</a>
			</li>
		</ul>
		<div class="tab-content" style="padding:0;">
				<div id="matched" class="tab-pane active">
					<div class="row " style="padding: 10px 0 10px 0;">
						<div class="col-md-6 " id="checkBoxDiv" style="">
							<input type="checkBox" name="removeDebit" id="removeDedit" value="1" onclick="getHandonOnchange()">
							Remove Debit, Credit & Opening Balance
						</div>
						<div class="col-md-6" style="text-align: end">
							<button type="button" class="btn btn-danger roundCornerBtn4" id="clear" onclick="ClearFinancialData()"
									style="">Clear All Data
							</button>
							<button type="button" class="btn btn-primary roundCornerBtn4 filterBtn" id="finacialBtn" onclick="saveCopyFiancialData()"
									style="">Save
							</button>

						</div>
					</div>
					<div class="col-md-12" id="newErrorDiv" style="display: none;"></div>
					<div class="col-md-12" id="newDiv"></div>
				</div>
				<div id="unmatched" class="tab-pane">
					<div class="row" id="financialFormRow">
						<div class="col-lg-12 m-t-10">
							<div class="card-box">
								<form method="post" id="exportexcelsheet">
									<input type="hidden" name="unmatchStatus" id="unmatchStatus" value="0">
									<div class="row">
										<div class="col-md-12">
											<div><label>Upload Excel File</label><hr></div>
											<div class="col-md-2">
												<input type="file" name="userfile[]" id="userfile" class="form_control" style="display: none;">
												<label for="userfile"> <i class="fa fa-upload uploadLable"></i> Upload</label>
											</div>
											<div class="col-md-4"><button type="submit" class="btn btn-primary roundCornerBtn4">Save</button></div>
										</div>
										<div class="col-md-12" id="validateDiv"></div>
											<div class="col-md-12">
												<input type="hidden" name="count" id="count" class="form_control" value="0">
												<button type="button" class="btn btn-primary roundCornerBtn4 " id="saveExcelColumnsBtn" onclick="saveExcelColumns()" style="display: none;float: right; margin-top: 10px;">Save</button>
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
<div class="modal fade" tabindex="-1" role="dialog" id="excel-modal-company"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Unmatch Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

				<div class="modal-body py-0">
					<div class="card my-0 shadow-none" id="unmatch">

					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4" type="button" onclick="unmatchStatus()">Submit</button>
					<button class="btn btn-secondary roundCornerBtn4" type="reset">Reset</button>
				</div>

		</div>
	</div>
</div>

<?php $this->load->view('_partials/footer'); ?>

</div>

<script src="<?php echo base_url();?>assets/js/module/upload_data/financial_data.js"></script>
<script type="text/javascript">
	var base_url='<?php echo base_url(); ?>';
</script>
<script type="text/javascript">
	$(document).ready(function () {

		loadEditableTable();

	});
	$("#exportexcelsheet").validate({
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
			// console.log(formData);
			$.ajax({
				url: base_url+"ExportToTableValidation",
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
		var form_data = document.getElementById('exportexcelsheet');
		let formData = new FormData(form_data);
		formData.set('insertID', $("#insertID").val());
		formData.set('branchID', $("#branchID").val());
		// formData.set('creditCheck', creditCheck);
		app.request(base_url + "saveExcelColumns",formData).then(res=>{
			$.LoadingOverlay("hide");
			// data=res.data2;
			// console.log(res);

			$("#unmatchStatus").val(0);
			if(res.status==200)
			{
				toastr.success(res.body);
				$("#excel-modal-company").modal('hide');
				$("#saveExcelColumnsBtn").hide();
				$("#validateDiv").html('');
				$("#errorDiv").html('');
				$("#tableDiv").html('');
				window.location.href=base_url+"handson";
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
	}

	function unmatchStatus()
	{
		$("#unmatchStatus").val(1);
		saveExcelColumns();
	}
	// Empty validator
	emptyValidator = function(value, callback) {
	  if (!value) {
	    console.log('false');
	    callback(false);
	  } else {
	    console.log('true');
	    callback(true);
	  }
	};
	let debitCheck = 0;
	// let creditCheck=0;
	// let columnRows=[];
	// let columnsHeader=[];
	function loadEditableTable() {
		$.LoadingOverlay("show");
		var id=$("#insertID").val();
		var branch_id=$("#branchID").val();
		$.ajax({
			url: base_url + "getExportToTableData",
			type: "POST",
			dataType: "json",
			data: {id: id, branch_id: branch_id},
			success: function (result) {
				$.LoadingOverlay("hide");
				var rows = [
					['', '', '', '', '',],
				];
				if (result.status === 200) {
					// var columns=result.columns;
					if (result.rows.length > 0) {
						rows = result.rows;
					}
					// var types=result.types;
					// columnRows=rows;
					// columnsHeader=columns;

				} else {

					rows = [
						['', '', '', '', ''],
					];
				}
				var types = [
					{type: 'text',validator: emptyValidator,},
					// { type: 'numeric',numericFormat: {
					// 		pattern: {
					// 			thousandSeparated: true,
					// 			forceSign: true,
					// 			trimMantissa: true
					// 		}
					//
					// 	},},
					{type: 'text'},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								trimMantissa: true,
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								trimMantissa: true,
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								trimMantissa: true,
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								trimMantissa: true,
							}

						},
					},
				];
				var hideArra = [];
				var columns = ['gl_ac(A)', 'detail(B)', 'Opening Balance(C)', 'debit(D)', 'credit(E)', 'total(F)'];
				if (debitCheck == 1) {

					hideArra.push(2, 3, 4);
				}
				//         if(creditCheck==1)
				//         {

				// hideArra.push(3);

				//         }

				hideColumn = {
					// specify columns hidden by default
					columns: hideArra,
					copyPasteEnabled: false,
				};
				createHandonTable(columns, rows, types, 'newDiv', hideColumn);

			},
			error: function (error) {
				console.log(error);
				$.LoadingOverlay("hide");
			}
		});

	}

	let hotDiv;

	function createHandonTable(columnsHeader, columnRows, columnTypes, divId, hideColumn = true) {
		$(".filterBtn").show();
		var element = document.getElementById(divId);
		hotDiv != null ? hotDiv.destroy() : '';
		hotDiv = new Handsontable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			formulas: true,
			manualColumnResize: true,
			manualRowResize: true,
			columns: columnTypes,
			beforeChange: function (changes, source) {
				var row = changes[0][0];

				var prop = changes[0][1];

				var value = changes[0][3];

			},
			beforePaste:(data, coords) => {
				for (let i = 0; i < data.length; i++) {
					var c = 0;
					for (let j = 0; j < data[i].length; j++) {
						if (coords[0].startCol == 0) {
							data[i][j] = data[i][j].replace(/[^a-z0-9]/gi, '');
						//	data[i][j] = data[i][j].replace(/\D/g, '');
							c++;
						}
						if(c === 2 || c === 3 || c === 4 || c === 5|| c === 6 || coords[0].startCol == 2 || coords[0].startCol == 3 || coords[0].startCol == 4 || coords[0].startCol == 5 || coords[0].startCol == 6)
						{
							data[i][j] = data[i][j].replace(/,/g, '');
							data[i][j] = data[i][j].replace(/^\(/g,'-');
							data[i][j] = data[i][j].replace(/["'\(\)]/g,'');
							data[i][j] = data[i][j].trim();
						}
						c++;
					}
				}
			},
			afterChange: function(changes, src){
				if(changes){
					var row = changes[0][0];
					var value = changes[0][3];
					var prop = changes[0][1];

					if(prop == 2 || prop == 3 || prop == 4|| prop == 5 || prop == 6 )
					{
						if (typeof value === 'string' || value instanceof String){
							var value1 = value.replace(/,/g, '');
							value1 = value1.replace(/^\(/g,'-');
							value1 = value1.replace(/["'\(\)]/g,'');
							value1 = parseInt(value1.trim());
							this.setDataAtCell(row,prop,value1);
							this.render();
						}
					}

					if(prop == 0)
					{
						value = value.replace(/[^a-z0-9]/gi, '');
						value = value.replace(/["'\(\)]/g,'');
						value = value.trim();
						this.setSourceDataAtCell(row,prop,value);
						this.render();
					}

				}
			},
			beforeValidate:function(value,row,prop){
				if((prop===0) && value==="")
				{
					return false;
				}
			},
			afterFilter: function (conditionsStack) {
				if(conditionsStack.length>0)
				{
					$(".filterBtn").hide();
				}
				else {
					$(".filterBtn").show();
				}
			},
			stretchH: 'all',
			colWidths: '100%',
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			hiddenColumns: hideColumn,
			dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		hotDiv.validateCells();
	}
	function ClearFinancialData() {
		if(confirm("Do you really want delete this data?")){
			$.LoadingOverlay("show");
			let formData = new FormData();
			formData.set('insertID', $("#insertID").val());
			formData.set('branchID', $("#branchID").val());
			app.request(base_url + "ClearAllFinancialData", formData).then(res => {
				$.LoadingOverlay("hide");
				// data=res.data2;
				// console.log(res);
				if (res.status == 200) {

					loadEditableTable();
				} else {

				}

			});
		}else{

		}

	}
	function saveCopyFiancialData() {
		$.LoadingOverlay("show");
		$("#newErrorDiv").hide();
		$("#newErrorDiv").html('');
		var data = hotDiv.getData();
		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('insertID', $("#insertID").val());
		formData.set('branchID', $("#branchID").val());
		formData.set('debitCheck', debitCheck);
		// formData.set('creditCheck', creditCheck);
		app.request(base_url + "saveCopyFiancialData", formData).then(res => {
			$.LoadingOverlay("hide");
			// data=res.data2;
			// console.log(res);
			if (res.status == 200) {
				toastr.success(res.body);
				document.getElementById("removeDedit").checked = false;
				// document.getElementById("removeCredit").checked = false;
				debitCheck = 0;
				// creditCheck=0;
				hideArra = [];
				loadEditableTable();
			} else {
				if (res.status == 202) {
					if(res.type==2)
					{
						$("#newErrorDiv").show();
						$("#newErrorDiv").append(`<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">At this Position <b>Opening Balance</b> Supposed to be <b>0</b> </div>
							                         ${res.opening}
							                      </div>
							                    </div></div>`);
					}
					if(res.type==1)
					{
						$("#newErrorDiv").show();
						$("#newErrorDiv").append(`<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
							                         ${res.body}
							                      </div>
							                    </div></div>`);
					}
				}
				else
				{
					toastr.error(res.body);
				}
			}

		});
	}

	function getHandonOnchange() {
		var checkBoxDebit = document.getElementById("removeDedit");

		if (checkBoxDebit.checked == true) {
			debitCheck = 1;
		} else {
			debitCheck = 0;
		}
		var id = $("#insertID").val();
		var branch_id = $("#branchID").val();
		loadEditableTable(id, branch_id);

	}
</script>
