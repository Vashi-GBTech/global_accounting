<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	#sortable1 {
		border: none;
		display: grid;
		grid-template-columns: auto auto auto;
		align-content: flex-start;
	}
	.ignorelist {
		height: 748px;
		/*padding: 5px;*/
		border: 1px solid #80808036;
		margin-left: 5px;
		border-radius: 5px;
		color: #000000d6;
	}

	.parent {
		border: none;
		display: flex;
		flex-wrap: wrap;
	}

	.hidden {
		display: none !important;
	}

	#sortable1, #sortable2, #sortable3, #sortable4 {
		border-radius: 5px;
	}

	#sortable1 li, #sortable2 li, #sortable3 li, #sortable4 li, {
		cursor: move;
	}

	.selected {
		background: #F2D176 !important;
	}

	.card1,.card3{
		padding: 5px;
	}

	.card2 {
		padding: 5px;
		padding-left: 22px;
		padding-right: 22px;
	}
	.child_list {
		padding: 5px;
		border: 1px solid #80808036;
		margin: 5px;
		border-radius: 5px;
		/*width: 30%;*/
		height: auto;
		color: #000000d6;
		font-size: 12px;
	}
	.childlist {
		width: auto!important;
	}

	.parent_list {
		flex: 1;
		padding: 5px;
		border: 1px solid #80808036;
		margin: 5px;
		border-radius: 5px;
	}
	#parentDiv{
		height: 748px;
		width: 100%;
		scrollbar-width: thin;
		overflow-y: auto;
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
	.card-box
	{
		background-color: #f8f8f8;
	}
	.divBox
	{
		overflow: auto;
		padding-top: 10px;
		box-shadow: 0px 1px 3px 0px #dfd6d6;
		background-color: white;
	}
	.divPad
	{
		padding-top: 30px!important;
	}
	.col_type1
	{
		/*height: 270px!important;*/
	}
	.col_type01
	{
		height: 50px!important;
		background-color: #f0f0f0;
	}

	.main_child_div
	{
		padding: 0px 5px 0px 5px;
		margin-top: -5px;
	}
	#contentSub label
	{
		font-size: 12px!important;
	}

</style>
<div class="content-page" id="contentSub">
	<div class="content">
		<div class="card-box">
			<div class="row">
				<div class="col-md-12 divBox">
					<div class="col-md-3">
						<a href="<?php echo base_url();?>MainSetup" class="btn btn-primary roundCornerBtn4"><i class="fa fa-arrow-left"></i>Back</span></a>
					</div>
					<div class="col-md-6">
					</div>
					<div class="col-md-3">
							<div class="form-group">
								<select name="type0" onchange="getType0()" id="type0" class="form-control">
									<option value="1">Balance Sheet</option>
									<option value="2">Profit & loss</option>
								</select>
							</div>
					</div>
				</div>
				<div class="col-md-12 m-t-10 p-0">
					<div class="col-md-4 card1">
						<div class="row divBox">
							<div class="col-md-12" >
								<label style="">Subsidiary Accounts</label>
								<div style="min-height: 77vh;border: 1px solid #80808036;">
									<div id="sortable1" class="droptrue child p-0 ui-sortable m-b-10" style="border-radius: 5px;min-height: 300px;">
									</div>

								</div>

							</div>
						</div>
					</div>
					<div class="col-md-8 card2">
						<div class="row divBox divPad">
							<div class="col-md-12" id="parentDiv" style="">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('_partials/footer'); ?>
<script>
	$(document).ready(function () {
		getAllData();
	});
	function minimize(id) {
		$('.parent' + id).slideToggle();
	}

	function updateBranchId(parent, child) {
		$.LoadingOverlay("show");
		const urlParams = new URLSearchParams(window.location.search);
		const id = urlParams.get('id');
		let formData = new FormData();
		formData.set('id',id)
		formData.set('type',$('#type0').val());
		formData.set('group_id', parent);
		formData.set('main_id', JSON.stringify(child));
		app.request(baseURL + "UpdateMainGroupMap", formData).then(res => {
			if (res.status == 200) {
				$.LoadingOverlay("hide");
			} else {
				$.LoadingOverlay("hide");
				alert('Something Went Wrong');
			}
		});
	}

	function getAllData() {
		const urlParams = new URLSearchParams(window.location.search);
		const id = urlParams.get('id');
		let formData = new FormData();
		formData.set('id',id);
		formData.set('type',$('#type0').val());
		app.request(baseURL + "getMainMapData", formData).then(res => {
			if (res.status == 200) {
				$('#sortable1').html("");
				$('#parentDiv').html("");

				var main_data = res.GroupDiv;
				var branch_data = res.MainDiv;
				var branch_data = res.MainDiv;


				$('#sortable1').append(branch_data);
				$('#parentDiv').append(main_data);
				loadSortable();

			} else {
				$('#sortable1').html("");
				$('#parentDiv').html("");
				alert('No Data Found');
			}
		});
	}

	function getType0()
	{
		getAllData();
	}

	function loadSortable () {
		$('.droptrue').on('click', 'div', function () {
			$(this).toggleClass('selected');
		});

		$("div.droptrue").sortable({
			connectWith: 'div.droptrue',
			opacity: 0.6,
			scroll: false,
			appendTo: 'body',
			helper: function (e, item) {
				if (!item.hasClass('selected'))
					item.addClass('selected');
				item.addClass('childlist');
				var elements = $('.selected').not('.ui-sortable-placeholder').clone();
				var helper = $('<div/>');
				return helper.append(elements);
			},
			start: function (e, ui) {
				var elements = ui.item.siblings('.selected').not('.ui-sortable-placeholder');
				ui.item.data('items', elements);
			},
			receive: function (e, ui) {
				ui.item.before(ui.item.data('items'));
				var dataArray1 = $(this).sortable("toArray");
				// console.log(e.target.id);
				// console.log(dataArray1);
				updateBranchId(e.target.id, dataArray1);
			},
			stop: function (e, ui) {
				$('.selected').removeClass('selected');
			},
			update: function (e, ui) {
				// var dataArray1 = $(this).sortable("toArray");
				// updateBranchId(e.target.id, dataArray1);
			}
		});
	}

</script>

</div>
