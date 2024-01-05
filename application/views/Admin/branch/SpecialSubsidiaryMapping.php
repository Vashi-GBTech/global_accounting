<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	.error{
		color:red;
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
							<h4 class="page-title">Subsidiary Accounts Details</h4>

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
				<form id="Form_mapping" method="post">
				<div class="form-group my-0 py-0">
					<label>Select Company</label>
					<select class="form-control" onchange="getSpecialSubsidiaries(this.value);getParentGlAccounts(this.value)" required="" name="dcompany_id" id="dcompany_id"  data-valid="required" data-msg="Select Company name" ><option selected="" disabled="">Select Option</option></select>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-4">
							<label>Select Subsidiary Intra Company</label>
							<input type="text" readonly id="subsidiaryIntra" name="subsidiaryIntra" class="form-control">
							<input type="hidden" id="subs1" name="subs1" class="form-control">
						</div>
						<div class="col-md-4">
							<label>Select Parent Account (BS)</label>
							<select class="form-control" id="Intra_Parent_bs" name="Intra_Parent_bs">
								<option value="">Select Intra Parent GL</option>
							</select>
						</div>
						<div class="col-md-4">
							<label>Select Parent Account (PL)</label>
							<select class="form-control" id="Intra_Parent_pl" name="Intra_Parent_pl">
								<option value="">Select Intra Parent GL</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-4">
							<label>Select Subsidiary Inter Company</label>
							<input type="text" readonly id="subsidiaryInter" name="subsidiaryInter" class="form-control">
							<input type="hidden" id="subs2" name="subs2" class="form-control">
						</div>
						<div class="col-md-4">
							<label>Select Parent Account</label>
							<select class="form-control" id="Inter_Parent_bs" name="Inter_Parent_bs">
								<option value="">Select Inter Parent GL</option>
							</select>
						</div>
						<div class="col-md-4">
							<label>Select Parent Account</label>
							<select class="form-control" id="Inter_Parent_pl" name="Inter_Parent_pl">
								<option value="">Select Inter Parent GL</option>
							</select>
						</div>
					</div>

				</div><br>
				<div class="row" >
					<div class="col-md-12">
					<button class="btn btn-primary" type="button" onclick="SaveMapping()" style="float: right;">Save</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>


</div>

<?php
$this->load->view('_partials/footer');
?>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

</div>
<script>
	$( document ).ready(function() {
		getListCompany();
	});
	function getSpecialSubsidiaries(company_id) {
		let formData = new FormData();
		formData.set("company_id", company_id);
		app.request(baseURL + "getSpecialSubsidiaries",formData).then(res=>{
			var intra=res.intra;
			var inter=res.inter;
			intraBranchname='';
			intraBranchId='';
			interBranchname='';
			interBranchId='';
			if(intra.length > 0){
				intraBranchname=intra[0];
				intraBranchId=intra[1];
			}
			if(inter.length > 0){
				interBranchname=inter[0];
				interBranchId=inter[1];
			}
			$("#subsidiaryIntra").val(intraBranchname);
			$("#subsidiaryInter").val(interBranchname);
			$("#subs1").val(intraBranchId);
			$("#subs2").val(interBranchId);

		});
	}
	function getListCompany() {
		app.request(baseURL + "getLisCompany",null).then(res=>{
			$.LoadingOverlay("hide");

			if(res.status == 200){
				if($("#dcompany_id").is("select")) {
					$("#dcompany_id").html(res.data);
				}

			}else{
				if($("#dcompany_id").is("select")) {
					$("#dcompany_id").html(res.data);
				}

			}
		});
	}
	function getParentGlAccounts(company_id) {
		let formData = new FormData();
		formData.set("company_id", company_id);
		app.request(baseURL + "getParentGlAccounts",formData).then(res=>{

			$.LoadingOverlay("hide");
			$("#Intra_Parent_bs").html(res.option);
			$("#Intra_Parent_bs").val(res.IntraGl).change();
			$("#Intra_Parent_pl").html(res.option);
			$("#Intra_Parent_pl").val(res.IntraGlPL).change();
			$("#Inter_Parent_bs").html(res.option);
			$("#Inter_Parent_bs").val(res.InterGl).change();
			$("#Inter_Parent_pl").html(res.option);
			$("#Inter_Parent_pl").val(res.InterGlPL).change();

		});
	}
	//Form_mapping
	function SaveMapping() {
	var company_id=$("#dcompany_id").val();
	var subsidiaryIntra=$("#subs1").val();
	var subsidiaryInter=$("#subs2").val();
	var Intra_ParentBS=$("#Intra_Parent_bs").val();
	var Inter_ParentBS=$("#Inter_Parent_bs").val();
	var Intra_ParentPL=$("#Intra_Parent_pl").val();
	var Inter_ParentPL=$("#Inter_Parent_pl").val();
	if(company_id == "" || subsidiaryIntra=="" || subsidiaryInter=="" || Intra_ParentBS=="" || Inter_ParentBS==""|| Intra_ParentPL=="" || Inter_ParentPL==""){
		toastr.error('All fields are compulsory !');
		return;
	}
		let formData = new FormData();
		formData.set("company_id", company_id);
		formData.set("subsidiaryIntra", subsidiaryIntra);
		formData.set("subsidiaryInter", subsidiaryInter);
		formData.set("Intra_ParentBS", Intra_ParentBS);
		formData.set("Inter_ParentBS", Inter_ParentBS);
		formData.set("Intra_ParentPL", Intra_ParentPL);
		formData.set("Inter_ParentPL", Inter_ParentPL);
		app.request(baseURL + "SaveMapping",formData).then(res=>{
			if(res.status == 200){
				toastr.success('Added Successfully!');
			}else{
				toastr.error('Something Went Wrong!');
			}
		});
	}
</script>
