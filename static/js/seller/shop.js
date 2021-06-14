$(document).ready(function () {
	$("#add_shop").validate({
		rules: {
			name: {
				required: true,
				minlength: 3,
				maxlength: 100,
			},
			location: {
				required: true,
				maxlength: 150,
			},
			type: {
				required: true,
				maxlength: 64,
			},
			description: {
				required: true,
				maxlength: 150,
				minlength: 25,
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
			var data = $("#add_shop").serialize();
			var aProof = new FormData($("#add_shop")[0]);
			var url = "/seller/add_shop";
			$.ajax(url, {
				data: aProof,
				dataType: "json",
				contentType: false,
				processData: false,
				success: generic_success,
				error: onError,
				type: "POST",
			});
			return false;
		},
	});

	$("#update_shop").validate({
		rules: {
			name: {
				required: true,
				minlength: 3,
				maxlength: 100,
			},
			location: {
				required: true,
				maxlength: 150,
			},
			type: {
				required: true,
				maxlength: 64,
			},
			description: {
				required: true,
				maxlength: 150,
				minlength: 25,
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
			var data = $("#update_shop").serialize();
			var aProof = new FormData($("#update_shop")[0]);
			var url = "/seller/update_shop";
			$.ajax(url, {
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
		},
	});
});
