<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.toggle
	{
		    width: 200px!important;
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
							<button class="btn btn-icon btn-primary roundCornerBtn4 xs_btn" style="float: right" onclick="$('#intraFormRow').toggle()" ><i class="fa fa-plus"></i></button>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="intraFormRow" style="display: none">
		<div class="col-lg-12">
			<div class="card-box">
				<form method="post" id="exportexcelsheet">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label>Select Year</label>
								<select name="year" id="year" class="form-control year">
									<option disabled selected>select year</option>
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
							<div class="col-md-6">
								<div class="form-group">
									<label>Select Month</label>
								<select name="quarter" id="quarter" class="form-control month">
									<option disabled selected>select month</option>
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
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<!-- <?php if($this->session->userdata('user_type') == 2){ ?>
								<div class="col-md-6">
									<div class="form-group">
										<label>Branch</label>
																				<input type="file" class="form-control" id="userfile" name="userfile" >
										<select name="branch_id" id="branch_id" class="form-control">
											<
										</select>
									</div>
								</div>
							<?php } ?> -->
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
								<!-- <input type="checkbox" id="toggle-two" value="1"> -->
								<input type="radio" data-toggle="toggle" name="holdingType" id="holdingType1" value="1"> <label for="holdingType1">Holding Company</label>
								<input type="radio" name="holdingType" id="holdingType2" value="2"> <label for="holdingType2">Subsidiary Account</label>
							</div>
							<div class="col-md-6">

								<button type="submit" class="btn btn-primary roundCornerBtn4" style="margin-top: 27px;">Create</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-ms-12">
			<input type="hidden" name="insertID" id="insertID">
			<input type="hidden" name="branchID" id="branchID">
		</div>
		<div class="col-md-12" id="newDiv"></div>
		<div class="col-md-12">
			<button type="button" class="btn btn-primary roundCornerBtn4" id="finacialBtn" onclick="saveCopyIntraData()" style="display: none;">Save</button>
		</div>
		<div class="col-md-12" id="example"></div>
	</div>
	<div class="row" style="padding: 0rem 1rem;">
		<div class="col-md-4">
			<div class="form-group" style="width: 90%; margin: 0rem auto 1.3rem auto;">
				<label>Filter By Year</label>
				<select name="year" id="filteryear" class="form-control" onchange="getIntraCompanyList()">
					<option value="-1"  selected>All</option>
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
			<div class="form-group" style="width: 90%; margin: 0rem auto 1.3rem auto;">
				<label>Filter By Month</label>
				<select name="quarter" id="filterquarter" class="form-control" onchange="getIntraCompanyList()">
					<option value="-1"  selected>All</option>
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
			<div class="form-group" style="width: 90%; margin: 0rem auto 1.3rem auto">
				<label>Filter By Status</label>
				<select name="quarter" id="filterStatus" class="form-control" onchange="getIntraCompanyList()">
					<option value="-1"  selected>All</option>
					<option value="1">Approve</option>
					<option value="0">Not Approve</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<table class="table table-striped" id="intraTable">
					<thead>
					<tr>
						<td>#</td>
						<!-- <td>Template Name</td> -->
						<!-- <td>Company </td> -->
						<!-- <td>File</td> -->
						<td>Year</td>
						<td>Month</td>
						<!-- <td>Approve Status</td> -->
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
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="<?php echo base_url();?>assets/js/module/upload_data/financial_data.js"></script>
<script type="text/javascript">
	var base_url='<?php echo base_url(); ?>';
</script>
<script>
  $(function() {
    $('#toggle-two').bootstrapToggle({
      on: 'Holding Company',
      off: 'Branch'
    });

  })
</script>
<script type="text/javascript">
	$(document).ready(function(){
		getTemplates();
		getIntraCompanyList();
		getBranchList();
	});

	function  getBranchList() {
		app.request(baseURL + "getCompanyBranchList",null).then(res=>{
			if(res.status == 200) {
				$('#branch_id').append(res.data);
			}
		}).catch(e => {
			console.log(e);
		});
	}

	$("#exportexcelsheet").validate({
		rules: {
			year: {
				required: true
			},
			quarter: {
				required: true
			},
			holdingType:
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
			holdingType:
			{
				required: "Please select"
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
			// $.LoadingOverlay("show");

			var formData=new FormData(form);
			$.ajax({
				url: base_url+"ExportToTable2",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
        		contentType: false,
				success: function (result) {
					if (result.status === 200) {
		                var id=result.body;
		                // var branch_id = result.branch_id
		                 $("#insertID").val(id);
		                 window.location.href = base_url+'viewIntraCompanyDetails/'+id;
		                 // $("#branchID").val(branch_id);
		                // loadEditableTable(id,branch_id);
						// getIntraCompanyList();
						// $("#finacialBtn").show();
		            }
		            else
		            {
		            	toastr.error(result.body);
		            	// alert(result.body);
		            }
				}, error: function (error) {
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
		$.ajax({
	        url: base_url + "getExportToTableData",
	        type: "POST",
	        dataType: "json",
	        data: {id:id,branch_id:branch_id},
	        success: function (result) {
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
	var data = hotDiv.getData();
	let formData = new FormData();
	formData.set('arrData', JSON.stringify(data));
	formData.set('insertID', $("#insertID").val());
	formData.set('branchID', $("#branchID").val());
	formData.set('debitCheck',debitCheck);
	formData.set('creditCheck', creditCheck);
	app.request(base_url + "saveCopyIntraData",formData).then(res=>{
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
// 	const data = [
//   [1,'', 'Tesla', 'Volvo', 'Toyota', 'Ford'],
//   [2,'abc', 10, 11, 12, 13],
//   [3,'2020', 20, 11, 14, 13],
//   [4,'2021', 30, 15, 12, 13]
// ];

// const container = document.getElementById('example');
// const hot = new Handsontable(container, {
//   data:data,
//   colHeaders: [
//     "Company name",
//     "Country",
//     "Name",
//     "Sell date",
//     "Order ID",
//     "In stock",
//     "Qty",
//     "Progress",
//     "Rating"
//   ],
//   manualColumnResize: true,
//   manualRowResize :true,
//   columns: [
//    { type: 'text' },
//     { type: 'dropdown',source:[1,2,3,4] ,allowInvalid: false,validator: function(value, callback) {
//       	if (/^(\d|\-)*$/.test(value)) {
//         	callback(true);
//       	} else {
//         	callback(false);
//       	}
//     	}
//   	},
//     { type: 'text' },
//     { type: 'text' },
//     { type: 'text' },
//     { type: 'date', dateFormat: 'M/D/YYYY' }
//   ],
//   beforeChange: function (changes, source) {
//   	  var row = changes[0][0];

//         var prop = changes[0][1];

//         var value = changes[0][3];
//         if(prop==1)
//         {

//          this.setDataAtRowProp(row,2,"supriya");
//         }
//         console.log(changes,row,prop,value);

//   },
//    colWidths: '100%',
//     width: '100%',
//     height: 320,
//     rowHeights: 23,
//     rowHeaders: true,
//     filters: true,
//     contextMenu: true,
//     hiddenColumns: {
// 	    // specify columns hidden by default
// 	    columns: [0]
// 	  },
//     dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
//     licenseKey: 'non-commercial-and-evaluation'
// });
// hot.validateCells();
</script>
<script type="text/javascript">
	function getTemplates()
	{
		app.request(base_url + "getTemplates",null).then(res=>{
			if(res.status == 200){
				app.selectOption('select_template','select template',res.data);
			}else{
			}
		});
	}
</script>
