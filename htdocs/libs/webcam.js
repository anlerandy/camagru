var video = document.querySelector("#videoElement");
var canvas = document.createElement('canvas');
var context = canvas.getContext('2d');
canvas.setAttribute('id', 'canvas');

if (navigator.mediaDevices.getUserMedia) {
	navigator.mediaDevices.getUserMedia({video: true, audio: false})
		.then(function(stream) {
			video.srcObject = stream;
			video.setAttribute('width', '100%');
		})
	.catch(function(err0r) {
		console.log("Something went wrong!");
		video.setAttribute('background', 'gray');
	});
}

function Shot() {
	context.drawImage(video, 0, 0, 100, 75);
	document.body.appendChild(canvas);
	var data = canvas.toDataURL('image/jpg');
	console.log(data);
}
