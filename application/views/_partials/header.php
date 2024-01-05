<!doctype html>
<html lang="en"><head>
	<meta charset="utf-8">
	<title><?php  echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<link href="<?=base_url();?>assets/dh/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/plugins/select2/css/select2.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/css/core.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/css/components.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/css/icons.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/css/pages.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/css/menu.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/css/responsive.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/dh/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/jquery.datepick.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/sumoselect.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/jquery.simple-dtpicker.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/daterangepicker-bs3.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/bootstrap-clockpicker.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	

	<?php if($this->uri->segment(1)=="Excel" || $this->uri->segment(1)=="handson"
	|| $this->uri->segment(1)=="upload_data" || $this->uri->segment(1)=="user_excel_view"||
	$this->uri->segment(1)=="MainSetup"|| $this->uri->segment(1)=="currency"
			|| $this->uri->segment(1)=="consolidate"
			|| $this->uri->segment(1)=="uploadIntraCompanyTransfer"
			|| $this->uri->segment(1)=="viewCurrencyDetails"
			|| $this->uri->segment(1)=="update_report"
			|| $this->uri->segment(1)=="viewIntraCompanyDetails"
			|| $this->uri->segment(1)=="update_report_schedule"
			|| $this->uri->segment(1)=="excelUploadValidation"
			|| $this->uri->segment(1)=="previousConsolidate"
			|| $this->uri->segment(1)=="tablereportMakerByMonth"
			|| $this->uri->segment(1)=="reportMakerByMonthVersion3"
			|| $this->uri->segment(1)=="derived_report"

	){

		?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.css"/>
	<?php } ?>
	<script src="<?=base_url();?>assets/dh/js/modernizr.min.js" type="text/javascript"></script>
	<style>
		.header{
			background: #F2D176!important;
		}
		.logo_name{
			color: #A27700;
			text-shadow: 0px 1px 2px #00000055;
		}
		.logout {
			color: #A27700!important;;
			/* color: #F2D176; */
		}
		.logout span i{
			color: #000;
			/* color: #F2D176; */
		}
		.page-title{
			color: #4e3a04!important;
		}
		.side-menu
		{
			box-shadow: 1px 1px 3px 0px lightgrey;
		}
		.page-title-box
		{
			box-shadow: 1px 1px 3px 0px lightgrey;
			margin: 0 -20px!important;
		}
		.alert.alert-light {
	    background-color: #ef13074d;
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
	</style>
</head>
<body>
<div id="wrapper">

	<div class="topbar">
		<div class="topbar-left header">
			<a href="" class="logo">
            <span>
				<img src="<?php echo base_url();?>assets/images/gbt_logo.png" alt="GBT LOGO" style="width: 50%;height: 80%;">
            </span>
				<i>
					<img src="<?php echo base_url();?>assets/images/gbt_logo.png" alt="GBT LOGO" style="width: 50%;height: 80%;">
				</i>
			</a>
		</div>

		<div class="navbar navbar-default header" role="navigation">
			<div class="container">
				<ul class="nav navbar-nav navbar-left nav-menu-left header">
					<li>
						<button type="button" class="button-menu-mobile open-left waves-effect header">
							<i class="dripicons-menu"></i>
						</button>
					</li>
					<li>
						<div class="form-group">
							<label class="logo_name" style="font-size: 18px;margin: 23px 10px 0px 10px;">Global Accounting Software</label>
						</div>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right logo_name">
					<li class="hidden-xs">
					</li>
					<li class="dropdown user-box logout" >
						<a href="" class="dropdown-toggle waves-effect user-link header" style="color: #4e3a04!important;text-shadow: 0px 1px 2px #00000055; "  data-toggle="dropdown"
						   aria-expanded="true">
							<?php echo $this->session->userdata('username'); ?> <i class="fa fa-sort-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list ">
							<li><a href="<?php echo base_url(); ?>">Logout</a></li>
						</ul>
					</li>
				</ul>

			</div>
		</div>
	</div>

	<?php
	$this->load->view('_partials/sidebar');
	?>
</div>
<?php
$this->load->view('_partials/sidebar_script');
?>
</body>
</html>
