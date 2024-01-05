
<script src="<?=base_url();?>assets/dh/js/jquery.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/js/metisMenu.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/js/waves.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/js/jquery.slimscroll.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/waypoints/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/moment/moment.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/fullcalendar/js/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/plugins/select2/js/select2.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/js/jquery.datepick.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/js/jquery.sumoselect.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/js/jquery.simple-dtpicker.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/js/daterangepicker.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/js/bootstrap-clockpicker.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/pages/jquery.calendar.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/pages/jquery.dashboard.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/js/jquery.core.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/dh/js/jquery.app.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function() {
		var match = document.cookie.match(new RegExp('color=([^;]+)'));
		if(match) var color = match[1];
		if(color) {
			$('body').removeClass(function (index, css) {
				return (css.match (/\btheme-\S+/g) || []).join(' ')
			})
			$('body').addClass('theme-' + color);
		}

		$('[data-popover="true"]').popover({html: true});

	});

</script>

<script type="text/javascript">
	$(function() {
		var uls = $('.sidebar-nav > ul > *').clone();
		uls.addClass('visible-xs');
		$('#main-menu').append(uls.clone());
	});
</script>
