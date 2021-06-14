$("#profile_form").submit(function (e) {
	e.preventDefault();
	NProgress.start();
	var data = $("#profile_form").serialize();
	var aProof = new FormData($("#profile_form")[0]);
	NProgress.start();
	$.ajax({
		url: "/profile/update",
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
