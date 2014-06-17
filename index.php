<?php

require_once('backend.php');

// this starts the session
start_user_session( $assemblervars);

?>
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
<style>
	.nav-tabs li a, .tab-content div {
		background-color: #DDD;
	}
	.nav-tabs li.active a{
		background-color: white;
	}
	.tab-content div.active {
		background-color: white;
		border-right: 1px solid #DDD;
		border-left: 1px solid #DDD;
		border-bottom: 1px solid #DDD;
	}
	.input-group {
		margin-top: 6px;
	}
	legend {
		margin-bottom: 10px;
	}
	.tab-pane {
		height: 400px;
	}
	.navbar-brand {
		margin-top: -5px;
		text-size: 20px;
		font-size: 2.4em;
	}
	.navbar-brand span{
		color: #ECECEC !important;
	}
	.navbar-brand img {
		vertical-align: baseline;
	}
	.help span{
		font-size: 20px;
	}
	.disclaimer span{
		font-size: 18px;
	}
	.help {
		margin-left: 14px ;
		color:white;
		float:right;
	}
	.disclaimer {
		margin-left: 14px ;
		margin-top: -5px;
		color:white;
		background-image: linear-gradient(to bottom, #666666 0px, #222222 100%);
    		background-color: #666666;
		border-color: #666666;
		float:right;
	}
	.help:hover, .help:focus {
		color:white;
		border: 1px solid #555;
	}
	.disclaimer:hover, .disclaimer:hover  {
		color:white;
		background-image: linear-gradient(to bottom, #aaa 0px, #444 100%);
	}
	.download, .preview  {
		float:right;
		margin-left: 14px ;
	}
	.navbar-fixed-bottom .container {
		margin-top:12px;
		font-size:20px;
		color: #ECECEC;
	}
	.loading-modal .modal-dialog {
		width: 337px;
	}
	.loading-modal .modal-content {
		border-radius: 80px;
		margin: 90px auto;
		background-color:transparent;
	}
	.loading-modal .modal-content div{
		border-radius: 70px;
		margin:12px 16px;;
		background-color:white;
		color:#A00;
		font-size:1.2em;
	}
	.modal-footer {
		margin-top: 0;
		padding: 10px 24px 13px;
	}
	.modal-header {
		padding: 12px;
	}
	div#preview {
		background-color: #FFFFEB;
	}
	div#preview p.download_stl {
		text-align: center;
		background-color: #DDD;
	}
	.config-col select, .config-col input{
		height:32px;
	}
	.config-col label{
		margin-top:3px;
		margin-bottom:0px;
	}
	.config-col legend{
		margin-bottom: 0px;
	}
	.config-col fieldset fieldset :last-child{
		margin-bottom: 8px;
	}
	#left-tab span, #right-tab span {
		font-size: 1.1em;
		margin-right:2px;
	}
	.fancy {
		background-repeat: no-repeat;
		width: 117px;
		height: 35px;
		position: absolute;
	}
	#l1 {
		background:url("imgs/arrows.png") repeat scroll -10px -315px rgba(0, 0, 0, 0) !important;
		width: 90px;
		margin-left: 10px;
		top: 389px;
	}
	#l2 {
		background:url("imgs/arrows.png") repeat scroll -10px -280px rgba(0, 0, 0, 0) !important;
		width: 88px;
		margin-left: 11px;
		top: 356px;
	}
	#l3 {
		background:url("imgs/arrows.png") repeat scroll -20px -245px rgba(0, 0, 0, 0) !important;
		width: 70px;
		margin-left: 20px;
		top: 307px;
	}
	#l4 {
		background:url("imgs/arrows.png") repeat scroll -26px -210px rgba(0, 0, 0, 0) !important;
		width: 58px;
		margin-left: 26px;
		top: 272px;
	}
	#l5 {
		background:url("imgs/arrows.png") repeat scroll -34px -175px rgba(0, 0, 0, 0) !important;
		width: 58px;
		margin-left: 34px;
		top: 239px;
	}
	#l6 {
		background:url("imgs/arrows.png") repeat scroll -74px -85px rgba(0, 0, 0, 0) !important;
		height: 42px;
		width: 32px;
		margin-left: 88px;
		top: 216px;
	}
	#l7 {
		background:url("imgs/arrows.png") repeat scroll -44px -85px rgba(0, 0, 0, 0) !important;
		height: 42px;
		width: 27px;
		margin-left: 58px;
		top: 213px;
	}
	#l8 {
		background:url("imgs/arrows.png") repeat scroll -44px -140px rgba(0, 0, 0, 0) !important;
		width: 52px;
		margin-left: 44px;
		top: 162px;
	}
	#l9 {
		background:url("imgs/arrows.png") repeat scroll -3px -85px rgba(0, 0, 0, 0) !important;
		height: 42px;
		width: 32px;
		margin-left: 22px;
		top: 213px;
	}
	#l10 {
		background:url("imgs/arrows.png") repeat scroll -127px -185px rgba(0, 0, 0, 0) !important;
		height: 164px;
		width: 37px;
		margin-left: 102px;
		top: 251px;
	}
	#r1 {
		background: url("imgs/arrows.png") repeat scroll -189px -315px rgba(0, 0, 0, 0) !important;
    		margin-left: 189px;
    		top: 406px;
    		width: 90px;
	}
	#r2 {
		background:url("imgs/arrows.png") repeat scroll -185px -278px rgba(0, 0, 0, 0) !important;
		width: 90px;
		margin-left: 185px;
		top: 347px;
	}
	#r3 {
		background:url("imgs/arrows.png") repeat scroll -185px -242px rgba(0, 0, 0, 0) !important;
		width: 90px;
		margin-left: 185px;
		top: 292px;
	}
	#r4 {
		background:url("imgs/arrows.png") repeat scroll -185px -210px rgba(0, 0, 0, 0) !important;
		width: 90px;
		margin-left: 185px;
		top: 243px;
	}
	#r5 {
		background:url("imgs/arrows.png") repeat scroll -174px -175px rgba(0, 0, 0, 0) !important;
		width: 90px;
		margin-left: 174px;
		top: 170px;
	}
	#r6 {
		background: url("imgs/arrows.png") repeat scroll -117px -21px rgba(0, 0, 0, 0) !important;
		height: 150px;
		margin-left: 132px;
		top: 47px;
		width: 47px;
	}
	#r8 {
		background:url("imgs/arrows.png") repeat scroll -171px -140px rgba(0, 0, 0, 0) !important;
		width: 90px;
		margin-left: 171px;
		top: 112px;
	}
	#r9 {
		background: url("imgs/arrows.png") repeat scroll -202px -52px rgba(0, 0, 0, 0) !important;
		height: 83px;
		margin-left: 241px;
		top: 97px;
		width: 34px;
	}
	#r10 {
		background: url("imgs/arrows.png") repeat scroll -283px -90px rgba(0, 0, 0, 0) !important;
		height: 259px;
		margin-left: 267px;
		top: 177px;
		width: 34px;
	}
	#image .thumbnail {
		width: 316px;
		margin-left: auto;
		margin-right: auto;
	}
	.focus .input-group-addon {
		background-color: yellow;
	}
	.image_hover {
		background-color: rgba(0, 0, 0, 0.5);
		/* For IE 8*/
		-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
		color: #FFFFFF;
		font-size: 1.3em;
		font-weight: bold;
		height: 122px !important;
		padding: 20px;
		position: absolute;
		top: 46px;
		vertical-align: middle;
		width: 306px !important;
	}
	.bottom {
		top: 320px;
	}
