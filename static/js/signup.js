$("#signup_form").submit(function (e) {
	e.preventDefault();
	NProgress.start();
	var data = $("#signup_form").serialize();
	var aProof = new FormData($("#signup_form")[0]);
	NProgress.start();
	$.ajax({
		url: "/credentials/postsignup",
		data: aProof,
		dataType: "json",
		contentType: false,
		processData: false,
		success: generic_success,
		error: onError,
		type: "POST",
	});
	NProgress.done();
	return false;
});
