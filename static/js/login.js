$(document).ready(function () {
	$("#login_form").validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
			password: {
				required: true,
				minlength: 8,
				maxlength: 16,
			},
		},
		errorPlacement: function (label, element) {
			label.insertAfter(element);
		},
		highlight: function (label) {
			$(label).closest(".form-group").addClass("has-error");
			$(label).closest(".form-group").removeClass("has-success");
			$(label).closest("input").addClass("error");
			$(label).closest("input").removeClass("valid");
		},
		success: function (label) {
			$(label).closest(".form-group").addClass("has-success");
			$(label).closest(".form-group").removeClass("has-error");
			$(label).closest("input").addClass("valid");
			$(label).closest("input").removeClass("error");
		},
		submitHandler: function () {
			NProgress.start();
			var data = $("#login_form").serialize();
			var url = "/credentials/postlogin";
			$.ajax(url, {
				data: data,
				dataType: "json",
				success: generic_success,
				error: onError,
				type: "POST",
			});
			NProgress.done();
			return false;
		},
	});
});