</style>
</head>

<body id="index" class="home">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="./lib/bootstrap-3.1.1/js/bootstrap.min.js"></script>
<form>
<?php

$prostheticHand_options = prostheticHand_options();
$part_options = part_options();
$gauntletSelect_options = gauntletSelect_options();
$fingerSelect_options = fingerSelect_options();
$palmSelect_options = palmSelect_options();
$render = render( $assemblervars);
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

$renderedButtons = renderButtons();
$renderedSampleLoader = renderSampleLoader();

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
    <a id="feedback" class="help btn btn-help" value='feedback' target='_blank' href="https://docs.google.com/forms/d/1hqjed1x9NuTdLt5qNfGwx-YoK3H3JSgnu30vaF47mKs/viewform?edit_requested=true#">
      <span class="fa fa-comments"></span> </a>
      $renderedButtons
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
      $renderedSampleLoader
 </div>
</div>

<br/><br/><br/>
<div class="container">
<div class="row">
 <div class="col-md-4">

  <ul class="nav nav-tabs">
   <li class="active"><a href="#left" data-toggle="tab" id="left-tab"><span class="fa fa-print green"></span> Left Arm</a></li>
   <li><a href="#right" data-toggle="tab" id="right-tab"><span class="fa fa-print green hidden"></span> Right Arm</a></li>  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
   <div class="tab-pane active" id="left">

     <fieldset>
     <div class="input-group"><span class="input-group-addon">L1</span> <input id="v_l1" type="number" step="any" min="0" name="Left1" value='{$_SESSION['Left1']}' id="a1" placeholder="Length of Elbow Joint" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L2</span> <input id="v_l2" type="number" step="any" min="0" name="Left2" value='{$_SESSION['Left2']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the elbow joint" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L3</span> <input id="v_l3" type="number" step="any" min="0" name="Left3" value='{$_SESSION['Left3']}'  placeholder="Distance between lateral and medial side of the middle forearm" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L4</span> <input id="v_l4" type="number" step="any" min="0" name="Left4" value='{$_SESSION['Left4']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the wrist" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L5</span> <input id="v_l5" type="number" step="any" min="0" name="Left5" value='{$_SESSION['Left5']}'  placeholder="Wrist Joint distance from lateral to medial side" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L6</span> <input id="v_l6" type="number" step="any" min="0" name="Left6" value='{$_SESSION['Left6']}'  placeholder="Distance from wrist to distal end of finger on thumb side (Lateral)" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L7</span> <input id="v_l7" type="number" step="any" min="0" name="Left7" value='{$_SESSION['Left7']}'  placeholder="Distance from wrist to distal middle end of effected hand" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L8</span> <input id="v_l8" type="number" step="any" min="0" name="Left8" value='{$_SESSION['Left8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L9</span> <input id="v_l9" type="number" step="any" min="0" name="Left9" value='{$_SESSION['Left9']}'  placeholder="Distance from wrist to proximal end of 1st phalange on pinky side (Medial)" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L10</span> <input id="v_l10" type="number" step="any" min="0" name="Left10" value='{$_SESSION['Left10']}'  placeholder="Length of Elbow to wrist joint" class="form-control"><span class="input-group-addon">cm</span></div>
    </fieldset>
   </div>
   <div class="tab-pane" id="right">
    <fieldset>
     <div class="input-group"><span class="input-group-addon">R1</span> <input id="v_r1" type="number" step="any" min="0" name="Right1" value='{$_SESSION['Right1']}'  placeholder="Length of Elbow Joint" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R2</span> <input id="v_r2" type="number" step="any" min="0" name="Right2" value='{$_SESSION['Right2']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the elbow joint" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R3</span> <input id="v_r3" type="number" step="any" min="0" name="Right3" value='{$_SESSION['Right3']}'  placeholder="Distance between lateral and medial side of the middle forearm" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R4</span> <input id="v_r4" type="number" step="any" min="0" name="Right4" value='{$_SESSION['Right4']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the wrist" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R5</span> <input id="v_r5" type="number" step="any" min="0" name="Right5" value='{$_SESSION['Right5']}'  placeholder="Wrist Joint distance from lateral to medial side" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R6</span> <input id="v_r6" type="number" step="any" min="0" name="Right6" value='{$_SESSION['Right6']}'  placeholder="Distance from wrist to distal end of finger on thumb side (Lateral)" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R7</span> <input id="v_r7" type="number" step="any" min="0" name="Right7" value='{$_SESSION['Right7']}'  placeholder="Distance from wrist to distal middle end of effected hand" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R8</span> <input id="v_r8" type="number" step="any" min="0" name="Right8" value='{$_SESSION['Right8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R9</span> <input id="v_r9" type="number" step="any" min="0" name="Right9" value='{$_SESSION['Right9']}'  placeholder="Distance from wrist to proximal end of 1st phalange on pinky side (Medial)" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R10</span> <input id="v_r10" type="number" step="any" min="0" name="Right10" value='{$_SESSION['Right10']}'  placeholder="Length of Elbow to wrist joint" class="form-control"><span class="input-group-addon">cm</span></div>
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
	><span id="top_hover" class="image_hover"></span
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

    <label for='gauntletSelect'>Gauntlet Style</label>
     <select name='gauntletSelect' class="form-control">
     {$gauntletSelect_options}
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
   <legend>Spacing</legend>
    <div class="input-group"><span class="input-group-addon">Padding &nbsp;&nbsp;&nbsp;</span>
     <input type="number" step="any" min="0" name="Padding" value="5" class="form-control">
     <span class="input-group-addon">mm</span>
    </div>
   </fieldset>

<!--
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
-->
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
}

function resetVisibility(){
	$.each([{side:'left',code:'l'},{side:'right',code:'r'}],
		function(x,y){
			counter= 1;
			$("#"+y.side+" input").each(
				function(a,b){
					var element = $(b);
					var parent = element.parent();
					parent.removeClass("focus");
					$("#"+y.code+(a+1)).hide();
				}
			);
		}
	);					
}
var descriptions =[
	"Length of Elbow Joint",
	"Distance between lateral and medial side of the forearm proximal to the elbow joint",
	"Distance between lateral and medial side of the middle forearm",
	"Distance between lateral and medial side of the forearm proximal to the wrist",
	"Wrist Joint distance from lateral to medial side",
	"Distance from wrist to distal end of finger on thumb side (Lateral)",
	"Distance from wrist to distal middle end of effected hand",
	"Distance from Lateral and Medial sides of the distal part of the hand",
	"Distance from wrist to proximal end of 1st phalange on pinky side (Medial)",
	"Length of Elbow to wrist joint"
    ];


$(function(){
	handSelect();
	$('#prostheticHand').change(function(){handSelect();});
	var counter= 1;
	$("#top_hover").hide();
	$("#top_hover").click(function(){$("#top_hover").hide()});
	$.each([{side:'left',code:'l'},{side:'right',code:'r'}],
		function(x,y){
			counter= 1;
			$("#"+y.side+" input").each(
				function(a,b){
					var element = $(b);
					var parent = element.parent();
					var mssg = $("#top_hover");
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
						mssg.html(element.mCount+". "+ descriptions[element.mCount-1]);
						$("#top_hover").show();
						if (element.mCount > 5 && element.mCount != 10){
							mssg.addClass('bottom');
						} else {
							mssg.removeClass('bottom');
						}
					}).mouseleave( function(){
						var c = $("#"+y.code+element.mCount);
						if (!element.is(":focus")){
							c.hide();
						}
					}).focusout( function(){
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
