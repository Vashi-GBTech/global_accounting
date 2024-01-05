<?php
$this->load->view('_partials/header');
?>
<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">List of doctor availabilities</h4>

						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<div class="card-header clearfix">
							<div class="card-title clearfix">
								<h4 class="m-t-0 m-b-20 header-title"><b>List of doctor availabilities</b></h4>
								<!--@if($employee_perm['role_id'] !=3)-->
								<button type="button" onclick="openaddModal()"  class="btn btn-primary"><i class="fa fa-plus"></i>Add Doctor availability</button>
								<!--@endif-->

							</div>
						</div>

						<div class="table-responsive">
							<table id="availTable" class="table table-bordered table-striped table-actions-bar">
								<thead>
								<tr>
									<th>#</th>
									<th>Name of the specialist</th>
									<th>Specialization</th>
									<th>Date</th>
									<th>Availability</th>
									<th>From time</th>
									<th>To time</th>
									<th>Location</th>
									<th>OPD</th>
									<th>Created date</th>
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
					<h3 id="myModalLabel">Doctor availability</h3>
				</div>
				<div class="modal-body">
					<form method="POST"  accept-charset="UTF-8" id="Availibilityform" enctype="multipart/form-data">
						<input name="_token" id="_token" type="hidden" value="EtUzMCvJRYr0qWONtOYYU0STaL0vgAN6uXj7xPsl">
						<div class="form-group">
							<label>Specialization</label>
							<select class="form-control span12" id="specialisation" placeholder="Doctor Specialization" name="specialisation"><option value="" selected="selected">Select one Specialization</option><option value="1">Nutritionist</option><option value="2">Surgeon</option></select>

						</div>
						<div class="form-group">
							<label>Name of the specialist</label>
							<select class="form-control span12" id="doctor" placeholder="Doctor" name="doctor"></select>

						</div>
						<div class="form-group">
							<label>Availability</label>
							<select class="form-control span12" id="availability" placeholder="Availability" name="availability"><option value="" selected="selected">Select one option</option><option value="yes">Yes</option><option value="no">No</option></select>

						</div>
						<div class="form-group">
							<label>Date (m/d/Y)</label>
							<input class="form-control span12" id="available_date" placeholder="Available date" name="available_date" type="text" value="12/06/2021">

						</div>
						<div class="form-group" id="patientiddiv">
							<label>From time</label>
							<input class="form-control span12 clockpicker" id="from_time" placeholder="From time" name="from_time" type="time" value="">


						</div>
						<div class="form-group" id="enquiryiddiv">
							<label>To time</label>
							<input class="form-control span12 clockpicker" id="to_time" placeholder="To time" name="to_time" type="time" value="">


						</div>
						<div class="form-group">
							<label>Location</label>
							<select class="form-control span12" id="location" placeholder="Location" name="location" onchange="getOPDlistfromloc()"><option value="" selected="selected">Select Location</option><option value="mumbai">mumbai</option><option value="surat">surat</option><option value="Vadodra">Vadodra</option><option value="Raipur">Raipur</option><option value="vadodara">vadodara</option></select>

						</div>
						<div class="form-group" id="pdodiv" style="display: none;">
							<label>OPD</label>
							<select class="form-control span12" id="pdo" placeholder="Pdo" name="pdo"><option value="" selected="selected">Select Opd</option><option value="2">Gamdevi DHI</option><option value="11">Outreach Burhani Hospital</option><option value="12">Outreach Optimum Diagnostics Centre</option><option value="13">Ramkrishna care</option><option value="17">Surat</option></select>

						</div>
						<div class="form-group" id="status_div" style="display: none">
							<label>Status</label>
							<select class="form-control span12" id="status" placeholder="Status" name="status"><option value="">Select one option</option><option value="active" selected="selected">Active</option><option value="inactive">Inactive</option></select>

						</div>
						<div class="clearfix"></div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="btn btn-primary pull-right" type="button" onclick="CreateDoctorAvailList()"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	$this->load->view('_partials/footer');
	?>
	<script src="<?=base_url();?>assets/js/doctor/doctor_availibility.js" type="text/javascript"></script>
</div>
