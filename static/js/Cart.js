// setInterval(function () {
// 	load();
// }, 3000);

function load() {
	$.ajax({
		type: "POST",
		url: "/cart/yourCart",
		success: function (response) {
			$("#cart").html(response);
		},
		error: console.log("Error"),
	});
}

function updateCartInc(element, id) {
	NProgress.start();
	$.ajax({
		url: "/cart/addToCart/" + id,
		dataType: "json",
		success: console.log("cart updated"),
		type: "POST",
	});
	NProgress.done();
	return false;
}

function updateCartDec(element, id) {
	if (element.value > 1) {
		NProgress.start();
		$.ajax({
			url: "/cart/decCart/" + id,
			dataType: "json",
			success: console.log("cart updated"),
			type: "POST",
		});
		NProgress.done();
		return false;
	} else if (element.value == 1) {
		NProgress.start();
		$.ajax({
			url: "/cart/remove/" + id,
			dataType: "json",
			success: console.log("cart updated"),
			type: "POST",
		});
		NProgress.done();
		return false;
	} else {
		alert(element.value);
		return false;
	}
}

function remove(element, id) {
	NProgress.start();
	$.ajax({
		url: "/cart/remove/" + id,
		dataType: "json",
		success: alert("Item is removed from cart"),
		type: "POST",
	});
	NProgress.done();
	return false;
}

function cancel_order(element, id) {
	NProgress.start();
	var url = "/checkout/cancel/" + id;
	$.ajax(url, {
		dataType: "json",
		success: generic_success,
		error: onError,
		type: "POST",
	});
	NProgress.done();
	return false;
}
