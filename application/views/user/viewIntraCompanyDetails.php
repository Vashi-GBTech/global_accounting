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
							<h4 class="page-title">User Upload</h4>
						
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="intraFormRow">
		<div class="col-lg-12">
			<div class="card-box">
				<form method="post" id="exportexcelsheet">
					
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6 text-dark"><i class="fa fa-calendar"></i> Year - <span id="year_name"></span></div>
							<div class="col-md-6 text-dark"><i class="fa fa-calendar"></i> Month - <span id="month_name"></span></div>
							<hr/>
						</div>
						<div class="col-md-12">
							<input type="hidden" name="insertID" id="insertID" value="<?php echo $id; ?>">
							<input type="hidden" name="year" id="year">
							<input type="hidden" name="month" id="month">
							<input type="hidden" name="user_type" id="user_type" value="<?php echo $this->session->userdata('user_type') ?>">
							<?php if($this->session->userdata('user_type') == 2){ ?>
								<div class="col-md-3">
									<div class="form-group">
										<label>From Branch</label>
										<select name="from_branch_id" id="from_branch_id" class="form-control" onchange="getBranchGlAccount(this.value,1)">
											
										</select>
									</div>
								</div>
							<?php } else{?>
								<div class="col-md-3">
									<div class="form-group">
										<label>From Subsidiary Account</label>
										<input type="text" name="from_branch_name" id="from_branch_name" class="form-control" value="<?php echo $branch_name ?>" readonly>
										<input type="hidden" name="from_branch_id" id="from_branch_id" class="form-control" value="<?php echo $branch_id ?>">
									</div>
								</div>
								<?php }?>
								<div class="col-md-3">
									<div class="form-group">
										<label>Gl Account</label>
										<select name="from_gl_account" id="from_gl_account" class="form-control">
											
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>To Subsidiary Account</label>
										<select name="to_branch_id" id="to_branch_id" class="form-control" onchange="getBranchGlAccount(this.value,2)">
											
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Gl Account</label>
										<select name="to_gl_account" id="to_gl_account" class="form-control">
											
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Amount</label>
										<input type="number" name="amount" id="amount" class="form-control">
											
									</div>
								</div>
						<!-- 	<div class="col-md-6">
								<div class="form-group">
									<label>Excel File</label>
								<input type="file" class="form-control" id="userfile" name="userfile" >
								</div>
							</div> -->
