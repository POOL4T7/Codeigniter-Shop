$(document).ready(function () {
	$("#profile_checkout").validate({
		rules: {
			first_name: {
				required: true,
			},
			email: {
				required: true,
				email: true,
			},
			mobile: {
				required: true,
				minlength: 10,
				maxlength: 10,
			},
			checkbox: {
				required: true,
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
			var total = document.getElementById("id").value;
			if (document.getElementById("flexCheckChecked").checked) {
				NProgress.start();
				var data = $("#profile_checkout").serialize();
				var url = "/checkout/placeorder/" + total;
				$.ajax(url, {
					data: data,
					dataType: "json",
					success: generic_success,
					type: "POST",
				});
				NProgress.done();
				return false;
			}
		},
	});
});
