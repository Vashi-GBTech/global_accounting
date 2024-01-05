<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">

.even
{
	background: green;
}
td.custom-cell {
  color: #fff;
  background-color: #37bc6c;
}
.custom-table thead th:nth-child(even),
.custom-table tbody tr:nth-child(odd) th {
  background-color: #d7f1e1;
}
.handsontable td
{
	color: black!important;
}
.MyRow
{
	color: black!important;
}
.backgrn1{
	    background-color: #deffde !important;
	  }
.backgrn2{
	    background-color : #ffe1e5 !important;
	  }
.backgrn3{
	    background-color: #fee0d7 !important;
	  }

.nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
	border-bottom-color: #fff;
	background-color: #f7e3ad;
	color: black;
	text-shadow: 0px 4px 5px #00000055 !important;
}
.nav-tabs > li.active > a {
	color: black;
	background-color: #f7e3ad;
}

.nav-tabs > li.active > a {
	background-color: #f2d1767a !important;
	color: #473504 !important;
	text-shadow: 0px 1px 2px #00000055 !important;
}

.nav-tabs > li {
	border-radius: 6px;
	border: 1px solid #80808029;
}
.nav-tabs > li >a {
	margin-right: 0px;
}

.nav-item {
	width: auto;
	text-align: center;
}
	.error
	{
		color: red;
	}
.table > tbody > tr > td
{
	vertical-align: bottom;
	padding: 5px 5px;
}
	.alignTop
	{
		vertical-align: middle!important;
	}
