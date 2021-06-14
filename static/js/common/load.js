isOnline();

function isOnline() {
	if (navigator.onLine) {
		// var x = document.getElementById("wrapper").innerHTML;
		// alert(x);
	} else {
		document.getElementsByTagName("body")[0].innerHTML =
			"<div class='container jumbotron p-5 text-center'> <h3>Connection Aborted</h3> <hr><p>Make sure You Are Connected With Your Satellite</p> </div>";
	}
}

// Should we check the connection status immediatly on page load.
checkOnLoad: false;
Offline.options = {
	checks: {
		checkOnLoad: false,
		xhr: {
			url: "http://fuck.com",
		},
		reconnect: {
			// How many seconds should we wait before rechecking.
			initialDelay: 3,

			// How long should we wait between retries.
			delay: 3,
		},
		requests: true,
		// Should we monitor AJAX requests to help decide if we have a connection.
		interceptRequests: true,
	},
};
// $(function () {
// 	var $online = $(".online"),
// 		$offline = $(".offline");

// 	Offline.on("confirmed-down", function () {
// 		$online.fadeOut(function () {
// 			$offline.fadeIn();
// 		});
// 	});

// 	Offline.on("confirmed-up", function () {
// 		$offline.fadeOut(function () {
// 			$online.fadeIn();
// 		});
// 	});
// });
