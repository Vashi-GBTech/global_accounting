<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="<?=base_url();?>assets/dh/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="<?=base_url();?>assets/dh/plugins/select2/css/select2.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.css"/>
	<style type="text/css">
		.file_header {
			height: 60px;
		}
		.bg-light {
			background-color: #e3eaef !important;
		}
		.save_btn, .close_btn {
			font-size: x-large;
			padding: 5px;
			cursor: pointer;
		}
		.tox-tinymce
		{
			height: 90vh!important;
		}
		div::-webkit-scrollbar-track {
			-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
			border-radius: 10px;
			background-color: #F5F5F5;
		}

		div::-webkit-scrollbar {
			width: 8px;
			background-color: #F5F5F5;
			height: 8px;
		}

		div::-webkit-scrollbar-thumb {
			border-radius: 10px;
			-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
			background-color:#c1c1c1;
		}
		body::-webkit-scrollbar-track {
			-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
			border-radius: 10px;
			background-color: #F5F5F5;
		}

		body::-webkit-scrollbar {
			width: 8px;
			background-color: #F5F5F5;
			height: 8px;
		}

		body::-webkit-scrollbar-thumb {
			border-radius: 10px;
			-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
			background-color:#c1c1c1;
		}
		#accLevel .nav-tabs {
			border: 0;
			padding: 15px 0.7rem;
		}

		#accLevel .nav-tabs>.nav-item.active {
			box-shadow: 0px 3px 2px 0px rgba(0, 0, 0, 0.3);
		}
		#accLevel .nav-tabs>.nav-item.active>.nav-link {
			color: white;}
		#accLevel .nav-tabs {
			border-top-right-radius: 0.1875rem;
			border-top-left-radius: 0.1875rem;
		}

		#accLevel .nav-tabs>.nav-item>.nav-link {
			color: #888888;
			margin: 0;
			/*margin-right: 5px;*/
			background-color: transparent;
			border: 1px solid transparent;
			border-radius: 30px;
			font-size: 14px;
			padding: 7px 30px;
			line-height: 1.5;
		}

		#accLevel .nav-tabs>.nav-item:hover {
			background-color: transparent;
		}

		#accLevel .nav-tabs>.nav-item.active {
			background-color: #444;
			border-radius: 30px;
			color: #FFFFFF;
		}

		#accLevel .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
			font-size: 14px;
			position: relative;
			top: 1px;
			margin-right: 3px;
		}
		#accLevel .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{

			background-color: transparent;
		}
		.sign
		{
			font-size: 15px;
		}
		/*td{
			white-space: nowrap;
		}*/

		.tabbable-panel {
			/*border:1px solid #eee;*/
			padding: 10px;
		}

		.tabbable-line > .nav-tabs {
			border: none;
			margin: 0px;
		}
		.tabbable-line > .nav-tabs > li {
			margin-right: 2px;
		}
		.tabbable-line > .nav-tabs > li > a {
			border: 0;
			margin-right: 0;
			color: #737373;
		}
		.tabbable-line > .nav-tabs > li > a > i {
			color: #a6a6a6;
		}
		.tabbable-line > .nav-tabs > li.open, .tabbable-line > .nav-tabs > li:hover {
			border-bottom: 4px solid rgb(80,144,247);
		}
		.tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {
			border: 0;
			background: none !important;
			color: #333333;
		}
		.tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
			color: #a6a6a6;
		}
		.tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
			margin-top: 0px;
		}
		.tabbable-line > .nav-tabs > li.active {
			border-bottom: 4px solid #32465B;
			position: relative;
		}
		.tabbable-line > .nav-tabs > li.active > a {
			border: 0;
			color: #333333;
		}
		.tabbable-line > .nav-tabs > li.active > a > i {
			color: #404040;
		}
	</style>
</head>
<body>

