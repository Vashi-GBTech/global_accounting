<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	#sortable1 {
		display: flex;
		border: none;
	}
	.droptrue {
		border: 1px solid black;
	}

	#sortable1, #sortable2, #sortable3, #sortable4,#sortable5 {
		border-radius: 5px;
		overflow-y: scroll;
	}
	#sortable1 li, #sortable2 li, #sortable3 li, #sortable4 li, #sortable5 li {
		cursor: move;
	}
	.selected {
		background:#F2D176 !important;
	}
	.hidden {
		display:none !important;
	}


</style>
<div class="content-page">
	<div class="content">
		<div class="card">
			<div class="card-body">
				<div class="row" style="padding: 10px 5px 10px 5px">
					<div class="col-md-12">
						<ul id="sortable1" class="droptrue p-0 d-flex flex-wrap">
							<li id="1" class="list-group-item">Subsidiary Account 01</li>
							<li id="2" class="list-group-item">Subsidiary Account 02</li>
							<li id="3" class="list-group-item">Subsidiary Account 03</li>
							<li id="4" class="list-group-item">Subsidiary Account 04</li>
							<li id="5" class="list-group-item">Subsidiary Account 05</li>
							<li id="6" class="list-group-item">Subsidiary Account 06</li>
							<li id="7" class="list-group-item">Subsidiary Account 07</li>
							<li id="8" class="list-group-item">Subsidiary Account 08</li>
							<li id="9" class="list-group-item">Subsidiary Account 09</li>
							<li id="10" class="list-group-item">Subsidiary Account 10</li>

						</ul>

					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-3">
						<div class="form-group">
							<label>Parent 01</label>
							<ul id="sortable2" style="height: 200px" class='droptrue p-0 d-flex flex-wrap'></ul>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Parent 02</label>
							<ul id="sortable3" style="height: 200px" class='droptrue p-0 d-flex flex-wrap'></ul>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Parent 03</label>
							<ul id="sortable4" style="height: 200px" class='droptrue p-0 d-flex flex-wrap'></ul>
						</div>

					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Parent 04</label>
							<ul id="sortable5" style="height: 200px" class='droptrue p-0  d-flex flex-wrap'></ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('_partials/footer'); ?>
<script>
	$(function () {
		$('.droptrue').on('click', 'li', function () {
			$(this).toggleClass('selected');
		});

		$("ul.droptrue").sortable({
			connectWith: 'ul.droptrue',
			opacity: 0.6,
			revert: true,
			helper: function (e, item) {
				console.log('parent-helper');
				console.log(item);
				if(!item.hasClass('selected'))
					item.addClass('selected');
				var elements = $('.selected').not('.ui-sortable-placeholder').clone();
				var helper = $('<ul/>');
				item.siblings('.selected').addClass('hidden');
				return helper.append(elements);
			},
			start: function (e, ui) {
				var elements = ui.item.siblings('.selected.hidden').not('.ui-sortable-placeholder');
				ui.item.data('items', elements);
			},
			receive: function (e, ui) {
				ui.item.before(ui.item.data('items'));
			},
			stop: function (e, ui) {
				ui.item.siblings('.selected').removeClass('hidden');
				$('.selected').removeClass('selected');
			},
			update: function(){
				updatePostOrder();
				updateAdd();
			}
		});


		$("#sortable1, #sortable2, #sortable3").disableSelection();
		$("#sortable1, #sortable2, #sortable3").css('minHeight', $("#sortable1, #sortable2").height() + "px");
	});

	$('[data-search]').on('keyup', function() {
		var searchVal = $(this).val();
		var filterItems = $('[data-filter-item]');

		if ( searchVal != '' ) {
			filterItems.addClass('hidden');
			$('[data-filter-item][data-filter-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
		} else {
			filterItems.removeClass('hidden');
		}
	});


	function updatePostOrder() {
		var arr = [];
		$("#sortable2 li").each(function () {
			arr.push($(this).attr('id'));
		});
		$('#postOrder').val(arr.join(','));
	}


	function updateAdd() {
		var arr = [];
		$("#sortable3 li").each(function () {
			arr.push($(this).attr('id'));
		});
		$('#add').val(arr.join(','));
	}

</script>
</div>
