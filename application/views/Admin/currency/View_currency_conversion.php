<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
//$cc_id ='';
?>
<!-- Main Content -->
<div class="content-page">
	<div class="content">

		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
						<div class="page-title-box">
							<div class="" style="    display: flex; flex-direction: row;">
							<button class="btn btn-link"><a href="<?= base_url('currency') ?>"><i class="fa fa-arrow-left"></i></a></button>
							<h4 class="">Currency Conversion Details</h4>
							</div>
							<button class="btn btn-icon btn-primary roundCornerBtn4" style="float: right" data-toggle="modal"
									data-target="#fire-modal-company" data-id="0" onclick="openModal()" id="companyFormButton"><i
									class="fa fa-plus"></i></button>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<input type="hidden" id="cc_id" name="cc_id" value="<?php echo $cc_id; ?>">
		</div>
		 <div class="col-lg-12" style="background-color: white;">
			<div class="" style="padding-right: 20px;">
				<?php if ($checkPermission== true){ ?>
					<button class="btn btn-primary roundCornerBtn4 filterBtn" style="margin-top: 10px;float: right;" onclick="saveHandsonData()">Save</button>
<!--					<button class="btn btn-primary" onclick="saveData();">Save</button>-->
				<?php } ?>
				<div class="col-md-12" id="newErrorDiv"></div>
				<div class="col-md-12" id="example" style="margin: 10px;"></div>
				

			</div>
		</div>
	</div>
</div>

<?php $this->load->view('Admin/currency/currency_form'); ?>
</div>
<?php $this->load->view('_partials/footer'); ?>
<script src="<?=base_url();?>assets/js/module/currency/currency.js" type="text/javascript"></script>
<script>
	const base_URL ='<?= base_url() ?>';
</script>
<script>
	$(document).ready(function () {
		$.LoadingOverlay("show");
		getDataMainCC();
		$("#companyFormButton").hide();
	})
</script>
</div>
