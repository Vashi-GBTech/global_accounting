<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Admin login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<style>
		.full_container{
			background-image: url(<?=base_url('assets/images/background-monyplant.jpg')?>);
			width: 100%;
			height: 100vh;
			font-family: 'Nunito Sans';
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
			/* background-attachment */
		}
		.login_form {
			width: 30%;
			float: right;
			background: #ffffff9e;
			border-radius: 8px;
			padding: 1%;
			position: absolute;
			top: 28%;
			right: 10%;
			min-width: 430px;
		}
		.btn-sign_in{
			background: #E1C780 !important;
		}
	</style>
</head>
<body>
<div class="container-fluid full_container">
	<form class="login_form " id="LoginForm">
		<div class="logo text-center mb-1">
			<img src="<?=base_url("assets/images/gbt_logo.png")?>" alt="" width="22%" class="">
		</div>
		<h4 class="text-center mb-2">GLOBAL ACCOUNTING SYSTEM</h4>
		<div class="username">
			<label for="" class="username_lable mb-1"><h6 class="mb-1 pl-1">Username</h6></label>
			<input type="text" name="username" id="username" placeholder="username" class="user_name form-control mb-2" />
		</div>
		<div class="password">
			<label for="" class="password_lable mb-1"><h6 class="mb-1 pl-1">Password</h6></label>
			<input type="password" class="password_input form-control mb-4" name="password" id="password" placeholder="password">
		</div>
		<button type="button" class="btn btn-sign_in form-control mb-2" onclick="goLogin()"><h6 class="mb-0">Sign In</h6></button>
		<h6  class="float-right">Forget Password</h6>
	</form>
</div>

<script src="<?= base_url(); ?>assets/dh/js/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/dh/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/custom.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/module/login/login.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		
 	<script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>

</body>
</html>
