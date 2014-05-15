<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>eNable Web-Creator Demonstration</title>

<!--[if IE]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!-- Latest compiled and minified CSS -->

<link rel="stylesheet" href="./lib/bootstrap-3.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="./lib/bootstrap-3.1.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="./lib/font-awesome-4.0.3/css/font-awesome.min.css">

<!--
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

-->
<link rel="stylesheet" href="css/main.css" type="text/css" />
</head>

<body id="index" class="home">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="./lib/bootstrap-3.1.1/js/bootstrap.min.js"></script>
<form>
<?php
require_once('backend.php');

// this starts the session
start_user_session();

#echo "<p>This is a demonstration file generator. Reference documentation can be found <a href='https://docs.google.com/document/d/1LX3tBpio-6IsMMo3aaUdR-mLwWdv1jS4ooeEHb79JYo/edit?pli=1' target='_blank'>here</a>. Generator code can be found on <a href='https://github.com/laird/e-NABLE' target='_blank'>GitHub</a> and the code for this web interface can be found an <a href='https://github.com/creuzerm/e-NABLE-Web-Generator' target='_blank'>GitHub</a>.</p>";

$prostheticHand_options = prostheticHand_options();
$part_options = part_options();
$fingerSelect_options = fingerSelect_options();
$palmSelect_options = palmSelect_options();
$render = render();
$tabselect = "";
$stateClass = "";

if(isset($_GET["submit"]) && (strtolower(trim($_GET["submit"])) == 'preview' || strtolower(trim($_GET["submit"])) == 'stl')){
	$tabselect = <<<TABSELECT
	<script>
		$("#render_tab a:last").tab("show");
	</script>
TABSELECT;
} else {
	$stateClass = "hidden";
}



$html = <<<HTML
<div role="navigation" class="navbar navbar-inverse navbar-fixed-top">
 <div class="container">
  <div class="navbar-header">
   <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
   </button>
   <a href="#" class="navbar-brand"><img src="imgs/eNable_dark_bg.png"/> - <span>Generator</span></a>
  </div>
  <div class="navbar-collapse collapse">
   <div class="navbar-form navbar-right">
    <span id="help" class="help btn btn-help" value='help' data-toggle="modal" data-target=".help-modal">
      <span class="fa fa-question-circle"></span> </span>
    <button id="stl-btn" data-loading-text="Loading STL ..." class="download btn btn-danger" type="submit" name='submit' value='stl' onClick="javascript:goModal('stl');">
      <span class="glyphicon glyphicon-download"></span> Generate STL</button>
    <button id="preview-btn"  data-loading-text="Loading Preview..." class="preview btn btn-success" type="submit" name='submit' value='Preview' onClick="javascript:goModal('preview');"
      title="Preview" data-toggle="tooltip" data-placement="bottom">
      <span class="glyphicon glyphicon-picture"></span> Preview</button>
    <!--<button class="disabled email btn btn-info" type="button" name='submit' value='email'>
      <span class="glyphicon glyphicon-envelope"></span> Email</button>-->
    </div>
   </div>
  </div>
 </div>
</div>


<div class="navbar  navbar-inverse navbar-fixed-bottom">
 <div class="container">
	&copy; e-NABLE 2014
    <span id="disclaimer" class="disclaimer btn btn-help" value='help' data-toggle="modal" data-target=".disclaimer-modal">
      Disclaimer</span>
    <a class="disclaimer btn btn-help" href="./?Left1=66.47&Left2=64.04&Left3=46.95&Left4=35.14&Left5=35.97&Left6=27.27&Left7=31.80&Left8=40.97&Left9=31.06&Left10=147.5&Right1=62.67&Right2=65.62&Right3=59.14&Right4=48.78&Right5=51.85&Right6=16.4&Right7=0&Right8=72.52&Right9=72.23&Right10=230.6&part=0&fingerSelect=2&palmSelect=2&prostheticHand=0&WristBolt=5.5&KnuckleBolt=3.3&JointBolt=3.3&ThumbBolt=3.3&submit=Preview" onClick="javascript:goModal('preview');">Load Sample Data</a>
 </div>
</div>

