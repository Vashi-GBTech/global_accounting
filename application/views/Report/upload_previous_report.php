<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<h4 class="page-title">Previous Consolidate Report</h4>
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
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Year</label>
										<select name="year" id="year" class="form-control">
											<option disabled="" selected="">Select year</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
											<option value="2022">2022</option>
											<option value="2023">2023</option>
											<option value="2024">2024</option>
											<option value="2025">2025</option>
											<option value="2026">2026</option>
											<option value="2027">2027</option>
											<option value="2028">2028</option>
											<option value="2029">2029</option>
											<option value="2030">2030</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Month</label>
										<select name="quarter" id="quarter" class="form-control">
											<option disabled="" selected="">Select month</option>
											<option value="1">January</option>
											<option value="2">February</option>
											<option value="3">March</option>
											<option value="4">April</option>
											<option value="5">May</option>
											<option value="6">June</option>
											<option value="7">July</option>
											<option value="8">August</option>
											<option value="9">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<?php //if ($this->session->userdata('user_type') == 2) { ?>
											<div class="col-md-6">
												<div class="form-group">

													<!--										<input type="file" class="form-control" id="userfile" name="userfile" >-->
													<!-- <select name="branch_id" id="branch_id" class="form-control">

													</select> -->
												</div>
											</div>
										<?php //} ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="branch_data">
							<div class="col-md-12">
								<ul class="nav nav-tabs  m-b-20" id="ex1" role="tablist">
									<li class="nav-item match active" role="presentation">
										<a data-toggle="tab" href="#uploadData" class="nav-link active" role="tab"
										   aria-selected="true" aria-expanded="true">Upload Data</a>
									</li>
									<li class="nav-item unmatch" role="presentation">
										<a data-toggle="tab" href="#uploadExcel" class="nav-link" role="tab"
										   aria-selected="false" aria-expanded="false">Upload Excel</a>
									</li>
								</ul>

								<div class="tab-content" style="padding:0;">
									<div class="tab-pane active" id="uploadData">
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-primary roundCornerBtn4" onclick="saveCopyFiancialData()"
														style="float:right;margin-bottom: 10px;">Save
												</button>
												<div class="col-md-12" id="newErrorDiv"></div>
												<div class="col-md-12" id="example"></div>
											</div>
											
										</div>
									</div>

									<div class="tab-pane" id="uploadExcel">
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-12" id="excel_newErrorDiv"></div>
												<div class="col-md-12" id="excel_example">
													<form method="post" id="exportexcelsheet">
														<input type="hidden" name="unmatchStatus" id="unmatchStatus" value="0">
														<div class="row">
															<div class="col-md-12">
																<!-- <div><label>Upload Excel File</label><hr></div> -->
																<div class="col-md-2">
																	<input type="file" name="userfile" id="userfile" class="form_control" style="display: none;">
																	<label for="userfile"> <i class="fa fa-upload uploadLable"></i> Upload</label>
																</div>
																<div class="col-md-4"><button type="submit" class="btn btn-primary roundCornerBtn4">Save</button></div>
															</div>
															<div class="col-md-12" id="validateDiv"></div>
																<div class="col-md-12">
																	<input type="hidden" name="count" id="count" class="form_control" value="0">
																	<button type="button" class="btn btn-primary  roundCornerBtn4" id="saveExcelColumnsBtn" onclick="saveExcelColumns()" style="display: none;float: right; margin-top: 10px;">Save</button>
																</div>
														</div>
														
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="row">
							<div class="card-box" id="report_body" style="border: none;">
								<button class="btn btn-primary" type="button" style="margin: 10px;" onclick="();">
									save
								</button>
								<div id="ReportSheet">
								</div>
							</div>
						</div> -->
						<div class="row">
							<div class="card-box" id="report_body" style="border: none;">
								<div id="ReportSheet">
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
<script type="text/javascript">
	var base_url='<?php echo base_url(); ?>';
