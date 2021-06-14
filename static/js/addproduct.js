$("#add").click(function () {
	var aProof = new FormData($("#addproduct")[0]);
	NProgress.start();
	$.ajax({
		url: "/product/save_product",
		type: "POST",
		data: aProof,
		dataType: "json",
		contentType: false,
		processData: false,
		success: generic_success,
	});
	NProgress.done();
	return false;
});

$("#update").click(function () {
	NProgress.start();
	$.ajax({
		url: "/product/update",
		type: "POST",
		data: $("#update_product").serialize(),
		dataType: "json",
		success: generic_success,
	});
	NProgress.done();
	return false;
});


