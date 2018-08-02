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
var imgFilt = document.getElementById("preview");
var img = document.getElementById("img");
var image = document.getElementById('image');
var byFile = document.getElementById('byFile');
var uno = 1;
var onAir = 0;
var onImg = 0;

if (navigator.mediaDevices.getUserMedia) {
	navigator.mediaDevices.getUserMedia({video: true, audio: false})
		.then(function(stream) {
			video.srcObject = stream;
			onAir = 1;
			imgFilt.style.display = "block";
			imgFilt.style.position = "absolute";
			imgFilt.setAttribute("style", "display:block;position:absolute;background-size:cover;");
			changeBg();
		})
	.catch(function(err0r) {
		console.log("No Cam device found.", err0r);
		video.setAttribute('style', 'background:gray');
		video.parentNode.removeChild(video);
		snap.parentNode.removeChild(snap);
	});
}

function changeBg() {
	imgFilt.style.width = video.offsetWidth;
	imgFilt.style.height = video.offsetHeight;
	var filt = document.querySelector('input[name="filt"]:checked').value;
	if (filt == 1)
		imgFilt.style.background = "url('/img/filter/01.png') no-repeat center center";
	else if (filt == 2)
		imgFilt.style.background = "url('/img/filter/02.png') no-repeat center center";
	else if (filt == 3)
		imgFilt.style.background = "url('/img/filter/03.png') no-repeat center center";
	else if (filt == 4)
		imgFilt.style.background = "url('/img/filter/04.png') no-repeat center center";
	else
		console.log("NotAbleToChangeBg");
	if (onImg == 1)
	{
		imgFilt.style.width = canvas.offsetWidth;
		imgFilt.style.height = canvas.offsetHeight;
	}
	else
	{
		imgFilt.style.width = video.offsetWidth;
		imgFilt.style.height = video.offsetHeight;
	}
}

function shot() {
	onImg = 0;
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
		byFile.setAttribute("style", "display:none");
		img.setAttribute("value", data);
	} catch (e) {
		console.log(e.message);
	}
}

function printImg() {
	onImg = 1;
	imgFilt.style.display = "block";
	imgFilt.style.position = "absolute";
	imgFilt.setAttribute("style", "display:block;position:absolute;background-size:cover;");
	canvas.setAttribute("style", "display:block;border-radius:15px;");
	canvas.width = image.offsetWidth;
	canvas.height = image.offsetHeight;
	context.drawImage(image, 0, 0, canvas.offsetWidth, canvas.offsetHeight );
	container.insertBefore(canvas, image);
	image.style.display = "none";

	var data = canvas.toDataURL('image/png');
	if (data.length != 6)
	{
		byFile.setAttribute("style", "display:none");
		video.setAttribute("style", "display:none");
		snap.setAttribute("style", "display:none");
		another.setAttribute("style", "display:block");
		publish.setAttribute("style", "display:block");
//		filter.setAttribute("style", "display:none");
		img.setAttribute("value", data);
	}
	changeBg();
};

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e)
			{
				image.setAttribute('src', e.target.result);
				image.onload = printImg;
				if (uno++ == 1)
					printImg();
				image.style.display = "block";
			}
		reader.readAsDataURL(input.files[0]);
	}
}

function retry() {
	onImg = 0;
	video.setAttribute("style", "display:block");
	snap.setAttribute("style", "display:block");
	another.setAttribute("style", "display:none");
	canvas.setAttribute("style", "display:none");
	publish.setAttribute("style", "display:none");
	filter.setAttribute("style", "display:block");
	byFile.setAttribute("style", "display:block");
	if (onAir == 1)
		imgFilt.style.display = "block";
	else
		imgFilt.style.display = "none";
	changeBg();
}
