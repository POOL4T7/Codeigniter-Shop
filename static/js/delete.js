/* 
Social Share Links:


WhatsApp:
https://wa.me/?text=[post-title] [post-url]
https://api.whatsapp.com/send?text=' + text + '%20' + url
https://api.whatsapp.com/send?text='${postTitle}%20${postUrl}
====================================================================

Facebook:
https://www.facebook.com/sharer.php?u=[post-url]
====================================================================

Twitter:
https://twitter.com/share?url=[post-url]&text=[post-title]
https://twitter.com/intent/tweet?url=' + url + '&text=' + text + '&via=' + via + '&hashtags=' + hash_tags |
====================================================================


Pinterest:
https://pinterest.com/pin/create/bookmarklet/?media=[post-img]&url=[post-url]&is_video=[is_video]&description=[post-title]
====================================================================


LinkedIn:
https://www.linkedin.com/shareArticle?url=[post-url]&title=[post-title]
====================================================================

SMS:
'sms':'sms:' + phone_number + '?body=' + text
TELEGRAM:
'telegram.me':'https://t.me/share/url?url=' + url + '&text=' + text + '&to=' + phone_number,

*/

const facebookBtn = document.querySelector(".facebook-btn");
const twitterBtn = document.querySelector(".twitter-btn");
const pinterestBtn = document.querySelector(".pinterest-btn");
const linkedinBtn = document.querySelector(".linkedin-btn");
const whatsappBtn = document.querySelector(".whatsapp-btn");

function init() {
	const pinterestImg = document.querySelector(".pinterest-img");
	const description = document.querySelector(".description");
	let postUrl = encodeURI(document.location.href);
	let postTitle = encodeURI(
		"*Hi there,Check this out*:- " + description.textContent
	);
	let postImg = encodeURI(pinterestImg.src);

	facebookBtn.setAttribute(
		"href",
		`https://www.facebook.com/sharer.php?u=${postUrl}`
	);

	twitterBtn.setAttribute(
		"href",
		`https://twitter.com/share?url=${postUrl}&text=${postTitle}&image=${postImg}`
	);

	pinterestBtn.setAttribute(
		"href",
		`https://pinterest.com/pin/create/bookmarklet/?media=${postImg}&url=${postUrl}&description=${postTitle}`
	);

	linkedinBtn.setAttribute(
		"href",
		`https://www.linkedin.com/shareArticle?url=${postUrl}&title=${postTitle}`
	);

	whatsappBtn.setAttribute(
		"href",
		`https://wa.me/?text=${postTitle} ${postUrl}`
	);
}

init();