<div class="" id="modal_editor_row">
	<!-- left side body  -->
	<div class="col-md-8" id="open_notepad" style="padding: 0px!important;">
		<form method="post" id="reportForm">
			<div class="text_area">
				<div class="file_header align-items-center borderjustify-content-between text-black-50 bg-light px-2" style="display: flex;padding-top: 15px;">
					<input type="text" placeholder="Template Name..." id="templateName" name="templateName" class="form-control col-md-4">
					<select  id="type" class="form-control col-md-3" name="type" onchange="getGlAccountData(this.value);groupYearData();">
						<option selected disabled>Select Type</option>
						<option value="1">IND</option>
						<option value="2">USD</option>
						<option value="3">IFRS</option>
					</select>
					<select  id="currencytype" class="form-control col-md-3" name="currencytype">
						<option disabled>Select Currency Type</option>
						<option selected value="1">LOCAL</option>
						<option value="2">LOCAL+INR</option>
						<option value="3">INR</option>
					</select>
					<select id="reportSection" class="form-control col-md-4" name="reportSection">
						<option selected value="1">Main Report</option>
						<option value="2">Schedule Report</option>
					</select>
					<span onclick="uploadTemplateData()"><i class="save_btn fa fa-check px-3" id="save_btn_i"></i></span>
					<a href="<?php echo base_url();?>version3Report"><i class="close_btn fa fa-times pr-3" id="close_notepad"></i></a>
					<input type="hidden" name="template_id" id="template_id" value="<?php echo $template_id; ?>">


				</div>
				<div class="col-md-12" id="handsontable"></div>


			</div>
		</form>
	</div>
	<div class="col-md-4" style="height: 100vh;overflow: auto;box-shadow: 1px 1px 5px 5px lightgrey;">
		<div class="col-md-12 row mb-2" id="styleDiv" style="display: none">
			<label class="h4 text-primary" >Styling for perticular Cell</label>
			<span class="text-success " style="font-weight: 700;" id="selectedColumn"></span> <button onclick="ChangeStyleRow()" title="Save" class="btn btn-link"><i class="fa fa-check"></i></button><br>
			<span>Background color:</span>
			<input id="numrowcol" type="hidden">
			<input id="backgroundColor" type="color">
			<span>Text color:</span>
			<input id="textColor" type="color">
			<br>
			<span>Font Bold:</span>
			<select name="isbold" id="isbold">
				<option value="bold">Bold</option>
				<option value="bolder">Bolder</option>
				<option value="lighter">Lighter</option>
				<option value="100">100</option>
				<option value="200">200</option>
				<option value="300">300</option>
				<option value="400">400</option>
				<option value="500">500</option>
				<option value="600">600</option>
				<option value="700">700</option>
				<option value="800">800</option>
				<option value="900">900</option>
				<option value="normal">Normal</option>
			</select>
			<span>Font Size:</span>
			<input type="number" name="textSize" id="textSize">
			<br>
			<span>Alignment :</span>
			<select name="textAlign" id="textAlign">
				<option value="left">Left</option>
				<option value="right">right</option>
				<option value="center">center</option>
			</select>
			<hr/>
		</div>
		<div class="col-md-12 row mb-2" id="attachReportDiv" style="display: none;">
			<div><label class="h4 text-primary" >Attach Report</label> - <span id="selectedvalue"></span>
				</div>
			<div class="col-md-5">
				<label for="">Select Report Type</label>
				<select name="reportType" id="reportType" class="form-control" onchange="getReportTemplateList(this.value)">
					<option value="0" selected></option>
					<option value="1">Template Report</option>
					<option value="2">Schedule Report</option>
				</select>
			</div>
			<div class="col-md-5">
				<label for="">Select Report</label>
				<select name="reportTemp" id="reportTemp" class="form-control">

				</select>
			</div>
			<div class="col-md-2">
				<button onclick="ChangeReportRow()" title="Save" class="btn btn-success btn-sm m-t-4" style="margin-top: 25px;">Save</button>
			</div>
			<div class="col-md-12">
				<hr/>
			</div>
		</div>
		<div class="col-md-12">

			<label><i class="fa fa-calendar"></i> Month - </label> <span id="monthText">#month</span><button class="btn btn-sm btn-link" onclick="copyText('monthText')"><i class="fa fa-copy"></i></button>
			<label> Year - </label> <span id="yearText">#year</span><button class="btn btn-sm btn-link" onclick="copyText('yearText')"><i class="fa fa-copy"></i></button>
		</div>

		<div class="col-md-12">
			<label>Formula Maker</label>
			<div class="col-md-12" style="padding: 0px!important;">

				<div>
					<textarea type="text" name="formulaMaker" id="formulaMaker" class="form-control"></textarea>
				</div>
				<div class=""><button class="btn btn-sm btn-link sign" onclick="pasteText('formulaMaker','+')">+ Addition</button>
					<button class="btn btn-sm btn-link sign" onclick="pasteText('formulaMaker','-')">- Substraction</button>
					<button class="btn btn-sm btn-link sign" onclick="pasteText('formulaMaker','*')">* multiplication</button>
					<button class="btn btn-sm btn-link sign" onclick="pasteText('formulaMaker','/')">/ Division</button> </div>
				<div class="text-right">
					<button class="btn btn-sm btn-link" onclick="copyTextFormula('formulaMaker',1)"><i class="fa fa-copy"> Copy</i></button>
					<button class="btn btn-sm btn-link" onclick="copyTextFormula('formulaMaker',2)"><i class="fa fa-cut"> Clear</i></button>
				</div>

			</div>
		</div>
		<hr>
		<div class="col-md-12" style="margin-bottom: 10px;">
			<label>Values in</label>
			<div class="col-md-12" style="padding: 0px!important;">
				<select id="number_conversion" class="form-control col-md-4" name="number_conversion">
					<option selected >Original Value</option>
					<option value="1">Thousand</option>
					<option value="2">Lakhs</option>
					<option value="4">Millions</option>
					<option value="3">Crores</option>

				</select>
			</div>
		</div>


		<div class="col-md-12 tabbable-panel" style="padding: 0px !important;">

			<div class="tabbable-line">
				<ul class="nav nav-tabs nav-justified mb-3" id="Alevel" role="tablist">
					<li class="nav-item match active" role="presentation">
						<a data-toggle="tab" href="#accLevel" class="nav-link active" id="matched_data" role="tab" aria-selected="true" aria-expanded="true">Account Level</a>
					</li>
					<li class="nav-item unmatch" role="presentation">
						<a data-toggle="tab" href="#queryLevel" class="nav-link" id="unmatched_data" role="tab" aria-selected="false" aria-expanded="false" onclick="">Query Level</a>
					</li>
				</ul>
				<div class="tab-content" style="padding:0;">
					<div id="accLevel" class="card tab-pane active">
						<div class="col-md-12 bg-white" style="padding: 0px !important;">
							<!-- <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist" style="margin-bottom: 10px;">
								<li class="nav-item match active" role="presentation">
									<a data-toggle="tab" href="#typePanel" class="nav-link active" id="matched_data" role="tab" aria-selected="true" aria-expanded="true" >Type3</a>
								</li>
								<li class="nav-item match" role="presentation">
									<a data-toggle="tab" href="#type2Panel" class="nav-link" id="matched_data" role="tab" aria-selected="false" aria-expanded="false" >Type2</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#type1Panel" class="nav-link" id="unmatched_data" role="tab" aria-selected="false" aria-expanded="false" onclick="">Type1</a>
								</li>
								<li class="nav-item unmatch" role="presentation">
									<a data-toggle="tab" href="#glPanel" class="nav-link" id="unmatched_data" role="tab" aria-selected="false" aria-expanded="false" onclick="">Gl Account</a>
								</li>
							</ul> -->
							<ul class="nav nav-tabs justify-content-center" role="tablist">
								<li class="nav-item active">
									<a class="nav-link " data-toggle="tab" href="#typePanel" role="tab">
										<i class="now-ui-icons objects_umbrella-13"></i> Type3
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#type2Panel" role="tab">
										<i class="now-ui-icons shopping_cart-simple"></i> Type2
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#type1Panel" role="tab">
										<i class="now-ui-icons shopping_shop"></i> Type1
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#glPanel" role="tab">
										<i class="now-ui-icons ui-2_settings-90"></i> Gl Account
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#daPanel" role="tab">
										<i class="now-ui-icons ui-2_settings-90"></i> Derived GL
									</a>
								</li>
							</ul>
							<div class="tab-content" style="padding:0;">
								<div id="typePanel" class="tab-pane active" role="tabpanel">
									<label>Type3 </label>
									<select name="yearWise" class="form-control" onchange="changeYearWise(this.value)">
										<option value="1">Current Year</option>
										<option value="2">Previous Year</option>
										<option value="3">Previous To Previous Year</option>
									</select>
									<div class="">
										<table id="sidebar_group_table" class="table table-bordered" style="font-size: 10px;margin-top: 10px;">
											<thead>
											<tr>
												<th>Type1</th>
												<th>Type2</th>
												<th>Type3</th>
												<th>Divide</th>
												<th colspan="4">#

												</th>
											</tr>

											<tr><th></th>
												<th></th>
												<th></th>
												<th></th>
												<th>OB</th>
												<th>Dr</th>
												<th>Cr</th>
												<th>Total</th>
											</tr>

											</thead>
											<tbody id="groupYearData">

											</tbody>
										</table>
									</div>
								</div>
								<div id="type2Panel" class="tab-pane">
									<label>Type2 </label>
									<select name="yearWise_table2" class="form-control" onchange="changeYearWise2(this.value)" style="margin-top: 10px;">
										<option value="1">Current Year</option>
										<option value="2">Previous Year</option>
										<option value="3">Previous To Previous Year</option>
									</select>
									<div class="">
										<div>Total of <input type="radio" name="type2PartC" value="" onclick="checkTypeRadioCheck('type2PartC','type2_partC')" checked> Part 1  <input type="radio" name="type2PartC" value="2" onclick="checkTypeRadioCheck('type2PartC','type2_partC')"> Part1+Part 2</div>
										<table id="sidebar_group_table_2" class="table table-bordered" style="font-size: 10px;margin-top: 10px;">
											<thead>
											<tr>
												<th>Type1</th>
												<th>Type2</th>
												<th>OB</th>
												<th>Dr</th>
												<th>Cr</th>
												<th>Total</th>
											</tr>

											</thead>
											<tbody id="groupYearData2">

											</tbody>
										</table>
									</div>
								</div>
								<div id="type1Panel" class="tab-pane">
									<label>Type1 </label>
									<select name="yearWise_table1" class="form-control" onchange="changeYearWise1(this.value)" style="margin-top: 10px;">
										<option value="1">Current Year</option>
										<option value="2">Previous Year</option>
										<option value="3">Previous To Previous Year</option>
									</select>
									<div class="">
										<div>Total of <input type="radio" name="type1PartC" value="" onclick="checkTypeRadioCheck('type1PartC','type1_partC')" checked> Part 1  <input type="radio" name="type1PartC" value="2" onclick="checkTypeRadioCheck('type1PartC','type1_partC')"> Part1+Part 2</div>
										<table id="sidebar_group_table_1" class="table table-bordered" style="font-size: 10px;margin-top: 10px;">
											<thead>
											<tr>
												<th>Type1</th>
												<th>OB</th>
												<th>Dr</th>
												<th>Cr</th>
												<th>Total</th>
											</tr>

											</thead>
											<tbody id="groupYearData1">

											</tbody>
										</table>
									</div>
								</div>
								<div id="glPanel" class="tab-pane">
									<div class="col-md-12">
										<label>Gl Account</label>


										<select name="yearWise_table2" class="form-control" onchange="changeYearWiseGL(this.value)" style="margin-top: 10px;">
											<option value="1">Current Year</option>
											<option value="2">Previous Year</option>
											<option value="3">Previous To Previous Year</option>
										</select>
									</div>
									<div class="col-md-12" style="margin-top: 10px;font-size: 10px;" id="tableDiv">
										<table class="table table-bordered">
											<thead>
											<tr>
												<th>Gl No./Type</th>
												<th>Detail</th>
												<th>Divide</th>
												<th colspan="4">#</th>

											</tr>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th>Ob</th>
												<th>Dr</th>
												<th>Cr</th>
												<th>Total</th>

											</tr>
											</thead>
											<tbody id="gl_table">




											</tbody>
										</table>

									</div>
								</div>
								<div id="daPanel" class="tab-pane">
									<label for="">Derived GL</label>
									<div class="col-md-12" style="margin-top: 10px;font-size: 10px;" id="datableDiv">
										<table class="table table-bordered">
											<thead>
											<tr>
												<th>Detail</th>
												<th colspan="4">#</th>

											</tr>
											</thead>
											<tbody id="da_table">




											</tbody>
										</table>

									</div>
								</div>

							</div>

						</div>
					</div>
					<div id="queryLevel" class="tab-pane">
					</div>
				</div>
			</div>
		</div>
	</div>


</div>

</body>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>
<script src="<?=base_url();?>assets/dh/js/jquery.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/select2/js/select2.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/module/reportMaker/reportVersion3.js"></script>

<script>


	$(document).ready(function () {
		$('#type').find('option[value=1]').attr('selected','selected');

		getGlAccountData(1);
		groupYearData(1);
		getReportTemplateData();
		groupYearData2(1);
		groupYearData1(1);
		getTemplateReportList(1);
		getTemplateReportList(2);
		getDerivedGLData(1);
	});

</script>
</html>
