<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.css"/>
	
</head>
<body>
	<form id="exportexcelsheet" method="post">
		<select name="year" id="year">
			<option disabled selected>select year</option>
			<option value="1">2021-2022</option>
			<option value="2">2022-2023</option>
			<option value="3">2023-2024</option>
			<option value="4">2024-2025</option>
		</select>
		<select name="quarter" id="quarter">
			<option disabled selected>select quarter</option>
			<option value="1">April-June</option>
			<option value="2">July-September</option>
			<option value="3">October-December</option>
			<option value="4">January-March</option>
		</select>

		<input type="file" id="userfile" name="userfile" />  
   		<input type="submit" id="viewfile"  value="Export To Table"  />  
   </form>

<div id="example"></div>
</body>
<script type="text/javascript">
	var base_url='<?php echo base_url(); ?>';
</script>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	 <script src="<?= base_url() ?>assets/scripts/jquery-validation/js/jquery.validate.min.js"
            type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.js"></script>
</html>
<script type="text/javascript">
	// $(document).ready(function(){
	// 	$.LoadingOverlay("show");
	// })
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
				required:true
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
			// $.LoadingOverlay("show");
			
			var formData=new FormData(form);
			$.ajax({
				url: base_url+"ExportToTable",
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
        		contentType: false,
				success: function (result) {
					if (result.status === 200) {
		                var id=result.body;
		                loadEditableTable(id);
		                // toastr.success(result.);
		            }
		            else
		            {
		            	toastr.error(result.body);
		            }
				}, error: function (error) {
					// $.LoadingOverlay("hide");
					toastr.error("Something went wrong please try again");
				}

			});
		}
	});

	function loadEditableTable(id)
	{
		$.ajax({
	        url: base_url + "getExportToTableData",
	        type: "POST",
	        dataType: "json",
	        data: {id:id},
	        success: function (result) {
	            if (result.status === 200) {
	                var columns=result.columns;
	                 var rows=result.rows;
	                $('#exceltable').jexcel({
					    data:rows,
					    // editable:false,
					    colHeaders: ['name','age','dob','contact','gender'],
					    // colWidths: [ 300, 80, 100, 60, 120 ],
					    // columns: [
					    //     { type: 'autocomplete', url:'/jspreadsheet/countries' },
					    //     { type: 'text' },
					    //     { type: 'dropdown', source:[ {'id':'1', 'name':'Fruits'}, {'id':'2', 'name':'Legumes'}, {'id':'3', 'name':'General Food'} ] },
					    //     { type: 'text' },
					    //     { type: 'calendar' },
					    // ]
					});
	            }
	            else
	            {
	            }
	           
	        },
	        error: function (error) {
	            console.log(error);
	           // $.LoadingOverlay("hide");
	        }
	    });
		
	}


	const data = [
  ['', 'Tesla', 'Volvo', 'Toyota', 'Ford'],
  ['2019', 10, 11, 12, 13],
  ['2020', 20, 11, 14, 13],
  ['2021', 30, 15, 12, 13]
];

const container = document.getElementById('example');
const hot = new Handsontable(container, {
  data: data,
  rowHeaders: true,
  colHeaders: true,
  height: 'auto',
  licenseKey: 'non-commercial-and-evaluation' // for non-commercial use only
});
</script>