<!--							<div class="col-md-6">-->
<!--								<div class="form-group">-->
<!--									<label>Select Template</label>-->
<!--									<select name="select_template" id="select_template" class="form-control">-->
<!--										<option disabled selected>select template</option>-->
<!--										-->
<!--									</select>-->
<!--								</div>-->
<!--							</div>-->
							<div class="col-md-6">

								<button type="submit" class="btn btn-primary roundCornerBtn4" style="margin-top: 27px;">Save
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<table class="table table-striped" id="intraTransactionTable" style="width: 100%!important;">
					<thead>
					<tr>
						<td>#</td>
						<td>From Subsidiary Account</td>
						<td>From Gl Account</td>
						<td>To Subsidiary Account </td>
						<td>To Gl Account</td>
						<td>Amount</td>
						<td>Approve Status</td>
						<td>Action</td>
					</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
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
		getBranchList();
		intraTransactionTable();
		var user_type=$("#user_type").val();
		if(user_type!=2)
		{
			var fromBranch=$("#from_branch_id").val();
			getBranchGlAccount(fromBranch,1);
		}
	});
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
			}
		}).catch(e => {
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
	function getBranchGlAccount(branch_id,type)
	{

		console.log(branch_id);
		var formData=new FormData();
		formData.set('branch_id',branch_id);
		app.request(base_url + "getBranchGlAccount",formData).then(res=>{
			if(res.status == 200) {
				if(type==1)
				{
					$('#from_gl_account').html('');
					$('#from_gl_account').append(res.data);
				}
				else
				{
					$('#to_gl_account').html('');
					$('#to_gl_account').append(res.data);
				}
			}
			else
			{
				if(type==1)
				{
					$('#from_gl_account').html('');
					$('#from_gl_account').append(res.data);
				}
				else
				{
					$('#to_gl_account').html('');
					$('#to_gl_account').append(res.data);
				}
			}
		}).catch(e => {
			console.log(e);
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
	function loadEditableTable(id,branch_id)
	{
		$.LoadingOverlay("show");
		$.ajax({
	        url: base_url + "getExportToTableData",
	        type: "POST",
	        dataType: "json",
	        data: {id:id,branch_id:branch_id},
	        success: function (result) {
		$.LoadingOverlay("hide");
	        	var rows = [
						['','', '', '', '', '','','',''],
					];
	            if (result.status === 200) {
	                // var columns=result.columns;
	                //  var rows=result.rows;
	                //  var types=result.types;
	                 // columnRows=rows;
	                 // columnsHeader=columns;
	            	// createHandonTable(columns,rows,types,'newDiv');
	            	if(result.rows.length>0)
	                {
	                	 rows=result.rows;
	                }
	            }
	            else
	            {

	            	rows = [
						['','', '', '', '', '','','',''],
					];

	            }
	           var types=[
					{ type: 'numeric' },
					{ type: 'text'},
					{ type: 'numeric'},
				];
	            var columns=['branch_company_id','name','amount'];
	            createHandonTable(columns,rows,types,'newDiv');
	        },
	        error: function (error) {
		$.LoadingOverlay("hide");
	            console.log(error);
	           // $.LoadingOverlay("hide");
	        }
	    });
		
	}

let hotDiv;
function createHandonTable(columnsHeader,columnRows,columnTypes,divId)
{
 var element=document.getElementById(divId);
  hotDiv !=null ? hotDiv.destroy():'';
 hotDiv= new Handsontable(element, {
				  data:columnRows,
				  colHeaders: columnsHeader,
				  manualColumnResize: true,
				  manualRowResize :true,
				  // columns: [
				  //  { type: 'text' },
				  //   { type: 'dropdown',source:[1,2,3,4] ,validator: function(value, callback) {
				  //     	if (/^(\d|\-)*$/.test(value)) { 
				  //       	callback(true);
				  //     	} else {
				  //       	callback(false);
				  //     	}
				  //   	}
				  // 	},
				  //   { type: 'text' },
				  //   { type: 'text' },
				  //   { type: 'text' },
				  //   { type: 'date', dateFormat: 'M/D/YYYY' }
				  // ],
				  columns:columnTypes,
				  beforeChange: function (changes, source) {
				  	  var row = changes[0][0];

				        var prop = changes[0][1];

				        var value = changes[0][3];
				        if(prop==1)
				        {

				         this.setDataAtRowProp(row,2,"supriya");
				        }
				        console.log(changes,row,prop,value);
				       
				  },
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
function saveCopyIntraData()
{
		$.LoadingOverlay("show");
	var data = hotDiv.getData();
	let formData = new FormData();
	formData.set('arrData', JSON.stringify(data));
	formData.set('insertID', $("#insertID").val());
	formData.set('branchID', $("#branchID").val());
	formData.set('debitCheck',debitCheck);
	formData.set('creditCheck', creditCheck);
	app.request(base_url + "saveCopyIntraData",formData).then(res=>{
		$.LoadingOverlay("hide");
		// data=res.data2;
		// console.log(res);
		if(res.status==200)
		{
			toastr.success(res.body);
			$("#insertID").val('');
		    $("#branchID").val('');
		    document.getElementById("exportexcelsheet").reset();
		    $("#newDiv").html('');
		    document.getElementById('newDiv').style.height=null;
		    $("#finacialBtn").hide();
		}
		else
		{
			toastr.error(res.body);
		}
		
	});
}

</script>

