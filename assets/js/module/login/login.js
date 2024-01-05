function goLogin() {
		$.LoadingOverlay("show");
	var form_data = document.getElementById('LoginForm');
	let formData = new FormData(form_data);
	app.request(baseURL + "GOLogin",formData).then(res=>{
		$.LoadingOverlay("hide");
		if(res.status == 200){
			if(res.user_type==1){
				window.location.href='ViewSubsidiary';
			}else if(res.user_type==2){
				// window.location.href='MainSetup';
				window.location.href='ViewSubsidiary';
			}
		}
		else
		{
			toastr.error(res.message);
		}
	}).catch(e => {
		$.LoadingOverlay("hide");
		console.log(e);
	});
}
