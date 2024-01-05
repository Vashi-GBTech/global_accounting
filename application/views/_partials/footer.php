</div>

<footer class="footer text-right">
	<?php echo date('Y'); ?> &copy; <a href="" target="_blank">Global Accounting Software</a>. All Rights Reserved.
</footer>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
<script src="<?= base_url() ?>assets/jquery-validation/js/jquery.validate.min.js"
            type="text/javascript"></script>
<script src="<?=base_url();?>assets/js/custom.js?version=<?=time()?>" type="text/javascript"></script>


<?php if($this->uri->segment(1)=="Excel" || $this->uri->segment(1)=="handson"
		|| $this->uri->segment(1)=="upload_data" || $this->uri->segment(1)=="user_excel_view"||
		$this->uri->segment(1)=="MainSetup"
		|| $this->uri->segment(1)=="uploadIntraCompanyTransfer"
		|| $this->uri->segment(1)=="currency" || $this->uri->segment(1)=="consolidate"
		|| $this->uri->segment(1)=="viewCurrencyDetails"
		|| $this->uri->segment(1)=="update_report"
		|| $this->uri->segment(1)=="viewIntraCompanyDetails"
		|| $this->uri->segment(1)=="update_report_schedule"
		|| $this->uri->segment(1)=="excelUploadValidation"
		|| $this->uri->segment(1)=="previousConsolidate"
		|| $this->uri->segment(1)=="tableReportMaker"
		|| $this->uri->segment(1)=="tablereportMakerByMonth"
		|| $this->uri->segment(1)=="reportMakerByMonthVersion3"
		|| $this->uri->segment(1)=="derived_report"
	){
		 ?>

		 <script type="text/javascript" src="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.js"></script>
	<?php } ?>

</body>
</html>

<script type="text/javascript">
	$( document ).ready(function() {
		app.request("<?php echo base_url();?>" + "getAllPermissionsCompany").then(res=>{
			if(res.html != ""){
				$("#side-menu").html(res.html);
			}

		});
		app.request("<?php echo base_url();?>" + "getDefaultYearMonthDetails").then(res=>{

				$(".year").val(res.year).trigger('change');
				$(".month").val(res.month).trigger('change');


		});
	});

</script>

