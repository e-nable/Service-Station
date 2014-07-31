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
<link rel="stylesheet" href="./css/main.css">

</head>

<body id="index" class="home">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="./lib/bootstrap-3.1.1/js/bootstrap.min.js"></script>
<form id="generatorForm" name="generatorForm">
<?php

$prostheticHand_options = prostheticHand_options();
$part_options = part_options();
$gauntletSelect_options = gauntletSelect_options();
$fingerSelect_options = fingerSelect_options();
$palmSelect_options = palmSelect_options();
$render = render( $assemblervars);
$tabselect = "";
$stateClass = "";
$paddingValue = !empty($_SESSION['Padding']) ? $_SESSION['Padding']: 5;
$advanced = !empty($_SESSION['advanced']) ? $_SESSION['advanced']: 'false';
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
<input id="advanced" type="hidden" name="advanced" value='{$advanced}'>
<div role="navigation" class="navbar navbar-inverse navbar-fixed-top">
 <div class="container">
  <div class="navbar-header">
   <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
   </button>
   <a href="#" class="navbar-brand"><img src="imgs/eNable_dark_bg.png"/> - <span id="product-title">Handomatic</span></a>
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


<div class="container main-container">
<div class="row">

 <div class="col-md-4 config-col">
   <div class="panel panel-warning" id="side-select">
      <div class="panel-heading">
        <h3 class="panel-title">Prosthetic Selection</h3>
      </div>
      <div class="panel-body" id="side-select-body">
        <label for='prostheticHand'>Prosthetic Hand</label>
        <select id="prostheticHand" name='prostheticHand' class="form-control">
          {$prostheticHand_options}
        </select>
      </div>
    </div>

   <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title">Model Selection</h3>
      </div>
      <div class="panel-body" id="option-select-body">
    <label for='part'>Generate</label>
    <select name='part' class="form-control" id="generateSelect">
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


   <label>Spacing</label>
    <div class="input-group"><span class="input-group-addon">Padding &nbsp;&nbsp;&nbsp;</span>
     <input type="number" step="any" min="0" name="Padding" value="{$paddingValue}" class="form-control">
     <span class="input-group-addon">mm</span>
    </div>

      </div>
    </div>

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
 </div>




 <div class="col-md-4" id="mid-pane">
  <ul class="nav nav-tabs" id="measure-tab">
   <li class=""><a href="#left" data-toggle="tab" id="left-tab"><span class="fa fa-print green"></span> Left Arm</a></li>
   <li><a href="#right" data-toggle="tab" id="right-tab"><span class="fa fa-print green hidden"></span> Right Arm</a></li>  
   <li class="active"><a href="#prosthetic" data-toggle="tab" id="prosthetic-tab"> <span class="fa fa-print green"></span><span class="title"> Left Prosthetic</span></a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
   <div class="tab-pane" id="left">

     <fieldset>
     <div class="input-group"><span class="input-group-addon">L1</span> <input id="v_l1" type="number" step="any" min="0" name="Left1" value='{$_SESSION['Left1']}' id="a1" placeholder="Length of Elbow Joint" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L2</span> <input id="v_l2" type="number" step="any" min="0" name="Left2" value='{$_SESSION['Left2']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the elbow joint" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L3</span> <input id="v_l3" type="number" step="any" min="0" name="Left3" value='{$_SESSION['Left3']}'  placeholder="Distance between lateral and medial side of the middle forearm" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L4</span> <input id="v_l4" type="number" step="any" min="0" name="Left4" value='{$_SESSION['Left4']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the wrist" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L5</span> <input id="v_l5" type="number" step="any" min="0" name="Left5" value='{$_SESSION['Left5']}'  placeholder="Wrist Joint distance from lateral to medial side" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L6</span> <input id="v_l6" type="number" step="any" min="0" name="Left6" value='{$_SESSION['Left6']}'  placeholder="Distance from wrist to distal end of finger on thumb side (Lateral)" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L7</span> <input id="v_l7" type="number" step="any" min="0" name="Left7" value='{$_SESSION['Left7']}'  placeholder="Distance from wrist to distal middle end of effected hand" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L8</span> <input id="v_l8" type="number" step="any" min="0" name="Left8" value='{$_SESSION['Left8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L9</span> <input id="v_l9" type="number" step="any" min="0" name="Left9" value='{$_SESSION['Left9']}'  placeholder="Distance from wrist to proximal end of 1st phalange on pinky side (Medial)" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">L10</span> <input id="v_l10" type="number" step="any" min="0" name="Left10" value='{$_SESSION['Left10']}'  placeholder="Length of Elbow to wrist joint" class="form-control"><span class="input-group-addon">mm</span></div>
    </fieldset>
   </div>
   <div class="tab-pane" id="right">
    <fieldset>
     <div class="input-group"><span class="input-group-addon">R1</span> <input id="v_r1" type="number" step="any" min="0" name="Right1" value='{$_SESSION['Right1']}'  placeholder="Length of Elbow Joint" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">R2</span> <input id="v_r2" type="number" step="any" min="0" name="Right2" value='{$_SESSION['Right2']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the elbow joint" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">R3</span> <input id="v_r3" type="number" step="any" min="0" name="Right3" value='{$_SESSION['Right3']}'  placeholder="Distance between lateral and medial side of the middle forearm" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">R4</span> <input id="v_r4" type="number" step="any" min="0" name="Right4" value='{$_SESSION['Right4']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the wrist" class="form-control"><span class="input-group-addon">mm</span></div>
      <div class="input-group"><span class="input-group-addon">R5</span> <input id="v_r5" type="number" step="any" min="0" name="Right5" value='{$_SESSION['Right5']}'  placeholder="Wrist Joint distance from lateral to medial side" class="form-control"><span class="input-group-addon">mm</span></div>
      <div class="input-group"><span class="input-group-addon">R6</span> <input id="v_r6" type="number" step="any" min="0" name="Right6" value='{$_SESSION['Right6']}'  placeholder="Distance from wrist to distal end of finger on thumb side (Lateral)" class="form-control"><span class="input-group-addon">mm</span></div>
      <div class="input-group"><span class="input-group-addon">R7</span> <input id="v_r7" type="number" step="any" min="0" name="Right7" value='{$_SESSION['Right7']}'  placeholder="Distance from wrist to distal middle end of effected hand" class="form-control"><span class="input-group-addon">mm</span></div>
      <div class="input-group"><span class="input-group-addon">R8</span> <input id="v_r8" type="number" step="any" min="0" name="Right8" value='{$_SESSION['Right8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">mm</span></div>
      <div class="input-group"><span class="input-group-addon">R9</span> <input id="v_r9" type="number" step="any" min="0" name="Right9" value='{$_SESSION['Right9']}'  placeholder="Distance from wrist to proximal end of 1st phalange on pinky side (Medial)" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">R10</span> <input id="v_r10" type="number" step="any" min="0" name="Right10" value='{$_SESSION['Right10']}'  placeholder="Length of Elbow to wrist joint" class="form-control"><span class="input-group-addon">mm</span></div>
    </fieldset>
   </div>

   <div class="tab-pane active" id="prosthetic">
    <fieldset>

     <input id="v_l1" type="hidden" name="Left1" value='{$_SESSION['Left1']}'>
     <input id="v_l2" type="hidden" name="Left2" value='{$_SESSION['Left2']}'>
     <input id="v_l3" type="hidden" name="Left3" value='{$_SESSION['Left3']}'>
     <input id="v_l4" type="hidden" name="Left4" value='{$_SESSION['Left4']}'>
     <input id="v_l6" type="hidden" step="any" min="0" name="Left6" value='{$_SESSION['Left6']}'>
     <input id="v_l7" type="hidden" name="Left7" value='{$_SESSION['Left7']}'>
     <input id="v_l8" type="hidden" name="Left8" value='{$_SESSION['Left8']}'>
     <input id="v_l10" type="hidden" name="Left10" value='{$_SESSION['Left10']}'>

     <input id="v_r1" type="hidden" step="any" min="0" name="Right1" value='{$_SESSION['Right1']}'>
     <input id="v_r2" type="hidden" step="any" min="0" name="Right2" value='{$_SESSION['Right2']}'>
     <input id="v_r3" type="hidden" step="any" min="0" name="Right3" value='{$_SESSION['Right3']}'>
     <input id="v_r4" type="hidden" step="any" min="0" name="Right4" value='{$_SESSION['Right4']}'>
     <input id="v_r6" type="hidden" step="any" min="0" name="Right6" value='{$_SESSION['Right6']}'>
     <input id="v_r7" type="hidden" step="any" min="0" name="Right7" value='{$_SESSION['Right7']}'>
     <input id="v_r8" type="hidden" step="any" min="0" name="Right8" value='{$_SESSION['Right8']}'>
     <input id="v_r10" type="hidden" step="any" min="0" name="Right10" value='{$_SESSION['Right10']}'>


     <div class="input-group"><span class="input-group-addon">P5</span> <input id="v_l5" type="number" step="any" min="0" name="Left5" value='{$_SESSION['Left5']}'  placeholder="Wrist Joint distance from lateral to medial side" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">P5</span> <input id="v_r5" type="number" step="any" min="0" name="Right5" value='{$_SESSION['Right5']}'  placeholder="Wrist Joint distance from lateral to medial side" class="form-control"><span class="input-group-addon">mm</span></div>
     Wrist Joint distance from lateral to medial side<br/><br/>

     <div class="input-group"><span class="input-group-addon">L9</span> <input id="v_l9" type="number" step="any" min="0" name="Left9" value='{$_SESSION['Left9']}'  placeholder="Distance from wrist to proximal end of 1st phalange on pinky side (Medial)" class="form-control"><span class="input-group-addon">mm</span></div>

     <div class="input-group"><span class="input-group-addon">R9</span><input id="v_r9" type="number" step="any" min="0" name="Right9" value='{$_SESSION['Right9']}'  placeholder="Distance from wrist to proximal end of 1st phalange on pinky side (Medial)" class="form-control"><span class="input-group-addon">mm</span></div>
     Distance from wrist to proximal end of 1st phalange on pinky side (Medial)<br/>
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
	><span id="l1" class="hover-arrow"></span
	><span id="l2" class="hover-arrow"></span
	><span id="l3" class="hover-arrow"></span
	><span id="l4" class="hover-arrow"></span
	><span id="l5" class="hover-arrow"></span
	><span id="l6" class="hover-arrow"></span
	><span id="l7" class="hover-arrow"></span
	><span id="l8" class="hover-arrow"></span
	><span id="l9" class="hover-arrow"></span
	><span id="l10" class="hover-arrow"></span
	><span id="r1" class="hover-arrow"></span
	><span id="r2" class="hover-arrow"></span
	><span id="r3" class="hover-arrow"></span
	><span id="r4" class="hover-arrow"></span
	><span id="r5" class="hover-arrow"></span
	><span id="r6" class="hover-arrow"></span
	><span id="r7" class="hover-arrow"></span
	><span id="r8" class="hover-arrow"></span
	><span id="r9" class="hover-arrow"></span
	><span id="r10" class="hover-arrow"></span
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


</div>
</div>

<br />
<br />

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

		Please reference the <a href="https://docs.google.com/file/d/0B9uusfrN9RdDRXY0NDdLalRzYWM">current generic measurement guide</a> for more details on measurements.
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
<p>Hand designs are sourced from, with attribution found at, the following links:</p>
<dl>
<dt>Cyborg Beast</dt><dd>by JorgeZuniga, verson 1.4 by Marc Petrykowski <a href="http://www.thingiverse.com/thing:261462" target="_blank">http://www.thingiverse.com/thing:261462</a></dd>
<dt>Creo version of Cyborg Beast</dt><dd>by Ryan Dailey <a href="http://www.thingiverse.com/thing:340750" target="_blank">http://www.thingiverse.com/thing:340750</a> </dd>
<dt>Parametric Gauntlet</dt><dd>by David Orgeman<a href="http://www.thingiverse.com/thing:270259" target="_blank">http://www.thingiverse.com/thing:270259</a></dd>
<dt>Cyborg Beast Short Gauntlet (Karuna's Gauntlet)</dt><dd>by Frankie Flood<a href="http://www.thingiverse.com/thing:270322" target="_blank">http://www.thingiverse.com/thing:270322 </a></dd>
<dt>Parametric Finger v2</dt><dd>by David Orgeman<a href=" http://www.thingiverse.com/thing:257544" target="_blank"> http://www.thingiverse.com/thing:257544</a></dd>

<dt></dt><dd><a href="" target="_blank"></a></dd>
</dl>
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

<div class="modal fade" id="valueWarningModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Missing Measurements</h4>
      </div>
      <div class="modal-body">
        <p>There seems to be a few missing values from the required measurements table in the first panel. Please set the associated <b>numeric</b> values for those fields <span class="incomplete-span">colored in red</span> before submitting again.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
HTML;
echo $html;
?>
<script src="./js/main.js"></script>

</form>
</body>
</html>
