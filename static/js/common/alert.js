function onError() {
	alert("Connection Time Out");
}

var generic_success = function (data) {
	if (data.status == "validation error") {
		throw_alert(data.title, data.message, data.page);
	} else if (data.status == true) {
		throw_success(data.title, data.message, data.page);
	} else {
		throw_error(data.title, data.message, false);
	}
};

function throw_success(success_title, success_msg, success_page) {
	Swal.fire({
		title: success_title,
		icon: "success",
		html: success_msg,
		showCancelButton: false,
		focusConfirm: false,
		confirmButtonText: "Okay",
	}).then((result) => {
		if (result.isConfirmed) {
			if (success_page) {
				window.location.href = success_page;
			}
		}
	});
}

function throw_error(error_title, error_msg, error_page) {
	Swal.fire({
		title: error_title,
		icon: "error",
		html: error_msg,
		showCancelButton: false,
		focusConfirm: false,
		confirmButtonText: "Okay",
	}).then((result) => {
		if (result.isConfirmed) {
			if (error_page) {
				window.location.href = error_page;
			}
		}
	});
}

function throw_alert(error_title, error_msg, error_page) {
	Swal.fire({
		title: error_title,
		icon: "warning",
		html: error_msg,
		showCancelButton: true,
		focusConfirm: false,
		confirmButtonText: "Okay",
	}).then((result) => {
		if (result.isConfirmed) {
			if (error_page) {
				window.location.href = error_page;
			}
		}
	});
}
