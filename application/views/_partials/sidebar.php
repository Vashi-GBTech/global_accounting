<?php
$user_type = $this->session->userdata('user_type');
//$user_type = 1;
?>
<style>
	.menu_list:hover{
		background-color: #f2d1767a!important;
		color: #473504 !important;
		text-shadow: 0px 1px 2px #00000055!important;
	}
	.nav{
		    font-size: 1.3rem!important;
	}
</style>
<div class="left side-menu">
	<div class="slimscroll-menu" id="remove-scroll">
		<div id="sidebar-menu">

			<ul class="metisMenu nav " id="side-menu">
				<li class="menu-title">Navigation</li>


				<?php if ($user_type == 1) { ?>
					<li class="menu_list"><a class="menu_list" href="<?php echo base_url(); ?>view_companies"><i class="fa fa-fw fa-building" style="color: #2196f3 "></i> <span>Company</span></a>
					</li>
					<li class="menu_list"><a class="menu_list" href="<?php echo base_url(); ?>ViewSubsidiary"><i class="fa fa-fw fa-sitemap" style="color:#ff5722;"></i>
							<span>Subsidiary Accounts</span></a></li>
					<li class="menu_list"><a class="menu_list" href="<?php echo base_url(); ?>SpecialSubsidiaryMapping"><i class="fa fa-fw fa-map" style="color:#ff5722;"></i>
							<span>Special Subsidiary Mapping</span></a></li>
					<li class="menu_list"><a class="menu_list" href="<?php echo base_url(); ?>Users"><i class="fa fa-fw fa-users" style="color: #673ab7 "></i>
							<span>Users</span></a></li>
					<li class="menu_list"><a class="menu_list" href="<?php echo base_url(); ?>templateTool"><i class=" fa fa-table" style="color: #009688"></i> <span>Template Spreadsheet</span></a>
					</li><li class="menu_list"><a class="menu_list" href="<?php echo base_url(); ?>template"><i class="fa fa-fw fa-credit-card" style="color: #009688"></i> <span>Template</span></a>
					</li>
					<li class="menu_list"><a class="menu_list" href="<?php echo base_url(); ?>assigntemplate"><i class="fa fa-fw fa-credit-card" style="color: #3f51b5"></i> <span>Assign Template</span></a>
					</li>

				<?php } else if ($user_type == 2) { ?>

				<?php } ?>


			</ul>
<!--			<ul class="metisMenu nav " id="">-->
<!--				<li class="menu_list"><a class="menu_list" href="--><?php //echo base_url(); ?><!--DataAnalytics"><i class="fa fa-fw fa-building" style="color: #2196f3 "></i> <span>Data Analytics</span></a>-->
<!--				</li>-->
<!--			</ul>-->
		</div>
		<div class="clearfix"></div>
	</div>
</div>


