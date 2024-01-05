<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<meta name="google-signin-client_id" content="960428125912-jbu9ucmurj48710nrv6bjo3e42rmiivi.apps.googleusercontent.com">
<style>
	.error {
		color: red;
	}

	.company {
		font-size: 25px;
		color: #d09b09;
		font-family: 'Nunito Sans', sans-serif;
	}

	.table > tbody > tr > td {
		border-top: none;
	}

	.card2 {
		border-radius: 10px;
		font-size: 13px;
		overflow-x: auto;
		scrollbar-gutter: stable;
	}

	.table th {
		color: #666f7b;
		font-family: 'Nunito Sans', sans-serif;
	}

	.table td {
		font-family: "Nunito Sans", sans-Serif;
	}

	table.dataTable thead th{
		border-bottom: 2px solid #ddd;
	}
	table.dataTable.no-footer{
		border:none;
	}

	.parent{
		border-radius: 10px;
	}

	.child_title {
		text-align: center;
		color: #80808080;
	}
	.child_box{
		border-left: none;
		border-top: none;
		border-bottom: none;
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
	<div class="row" style="margin-top: -30px">
		<div class="col-lg-12">
			<div class="card-box m-0" style="padding:0 21px 21px 21px;border: none;background-color: transparent;">
				<div class="row">
					<div class="col-md-12">
						<div class="card-box m-0" style="border:none;background-color: transparent">
							<div class="row" style="margin-bottom: -30px">
								<div class="card-box parent">
									<div class="card-title">
									<label class="company card-tile"><?=$name?></label>
									</div>
									<!--<div class="g-signin2" data-onsuccess="login"></div>
									<a href="#" onclick="signOut();">Sign out</a>-->
									<div class="row">
										<div class="col-md-12">

											<div class="col-md-4 p-0">
												<div class="card-box m-0 child_box">
													<label class="child_title">Financial Year</label>
													<h3><?=$start?>
													</h3>
												</div>
											</div>
											<div class="col-md-4 p-0">
												<div class="card-box m-0 child_box">
													<label class="child_title">Last Consolidated Month</label>
													<h3><?=$consolidate_month." ".$consolidate_year?></h3>
												</div>
											</div>
											<div class="col-md-4 p-0">
												<div class="card-box m-0 child_box" style="border-right: none">
													<label class="child_title">Total Subsidiary Accounts</label>
													<h3><?=$total?></h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1471.561" height="361.085" viewBox="0 0 1471.561 361.085" style="width: 100%">
							<defs>
								<filter id="Chart.BG" x="386" y="16.085" width="571" height="345" filterUnits="userSpaceOnUse">
									<feOffset dy="2" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="3" result="blur"/>
									<feFlood flood-opacity="0.039"/>
									<feComposite operator="in" in2="blur"/>
									<feComposite in="SourceGraphic"/>
								</filter>
								<clipPath id="clip-path">
									<rect width="509" height="183" fill="none"/>
								</clipPath>
								<clipPath id="clip-path-2">
									<rect width="443" height="14" fill="none"/>
								</clipPath>
								<filter id="Selectbox.BG" x="813.5" y="40.585" width="119" height="41" filterUnits="userSpaceOnUse">
									<feOffset dy="2" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="1.5" result="blur-2"/>
									<feFlood flood-opacity="0.051"/>
									<feComposite operator="in" in2="blur-2"/>
									<feComposite in="SourceGraphic"/>
								</filter>
								<filter id="BG" x="0" y="16.085" width="388" height="345" filterUnits="userSpaceOnUse">
									<feOffset dy="2" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="3" result="blur-3"/>
									<feFlood flood-opacity="0.039"/>
									<feComposite operator="in" in2="blur-3"/>
									<feComposite in="SourceGraphic"/>
								</filter>
								<clipPath id="clip-path-3">
									<path id="Path_259" data-name="Path 259" d="M71,0A71,71,0,0,1,0-71a71,71,0,0,1,71-71,71,71,0,0,1,71,71A71,71,0,0,1,71,0Zm0-10a61,61,0,0,0,61-61,61,61,0,0,0-61-61A61,61,0,0,0,10-71,61,61,0,0,0,71-10Z" transform="translate(0 142)" fill="none" clip-rule="evenodd"/>
								</clipPath>
								<clipPath id="clip-path-4">
									<path id="Path_258" data-name="Path 258" d="M-347,369H693V-534H-347Z" transform="translate(347 534)" fill="none"/>
								</clipPath>
								<clipPath id="clip-path-5">
									<rect id="Rectangle_136" data-name="Rectangle 136" width="144" height="144" transform="translate(0 0.417)" fill="none"/>
								</clipPath>
								<filter id="variable_1" x="983.324" y="0.782" width="138" height="97" filterUnits="userSpaceOnUse">
									<feOffset dy="3" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="13" result="blur-4"/>
									<feFlood flood-opacity="0.11"/>
									<feComposite operator="in" in2="blur-4"/>
									<feComposite in="SourceGraphic"/>
								</filter>
								<filter id="variable_1-2" x="1318.146" y="160.702" width="135" height="97" filterUnits="userSpaceOnUse">
									<feOffset dy="3" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="13" result="blur-5"/>
									<feFlood flood-opacity="0.11"/>
									<feComposite operator="in" in2="blur-5"/>
									<feComposite in="SourceGraphic"/>
								</filter>
								<filter id="variable_2" x="1124.531" y="0" width="198" height="97" filterUnits="userSpaceOnUse">
									<feOffset dy="3" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="13" result="blur-6"/>
									<feFlood flood-opacity="0.11"/>
									<feComposite operator="in" in2="blur-6"/>
									<feComposite in="SourceGraphic"/>
								</filter>
								<filter id="variable_2-2" x="1140.844" y="171.04" width="124" height="97" filterUnits="userSpaceOnUse">
									<feOffset dy="3" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="13" result="blur-7"/>
									<feFlood flood-opacity="0.11"/>
									<feComposite operator="in" in2="blur-7"/>
									<feComposite in="SourceGraphic"/>
								</filter>
								<filter id="variable_3" x="1297.215" y="0" width="168" height="97" filterUnits="userSpaceOnUse">
									<feOffset dy="3" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="13" result="blur-8"/>
									<feFlood flood-opacity="0.11"/>
									<feComposite operator="in" in2="blur-8"/>
									<feComposite in="SourceGraphic"/>
								</filter>
								<filter id="variable_3-2" x="984.775" y="171.04" width="135" height="97" filterUnits="userSpaceOnUse">
									<feOffset dy="3" input="SourceAlpha"/>
									<feGaussianBlur stdDeviation="13" result="blur-9"/>
									<feFlood flood-opacity="0.11"/>
									<feComposite operator="in" in2="blur-9"/>
									<feComposite in="SourceGraphic"/>
								</filter>
							</defs>
							<g id="Bar_Chart" data-name="Bar Chart" transform="translate(180.139 -134.915)">
								<g transform="matrix(1, 0, 0, 1, -180.14, 134.91)" filter="url(#Chart.BG)">
									<rect id="Chart.BG-2" data-name="Chart.BG" width="553" height="327" transform="translate(395 23.09)" fill="#fff"/>
								</g>
								<g id="line" transform="translate(234.861 250)" clip-path="url(#clip-path)">
									<g id="line-2" data-name="line" transform="translate(-235 -447)">
										<text id="_100K" data-name="100K" transform="translate(744 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">100K</tspan></text>
										<rect id="Rectangle_132" data-name="Rectangle 132" width="462" height="1" transform="translate(269 454)" fill="#eaf0f4"/>
										<text id="_30k" data-name="$30k" transform="translate(257 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="-23.257" y="0">$30k</tspan></text>
									</g>
									<g id="line-3" data-name="line" transform="translate(-235 -406)">
										<text id="_80K" data-name="80K" transform="translate(744 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">80K</tspan></text>
										<rect id="Rectangle_132-2" data-name="Rectangle 132" width="462" height="1" transform="translate(269 454)" fill="#eaf0f4"/>
										<text id="_25k" data-name="$25k" transform="translate(257 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="-23.257" y="0">$25k</tspan></text>
									</g>
									<g id="line-4" data-name="line" transform="translate(-235 -365)">
										<text id="_60K" data-name="60K" transform="translate(744 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">60K</tspan></text>
										<rect id="Rectangle_132-3" data-name="Rectangle 132" width="462" height="1" transform="translate(269 454)" fill="#eaf0f4"/>
										<text id="_20k" data-name="$20k" transform="translate(257 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="-23.257" y="0">$20k</tspan></text>
									</g>
									<g id="line-5" data-name="line" transform="translate(-235 -324)">
										<text id="_40K" data-name="40K" transform="translate(744 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">40K</tspan></text>
										<rect id="Rectangle_132-4" data-name="Rectangle 132" width="462" height="1" transform="translate(269 454)" fill="#eaf0f4"/>
										<text id="_15k" data-name="$15k" transform="translate(257 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="-23.257" y="0">$15k</tspan></text>
									</g>
									<g id="line-6" data-name="line" transform="translate(-235 -283)">
										<text id="_20K-2" data-name="20K" transform="translate(744 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">20K</tspan></text>
										<rect id="Rectangle_132-5" data-name="Rectangle 132" width="462" height="1" transform="translate(269 454)" fill="#eaf0f4"/>
										<text id="_10k" data-name="$10k" transform="translate(257 458)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="-23.257" y="0">$10k</tspan></text>
									</g>
								</g>
								<g id="days" transform="translate(272.861 433)" clip-path="url(#clip-path-2)">
									<g id="days-2" data-name="days" transform="translate(-335 -567)">
										<text id="Mon" transform="translate(335 578)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Mon</tspan></text>
									</g>
									<g id="days-3" data-name="days" transform="translate(-262 -567)">
										<text id="Tue" transform="translate(335 578)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Tue</tspan></text>
									</g>
									<g id="days-4" data-name="days" transform="translate(-189 -567)">
										<text id="Wed" transform="translate(335 578)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Wed</tspan></text>
									</g>
									<g id="days-5" data-name="days" transform="translate(-116 -567)">
										<text id="Thu" transform="translate(335 578)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Thu</tspan></text>
									</g>
									<g id="days-6" data-name="days" transform="translate(-43 -567)">
										<text id="Fri" transform="translate(335 578)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Fri</tspan></text>
									</g>
									<g id="days-7" data-name="days" transform="translate(30 -567)">
										<text id="Sat" transform="translate(335 578)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Sat</tspan></text>
									</g>
									<g id="days-8" data-name="days" transform="translate(103 -567)">
										<text id="Sun" transform="translate(335 578)" fill="#43425d" font-size="11" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Sun</tspan></text>
									</g>
								</g>
								<g id="Chart.Content" transform="translate(269 293.275)">
									<g id="Sun-2" data-name="Sun" transform="translate(419.861 30)">
										<path id="Blue.Bar_Visits_" data-name="Blue.Bar (Visits)" d="M3,0H3A3,3,0,0,1,6,3V106a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(10 -0.275)" fill="#56d9fe"/>
										<path id="Purple.Bar_Items_" data-name="Purple.Bar (Items)" d="M3,0H3A3,3,0,0,1,6,3V77a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(0 28.725)" fill="#a4a1fb"/>
									</g>
									<g id="Sat-2" data-name="Sat" transform="translate(346.861)">
										<path id="Blue.Bar_Visits_2" data-name="Blue.Bar (Visits)" d="M3,0H3A3,3,0,0,1,6,3V136a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(10 -0.275)" fill="#56d9fe"/>
										<path id="Purple.Bar_Items_2" data-name="Purple.Bar (Items)" d="M3,0H3A3,3,0,0,1,6,3V97a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(0 38.725)" fill="#a4a1fb"/>
									</g>
									<g id="Fri-2" data-name="Fri" transform="translate(279.587 68)">
										<path id="Blue.Bar_Visits_3" data-name="Blue.Bar (Visits)" d="M3,0H3A3,3,0,0,1,6,3V68a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(10.273 -0.275)" fill="#56d9fe"/>
										<path id="Purple.Bar_Items_3" data-name="Purple.Bar (Items)" d="M3,0H3A3,3,0,0,1,6,3V58a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(0.273 9.725)" fill="#a4a1fb"/>
									</g>
									<g id="Thu-2" data-name="Thu" transform="translate(210.411 79)">
										<path id="Blue.Bar_Visits_4" data-name="Blue.Bar (Visits)" d="M3,0H3A3,3,0,0,1,6,3V26a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(10.451 30.725)" fill="#56d9fe"/>
										<path id="Purple.Bar_Items_4" data-name="Purple.Bar (Items)" d="M3,0H3A3,3,0,0,1,6,3V57a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(0.451 -0.275)" fill="#a4a1fb"/>
									</g>
									<g id="Wed-2" data-name="Wed" transform="translate(140.274 66)">
										<path id="Blue.Bar_Visits_5" data-name="Blue.Bar (Visits)" d="M3,0H3A3,3,0,0,1,6,3V70a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(9.587 -0.275)" fill="#56d9fe"/>
										<path id="Purple.Bar_Items_5" data-name="Purple.Bar (Items)" d="M3,0H3A3,3,0,0,1,6,3V57a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(-0.413 12.725)" fill="#a4a1fb"/>
									</g>
									<g id="Tue-2" data-name="Tue" transform="translate(73 62)">
										<path id="Blue.Bar_Visits_6" data-name="Blue.Bar (Visits)" d="M3,0H3A3,3,0,0,1,6,3V74a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(9.861 -0.275)" fill="#56d9fe"/>
										<path id="Purple.Bar_Items_6" data-name="Purple.Bar (Items)" d="M3,0H3A3,3,0,0,1,6,3V53.71a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(0 20.29)" fill="#a4a1fb"/>
									</g>
									<g id="Mon-2" data-name="Mon" transform="translate(0 30)">
										<path id="Blue.Bar_Visits_7" data-name="Blue.Bar (Visits)" d="M3,0H3A3,3,0,0,1,6,3V106a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(9.861 -0.275)" fill="#56d9fe"/>
										<path id="Purple.Bar_Items_7" data-name="Purple.Bar (Items)" d="M3,0H3A3,3,0,0,1,6,3V77a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(-0.139 28.725)" fill="#a4a1fb"/>
									</g>
								</g>
								<g id="Legend" transform="translate(356.706 228.323)">
									<g id="Items">
										<g id="Purple.Ellipse" transform="translate(0.156 1.677)" fill="#fff" stroke="#a4a1fb" stroke-width="3">
											<circle cx="7" cy="7" r="7" stroke="none"/>
											<circle cx="7" cy="7" r="5.5" fill="none"/>
										</g>
										<text id="Germany" transform="translate(22.156 13.677)" fill="#4d4f5c" font-size="13" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Germany</tspan></text>
									</g>
									<g id="Visits" transform="translate(107)">
										<g id="Blue.Ellipse" transform="translate(0.156 1.677)" fill="#fff" stroke="#56d9fe" stroke-width="3">
											<circle cx="7" cy="7" r="7" stroke="none"/>
											<circle cx="7" cy="7" r="5.5" fill="none"/>
										</g>
										<text id="France" transform="translate(22.156 13.677)" fill="#4d4f5c" font-size="13" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">France</tspan></text>
									</g>
								</g>
								<text id="Income_and_Expenses" data-name="Income and Expenses" transform="translate(234.861 196)" fill="#4d4f5c" font-size="18" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Income and Expenses</tspan></text>
								<g id="Selectbox.Filter" transform="translate(637.861 178)">
									<g transform="matrix(1, 0, 0, 1, -818, -43.09)" filter="url(#Selectbox.BG)">
										<g id="Selectbox.BG-2" data-name="Selectbox.BG" transform="translate(818 43.09)" fill="#fff" stroke="#d7dae2" stroke-width="1">
											<rect width="110" height="32" rx="4" stroke="none"/>
											<rect x="0.5" y="0.5" width="109" height="31" rx="3.5" fill="none"/>
										</g>
									</g>
									<text id="Germany-2" data-name="Germany" transform="translate(12 21)" fill="#4d565c" font-size="13" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Germany</tspan></text>
									<g id="small-down" transform="translate(87 13)">
										<path id="Path_26" data-name="Path 26" d="M8.1,11.6,2.6,6.041,4.026,4.6,8.1,8.718,12.174,4.6,13.6,6.041Z" transform="translate(-2.6 -4.6)" fill="#a4afb7"/>
									</g>
								</g>
							</g>
							<g id="Pie_Chart_Percentage_" data-name="Pie Chart (Percentage)" transform="translate(-206 -516.915)">
								<g transform="matrix(1, 0, 0, 1, 206, 516.91)" filter="url(#BG)">
									<rect id="BG-2" data-name="BG" width="370" height="327" transform="translate(9 23.09)" fill="#fff"/>
								</g>
								<text id="Show_More_Link" data-name="Show More Link" transform="translate(356 843)" fill="#fecb2e" font-size="13" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">View Full Report</tspan></text>
								<rect id="Divider" width="330" height="1" transform="translate(235 796)" fill="#e8e9ec"/>
								<g id="Pie_Chart" data-name="Pie Chart" transform="translate(329 617.908)">
									<g id="Pie_Chart-2" data-name="Pie Chart" clip-path="url(#clip-path-3)">
										<g id="Group_208" data-name="Group 208" transform="translate(-347 -392)" clip-path="url(#clip-path-4)">
											<g id="Group_207" data-name="Group 207" transform="translate(346 390.675)">
												<g id="Group_206" data-name="Group 206" clip-path="url(#clip-path-5)">
													<image id="Rectangle_135" data-name="Rectangle 135" width="144" height="144" transform="translate(0 0.417)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJAAAACQCAYAAADnRuK4AAAAAXNSR0IArs4c6QAABQVJREFUeAHt3U1v1DAQxvGWHgqq1Ftprz2ABNdVOYFAhRN8XvhU8BF4C/Qt23XWjmfsmfGfC5t1YjvP/DQt2rQc/vj+6/eB0T/fvv40ujO2dZvAk9sX/E0CaxIwDej9B9PbW5N3uGtMV+jk5DBc4NFuyDSgKezNxvwWo5kouh/z1Tm/oAsVVbTxyeYBTXm8eAmixi6yl/MB6IWLbWaHHulEN5U5v4gUe5x7cQNoszmKk3qgO3EDaMr86bNAyQe5FVeArq/pQtbcuQJkLTz2c3DgDtDnL3QhS3DdAbIUHntx2IGmotGF7NClA9mphcuduAVEF7LhzS0gG/GxC9eAPn5yvf0Q+lxX4PiYT+l7K3QNaAqPB876EnIPiAfOAFSdwOUlX8qqQ1w5gfsONN33q9chbmNlCfteFib509O+QY66ehhAb9/xIWsPxGEA9QiPNZ1+mJoqHB9vpJLRe58OpJftEDOHA0QXaus2HKC28bFaSEB0oXawQwJqFx8rhQVEF2qDOyygNvGxSmhAdCF94KEB6cfHCuEB8cCZLvLwgHjgDEDVCfC7haojTE4QvgNNd87vFkrWv3pgCEDVKTFBMoFhAPFP+qSBqoFhAFWlxMXJBIYCRBdKOlg9MBSg1SlxYTKB4QDRhZIWVg0MB2hVSlyUTGBIQHShpIfigSEBFafEBckEhgVEF0qaKBoYFlBRSpycTGBoQHShpIvsgaEBZafEickEhgfEA2dJG1kDwwPigbMsJ8mThgeUTIaBrAQA9DcmvpnOsrLzJADtjIU3cxMA0E1SdKFcMvPzADTPg6PCBAD0IDC60IMwMl8CKDMoTtudAIC2cqELbQWy5xBAewJieDkBAO3Ihy60I5TEWwBKBMPbeQkAKJETXSgRzNbbANoKhMOyBAC0kBddaCGcmyEA7c+IMxYSANBCOAztTwBAezLiy9hyQABazuffKIjSIQEonc1sBESzOO4OAHQXxf4XIHqcEYAeZ7L4Dojm8QBonkfWEYjuYwLQfRZFr0D0Py4AFbGZnwyiYP/p7ry8bY5GR0QHEnA2MiIACQCaphgVEYCEAI2KCECCgEZEBCBhQKMhApACoJEQAUgJ0CiIAKQIaAREAFIGFB0RgBoAiowIQI0ARUUEoIaAIiICUGNA0RABqAOgSIgA1AlQFEQA6ggoAiIAdQbkHRGADACatnD23MhGCrcBoMLAtE6/ujrSmlp1XgCpxls2ucenGgFUVmP1s70hApA6ifIFPCECUHl9m1zhBRGAmnBYt4gHRABaV9tmV1lHBKBmFNYvZBkRgNbXtemVVhEBqCmDusUsIgJQXU2bX20NEYCaE6hf0BIiANXXs8sMVhABqEv5ZRa1gAhAMrXsNktvRADqVnq5hXsiApBcHbvO1AsRgLqWXXbxHogAJFvD7rO1RgSg7iWX30BLRACSr5+JGVshApCJcutsogUiAOnUzsys2ogAZKbUehvRRAQgvbqZmlkLEYBMlVl3M1dv5MstP6NuBsxekcDZ2aH4j1ADqKIgHi+V/hFqAHlUULlnye+HAFRZDK+XSyECkFcBAvuWQAQggUJ4nqIWEYA8V19o7zWIACRUBO/TrEUEIO+VF9z/GkQAEixAhKlKEQEoQtWF76EEEYCEw48yXS4iAEWpuMJ95CACkELwkabchwhAkaqtdC9LiACkFHq0aVOIABSt0or3swsRgBQDjzj1NqI/2UVD7uFBspQAAAAASUVORK5CYII="/>
												</g>
											</g>
										</g>
									</g>
									<text id="_48_" data-name="48%" transform="translate(71 71.092)" fill="#4d4f5c" font-size="18" font-family="SegoeUI, Segoe UI"><tspan x="-17.068" y="0">48%</tspan></text>
								</g>
								<g id="Total_Budget" data-name="Total Budget" transform="translate(235 606.048)">
									<text id="_50_000" data-name="$50,000" transform="translate(330 15.952)" fill="#4ad991" font-size="15" font-family="SegoeUIBlack, Segoe UI"><tspan x="-58.718" y="0">$50,000</tspan></text>
									<text id="Total_Budget-2" data-name="Total Budget" transform="translate(0 15.952)" fill="#43425d" font-size="15" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Total Budget</tspan></text>
								</g>
								<text id="_of_Income_Budget" data-name="% of Income Budget" transform="translate(235 579)" fill="#4d4f5c" font-size="18" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">% of Income Budget</tspan></text>
							</g>
							<g id="Countries_overview" data-name="Countries overview" transform="translate(948 19.085)">
								<rect id="Rectangle" width="499.561" height="327" transform="translate(24 4)" fill="#fff"/>
								<g id="Group_19" data-name="Group 19" transform="translate(42.74 17.696)">
									<path id="Path_3" data-name="Path 3" d="M0,14.567l21.682-8.54L42.951,10.3,61.493,0l17.9,10.3,24.776,4.27,20.06-4.27" transform="translate(0 85.451)" fill="none" stroke="#00e38c" stroke-miterlimit="10" stroke-width="1.5"/>
									<text id="_475" data-name="475" transform="translate(49.47 57.769)" fill="#002257" font-size="26" font-family="Lato-Bold, Lato" font-weight="700" letter-spacing="0.007em"><tspan x="-22.799" y="0">475</tspan></text>
									<g transform="matrix(1, 0, 0, 1, -990.74, -36.78)" filter="url(#variable_1)">
										<text id="variable_1-3" data-name="variable 1" transform="translate(1022.32 51.78)" fill="#495172" font-size="14" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Net Profit</tspan></text>
									</g>
									<path id="Polygon_3" data-name="Polygon 3" d="M6.546,0l6.546,6.931H0Z" transform="translate(80.186 44.99)" fill="#00e38c"/>
								</g>
								<g id="Group_16" data-name="Group 16" transform="translate(371.413 177.617)">
									<path id="Path_3-2" data-name="Path 3" d="M0,14.567l21.682-8.54L42.951,10.3,61.493,0l17.9,10.3,24.776,4.27,20.06-4.27" transform="translate(0 85.451)" fill="none" stroke="#00e38c" stroke-miterlimit="10" stroke-width="1.5"/>
									<text id="_475-2" data-name="475" transform="translate(49.47 57.769)" fill="#002257" font-size="26" font-family="Lato-Bold, Lato" font-weight="700" letter-spacing="0.007em"><tspan x="-22.799" y="0">475</tspan></text>
									<g transform="matrix(1, 0, 0, 1, -1319.41, -196.7)" filter="url(#variable_1-2)">
										<text id="variable_1-4" data-name="variable 1" transform="translate(1357.15 211.7)" fill="#495172" font-size="14" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Liabilities</tspan></text>
									</g>
									<path id="Polygon_8" data-name="Polygon 8" d="M6.546,0l6.546,6.931H0Z" transform="translate(80.186 44.99)" fill="#00e38c"/>
								</g>
								<g id="Group_18" data-name="Group 18" transform="translate(204.75 16.915)">
									<text id="_220" data-name="220" transform="translate(48.751 58.899)" fill="#002257" font-size="27" font-family="Lato-Bold, Lato" font-weight="700" letter-spacing="0.007em"><tspan x="-23.676" y="0">431</tspan></text>
									<g transform="matrix(1, 0, 0, 1, -1152.75, -36)" filter="url(#variable_2)">
										<text id="variable_2-3" data-name="variable 2" transform="translate(1163.53 51)" fill="#495172" font-size="14" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Account Reciveable</tspan></text>
									</g>
									<path id="Path_3-3" data-name="Path 3" d="M0-2.91,21.682,5.63l21.269-10.1L61.493,5.83l17.9-4.47L104.17-2.91l20.06-9.857" transform="translate(0 97.101)" fill="none" stroke="#00e38c" stroke-miterlimit="10" stroke-width="1.5"/>
									<path id="Polygon_4" data-name="Polygon 4" d="M6.546,0l6.546,6.931H0Z" transform="translate(80.197 44.99)" fill="#00e38c"/>
								</g>
								<g id="Group_15" data-name="Group 15" transform="translate(196.419 187.954)">
									<text id="_220-2" data-name="220" transform="translate(48.751 58.899)" fill="#002257" font-size="27" font-family="Lato-Bold, Lato" font-weight="700" letter-spacing="0.007em"><tspan x="-23.676" y="0">134</tspan></text>
									<g transform="matrix(1, 0, 0, 1, -1144.42, -207.04)" filter="url(#variable_2-2)">
										<text id="variable_2-4" data-name="variable 2" transform="translate(1179.84 222.04)" fill="#495172" font-size="14" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Revenu</tspan></text>
									</g>
									<path id="Path_3-4" data-name="Path 3" d="M0-2.91,21.682,5.63l21.269-10.1L61.493,5.83l17.9-4.47L104.17-2.91l20.06-9.857" transform="translate(0 97.101)" fill="none" stroke="#00e38c" stroke-miterlimit="10" stroke-width="1.5"/>
									<path id="Polygon_7" data-name="Polygon 7" d="M6.546,0l6.546,6.931H0Z" transform="translate(80.197 44.99)" fill="#00e38c"/>
								</g>
								<g id="Group_17" data-name="Group 17" transform="translate(371.403 16.915)">
									<text id="_471" data-name="471" transform="translate(59.123 58.899)" fill="#002257" font-size="27" font-family="Lato-Bold, Lato" font-weight="700" letter-spacing="0.007em"><tspan x="-23.676" y="0">174</tspan></text>
									<g transform="matrix(1, 0, 0, 1, -1319.4, -36)" filter="url(#variable_3)">
										<text id="variable_3-3" data-name="variable 3" transform="translate(1336.21 51)" fill="#495172" font-size="14" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Current Ration</tspan></text>
									</g>
									<path id="Path_3-5" data-name="Path 3" d="M0,8.74,21.682.2,42.951,10.3,61.493,0l17.9,4.47L104.17,8.74,124.23,18.6" transform="translate(124.23 102.931) rotate(180)" fill="none" stroke="#ff4b75" stroke-miterlimit="10" stroke-width="1.5"/>
									<path id="Polygon_5" data-name="Polygon 5" d="M6.546,0l6.546,6.931H0Z" transform="translate(103.66 51.921) rotate(180)" fill="#ff4b75"/>
								</g>
								<g id="Group_14" data-name="Group 14" transform="translate(38.595 187.954)">
									<text id="_471-2" data-name="471" transform="translate(59.123 58.899)" fill="#002257" font-size="27" font-family="Lato-Bold, Lato" font-weight="700" letter-spacing="0.007em"><tspan x="-23.676" y="0">471</tspan></text>
									<g transform="matrix(1, 0, 0, 1, -986.6, -207.04)" filter="url(#variable_3-2)">
										<text id="variable_3-4" data-name="variable 3" transform="translate(1023.78 222.04)" fill="#495172" font-size="14" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">Expenses</tspan></text>
									</g>
									<path id="Path_3-6" data-name="Path 3" d="M0,8.74,21.682.2,42.951,10.3,61.493,0l17.9,4.47L104.17,8.74,124.23,18.6" transform="translate(124.23 102.931) rotate(180)" fill="none" stroke="#ff4b75" stroke-miterlimit="10" stroke-width="1.5"/>
									<path id="Polygon_6" data-name="Polygon 6" d="M6.546,0l6.546,6.931H0Z" transform="translate(103.66 51.921) rotate(180)" fill="#ff4b75"/>
								</g>
							</g>
						</svg>

					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="card-box card2">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-8" style="margin-top: -4px;"><h4 style="color: #d09b09">Subsidiary Accounts</h4>
										</div>
										<div class="col-md-2">
											<select class="form-control" style="margin-top: -7px;" onchange="getBranchList2();" id="type" name="type">
												<option value="-1">All</option>
												<option value="parent">Parent</option>
												<option value="subsidiary">Subsidiary</option>
												<option value="associate">Associate</option>
											</select>
										</div>
<!--										<div class="col-md-1"><button class="btn btn-icon btn-warning btn-xs" style="float: right" onclick="openModal();"-->
<!--																	  data-id="0" id="companyFormButton"><i-->
<!--														class="fa fa-plus"></i></button></div>-->
										<div class="col-md-2"><a href="<?php echo base_url('ViewBranch');?>" class="btn btn-danger btn-xs roundCornerBtn4">View More <i class="fa fa-chevron-right"></i></a></div>
									</div>
								</div>
								<table class="table table-hover table-responsive table-flush" id="BranchTable2">
									<thead>
									<tr>
										<th>Name</th>
										<th>Country</th>
										<th>Currency</th>
										<th>Share Percentage</th>
										<th>Financial Year</th>
										<th>Type</th>
<!--										<th>Action</th>-->
									</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-3">
							<div class="card-box card2">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-9" style="margin-top: -4px;"><h4 style="color: #d09b09">Consolidated Data</h4></div>
										<div class="col-md-3"><a href="<?php echo base_url('view_consolidate_report');?>" class="btn btn-success btn-xs roundCornerBtn4">View More <i class="fa fa-chevron-right"></i></a></div>
									</div>
								</div>
								<table class="table table-hover table-responsive table-flush" id="ReportTable2">
									<thead>
									<tr>
										<th>Year</th>
										<th>Month</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-3">
							<div class="card-box card2">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-9" style="margin-top: -4px;"><h4 style="color: #d09b09">Financial Data</h4></div>
										<div class="col-md-3"><a href="<?php echo base_url('handson');?>" class="btn btn-warning btn-xs roundCornerBtn4">View More <i class="fa fa-chevron-right"></i></a></div>
								</div>
								<table class="table table-hover table-responsive table-flush" data-page-length='5' id="FinancialData2">
									<thead>
									<tr>
										<th>Year</th>
										<th>Month</th>
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
	</div>
	<!--	<div class="row">-->
	<!--		<div class="col-lg-12">-->
	<!--			<div class="card-box">-->
	<!--				<table class="table table-striped" id="BranchTable">-->
	<!--					<thead>-->
	<!--					<tr>-->
	<!--						<td>#</td>-->
	<!--						<td>Name</td>-->
	<!--						<td>Country</td>-->
	<!--						<td>Currency</td>-->
	<!--						<td>Currency Rate</td>-->
	<!--						<td>Type</td>-->
	<!--						<td>Percentage of share holder</td>-->
	<!--						<td>Branch ID</td>-->
	<!--						<td>Status</td>-->
	<!--						<td>Action</td>-->
	<!--					</tr>-->
	<!--					</thead>-->
	<!--					<tbody>-->
	<!---->
	<!--					</tbody>-->
	<!--				</table>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</div>-->
</div>


</div>
<?php $this->load->view('Admin/branch/branch_form'); ?>
<?php
$this->load->view('_partials/footer');
?>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/js/module/branch/branch.js" type="text/javascript"></script>


<!--<script src="https://apis.google.com/js/platform.js?onload=onLoadCallback" async defer></script>
<script type="text/javascript">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
function login()
{
	var myParams = {
		'clientid' : '960428125912-jbu9ucmurj48710nrv6bjo3e42rmiivi.apps.googleusercontent.com', //You need to set client id
		'cookiepolicy' : 'single_host_origin',
		'callback' : 'loginCallback', //callback function
		'approvalprompt':'force',
		'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
	};
	gapi.auth.signIn(myParams);

}

function loginCallback() {
	const googleUser = gapi.auth2.getAuthInstance().currentUser.get();
	var profile = googleUser.getBasicProfile();
	console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	console.log('Name: ' + profile.getName());
	console.log('Image URL: ' + profile.getImageUrl());
	console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}
function signOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
		console.log('User signed out.');
	});
}


</script>-->
</div>

