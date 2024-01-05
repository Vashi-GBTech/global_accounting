<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	.unmatch {
		padding-left: 10px;
	}

	.nav-tabs.nav-justified > li > a {
		/*border: none;*/
		background-color: transparent;
		color: grey;
	}

	/*.nav-tabs.nav-justified > li > a:hover {
		color: #891635;
	}*/

	/*.nav-tabs.nav-justified > .active > a {
		color: #891635 !important;
		border: none !important;
		border-bottom: 3px solid #891635 !important;
	}*/
	.nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover {
	    border-bottom-color: #fff;
	    background-color: #f7e3ad;
	    color: black;
	    text-shadow: 0px 4px 5px #00000055!important;
	}
	.tab-pane
	{
		padding: 10px 20px;
	}
	.card{
		box-shadow: 0 4px 8px rgb(0 0 0 / 10%);
	    background-color: #fff;
	    border-radius: 3px;
	    border: none;
	    position: relative;
	    margin-bottom: 30px;
	    min-height: 115px;
	    padding: 15px 17px;
	}
	span.span_count_i {
	    font-size: 40px;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	    width: 100%;
	    height: 80px;
	    color: #fff;
    }
    #span_count1{
    	background-color: #dadf3c;
    }
    #span_count2{
    	background-color: #3cdfc4;
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
							<div class="" style="    display: flex; flex-direction: row;">
								<button class="btn btn-link "><a href="handson"><i class="fa fa-arrow-left"></i></a></button>
								<h4 class="">Upload Financial Data</h4>
							</div>

							<input type="hidden" name="unmatch" id="unmatch" value="">
							<input type="hidden" name="transfer_type" id="transfer_type" value="0">
							<button class="btn btn-icon btn-primary roundCornerBtn4" style="float: right" id="Approve" onclick="updateApprove(1)">Approve</button>
							<button class="btn btn-icon btn-primary roundCornerBtn4" style="float: right;display: none;" id="UnApprove" onclick="updateApprove(0)">Not Approve</button>
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
				<div class="row">
					<div class="col-md-12">
						<h5>Financial Data <span id="monthName">-</span> <span id="yearName">-</span></h5>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">

						<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
							<li class="nav-item ind active" role="presentation">
								<a
										data-toggle="tab" href="#ind"
										class="nav-link active"
										id="matched_data"
										role="tab"
										aria-selected="true" onclick="loadData()">Ind</a>
							</li>
							<li class="nav-item us" role="presentation">
								<a
										data-toggle="tab" href="#us"
										class="nav-link"
										id="unmatched_data"
										href=""
										role="tab"
										aria-selected="false" onclick="loadDataUs()">US</a>
							</li>
							<li class="nav-item ifrs" role="presentation">
								<a
										data-toggle="tab" href="#ifrs"
										class="nav-link"
										id="unmatched_data"
										href=""
										role="tab"
										aria-selected="false" onclick="loadDataIfrs()">IFRS</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-content" style="padding:0;">
					<div id="ind" class="tab-pane active">
						<div id="SummarisedData">
							<div class="row">
								<div class="col-md-6">
									<div class="card card-statistic-1">
										<div class="row">
											<div class="col-md-2 col-sm-3 col-xs-3">
												<span class="span_count_i" id="span_count1"><i class="fa fa-calculator" aria-hidden="true"></i><!-- <i class="fa fa-user"></i> --></span>
											</div>
											<div class="col-md-10 col-sm-9 col-xs-9">
												<b>Total Rows Count: </b> <span id="totalrowCount">---</span>
												<br>
												<b>Unmatched Rows Count: </b> <span id="umatchedrowCount">---</span>
												<br>
												<b>Matched Rows Count: </b> <span id="matchedrowCount">---</span>	
											</div>
										</div>
										
									</div>
								</div>
								<div class="col-md-6">
									<div class="card card-statistic-1">
										<div class="row">
											<div class="col-md-2 col-sm-3 col-xs-3">
												<span class="span_count_i" id="span_count2"><i class="fa" aria-hidden="true">&#xf156;</i></span>
											</div>
											<div class="col-md-10 col-sm-9 col-xs-9">
												<b>Total Opening Balance: </b> <span id="OBrowCount">---</span>	
												<br>
												<b>Total Debit: </b> <span id="DebitrowCount">---</span>
												<br>
												<b>Total Credit: </b> <span id="CreditrowCount">---</span>
												<br>
												<b>Sum of Total: </b> <span id="totalsum">---</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">

								<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
									<li class="nav-item match active" role="presentation">
										<a
												data-toggle="tab" href="#matched"
												class="nav-link active"
												id="matched_data"
												role="tab"
												aria-selected="true" onclick="loadData()">Matched Data</a>
									</li>
									<li class="nav-item unmatch" role="presentation">
										<a
												data-toggle="tab" href="#unmatched"
												class="nav-link"
												id="unmatched_data"
												href=""
												role="tab"
												aria-selected="false" onclick="loadData()">Unmatched Data</a>
									</li>
								</ul>
							</div>
						</div>

						<div class="tab-content" style="padding:0;">
							<div id="matched" class="tab-pane active">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div class="text-right m-b-5">
												<button type="button" class="btn btn-primary btn-sm" onclick="downloadMatchData()"> Download <i class="fa fa-download"></i></button>
											</div>
											<div id="Match"></div><br>
		<!--									--><?php //if ($checkPermission== true){ ?>
		<!--										<button class="btn btn-primary" onclick="saveData1();">Save</button>-->
		<!--									--><?php //} ?>
										</div>
									</div>
								</div>
							</div>
							<div id="unmatched" class="tab-pane">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div id="unMatch"></div>
											<?php if ($checkPermission== true){ ?>
													<button class="btn btn-primary roundCornerBtn4 filterBtn" id="SaveData" onclick="saveData(1);">Save</button>
												<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="us" class="tab-pane">
						<div id="SummarisedDataUS">
							<div class="row">
								<div class="col-md-6">
									<div class="card card-statistic-1">
										<div class="row">
											<div class="col-md-2 col-sm-3 col-xs-3">
												<span class="span_count_i" id="span_count1"><i class="fa fa-calculator" aria-hidden="true"></i><!-- <i class="fa fa-user"></i> --></span>
											</div>
											<div class="col-md-10 col-sm-9 col-xs-9">
												<b>Total Rows Count: </b> <span id="totalrowCountUS">---</span>
												<br>
												<b>Unmatched Rows Count: </b> <span id="umatchedrowCountUS">---</span>
												<br>
												<b>Matched Rows Count: </b> <span id="matchedrowCountUS">---</span>	
											</div>
										</div>
										
									</div>
								</div>
								<div class="col-md-6">
									<div class="card card-statistic-1">
										<div class="row">
											<div class="col-md-2 col-sm-3 col-xs-3">
												<span class="span_count_i" id="span_count2"><i class="fa fa-usd" aria-hidden="true"></i><!-- <i class="fa fa-money" aria-hidden="true"></i> --></span>
											</div>
											<div class="col-md-10 col-sm-9 col-xs-9">
												<b>Total Opening Balance: </b> <span id="OBrowCountUS">---</span>
												<br>
												<b>Total Debit: </b> <span id="DebitrowCountUS">---</span>
												<br>
												<b>Total Credit: </b> <span id="CreditrowCountUS">---</span>
												<br>
												<b>Sum of Total: </b> <span id="totalsumUS">---</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">

								<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
									<li class="nav-item match active" role="presentation">
										<a
												data-toggle="tab" href="#matchedUs"
												class="nav-link active"
												id="matched_data"
												role="tab"
												aria-selected="true" onclick="loadDataUs()">Matched Data</a>
									</li>
									<li class="nav-item unmatch" role="presentation">
										<a
												data-toggle="tab" href="#unmatchedUs"
												class="nav-link"
												id="unmatched_data"
												href=""
												role="tab"
												aria-selected="false" onclick="loadDataUs()">Unmatched Data</a>
									</li>
								</ul>
							</div>
						</div>

						<div class="tab-content" style="padding:0;">
							<div id="matchedUs" class="tab-pane active">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div id="MatchUs"></div><br>
		<!--									--><?php //if ($checkPermission== true){ ?>
		<!--										<button class="btn btn-primary" onclick="saveData1();">Save</button>-->
		<!--									--><?php //} ?>
										</div>
									</div>
								</div>
							</div>
							<div id="unmatchedUs" class="tab-pane">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div id="unMatchUs"></div>
											<?php if ($checkPermission== true){ ?>
													<button class="btn btn-primary roundCornerBtn4 filterBtn" id="SaveData" onclick="saveData(2);">Save</button>
												<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="ifrs" class="tab-pane">
						<div id="SummarisedDataUS">
							<div class="row">
								<div class="col-md-6">
									<div class="card card-statistic-1">
										<div class="row">
											<div class="col-md-2 col-sm-3 col-xs-3">
												<span class="span_count_i" id="span_count1"><i class="fa fa-calculator" aria-hidden="true"></i><!-- <i class="fa fa-user"></i> --></span>
											</div>
											<div class="col-md-10 col-sm-9 col-xs-9">
												<b>Total Rows Count: </b> <span id="totalrowCountIFRS">---</span>
												<br>
												<b>Unmatched Rows Count: </b> <span id="umatchedrowCountIFRS">---</span>
												<br>
												<b>Matched Rows Count: </b> <span id="matchedrowCountIFRS">---</span>
											</div>
										</div>
										
									</div>
								</div>
								<div class="col-md-6">
									<div class="card card-statistic-1">
										<div class="row">
											<div class="col-md-2 col-sm-3 col-xs-3">
												<span class="span_count_i" id="span_count2"><i class="fa fa-money" aria-hidden="true"></i></span>
											</div>
											<div class="col-md-10 col-sm-9 col-xs-9">
												<b>Total Opening Balance: </b> <span id="OBrowCountIFRS">---</span>
												<br>
												<b>Total Debit: </b> <span id="DebitrowCountIFRS">---</span>
												<br>
												<b>Total Credit: </b> <span id="CreditrowCountIFRS">---</span>
												<br>
												<b>Sum of Total: </b> <span id="totalsumIFRS">---</span>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
									<li class="nav-item match active" role="presentation">
										<a
												data-toggle="tab" href="#matchedIfrs"
												class="nav-link active"
												id="matched_data"
												role="tab"
												aria-selected="true" onclick="loadDataIfrs()">Matched Data</a>
									</li>
									<li class="nav-item unmatch" role="presentation">
										<a
												data-toggle="tab" href="#unmatchedIfrs"
												class="nav-link"
												id="unmatched_data"
												href=""
												role="tab"
												aria-selected="false" onclick="loadDataIfrs()">Unmatched Data</a>
									</li>
								</ul>
							</div>
						</div>

						<div class="tab-content" style="padding:0;">
							<div id="matchedIfrs" class="tab-pane active">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div id="MatchIfrs"></div><br>
		<!--									--><?php //if ($checkPermission== true){ ?>
		<!--										<button class="btn btn-primary" onclick="saveData1();">Save</button>-->
		<!--									--><?php //} ?>
										</div>
									</div>
								</div>
							</div>
							<div id="unmatchedIfrs" class="tab-pane">
								<div class="row">
									<div class="col-lg-12">
										<div class="card-box" style="border: none">
											<div id="unMatchIfrs"></div>
											<?php if ($checkPermission== true){ ?>
													<button class="btn btn-primary roundCornerBtn4 filterBtn" id="SaveData" onclick="saveData(3);">Save</button>
												<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


</div>
<?php $this->load->view('_partials/footer'); ?>
<script>var baseurl = '<?php echo base_url();?>';</script>
<script>
	$(document).ready(function(){
		loadData();
	});
	let hotDiv1 = null, hotDiv2 = null;

	function loadData() {
		$.LoadingOverlay("show");
		$('#unmatch').val("");
		const urlParams = new URLSearchParams(window.location.search);
		const myParam = urlParams.get('id');
		let formData = new FormData();
		formData.set("id", myParam);
		app.request("getMatchUnMatchData", formData).then(res => {
		$.LoadingOverlay("hide");
			if (res.status === 200) {
				$("#monthName").html(res.month);
				$("#yearName").html(res.year);
				$("#umatchedrowCount").html(res.unMatch.length);
				$("#matchedrowCount").html(res.match.length);
				$("#totalrowCount").html((res.match.length)*1 + (res.unMatch.length)*1);
				$("#OBrowCount").html(res.openingBalnceSum);
				$("#DebitrowCount").html(res.DebitSum);
				$("#CreditrowCount").html(res.creditSum);
				$("#totalsum").html(res.TotalSum);

				if(res.unMatch.length == 0)
				{
					$('#SaveData').hide();
					$('#unmatch').val(1);
				}
				if(res.approve_status == 1)
				{
					$('#Approve').hide();
					$('#UnApprove').show();
				}else
				{
					$('#Approve').show();
					$('#UnApprove').hide();
				}
				hotDiv1 != null ? hotDiv1.destroy() : '';
				hotDiv1 = loadHandSon(document.getElementById("Match"), res.match, res.header, res.types);
				hotDiv1.validateCells();
				hotDiv2 != null ? hotDiv2.destroy() : '';
				hotDiv2 = loadHandSon(document.getElementById("unMatch"), res.unMatch, res.header, res.types);
				hotDiv2.validateCells();
				$("#transfer_type").val(res.transfer_type);
				if(res.transfer_type==1 || res.transfer_type==2)
				{
					$("#SaveData").hide();
				}
				else {
					$("#SaveData").show();
				}
			} else {
				toastr.danger(res.message);
			}
		})
	}

	// loadData();

function loadDataUs() {
		$.LoadingOverlay("show");
		$('#unmatch').val("");
		const urlParams = new URLSearchParams(window.location.search);
		const myParam = urlParams.get('id');
		let formData = new FormData();
		formData.set("id", myParam);
		app.request("getMatchUnMatchDataUs", formData).then(res => {
		$.LoadingOverlay("hide");
			if (res.status === 200) {
				$("#monthName").html(res.month);
				$("#yearName").html(res.year);
				$("#umatchedrowCountUS").html(res.unMatch.length);
				$("#matchedrowCountUS").html(res.match.length);
				$("#totalrowCountUS").html((res.match.length)*1 + (res.unMatch.length)*1);
				$("#OBrowCountUS").html(res.openingBalnceSum);
				$("#DebitrowCountUS").html(res.DebitSum);
				$("#CreditrowCountUS").html(res.creditSum);
				$("#totalsumUS").html(res.TotalSum);
				if(res.unMatch.length === 0)
				{
					$('#SaveData').hide();
					$('#unmatch').val(1);
				}
				if(res.approve_status == 1)
				{
					$('#Approve').hide();
					$('#UnApprove').show();
				}else
				{
					$('#Approve').show();
					$('#UnApprove').hide();
				}
				hotDiv1 != null ? hotDiv1.destroy() : '';
				hotDiv1 = loadHandSon(document.getElementById("MatchUs"), res.match, res.header, res.types);
				hotDiv1.validateCells();
				hotDiv2 != null ? hotDiv2.destroy() : '';
				hotDiv2 = loadHandSon(document.getElementById("unMatchUs"), res.unMatch, res.header, res.types);
				hotDiv2.validateCells();
			} else {
				toastr.danger(res.message);
			}
		})
	}

	// loadDataUs();

function loadDataIfrs() {
		$.LoadingOverlay("show");
		$('#unmatch').val("");
		const urlParams = new URLSearchParams(window.location.search);
		const myParam = urlParams.get('id');
		let formData = new FormData();
		formData.set("id", myParam);
		app.request("getMatchUnMatchDataIfrs", formData).then(res => {
		$.LoadingOverlay("hide");
			if (res.status === 200) {
				$("#monthName").html(res.month);
				$("#yearName").html(res.year);
				$("#umatchedrowCountIFRS").html(res.unMatch.length);
				$("#matchedrowCountIFRS").html(res.match.length);
				$("#totalrowCountIFRS").html((res.match.length)*1 + (res.unMatch.length)*1);
				$("#OBrowCountIFRS").html(res.openingBalnceSum);
				$("#DebitrowCountIFRS").html(res.DebitSum);
				$("#CreditrowCountIFRS").html(res.creditSum);
				$("#totalsumIFRS").html(res.TotalSum);
				if(res.unMatch.length === 0)
				{
					$('#SaveData').hide();
					$('#unmatch').val(1);
				}
				if(res.approve_status == 1)
				{
					$('#Approve').hide();
					$('#UnApprove').show();
				}else
				{
					$('#Approve').show();
					$('#UnApprove').hide();
				}
				hotDiv1 != null ? hotDiv1.destroy() : '';
				hotDiv1 = loadHandSon(document.getElementById("MatchIfrs"), res.match, res.header, res.types);
				hotDiv1.validateCells();
				hotDiv2 != null ? hotDiv2.destroy() : '';
				hotDiv2 = loadHandSon(document.getElementById("unMatchIfrs"), res.unMatch, res.header, res.types);
				hotDiv2.validateCells();
			} else {
				toastr.danger(res.message);
			}
		})
	}

	// loadDataIfrs();

	function loadHandSon(element, columnRows, columnsHeader, columnTypes) {
		$(".filterBtn").show();
		return app.getHandSonTable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			columns: columnTypes,
			filters: true,
			hiddenColumns: {
				columns: [0]
			},
			afterFilter: function (conditionsStack) {
				if(conditionsStack.length>0)
				{
					$(".filterBtn").hide();
				}
				else {
					if($("#transfer_type").val()===1 || $("#transfer_type").val()===2)
					{
						$(".filterBtn").show();
					}
					else{
						$(".filterBtn").hide();
					}
				}
			},
		})

	}

	function saveData(acType) {
		$.LoadingOverlay("show");
		const urlParams = new URLSearchParams(window.location.search);
		const template = urlParams.get('template');
		const id = urlParams.get('id');
		let data = hotDiv2.getData();
		let formData = new FormData();
		formData.set("data", JSON.stringify(data));
		formData.set('template', template);
		formData.set('id', id);
		formData.set('acType', acType);
		console.log(data);
		app.request("SaveData", formData).then(res => {
		$.LoadingOverlay("hide");
			if (res.status === 200) {
				toastr.success(res.message);
				if(acType == 1){
					loadData();
				}else if(acType == 2){
					loadDataUs();
				}else{
					loadDataIfrs();
				}
				
			} else {
				toastr.danger(res.message);
			}
		})
	}
	function saveData1() {
		$.LoadingOverlay("show");
		const urlParams = new URLSearchParams(window.location.search);
		const template = urlParams.get('template');
		const id = urlParams.get('id');
		let data = hotDiv1.getData();
		let formData = new FormData();
		formData.set("data", JSON.stringify(data));
		formData.set('template', template);
		formData.set('id', id);
		console.log(data);
		app.request("SaveData", formData).then(res => {
		$.LoadingOverlay("hide");
			if (res.status === 200) {
				toastr.success(res.message);
				loadData();
			} else {
				toastr.danger(res.message);
			}
		})
	}

	function updateApprove(status){
		$.LoadingOverlay("show");
		let formData = new FormData();
		const urlParams = new URLSearchParams(window.location.search);
		const id = urlParams.get('id');
		const template = urlParams.get('template');
		var unmatch_data = $('#unmatch').val();
		formData.set("excelSheet_id",id);
		formData.set("unmatch",unmatch_data);
		formData.set("approve_status",status);
		let data = hotDiv2.getData();
		if(data.length === 0){
			app.request("approveData",formData).then(res=>{
		$.LoadingOverlay("hide");
				if(res.status===200){
					toastr.success(res.body);
					if(template == "1")
					{
						window.location.href = baseurl + "handson";
					}else
					{
						window.location.href = baseurl + "uploadIntraCompanyTransfer"
					}
				}else{
					toastr.danger(res.body);
				}
			})
		}else{
		$.LoadingOverlay("hide");
			alert("Some Un-match Data exists");
		}

	}
	function downloadMatchData() {
		const urlParams = new URLSearchParams(window.location.search);
		const id = urlParams.get('id');
		window.location.href=baseurl+'downloadMatchedData/'+id;
	}
</script>
</div>
