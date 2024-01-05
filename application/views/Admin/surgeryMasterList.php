<?php
$this->load->view('_partials/header');
?>
<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">Surgeries</h4>

						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<div class="card-header clearfix">
							<div class="card-title clearfix">
								<h4 class="m-t-0 m-b-20 header-title"><b>Surgeries</b></h4>
								<button type="button" onclick="openaddModal()" class="btn btn-primary"><i class="fa fa-plus"></i> New surgery</button>

							</div>
						</div><br>

						<div class="table-responsive">
							<table id="SurgeryMasterTable" class="table table-bordered table-striped table-actions-bar">
								<thead>
								<tr>
									<th>#</th>
									<th>Surgery name</th>
									<th>Status</th>
									<th>Created on</th>
									<th>Action</th>
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
	</div>

	<div class="modal small fade" id="Mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
					<h3 id="myModalLabel">Add Hospital</h3>
				</div>
				<div class="modal-body">
					<form method="POST" id="addsurgerymasterForm" accept-charset="UTF-8" enctype="multipart/form-data">
						<input name="_token" id="_token" type="hidden" value="">
						<div class="form-group">
							<label>Surgery name</label>
							<input class="form-control span12" id="surgery_name" placeholder="Surgery name" name="surgery_name" type="text" value="">

						</div>
						<div class="form-group">
							<label>Status</label>
							<select class="form-control " id="status" placeholder="Status" name="status" tabindex="-1" aria-hidden="true">
								<option value="" selected="selected">Select Status</option><option value="active">Active</option><option value="Inactive">Inactive</option></select>

						</div>

						<div class="clearfix"></div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="btn btn-primary pull-right" type="button"  onclick="CreateSurgery()"><i class="fa fa-save"></i>Save</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	$this->load->view('_partials/footer');
	?>
	<script src="<?=base_url();?>assets/js/surgery/surgery.js" type="text/javascript"></script>
</div>
