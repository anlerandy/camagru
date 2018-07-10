'use strict';

var video = document.querySelector("#videoElement");
var canvas = document.createElement('canvas');
var context = canvas.getContext('2d');
canvas.setAttribute('id', 'canvas');
canvas.setAttribute("style", "");
var container = document.getElementsByClassName("webcam")[0];
var snap = document.getElementById("shot");
var another = document.getElementById("retry");
var publish = document.getElementsByClassName("publish")[0];
var filter = document.getElementsByClassName("filter")[0];
var img = document.getElementById("img");

if (navigator.mediaDevices.getUserMedia) {
	navigator.mediaDevices.getUserMedia({video: true, audio: false})
		.then(function(stream) {
			video.srcObject = stream;
		})
	.catch(function(err0r) {
		console.log("Something went wrong!");
		video.setAttribute('style', 'background:gray');
	});
}

function shot() {
	canvas.setAttribute("style", "display:block;border-radius:15px;");
	canvas.width = video.offsetWidth;
	canvas.height = video.offsetHeight;
	context.drawImage(video, 0, 0, video.offsetWidth, video.offsetHeight );
	try {
		container.insertBefore(canvas, video);
		var data = canvas.toDataURL('image/jpg');
		video.setAttribute("style", "display:none");
		snap.setAttribute("style", "display:none");
		another.setAttribute("style", "display:block");
		publish.setAttribute("style", "display:block");
		filter.setAttribute("style", "display:none");
		img.setAttribute("value", data);
	} catch (e) {
		console.log(e.message);
	}
}

function retry() {
	video.setAttribute("style", "display:block");
	snap.setAttribute("style", "display:block");
	another.setAttribute("style", "display:none");
	canvas.setAttribute("style", "display:none");
	publish.setAttribute("style", "display:none");
	filter.setAttribute("style", "display:block");
}