<br/><br/><br/>
<div class="container">
<div class="row">
 <div class="col-md-4">

  <ul class="nav nav-tabs">
   <li class="active"><a href="#left" data-toggle="tab" id="left-tab"><span class="fa fa-wrench green"></span> Left Arm</a></li>
   <li><a href="#right" data-toggle="tab" id="right-tab"><span class="fa fa-wrench green hidden"></span> Right Arm</a></li>  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
   <div class="tab-pane active" id="left">

     <fieldset>
     <div class="input-group"><span class="input-group-addon">L1</span> <input type="number" step="any" min="0" name="Left1" value='{$_SESSION['Left1']}' id="a1" placeholder="Length of Elbow Joint" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L2</span> <input type="number" step="any" min="0" name="Left2" value='{$_SESSION['Left2']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the elbow joint" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L3</span> <input type="number" step="any" min="0" name="Left3" value='{$_SESSION['Left3']}'  placeholder="Distance between lateral and medial side of the middle forearm" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L4</span> <input type="number" step="any" min="0" name="Left4" value='{$_SESSION['Left4']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the wrist" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L5</span> <input type="number" step="any" min="0" name="Left5" value='{$_SESSION['Left5']}'  placeholder="Wrist Joint distance from lateral to medial side" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L6</span> <input type="number" step="any" min="0" name="Left6" value='{$_SESSION['Left6']}'  placeholder="Distance from wrist to distal end of finger on thumb side (Lateral)" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L7</span> <input type="number" step="any" min="0" name="Left7" value='{$_SESSION['Left7']}'  placeholder="Distance from wrist to distal middle end of effected hand" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L8</span> <input type="number" step="any" min="0" name="Left8" value='{$_SESSION['Left8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L9</span> <input type="number" step="any" min="0" name="Left9" value='{$_SESSION['Left9']}'  placeholder="Distance from wrist to proximal end of 1st phalange on pinky side (Medial)" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L10</span> <input type="number" step="any" min="0" name="Left10" value='{$_SESSION['Left10']}'  placeholder="Length of Elbow to wrist joint" class="form-control"><span class="input-group-addon">cm</span></div>
    </fieldset>
   </div>
   <div class="tab-pane" id="right">
    <fieldset>
     <div class="input-group"><span class="input-group-addon">R1</span> <input type="number" step="any" min="0" name="Right1" value='{$_SESSION['Right1']}'  placeholder="Length of Elbow Joint" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R2</span> <input type="number" step="any" min="0" name="Right2" value='{$_SESSION['Right2']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the elbow joint" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R3</span> <input type="number" step="any" min="0" name="Right3" value='{$_SESSION['Right3']}'  placeholder="Distance between lateral and medial side of the middle forearm" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R4</span> <input type="number" step="any" min="0" name="Right4" value='{$_SESSION['Right4']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the wrist" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R5</span> <input type="number" step="any" min="0" name="Right5" value='{$_SESSION['Right5']}'  placeholder="Wrist Joint distance from lateral to medial side" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R6</span> <input type="number" step="any" min="0" name="Right6" value='{$_SESSION['Right6']}'  placeholder="Distance from wrist to distal end of finger on thumb side (Lateral)" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R7</span> <input type="number" step="any" min="0" name="Right7" value='{$_SESSION['Right7']}'  placeholder="Distance from wrist to distal middle end of effected hand" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R8</span> <input type="number" step="any" min="0" name="Right8" value='{$_SESSION['Right8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R9</span> <input type="number" step="any" min="0" name="Right9" value='{$_SESSION['Right9']}'  placeholder="Distance from wrist to proximal end of 1st phalange on pinky side (Medial)" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R10</span> <input type="number" step="any" min="0" name="Right10" value='{$_SESSION['Right10']}'  placeholder="Length of Elbow to wrist joint" class="form-control"><span class="input-group-addon">cm</span></div>
    </fieldset>
   </div>
  </div>
 </div>

 <div class="col-md-4">
  <ul class="nav nav-tabs" id="render_tab">
   <li class="dropdown">
    <a data-toggle="dropdown" class="dropdown-toggle" id="myTabDrop1" href="#">Reference <b class="caret"></b></a>
    <ul aria-labelledby="myTabDrop1" role="menu" class="dropdown-menu">
     <li><a data-toggle="tab" tabindex="-1"  href="#image" data-toggle="tab">Visual</a></li>
     <li><a data-toggle="tab" tabindex="-1"  href="#descriptions" data-toggle="tab">Descriptions</a></li>
    </ul>
   </li>
   <li class="{$stateClass}"><a href="#preview" data-toggle="tab">Preview</a></li>  
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
   <div class="tab-pane active" id="image"
	><div class="thumbnail"><img src="./imgs/reference.png"/
	><span id="l1" class="fancy"></span
	><span id="l2" class="fancy"></span
	><span id="l3" class="fancy"></span
	><span id="l4" class="fancy"></span
	><span id="l5" class="fancy"></span
	><span id="l6" class="fancy"></span
	><span id="l7" class="fancy"></span
	><span id="l8" class="fancy"></span
	><span id="l9" class="fancy"></span
	><span id="l10" class="fancy"></span
	><span id="r1" class="fancy"></span
	><span id="r2" class="fancy"></span
	><span id="r3" class="fancy"></span
	><span id="r4" class="fancy"></span
	><span id="r5" class="fancy"></span
	><span id="r6" class="fancy"></span
	><span id="r7" class="fancy"></span
	><span id="r8" class="fancy"></span
	><span id="r9" class="fancy"></span
	><span id="r10" class="fancy"></span
	></div></div>
   <div class="tab-pane" id="descriptions">
    <br>
    <ol>
    <li>Length of Elbow Joint</li>
    <li>Distance between lateral and medial side of the forearm proximal to the elbow joint</li>
    <li>Distance between lateral and medial side of the middle forearm</li>
    <li>Distance between lateral and medial side of the forearm proximal to the wrist</li>
    <li>Wrist Joint distance from lateral to medial side</li>
    <li>Distance from wrist to distal end of finger on thumb side (Lateral)</li>
    <li>Distance from wrist to distal middle end of effected hand</li>
    <li>Distance from Lateral and Medial sides of the distal part of the hand</li>
    <li>Distance from wrist to proximal end of 1st phalange on pinky side (Medial)</li>
    <li>Length of Elbow to wrist joint</li>
    </ol>
   </div>
   <div class="tab-pane" id="preview">{$render}</div>
  </div>
 </div>

{$tabselect}

 <div class="col-md-4 config-col">
  <fieldset>
   <fieldset>
    <legend>Model Selection</legend>
    <label for='prostheticHand'>Hand</label>
    <select id="prostheticHand" name='prostheticHand' class="form-control">
     {$prostheticHand_options}
    </select>
    
    <label for='part'>Generate</label>
    <select name='part' class="form-control">
     {$part_options}
    </select>

    <label for='fingerSelect'>Finger Style</label>
     <select name='fingerSelect' class="form-control">
     {$fingerSelect_options}
    </select>

    <label for='palmSelect'>Palm Style</label>
    <select name='palmSelect' class="form-control">
     {$palmSelect_options}
    </select>
   </fieldset>
   <fieldset>
   <legend>Connector Holes</legend>
    <div class="input-group"><span class="input-group-addon">Wrist Bolt &nbsp;&nbsp;&nbsp;</span>
     <input type="number" step="any" min="0" name="WristBolt" value="5.5" class="form-control">
     <span class="input-group-addon">mm</span>
    </div>
    <div class="input-group"><span class="input-group-addon">Knuckle Bolt</span>
     <input type="number" step="any" min="0" name="KnuckleBolt" value="3.3" class="form-control">
     <span class="input-group-addon">mm</span>
    </div>
    <div class="input-group"><span class="input-group-addon">Finger Bolt&nbsp;&nbsp;&nbsp;</span>
     <input type="number" step="any" min="0" name="JointBolt"  value="3.3" class="form-control">
     <span class="input-group-addon">mm</span>
    </div>
    <div class="input-group"><span class="input-group-addon">Thumb Bolt&nbsp;&nbsp;</span>
     <input type="number" step="any" min="0" name="ThumbBolt" value="3.3" class="form-control">
     <span class="input-group-addon">mm</span>
    </div>
   </fieldset>
  </fieldset>
 </div>
</div>
</div>

<br />
<br />
<!-- 
<div class="container">
  <div class="well">
    <p>Disclaimer: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. </p>
</div>
-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="help-modal modal fade in" id="helpModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
          <h4 id="myModalLabel" class="modal-title">Help</h4>
        </div>
	<div class="modal-body">
		The purpose of this project is to allow an advanced user to preview and build STL files associated with an <b>e-NABLE</b> Gauntlet or any associated part to it while assuring that the scaling factors used do not affect the bolting components and that other fittings remain proportionately scaled.
	<BR/>
	<BR/>
		In order to provide a proper fitting, several measurements are required which are detailed by the image in the center visual pane. Please provide all lengths for both left (L#) and right (R#) arm measurements by tabbing through the left pane, select the proper bolts sizes and other configurable selections before choosing to request a preview or generate an STL file. The preview image will only populate in a tab within the center pane when either preview or generate buttons are clicked.
	<BR/>
	<BR/>
	This product allows the user to:
	<UL>
		<LI>Preview a component build</LI>
		<LI>Generate downloadable associated STL files</LI>
	</UL>
	This product does NOT:
	<UL>
		<LI>Generate a request to order manufacturing of this product</LI>
		<LI>Talk to a 3D printer</LI>
	</UL>

		Please reference the <a href="https://docs.google.com/file/d/0B9uusfrN9RdDX3E4anlWTW01bm8">current generic intake form</a> for more details on measurements.
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        </div>

      </div>
    </div>
</div>


<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="disclaimer-modal modal fade in" id="disclaimerModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
          <h4 id="myModalLabel" class="modal-title">Disclaimer</h4>
        </div>
        <div class="modal-body">By accepting any design, plan, component or assembly related to the so called “e-NABLE Hand” , I understand and agree that any such information or material furnished by any individual associated with the design team is furnished as is without representation or warranties of any kind, express or implied, and is intended to be a gift  for the sole purpose of evaluating various design iterations, ideas and modifications. I understand that such improvements are intended to benefit individuals having specific disabilities and are not intended, and shall not be used,  for commercial use. I further understand and agree that any individual associated with e-NABLE organization shall not be liable for any injuries or damages resulting from the use of any of the materials related to the e-NABLE hand.
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        </div>

      </div>
    </div>
</div>


<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="loading-modal modal fade" id="loadingModal">
    <div class="modal-dialog">
      <div class="modal-content">
	<div class="modal-body">
		<div>Please wait while the content renders...</div>
        </div>
      </div>
    </div>
</div>

</div>
HTML;
echo $html;
?>
<script>
function goModal(v){
	$("#loadingModal").modal({backdrop:'static', keyboard: false, show:true});
	if (v == 'preview'){
		$('#stl-btn').addClass('disabled');
	} else if ( v == 'stl'){
		$('#preview-btn').addClass('disabled');
	}
}


function handSelect(){
	var hand_selected = $("#prostheticHand").val();
	if (!hand_selected){
		console.log('selection returned empty');
	} else if (hand_selected == 0){
		$('#left-tab span').removeClass('hidden');
		$('#right-tab span').addClass('hidden');
	} else if (hand_selected == 1){ ;
		$('#left-tab span').addClass('hidden');
		$('#right-tab span').removeClass('hidden');
	}
	console.log('changed');
}

function resetVisibility(){
	$.each([{side:'left',code:'l'},{side:'right',code:'r'}],
		function(x,y){
			counter= 1;
			$("#"+y.side+" input").each(
				function(a,b){
					var element = $(b);
					$("#"+y.code+element.mCount).hide();
				}
			);
		}
	);					
}

$(function(){
	handSelect();
	$('#prostheticHand').change(function(){handSelect();});
	var counter= 1;
	$.each([{side:'left',code:'l'},{side:'right',code:'r'}],
		function(x,y){
			counter= 1;
			$("#"+y.side+" input").each(
				function(a,b){
					var element = $(b);
					var parent = element.parent();
					element.mCount=counter++;
					$("#"+y.code+element.mCount).hide();
					element.mouseenter( function(){
						var c = $("#"+y.code+element.mCount);
						c.show();
					}).focus(function(){
						var c = $("#"+y.code+element.mCount);
						resetVisibility();
						c.show();
						parent.addClass("focus");
					}).mouseleave( function(){
						var c = $("#"+y.code+element.mCount);
						if (!element.is(":focus")){
							c.hide();
						}
					}).focusout( function(){
						console.log('focus out');
						var c = $("#"+y.code+element.mCount);
						c.hide();
						parent.removeClass("focus");
					});
				}
			);
		}
	);
});
</script>

</form>
</body>
</html>
