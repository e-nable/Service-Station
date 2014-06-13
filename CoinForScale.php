<!doctype html>

<html>
	<head>
		<title>Coin For Scale</title>
		<meta charset="utf-8" />

		<style type="text/css">

			#canvas{background-color: #000;}

		</style>

		<script type="text/javascript">
			var state = ''; // a state variable so we know what we are doing
			var scalecircle = [];
			var circlecenter = [];
			var circleScalePixels = '';
			var circleScale = '';
			var lastClick = '';

			document.addEventListener("DOMContentLoaded", init, false);

function init()
{
	var canvas = document.getElementById("canvas");
	canvas.addEventListener("mousedown", getPosition, false);
}

function getPosition(event)
{
	var x = new Number();
	var y = new Number();
	var canvas = document.getElementById("canvas");

	if (event.x != undefined && event.y != undefined)
	{
		x = event.x;
		y = event.y;
	}
	else // Firefox method to get the position
	{
		x = event.clientX + document.body.scrollLeft +
			document.documentElement.scrollLeft;
		y = event.clientY + document.body.scrollTop +
			document.documentElement.scrollTop;
	}

	x -= canvas.offsetLeft;
	y -= canvas.offsetTop;

	if(state == 'scalecircle')
	{
		storeCoordinate(x, y, scalecircle);
		if(scalecircle.length >= 3)
		{
			state = ''; // quit doing this by changing the state
			var circlecenter = findCircleCenter(scalecircle[0],scalecircle[1],scalecircle[2]);
			circleScalePixels = lineDistance(circlecenter, scalecircle[0] );
			// lets draw this thing
			var ctx=canvas.getContext("2d");
			ctx.beginPath();
			ctx.arc(circlecenter.x,circlecenter.y,circleScalePixels,0,2*Math.PI);
			ctx.stroke();

			circleScale = (circleScalePixels * 2) / document.getElementById('circleRealSize').value ;

		}
	}else
	{
		var context = canvas.getContext('2d');

		context.beginPath();
		context.moveTo(x, y);
		context.lineTo(lastClick.x, lastClick.y);
		context.stroke();

		lineSize = lineDistance({x: x, y: y}, lastClick);
		distance = lineSize / circleScale;

	}


	//alert("x: " + x + "  y: " + y);
	document.getElementById('console').innerHTML="Last line measured " + distance + "mm<br>Most Recent Click Coordinates x: " + x + "  y: " + y + " previous x: " + lastClick.x + "  y: " + lastClick.y + "<br>" + /*Scale Circle Center " + JSON.stringify(circlecenter, null, 4) + " giving us " +*/ circleScale + " pixels per mm";

	lastClick = {x: x, y: y};
}

function loadAndDrawImage(url)
{
	// Create an image object. This is not attached to the DOM and is not part of the page.
	var image = new Image();

	// When the image has loaded, draw it to the canvas
	image.onload = function()
	{
		canvas.width  = image.width;///4;
		canvas.height = image.height;///4;

		var context = canvas.getContext("2d");
		//context.scale(.25,.25);

		context.drawImage(image, 0, 0);

	}

	// Now set the source of the image that we want to load
	image.src = url;
}
loadAndDrawImage("hand.png");
//loadAndDrawImage("http://hexagonmetrology.us/images/absolute/romer-absolute-arm-feature-points.jpg");


function defineCircle()
{
	state = 'scalecircle';
	// Clear the current circle
	while(scalecircle.length > 0) {
		scalecircle.pop();
	}

	document.getElementById('console').innerHTML="Click 3 points around the circle.";

}

function storeCoordinate(xVal, yVal, array) {
	array.push({x: xVal, y: yVal});
}

function sqr(a) {
	return a * a;
}

function dist(a, b) {
	return Math.sqrt(sqr(a.x-b.x) + sqr(a.y - b.y));
}


function findCircleCenter(b, c, d) {

	var temp = sqr(c.x) + sqr(c.y);
	var bc = (sqr(b.x) + sqr(b.y) - temp) / 2.;
	var cd = (temp - sqr(d.x) - sqr(d.y)) / 2.;
	var det = (b.x-c.x) * (c.y-d.y) - (c.x-d.x) * (b.y-c.y);

	if (Math.abs(det) < 1e-14)
	{
		alert("error in finding circle center");	    
		return false;
	}

	var circ = new Object({
x: (bc * (c.y-d.y) - cd * (b.y-c.y)) / det,
y: ((b.x-c.x) * cd - (c.x-d.x) * bc) / det
});
//alert(JSON.stringify(circ, null, 4));
return circ;
}


function lineDistance( point1, point2 )
{
	var xs = 0;
	var ys = 0;

	xs = point2.x - point1.x;
	xs = xs * xs;

	ys = point2.y - point1.y;
	ys = ys * ys;

	return Math.sqrt( xs + ys );
}



</script>

  </head>

  <body>
	  <canvas id="canvas" width="640" height="360">Unfortunatly, you cannot use this tool as your browser doesn't support it.</canvas>
	  <div id="console"></div>
	  <button type="button" name='circle' onclick='defineCircle()'>Circle</button>
	  <input type="number" step="any" min='0' placeholder='Diameter in mm' list='coins' id='circleRealSize' name='Diameter' required>
	  <datalist id='coins'>
	  <option value='42'>Logo</option>
	  <option value='19.05'>US Penny</option>
	  <option value='21.21'>US Nickel</option>
	  <option value='17.91'>US Dime</option>
	  <option value='24.26'>US Quarter</option>
	  </datalist>
  </body>
</html>