.tableTrans{
	overflow-y: auto;
	height: 610px;
}
.tableTrans thead th {
	position: sticky;
	top: 0;
}
.tableTrans th {
	background: #f7e3ad;
	color: black;
}
.trborder{
	border-bottom: 1pt solid black;
}
	.table tbody{
		font-size: 12px;
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
							<h4 class="page-title">User Upload</h4>

							<div class="clearfix"></div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="intraFormRow">
		<input type="hidden" name="insertID" id="insertID" value="<?php echo $id; ?>">
		<input type="hidden" name="year" id="year">
		<input type="hidden" name="month" id="month">
		<input type="hidden" name="currency" id="currency" value="">
		<input type="hidden" name="user_type" id="user_type" value="<?php echo $this->session->userdata('user_type') ?>">
		<div class="col-lg-12 bg-white">
			<div class="card-box">
		<div class="col-md-12">
			<div class="col-md-4 text-dark"><i class="fa fa-calendar"></i> Year - <span id="year_name"></span></div>
			<div class="col-md-4 text-dark"><i class="fa fa-calendar"></i> Month - <span id="month_name"></span></div>
			<div class="col-md-4 text-dark"><span id="holdingData"></span></div>
			<hr/>
		</div>
	</div>
</div>

		<div class="col-lg-12 bg-white">
			<input type="hidden" id="TransferType" name="TransferType" value="1">
			<ul class="nav nav-tabs m-t-10" id="TransTabUl" role="tablist">
				<li class="nav-item match active transTab" role="presentation" id="transTabid">
					<a data-toggle="tab" href="#OgTab" class="nav-link active "  role="tab" aria-selected="true" aria-expanded="true" onclick="loadTransferType(1);getTransTableData()">Intra Company Transfer</a>
				</li>
				<li class="nav-item match  transTab" role="presentation" id="">
					<a data-toggle="tab" href="#CurTab" class="nav-link " role="tab" aria-selected="false" aria-expanded="false" onclick="loadTransferType(2);getTransTableData();">Inter Company Transfer</a>
				</li>

			</ul>

			<div class="tab-content" style="padding:0;">


<!--				<div id="OgTab" class="tab-pane active" >-->
					<input type="hidden" id="loadTransValue" value="1">
					<div class="col-md-12">
						<ul class="nav nav-tabs m-t-10" id="IntraTransTabUl" role="tablist">
							<li class="nav-item match active transTab" role="presentation" id="bstransTabid">
								<a data-toggle="tab" href="#bsTab" class="nav-link active "  role="tab" aria-selected="true" aria-expanded="true" onclick="loadTransTable(1);getTransTableData();">Balance Sheet</a>
							</li>
							<li class="nav-item match  transTab" role="presentation" id="">
								<a data-toggle="tab" href="#plTab" class="nav-link " role="tab" aria-selected="false" aria-expanded="false" onclick="loadTransTable(2);getTransTableData()">Profit & Loss</a>
							</li>
							<button id="excelDownload" type="button" class="btn btn-link" style="float: right" onclick="getExcelFormat()">
								<i
										class="fa fa-download" style="font-size: 18px"></i></button>
							<button type="button" class="btn btn-primary btn-sm" style="float: right;" data-toggle="modal" data-target="#addTransactionModal" onclick="getEntityTransferDropdownData()"><i class="fa fa-plus"></i> Add Transaction</button>
						</ul>
					</div>

					<div class="col-md-12">

<!--						<button type="button" id="intraBtnDelete" class="btn btn-primary roundCornerBtn4 filterBtn ml-2" style="margin-bottom: 10px;" onclick="ClearDataCompanyTranser(1)">Clear Data</button>-->
<!--						<button type="button" id="intraBtn" class="btn btn-primary roundCornerBtn4 filterBtn" style="float: right;margin-bottom: 10px;" onclick="saveCopyIntraData(1)">Save</button>-->

					</div>
				<div class="col-md-12 m-b-5 m-t-5">
					<div class="col-md-9">
					</div>
					<div class="col-md-3">
						<input type="text" id="search" placeholder="Type to search" onkeyup="getSearchData(this)" class="form-control">
					</div>
				</div>
					<div class="col-md-12 tableTrans">


						<table class="table table-bordered" id="transTableD"  cellspacing="0"
							   rules="rows"
							   border="1"
							   style="width: 100%;border-collapse: collapse;">
							<thead>
							<tr>
								<th>Sr No.</th>
								<th>Subsidiary Account</th>
								<th>GL Account</th>
								<th>Debit</th>
								<th>Credit</th>
								<th>Given By</th>
								<th>Currency</th>
								<th>Currency Rate</th>
								<th>Total Value</th>
								<th>Trade Currency Value</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody id="transTableBody">

							</tbody>
						</table>
					</div>
					<div id="newDiv"></div>
<!--				</div>-->
<!--				<div id="CurTab" class="tab-pane ">-->
<!---->
<!--					<div class="col-md-12">-->
<!--						<button type="button" id="interBtnDelete" class="btn btn-primary roundCornerBtn4 filterBtn ml-2" style="margin-bottom: 10px;" onclick="ClearDataCompanyTranser(2)">Clear Data</button>-->
<!--						<button type="button" id="interBtn" class="btn btn-primary roundCornerBtn4 filterBtn" style="float: right;margin-bottom: 10px;" onclick="saveCopyIntraData(2)">Save</button>-->
<!---->
<!--					</div>-->
<!---->
					<div id="newDiv1"></div>
<!--				</div>-->
			</div>


		</div>
	</div>

	<div class="modal fade" role="dialog" id="addTransactionModal" aria-hidden="true">
		<div class="modal-dialog modal-full" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Transaction</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<form id="uploadEntityTransactionData" method="post" data-form-valid="saveCompany">
					<div class="modal-body py-0">
						<div class="row">
							<input type="hidden" name="updateID" id="updateID" class="form-control">
							<div class="col-md-12">
								<div class="col-md-3">
									<label>Transaction Type</label>
									<select name="transactionType" id="transactionType" class="form-control">
										<option value="1">Balance Sheet</option>
										<option value="2">Profit & Loss</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
								<div class="col-md-3">
									<label>From Subsidiary Account</label>
									<select name="fromSubAccount" id="fromSubAccount" class="form-control" onchange="getTransCompanyGlAccount(1,this.value)">
										<option value=""></option>
									</select>
								</div>
								<div class="col-md-3">
									<label>From GL Account</label>
									<select name="fromGlAccount" id="fromGlAccount" class="form-control">
										<option value=""></option>
									</select>
								</div>
								<div class="col-md-2">
									<label>From Debit</label>
									<input type="number" name="fromDebit" id="fromDebit" class="form-control" onkeyup="calculateFromTotal()">
								</div>
								<div class="col-md-2">
									<label>From Credit</label>
									<input type="number" name="fromCredit" id="fromCredit" class="form-control" onkeyup="calculateFromTotal()">
								</div>
								<div class="col-md-2">
									<label>From Given By</label>
									<input type="text" name="fromGivenBy" id="fromGivenBy" class="form-control">
								</div>
								<div class="col-md-2">
									<label>From Currency</label>
									<select name="fromCurrency" id="fromCurrency" class="form-control" onchange="getTransCurrencyAverageValue(1,this.value)">
									</select>
								</div>
								<div class="col-md-2">
									<label>From Currency Rate</label>
									<input type="number" name="fromCurrencyRate" id="fromCurrencyRate" class="form-control" onkeyup="calculateFromTotal()">
								</div>
								<div class="col-md-2">
									<label>From Total Value</label>
									<input type="number" name="fromTotalValue" id="fromTotalValue" class="form-control" onkeyup="finalTotal()">
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
								<div class="col-md-3">
									<label>To Subsidiary Account</label>
									<select name="toSubAccount" id="toSubAccount" class="form-control" onchange="getTransCompanyGlAccount(2,this.value)">
										<option value=""></option>
									</select>
								</div>
								<div class="col-md-3">
									<label>To GL Account</label>
									<select name="toGlAccount" id="toGlAccount" class="form-control">
										<option value=""></option>
									</select>
								</div>
								<div class="col-md-2">
									<label>To Debit</label>
									<input type="number" name="toDebit" id="toDebit" class="form-control" onkeyup="calculateToTotal()">
								</div>
								<div class="col-md-2">
									<label>To Credit</label>
									<input type="number" name="toCredit" id="toCredit" class="form-control" onkeyup="calculateToTotal()">
								</div>
								<div class="col-md-2">
									<label>To Given By</label>
									<input type="text" name="toGivenBy" id="toGivenBy" class="form-control">
								</div>
								<div class="col-md-2">
									<label>To Currency</label>
									<select name="toCurrency" id="toCurrency" class="form-control" onchange="getTransCurrencyAverageValue(2,this.value)">
									</select>
								</div>
								<div class="col-md-2">
									<label>To Currency Rate</label>
									<input type="number" name="toCurrencyRate" id="toCurrencyRate" class="form-control" onkeyup="calculateToTotal()">
								</div>
								<div class="col-md-2">
									<label>To Total Value</label>
									<input type="number" name="toTotalValue" id="toTotalValue" class="form-control" onkeyup="finalTotal()">
								</div>
							</div>

							<div class="col-md-12">
								<hr/>
								<div class="col-md-3">
									<label for="">Difference GL</label>
									<select name="differenceGl" id="differenceGl" class="form-control">
										<option value=""></option>
									</select>
								</div>
								<div class="col-md-3">
									<label for="">Difference Debit</label>
									<input type="number" name="differenceDebit" id="differenceDebit" class="form-control">
								</div>
							</div>
						</div>
					</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1 roundCornerBtn4" type="submit" >Submit</button>
				</div>
				</form>
			</div>
		</div>
	</div>


</div>


</div>
<?php $this->load->view('_partials/footer'); ?>

</div>
<script type="text/javascript">
	var base_url='<?php echo base_url(); ?>';
</script>
<script src="<?php echo base_url();?>assets/js/module/upload_data/financial_data.js"></script>


<script type="text/javascript">
	$(document).ready(function(){
		getIntraInfoById();
		// getBranchList();
		// intraTransactionTable();
		// loadEditableTable(1);
		var user_type=$("#user_type").val();
		// if(user_type!=2)
		// {
		// 	var fromBranch=$("#from_branch_id").val();
		// 	getBranchGlAccount(fromBranch,1);
		// }
		getTransTableData();


	});

	function getSearchData(thi) {
		var input, filter, table, tr, td, i, txtValue,j;
		input = document.getElementById("search");
		filter = input.value.toUpperCase();
		table = document.getElementById("transTableBody");

		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td");
			if (td) {
				for(j=0;j<td.length;j++)
				{
					txtValue = td[j].textContent || td[j].innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						txtValue=txtValue;
						break;
					}
				}
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
					tr[i+1].style.display = "";
					tr[i+2].style.display = "";
					i=i+2;
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}
	function  getIntraInfoById() {
		$.LoadingOverlay("show");
		var formData=new FormData();
		formData.set('insertID',$("#insertID").val());
		app.request(base_url + "getIntraInfoById",formData).then(res=>{
		$.LoadingOverlay("hide");
			if(res.status == 200) {
				var userdata=res.data;
				$("#year").val(userdata.year);
				$("#month").val(userdata.quarter);
				$("#year_name").html(res.year);
				$("#month_name").html(res.month);
				$("#holdingData").html(res.holding_type);
				$("#currency").val(res.currency);
				if(res.BlockYear == 1){
					$('#intraBtnDelete').attr('disabled',true);
					$('#intraBtn').attr('disabled',true);
					$('#interBtnDelete').attr('disabled',true);
					$('#interBtn').attr('disabled',true);
				}
			}

		}).catch(e => {
		$.LoadingOverlay("hide");
			console.log(e);
		});
	}
	function  getBranchList() {
		app.request(base_url + "getCompanyBranchList",null).then(res=>{
			if(res.status == 200) {
				$('#from_branch_id').append(res.data);
				$('#to_branch_id').append(res.data);
			}
		}).catch(e => {
			console.log(e);
		});
	}
	function getBranchGlAccount(branch)
	{
		return new Promise(function (resolve,reject){
		$.ajax({
			url: base_url + "getCompanyGlAccount",
			type: "POST",
			dataType: "json",
			data:{branch:branch},
			success: function (result) {
				var data1 = [result.data,result.currency];
				resolve(data1);
			},
			error: function (error) {
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
		});
	}
	function getCurrencyAverageValue(currency,branchId)
	{
		let mon=$("#month").val();
		let yer=$("#year").val();
		return new Promise(function (resolve,reject){
			$.ajax({
				url: base_url + "getCurrencyAverageValue",
				type: "POST",
				dataType: "json",
				data:{currency:currency,branchId:branchId,month:mon,year:yer},
				success: function (result) {
					var data1 = result.rate;
					resolve(data1);
				},
				error: function (error) {
					console.log(error);
					// $.LoadingOverlay("hide");
				}
			});
		});
	}

	$("#exportexcelsheet").validate({
		rules: {
			from_branch_id: {
				required: true
			},
			from_gl_account: {
				required: true
			},
			to_branch_id: {
				required: true
			},
			to_gl_account: {
				required: true
			},
			amount: {
				required: true
			}
		},
		messages: {
			from_branch_id: {
				required: "Please select branch",
			},
			from_gl_account: {
				required: "Please select gl_account",
			},
			to_branch_id: {
				required: "Please select branch",
			},
			amount: {
				required: "Enter Amount",
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
		$.LoadingOverlay("show");
			// $.LoadingOverlay("show");

			var formData=new FormData(form);
			// formData.set('insertID',$("#insertID").val());
			$.ajax({
				url: base_url+"uploadIntraTransaction",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
        		contentType: false,
				success: function (result) {
		$.LoadingOverlay("hide");
					if (result.status === 200) {
		               toastr.success(result.body);
						$("#amount").val("");
		               intraTransactionTable()
		            }
		            else
		            {
		            	toastr.error(result.body);
		            	// alert(result.body);
		            }
				}, error: function (error) {
		$.LoadingOverlay("hide");
					// $.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});
	let debitCheck=0;
	let creditCheck=0;
	// let columnRows=[];
	// let columnsHeader=[];

	function loadEditableTable(companyType='')
	{
		$("#TransferType").val(companyType);
		$.LoadingOverlay("show");
		var formData=new FormData();
		formData.set('id',$("#insertID").val());
		formData.set('companyType',companyType);
		$.ajax({
	        url: base_url + "getIntraTableData",
	        type: "POST",
	        dataType: "json",
	        data: formData,
	        processData: false,
        	contentType: false,
	        success: function (result) {
		$.LoadingOverlay("hide");
	        	var branchName=result.branchName;
	        	var rows = [
						['','', '', '', '', '','','','','',''],
					];
					if($("#user_type").val()!=2)
					{
						rows = [
							[branchName,'', '', '', '', '','','','','',''],
						];
					}
	            if (result.status === 200) {
	                // var columns=result.columns;
	                 rows=result.rows;
	                //  var types=result.types;
	                 // columnRows=rows;
	                 // columnsHeader=columns;
	            	// createHandonTable(columns,rows,types,'newDiv');
	            	// if(result.rows.length>0)
	             //    {
	             //    	 rows=result.rows;
	             //    }
	            }

	            var dataschema=result.dataSchema;
	            // console.log(dataschema);
	           var types=result.type;
	           var columns=result.columns;
	           if(companyType == 1){
	           	var divName='newDiv';
			   }else{
				   var divName='newDiv1';
			   }
	            createHandonTable(columns,rows,types,divName,dataschema);
	        },
	        error: function (error) {
		$.LoadingOverlay("hide");
	            console.log(error);
	           // $.LoadingOverlay("hide");
	        }
	    });

	}
	 function firstRowRenderer1(instance, td) {
	    td.style.background = '#deffde';
	    td.style.color = 'black';
	  }
	 function firstRowRenderer2(instance, td) {
	    td.style.background = '#ffe1e5';
	  }
	 function firstRowRenderer3(instance, td) {
	    td.style.background = '#fee0d7';
	  }

let hotDiv;
function createHandonTable(columnsHeader,columnRows,columnTypes,divId,dataschema)
{
	const button = document.querySelector('#excelDownload');
	$(".filterBtn").show();
 var element=document.getElementById(divId);
  hotDiv !=null ? hotDiv.destroy():'';
 hotDiv= new Handsontable(element, {
				  data:columnRows,
				  colHeaders: columnsHeader,
				  manualColumnResize: true,
				  manualRowResize :true,
				  columns:columnTypes,
				  dataSchema:dataschema,
				afterCreateRow: function(row, amount, src) {
			      for (var i = 0; i < this.countCols(); i++) {
			        this.setCellMeta(row, i, 'className', 'MyRow')
			      }
			    },
				 beforeCut: function(data, coords) {
				 	console.log(1);
				 },
				  beforeChange: function (changes, source) {

				  	// hotDiv.render();
				  	  var row = changes[0][0];

				        var prop = changes[0][1];

				        var value = changes[0][3];

				  },
	 beforePaste:(data, coords) => {
		 for (let i = 0; i < data.length; i++) {
			 var c = 0;
			 for (let j = 0; j < data[i].length; j++) {
				 if (coords[0].startCol == 0) {
					 c++;
				 }
				 if(c === 3 || c === 4 || c === 13|| c === 12 || coords[0].startCol == 3 || coords[0].startCol == 4 || coords[0].startCol == 12 || coords[0].startCol == 13)
				 {
					 data[i][j] = data[i][j].replace(/,/g, '');
				 }
				 c++;
			 }
		 }
	 },
				  afterChange: function(changes, src){

				  	let currencySet=$("#currency").val();
				    if(changes){

				    	var row = changes[0][0];
				    	var value = changes[0][3];
				    	 var prop = changes[0][1];

				    	 if(prop==0)
				    	 {
				    	 	this.setCellMeta(row,1, 'type', 'dropdown');

				      		var data=getBranchGlAccount(value).then(e=>{
				      			this.setCellMeta(row,1, 'source', e[0]);
				      			if(currencySet!="")
				      			{
				      				this.setDataAtRowProp(row,6,currencySet);
				      			}
				      			else
				      			{
				      				this.setDataAtRowProp(row,6,e[1]);
				      			}
								var TransferType=$("#TransferType").val();
				      			if(TransferType == 2){
									this.setDataAtRowProp(row,9,value);
									this.setCellMeta(row,9, 'type', 'dropdown');
									var data=getBranchGlAccount(value).then(e=>{
										this.setCellMeta(row,10, 'source', e[0]);
										if(currencySet!="")
										{
											this.setDataAtRowProp(row,15,currencySet);
										}
										else
										{
											this.setDataAtRowProp(row,15,e[1]);
										}
									});
									this.render();
								}
				      		});


				        	this.render();
				    	 }
				    	 if(prop==9)
				    	 {
				    	 	this.setCellMeta(row,10, 'type', 'dropdown');
				      		var data=getBranchGlAccount(value).then(e=>{
				      			this.setCellMeta(row,10, 'source', e[0]);
								if(currencySet!="")
				      			{
				      				this.setDataAtRowProp(row,15,currencySet);
				      			}
				      			else
				      			{
				      				this.setDataAtRowProp(row,15,e[1]);
				      			}
				      		});
				        	this.render();
				    	 }

				    	 if(prop==1)
				    	 {
				    	 	this.setCellMeta(row,2, 'type', 'text');
				      		var data=getBranchGlAccountSeperate(value).then(e=>{
				      			// console.log(glc_value);
				      			// this.setCellMeta(row,2, 'source', e);
				      			this.setDataAtRowProp(row,2,e);
								getdefaultGlAccount(e).then(defaultGlAccount=>{
									this.setDataAtRowProp(row,21,defaultGlAccount);
								});
				      		});

				        	this.render();
				    	 }
				    	 if(prop==10)
				    	 {
				    	 	this.setCellMeta(row,11, 'type', 'text');
				      		var data=getBranchGlAccountSeperate(value).then(e=>{
				      			// this.setCellMeta(row,5, 'source', e);

				      			this.setDataAtRowProp(row,11,e);
				      		});

				        	this.render();
				    	 }
						if(prop == 3 || prop == 4 || prop == 13|| prop == 12 )
						{
							if (typeof value === 'string' || value instanceof String){
								var value1 = value.replace(/,/g, '');
								this.setDataAtRowProp(row,prop,value1);

								this.render();
							}

						}
						if(prop==3 || prop==4 || prop==7)
						{
							this.setCellMeta(row,8, 'type', 'numeric');
							let fromDeb=this.getDataAtCell(row,3);
							let fromCred=this.getDataAtCell(row,4);
							let fromcurrencyRate=this.getDataAtCell(row,7);
							if(fromcurrencyRate==null || fromcurrencyRate==undefined || fromcurrencyRate=="")
							{
								fromcurrencyRate=1;
							}
							let totalValue=(fromDeb-fromCred)*fromcurrencyRate;
							this.setDataAtRowProp(row,8,totalValue);
							this.render();
						}
						if(prop==6)
						{
							this.setCellMeta(row,7, 'type', 'numeric');
							let branchId=this.getDataAtCell(row,0);
							let fromDeb=this.getDataAtCell(row,3);
							let fromCred=this.getDataAtCell(row,4);
							var data1=getCurrencyAverageValue(value,branchId).then(e=>{

								this.setDataAtRowProp(row,7,e);
								if(e==null || e==undefined || e=="")
								{
									e=1;
								}
								let totalValue=(fromDeb-fromCred)*e;
								this.setDataAtRowProp(row,8,totalValue);
							});

							this.render();
						}
						if(prop==15)
						{
							this.setCellMeta(row,16, 'type', 'numeric');
							let branchId1=this.getDataAtCell(row,9);
							let fromDeb1=this.getDataAtCell(row,12);
							let fromCred1=this.getDataAtCell(row,13);
							var data1=getCurrencyAverageValue(value,branchId1).then(e=>{

								this.setDataAtRowProp(row,16,e);
								if(e==null || e==undefined || e=="")
								{
									e=1;
								}
								let totalValue1=(fromDeb1-fromCred1)*e;
								this.setDataAtRowProp(row,17,totalValue1);
							});

							this.render();
						}
						if(prop==12 || prop==13 || prop==16)
						{
							this.setCellMeta(row,16, 'type', 'numeric');
							let fromDeb2=this.getDataAtCell(row,12);
							let fromCred2=this.getDataAtCell(row,13);
							let fromcurrencyRate2=this.getDataAtCell(row,16);
							if(fromcurrencyRate2==null || fromcurrencyRate2==undefined || fromcurrencyRate2=="")
							{
								fromcurrencyRate2=1;
							}
							let totalValue2=(fromDeb2-fromCred2)*fromcurrencyRate2;
							this.setDataAtRowProp(row,17,totalValue2);
							this.render();
						}
						if(prop==8 || prop==17)
						{
							let toTotal=this.getDataAtCell(row,17);
							let fromTotal=this.getDataAtCell(row,8);
							// let finaltotalValue=(toTotal-fromTotal);
							let finaltotalValue=(-fromTotal-toTotal);
							this.setDataAtRowProp(row,20,finaltotalValue);
							this.render();
						}

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
				    width: '100%',
				    height: 320,
				    rowHeights: 23,
				    rowHeaders: true,
				    filters: true,
				    contextMenu: true,
	 				minSpareRows: 1,
				    hiddenColumns: {
					    // specify columns hidden by default
					    columns: [2,11,18,19],
					    copyPasteEnabled: false,
					  },

				    dropdownMenu: ['filter_by_condition','filter_by_value','filter_action_bar'],
				    licenseKey: 'non-commercial-and-evaluation'
				});
 	hotDiv.validateCells();
	const exportPlugin = hotDiv.getPlugin('exportFile');
	if($("#TransferType").val() == 1){
		var FileName='Intra_Company_Transfer-file_[YYYY]-[MM]-[DD]';
	}else{
		var FileName='Inter_Company_Transfer-file_[YYYY]-[MM]-[DD]';
	}
	button.addEventListener('click', () => {
		exportPlugin.downloadFile('csv', {
			bom: false,
			columnDelimiter: ',',
			columnHeaders: true,
			exportHiddenColumns: false,
			exportHiddenRows: true,
			fileExtension: 'csv',
			filename: FileName,
			mimeType: 'text/csv',
			rowDelimiter: '\r\n',
			rowHeaders: true
		});
	});
 // 	hotDiv.addHook('afterCreateRow', (row, amount) => {
	//   console.log(`1`);
	// })
 	hotDiv.updateSettings({
 		cells(row, col) {
		   if (col === 0 || col === 1 || col === 2 || col === 3|| col === 4 || col === 5 || col === 6 || col === 7 || col === 8 ) {
		      return {
		        className:'backgrn1',
		      };
		    }
		    if ( col === 9 || col === 10 || col === 11 || col === 12  || col === 13 || col === 14 || col===15 || col === 16 || col===17) {
		      return {
		        className:'backgrn2',
		      };
		    }
		    if (col === 18 || col===19 || col===20) {
		      return {
		        className:'backgrn3',
		      };
		    }
			var TransferType=$("#TransferType").val();
			if(TransferType == 2){
				if(col == 10){
					cellProperties.editor = false;
				}

			}
		  }
	});
}
function saveCopyIntraData(transferType)
{
		// $.LoadingOverlay("show");
	var data = hotDiv.getData();
	let formData = new FormData();
	formData.set('arrData', JSON.stringify(data));
	formData.set('insertID', $("#insertID").val());
	formData.set('year', $('#year').val());
	formData.set('month', $('#month').val());
	formData.set('transferType', transferType);
	console.log(data);
	app.request(base_url + "saveCopyIntraData",formData).then(res=>{
		// $.LoadingOverlay("hide");
		// data=res.data2;
		// console.log(res);
		if(res.status==200)
		{
			toastr.success(res.body);
			loadEditableTable(transferType);
			// $("#insertID").val('');
		    // $("#branchID").val('');
		    // document.getElementById("exportexcelsheet").reset();
		    // $("#newDiv").html('');
		    // document.getElementById('newDiv').style.height=null;
		    // $("#finacialBtn").hide();
		}
		else
		{
			toastr.error(res.body);
		}

	});
}
function ClearDataCompanyTranser(transferType) {
	let formData = new FormData();
	formData.set('year', $('#year').val());
	formData.set('month', $('#month').val());
	formData.set('transferType', transferType);
	if(confirm("Do You Really Want To Delete??")){
		app.request(base_url + "ClearEntityTransfer",formData).then(res=>{
			if(res.status==200)
			{
				toastr.success(res.body);
			}
			else
			{
				toastr.error(res.body);
			}
		});
	}

}

function getBranchGlAccountSeperate(glc_value)
{

	return new Promise(function (resolve,reject){
	let glcNumber='';
	if(glc_value!="")
	{
		let glcData=glc_value.split('-');
		if(glcData.length>1)
		{
			glcNumber=glcData[0];

		}

	}

		resolve(glcNumber);
	});
}
	function getdefaultGlAccount(GlAccount)
	{
		let formData = new FormData();
		formData.set('GlAccount', GlAccount);
		formData.set('TransferType', $("#TransferType").val());
		let result='';
		return new Promise(function (resolve,reject){
			app.request(base_url + "getdefaultGlAccount",formData).then(res=>{

				if(res.status == 200){
					if($("#TransferType").val() == 1){
						result=res.IntraGlAccount;
					}else{
						result=res.InterGlAccount;
					}
					resolve(result);
				}else{

				}


			});

		});
	}
	function loadTransTable(type) {
		$("#loadTransValue").val(type);
	}
	$('#addTransactionModal').on('shown.bs.modal', function (e) {

		// getEntityTransferDropdownData();
	});
$('#addTransactionModal').on('hidden.bs.modal', function (e) {
	$("#uploadEntityTransactionData")[0].reset();
	$("#uploadEntityTransactionData .select2-hidden-accessible").val(null).trigger("change");
	$("#uploadEntityTransactionData input[type='hidden']").val(null).trigger("change");
		// getEntityTransferDropdownData();
	});
	function getEntityTransferDropdownData() {
		app.request(base_url + "getEntityTransferDropdownData",null).then(res=>{
			if(res.status == 200){
				$("#fromSubAccount").html(res.branchList);
				$("#fromSubAccount").select2();
				$("#fromGlAccount").html(res.glaccountList);
				$("#fromGlAccount").select2();
				$("#fromCurrency").html(res.currencyList);
				$("#fromCurrency").select2();
				$("#toSubAccount").html(res.branchList);
				$("#toSubAccount").select2();
				$("#toGlAccount").html(res.glaccountList);
				$("#toGlAccount").select2();
				$("#toCurrency").html(res.currencyList);
				$("#toCurrency").select2();
				$("#differenceGl").html(res.glaccountList);
				$("#differenceGl").select2();
			}
		});
	}
	function getEntityTransferDropdownDataGL() {
		return new Promise(function (resolve,reject){
		app.request(base_url + "getEntityTransferDropdownData",null).then(res=>{
			if(res.status == 200){
				resolve(res);
			}
			else {
				reject(res);
			}
		});
		});
	}
	function getTransCompanyGlAccount(type,branch) {
		let currencySet=$("#currency").val();
		let formData = new FormData();
		formData.set('branch', branch);
		app.request(base_url + "getTransCompanyGlAccount",formData).then(res=>{
			if(res.status == 200){
				if(type==1)
				{
					if(currencySet!="")
					{
						$("#fromCurrency").val(currencySet);
						$("#fromCurrency").trigger('change');
					}
					else {
						$("#fromCurrency").val(res.currency);
						$("#fromCurrency").trigger('change');
					}
				}
				else {
					if(currencySet!="") {
						$("#toCurrency").val(currencySet);
						$("#toCurrency").trigger('change');
					}
					else {
						$("#toCurrency").val(res.currency);
						$("#toCurrency").trigger('change');
					}
				}
			}
			else {
				if(type==1)
				{
					if(currencySet!="") {
						$("#fromCurrency").val(currencySet);
						$("#fromCurrency").trigger('change');
					}
					else {
						$("#fromCurrency").val('');
						$("#fromCurrency").trigger('change');
					}
				}
				else {
					if(currencySet!="") {
						$("#toCurrency").val(currencySet);
						$("#toCurrency").trigger('change');
					}
					else {
						$("#toCurrency").val('');
						$("#toCurrency").trigger('change');
					}
				}
			}
		});
	}
	$("#uploadEntityTransactionData").validate({
		rules: {
			fromSubAccount: {
				required: true
			},
			fromGlAccount: {
				required: true
			},
			fromCurrency: {
				required: true
			},
			toSubAccount: {
				required: true
			},
			toGlAccount: {
				required: true
			},
			toCurrency: {
				required: true
			},
			fromTotalValue: {
				required: true
			},
			toTotalValue: {
				required: true
			}
		},
		messages: {
			fromSubAccount: {
				required: "Please select branch",
			},
			fromGlAccount: {
				required: "Please select gl_account",
			},
			fromCurrency: {
				required: "Please select currency",
			},
			toSubAccount: {
				required: "Please select branch",
			},
			toGlAccount: {
				required: "Please select gl_account",
			},
			toCurrency: {
				required: "Please select currency",
			},
			fromTotalValue: {
				required: "Enter Amount",
			},
			toTotalValue: {
				required: "Enter Amount",
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
			$.LoadingOverlay("show");
			// $.LoadingOverlay("show");

			var formData=new FormData(form);
			formData.set('transferType',$("#TransferType").val());
			formData.set('loadTransValue',$("#loadTransValue").val());
			formData.set('insertID',$("#insertID").val());
			formData.set('updateID',$("#updateID").val());
			formData.set('year', $('#year').val());
			formData.set('month', $('#month').val());
			$.ajax({
				url: base_url+"uploadIntraTransactionData",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status === 200) {
						toastr.success(result.body);
						$("#uploadEntityTransactionData")[0].reset();
						// $("#amount").val("");
						$("#addTransactionModal").modal('hide');
						getTransTableData();
					}
					else
					{
						toastr.error(result.body);
						// alert(result.body);
					}
				}, error: function (error) {
					$.LoadingOverlay("hide");
					// $.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});
	function getTransCurrencyAverageValue(type,currency)
	{
		let mon=$("#month").val();
		let yer=$("#year").val();
		return new Promise(function (resolve,reject){
			$.ajax({
				url: base_url + "getTransCurrencyAverageValue",
				type: "POST",
				dataType: "json",
				data:{currency:currency,month:mon,year:yer},
				success: function (result) {
					if(result.status==200)
					{
						if(type==1)
						{
							$("#fromCurrencyRate").val(result.rate);
						}
						else {
							$("#toCurrencyRate").val(result.rate);
						}
					}
					else {
						if(type==1) {
							$("#fromCurrencyRate").val('');
						}
						else {
							$("#toCurrencyRate").val('');
						}
					}
				},
				error: function (error) {
					console.log(error);
					// $.LoadingOverlay("hide");
				}
			});
		});
	}
	function calculateFromTotal() {
		var deb=$("#fromDebit").val();
		var cred=$("#fromCredit").val();
		var curr=$("#fromCurrencyRate").val();
		if(curr==null || curr==undefined || curr=="")
		{
			curr=1;
		}
		var totl=(deb-cred)*curr;
		$("#fromTotalValue").val(totl);
		finalTotal();
	}
	function calculateToTotal() {
		var deb=$("#toDebit").val();
		var cred=$("#toCredit").val();
		var curr=$("#toCurrencyRate").val();
		if(curr==null || curr==undefined || curr=="")
		{
			curr=1;
		}
		var totl=(deb-cred)*curr;
		$("#toTotalValue").val(totl);
		finalTotal();
	}
	function finalTotal() {
		var fromtl=$("#fromTotalValue").val();
		var totl=$("#toTotalValue").val();
		var fitl=(-fromtl-totl);
		$("#differenceDebit").val(fitl);
	}
	function getTransTableData() {
		$.LoadingOverlay("show");
		var transferType=$("#TransferType").val();
		var loadTransValue=$("#loadTransValue").val();
		let formData = new FormData();
		formData.set('companyType', transferType);
		formData.set('loadTransValue', loadTransValue);
		formData.set('id', $("#insertID").val());
		app.request(base_url + "getTransTableData",formData).then(res=>{
			$.LoadingOverlay("hide");
			$("#transTableBody").html('');
			if(res.status == 200){
				loadTableDesign(res.data);
			} else if(res.status==202)
			{
				$("#transTableBody").html('No Transactions Found');
			}
			else {
				toastr.error(res.data);
			}
		});
	}
	function loadTableDesign(data) {
		data.map((e,i)=>{
			let cureencyFrom=e.from_currency_rate;
			if(e.from_currency_rate=="" || e.from_currency_rate==null || e.from_currency_rate=="null")
			{
				cureencyFrom=1;
			}
			let transferCurrTValue=(e.to_totalValue/cureencyFrom);
		var html=`<tr>
			<td rowspan="3" class="alignTop">${i+1}</td>
					<td><b>From - </b><br> ${e.from_branch}</td>
			<td>${e.from_gl_account} - ${e.from_detail}</td>
			<td>${(e.from_debit)==null ? '' : Math.round(e.from_debit*100)/100}</td>
			<td>${(e.from_credit)==null ? ' ': Math.round(e.from_credit*100)/100}</td>
			<td>${(e.from_given_by)== null ? '': e.from_given_by }</td>
			<td>${e.from_currency}</td>
			<td>${e.from_currency_rate}</td>
			<td>${Math.round(e.from_totalValue*100)/100}</td>
			<td></td>
			<td rowspan="3" class="alignTop"><button type="button" class="btn btn-link text-primary" data-toggle="modal" data-target="#addTransactionModal" onclick="editTransData(${e.id})"><i class="fa fa-edit"></i></button>
			<button type="button" class="btn btn-link text-danger" onclick="deleteTransdata(${e.id})"><i class="fa fa-trash"></i></button></td>
			</tr>
			<tr>
			<td><b>To - </b><br> ${e.to_branch}</td>
			<td>${e.to_gl_account} - ${e.to_detail}</td>
			<td>${ (e.to_debit)==null ? '' :  Math.round(e.to_debit*100)/100}</td>
			<td>${(e.to_credit)==null ? '' :  Math.round(e.to_credit*100)/100}</td>
			<td>${(e.to_given_by) == null ? '' : e.to_given_by}</td>
			<td>${e.to_currency}</td>
			<td>${e.to_currency_rate}</td>
			<td>${ Math.round(e.to_totalValue*100)/100}</td>
			<td>${ Math.round(transferCurrTValue*100)/100}</td>
			</tr>
			<tr class="trborder">
			<td><b>Difference - </b><br></td>
			<td>${e.difference_gl}-${e.difference_details}</td>
			<td>${ Math.round(e.final_value*100)/100}</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>${ Math.round(e.final_value*100)/100}</td>
			<td></td>
			</tr>`;
			$("#transTableBody").append(html);
		});
	}
	function editTransData(id) {
		// $("#addTransactionModal").modal('show');

		let formData = new FormData();
		formData.set('id', id);
		app.request(base_url + "editTransData",formData).then(res=>{
			if(res.status == 200){
				let rdata=res.data;
				$("#updateID").val(rdata.id);
				$("#transactionType").val(rdata.trans_type);
				getEntityTransferDropdownDataGL().then(e=>{
					$("#fromSubAccount").html(e.branchList);
					$("#fromSubAccount").select2();
					$("#fromGlAccount").html(e.glaccountList);
					$("#fromGlAccount").select2();
					$("#fromCurrency").html(e.currencyList);
					$("#fromCurrency").select2();
					$("#toSubAccount").html(e.branchList);
					$("#toSubAccount").select2();
					$("#toGlAccount").html(e.glaccountList);
					$("#toGlAccount").select2();
					$("#toCurrency").html(e.currencyList);
					$("#toCurrency").select2();
					$("#differenceGl").html(e.glaccountList);
					$("#differenceGl").select2();

					$("#fromSubAccount").val(rdata.from_branch_id);
					$("#fromSubAccount").trigger('change');
					$("#fromGlAccount").val(rdata.from_gl_account);
					$("#fromGlAccount").trigger('change');
					let currencySet=$("#currency").val();
					if(currencySet!="")
					{
						$("#fromCurrency").val(currencySet);
						$("#fromCurrency").trigger('change');

						$("#toCurrency").val(currencySet);
						$("#toCurrency").trigger('change');
					}
					else {
						$("#fromCurrency").val(rdata.from_currency);
						$("#fromCurrency").trigger('change');
						$("#toCurrency").val(rdata.to_currency);
						$("#toCurrency").trigger('change');
					}


					$("#toGlAccount").val(rdata.to_gl_account);
					$("#toGlAccount").trigger('change');
					$("#toSubAccount").val(rdata.to_branch_id);
					$("#toSubAccount").trigger('change');


					$("#differenceGl").val(rdata.difference_gl);
					$("#differenceGl").trigger('change');

					$("#fromDebit").val(rdata.from_debit);
					$("#fromCredit").val(rdata.from_credit);
					$("#fromGivenBy").val(rdata.from_given_by);
					$("#fromCurrencyRate").val(rdata.from_currency_rate);
					$("#fromTotalValue").val(rdata.from_totalValue);
					$("#toDebit").val(rdata.to_debit);
					$("#toCredit").val(rdata.to_credit);
					$("#toGivenBy").val(rdata.toGivenBy);
					$("#toCurrencyRate").val(rdata.to_currency_rate);
					$("#toTotalValue").val(rdata.to_totalValue);
					$("#differenceDebit").val(rdata.final_value);
				});


			}
			else {
				toastr.error(res.data);
			}
		});
	}
	function deleteTransdata(id) {
		if(confirm("Are you sure you want to delete this transaction?"))
		{
			let formData = new FormData();
			formData.set('id', id);
			app.request(base_url + "deleteTransdata",formData).then(res=>{
				if(res.status == 200){
					toastr.success(res.data);
					getTransTableData();
				}
				else {
					toastr.error(res.data);
				}
			});
		}

	}
	function loadTransferType(type) {
		$("#TransferType").val(type);
	}
	function download_csv(csv, filename) {
		var csvFile;
		var downloadLink;

		// CSV FILE
		csvFile = new Blob([csv], {type: "text/csv"});

		// Download link
		downloadLink = document.createElement("a");

		// File name
		downloadLink.download = filename;

		// We have to create a link to the file
		downloadLink.href = window.URL.createObjectURL(csvFile);

		// Make sure that the link is not displayed
		downloadLink.style.display = "none";

		// Add the link to your DOM
		document.body.appendChild(downloadLink);

		// Lanzamos
		downloadLink.click();
	}

	function export_table_to_csv(html, filename) {
		var csv = [];
		var rows = document.querySelectorAll("#transTableD tr");
		var records = [];
		var firstCol=0;

		for (var i = 0; i < rows.length; i++) {
			var row = rows[i];

			var cells = row.querySelectorAll("td,th");
			cells.forEach((o, j) => {
				// Put in the forward rows data
				if (o.rowSpan > 1) {
					for (var z = 1; z < o.rowSpan; z++) {
						if (!records[i+z]) records[i+z] = [];
						records[i+z][j] = o.innerText;
					}
				}
			});

			if (!records[i]) records[i] = [];
			var bufferedTds = Array.prototype.slice.call(row.querySelectorAll("td,th"));

			for (var cellIndex = 0; cellIndex < 10; cellIndex++) {
				if (!records[i][cellIndex]) {
					var item = bufferedTds.shift();
					if (item) {
						records[i][cellIndex] = item.innerText;
					}
				}
			}
		}
		csv = toCSV(records);

		// Download CSV
		download_csv(csv, filename);
	}
	function toCSV(arr) {
		var output = "";
		arr.forEach((o, i) => {
			o.forEach((p, j) => {
				output += `"${p}"`;
				if (j < o.length-1) {
					output += ",";
				}
			});
			output += "\n";
		});
		return output;
	}

	// document.querySelector("#excelDownload").addEventListener("click", function () {
	// 	var html = document.querySelector("#transTableD").outerHTML;
	// 	export_table_to_csv(html, "table.csv");
	// });
	function getExcelFormat() {
		var transferType=$("#TransferType").val();
		var loadTransValue=$("#loadTransValue").val();
		var id=$("#insertID").val();
		window.location.href=base_url+"getExcelFormat?transferType="+transferType+"&loadTransValue="+loadTransValue+"&id="+id;
	}
</script>