</script>
<script>
	$(document).ready(function () {
		// getBranchList();
		loadEditableTable();
	});

	function getBranchList() {
		app.request(baseURL + "getCompanyBranchList", null).then(res => {
			$.LoadingOverlay("hide");
			if (res.status == 200) {
				$('#branch_id').append(res.data);
			}
		}).catch(e => {
			console.log(e);
		});
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
		rows = [
						['', '', '', '', '', '', '', '', ''],
					];
				
				var types = [
					{type: 'text',validator: emptyValidator,},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
					{
						type: 'numeric', numericFormat: {
							pattern: {
								thousandSeparated: true,
								forceSign: true,
								trimMantissa: true
							}

						},
					},
				];
				var columns = ['gl_ac(A)', 'Opening Balance 1(C)', 'debit 1(D)', 'credit 1(E)', 'total 1(F)', 'Opening Balance 2(C2)', 'debit 2(D2)', 'credit 2(E2)', 'total 2(F2)'];
				createHandonTable(columns, rows, types, 'example');

	}

	let hotDiv;
	function createHandonTable(columnsHeader, columnRows, columnTypes, divId) {

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
			beforePaste: (data, coords) => {
				
				for (let i = 0; i < data.length; i++) {
					var c=0;
					for (let j = 0; j < data[i].length; j++) {

						if (coords[0].startCol == c) {
							data[i][j] = data[i][j].replace(/[^A-Z0-9]/ig, '');
							data[i][j] = data[i][j].replace(/\D/g, '');
							c++;
						}
					}
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
			dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		
		hotDiv.validateCells();
	}

	function saveCopyFiancialData() {
		// $.LoadingOverlay("show");
		$("#newErrorDiv").hide();
		$("#newErrorDiv").html('');
		var data = hotDiv.getData();
		var year = $("#year").val();
		var quarter = $("#quarter").val();
		let formData = new FormData();
		formData.set('arrData', JSON.stringify(data));
		formData.set('branchID', $("#branchID").val());
		formData.set('debitCheck', debitCheck);
		formData.set('year', year);
		formData.set('quarter', quarter);

		// formData.set('creditCheck', creditCheck);
		app.request(base_url + "saveCopyFiancialDataPrevious", formData).then(res => {
			$.LoadingOverlay("hide");
			// data=res.data2;
			// console.log(res);
			if (res.status == 200) {
				toastr.success(res.body);
				// document.getElementById("removeDedit").checked = false;
				// document.getElementById("removeCredit").checked = false;
				debitCheck = 0;
				// creditCheck=0;
				hideArra = [];
				loadEditableTable();
			} else {
				if(res.type==1)
				{
					$("#newErrorDiv").show();
					$("#newErrorDiv").html(`<div><div class="alert alert-light alert-has-icon">
						                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
						                      <div class="alert-body">
						                        <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
						                         ${res.body}
						                      </div>
						                    </div></div>`);
				}
				else
				{
					toastr.error(res.body);
				}
			}

		});
	}

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
				url: base_url+"ExportToTableValidationConsolidate",
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
		formData.set('year', $("#year").val());
		formData.set('quarter', $("#quarter").val());
		// formData.set('creditCheck', creditCheck);
		app.request(base_url + "saveExcelColumnsConsolidate",formData).then(res=>{
			console.log(res);
			// data=res.data2;
			// console.log(res);

			$("#unmatchStatus").val(0);
			if(res.status==200)
			{
				$.LoadingOverlay("hide");
				toastr.success(res.body);
				$("#excel-modal-company").modal('hide');
				$("#saveExcelColumnsBtn").hide();
				$("#validateDiv").html('');
				$("#errorDiv").html('');
				$("#tableDiv").html('');
				window.location.href=base_url+"view_consolidate_report";
			}
			else
			{
				$.LoadingOverlay("hide");
				$("#tableDiv").html(res.table);
				toastr.error(res.body);
			}

		});
	}
	
	function loadData() {
		$.LoadingOverlay("show");
		var year = $("#year").val();
		var quarter = $("#quarter").val();
		let formData = new FormData();
		formData.set("branch_id", 3);
		formData.set("year", year);
		formData.set("month", quarter);
		app.request('getDataMain', formData).then(res => {
			if (res.status === 200){
				$.LoadingOverlay("hide");
				getSumValue().then(hData => {
					if(hData.status === 200){
						$('#report_body').show();
						loadHandSon(document.getElementById("ReportSheet"),
								hData.data,
								hData.headers,hData.hideColumn
						);
					}else
					{
						$.LoadingOverlay("hide");
						alert(hData.message);
					}
				})
			}else{
				$.LoadingOverlay("hide");
				alert(res.data);
			}

		})


	}

	// let hotDiv;

	function loadHandSon(element, columnRows, columnsHeader,hideColumn) {
	//	console.log(hideColumn);

		hotDiv = app.getHandSonTable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			hiddenColumns: {
				columns: hideColumn,
				copyPasteEnabled: false,
			}
			// beforeChange: function (changes, source) {
			//
			// 	let row = changes[0][0];
			// 	let prop = changes[0][1];
			// 	let value = changes[0][3];
			// 	if (prop === "GL_PROP") {
			// 		getSumValue(value).then(res => {
			// 			if (res.status === 200) {
			// 				// let count =1;
			// 				let [creditTotal,debitTotal,finalTotal]=[0,0,0];
			// 				res.data.forEach(item=>{
			// 					// this.setDataAtRowProp(row + count, 2,item.account);
			// 					creditTotal+=parseFloat(item.credit);
			// 					// this.setDataAtRowProp(row + count, 3,parseFloat(item.credit));
			// 					debitTotal+= parseFloat(item.debit)
			// 					// this.setDataAtRowProp(row + count, 4,parseFloat(item.debit));
			// 					finalTotal+=parseFloat(item.total)
			// 					// this.setDataAtRowProp(row + count, 5,parseFloat(item.total));
			// 					// count++;
			// 				})
			// 				// count++;
			// 				this.setDataAtRowProp(row, 2, creditTotal);
			// 				this.setDataAtRowProp(row, 3, debitTotal);
			// 				this.setDataAtRowProp(row, 4, finalTotal);
			// 			}
			// 		})
			// 	}
			// }


		})
		hotDiv.validateCells();
	}

	function saveData() {
		$.LoadingOverlay("show");
		let reportData = hotDiv.getData();
		let year = $('#year').val();
		let month = $('#quarter').val();
		let formData = new FormData();
		formData.set("data", JSON.stringify(reportData));
		formData.set("year", year);
		formData.set("month", month);
		app.request("saveConsolidationReport", formData).then(res => {
			$.LoadingOverlay("hide");
				window.location.href="view_consolidate_report";
		});

	}

	function getSumValue() {
		let year = $('#year').val();
		let month = $('#quarter').val();
		let formData = new FormData();
		formData.set("year", year);
		formData.set("month", month);
		return app.request("getTotalData", formData)
	}
</script>
</div>
