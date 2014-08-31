<!-- Web interface for back-end e-NABLE Assembler

    Copyright (C) 2014, e-NABLE / Rogelio Ortiz, Mike Creuzer

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see http://www.gnu.org/licenses/.
-->
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

	<title>e-NABLE Hand-o-matic</title>

	<!--[if IE]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
	<!-- Latest compiled and minified CSS -->

	<link rel="stylesheet" href="./lib/bootstrap-3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="./lib/bootstrap-3.1.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="./lib/font-awesome-4.0.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="./css/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="./lib/bootstrap-3.1.1/js/bootstrap.min.js"></script>
	<script src="./lib/knockout-3.2.0.js"></script>
	<script src="./js/main.js"></script>
	<?php
		printHeader();
	?>
</head>

<body id="index" class="home">
<form id="generatorForm" name="generatorForm">
<?php

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
   <a href="#" class="navbar-brand"><span id="product-title"></span></a>
  </div>
  <div class="navbar-collapse collapse">
   <div class="navbar-form navbar-right">
    <span id="help" class="help btn btn-help" value='help' data-toggle="modal" data-target=".help-modal">
      <span class="fa fa-question-circle"></span> </span>
      <a id="feedback" class="help btn btn-help" value='feedback' target='_blank'
	href="https://docs.google.com/forms/d/1hqjed1x9NuTdLt5qNfGwx-YoK3H3JSgnu30vaF47mKs/viewform?edit_requested=true#">
      <span class="fa fa-comments"></span> </a>
      <span id="action_buttons"></span>
    </div>
   </div>
  </div>
 </div>
</div>


<div class="navbar  navbar-inverse navbar-fixed-bottom">
 <div class="container" id="e_footer">
	&copy; e-NABLE 2014
    <span id="disclaimer" class="disclaimer btn btn-help" value='help' data-toggle="modal" data-target=".disclaimer-modal">
      Disclaimer</span>
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
	<select id="prostheticHand" name='prostheticHand' class="form-control"
		data-bind="options: prostheticHandItems,optionsText: 'name',optionsValue: 'id',value: selectedProstheticHand"></select>
      </div>
    </div>

   <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title">Model Selection</h3>
      </div>
      <div class="panel-body" id="option-select-body">
    <label for='part'>Generate</label>
    <select name='part' class="form-control" id="generateSelect"
	data-bind="options: partItems,optionsText: 'name',optionsValue: 'id',value: selectedPart">
    </select>

    <label for='gauntletSelect'>Gauntlet Style</label>
     <select name='gauntletSelect' class="form-control"
	data-bind="options: gauntletSelectItems,optionsText: 'name',optionsValue: 'id',value: selectedGauntletSelect">
    </select>

    <label for='fingerSelect'>Finger Style</label>
     <select name='fingerSelect' class="form-control"
	data-bind="options: fingerSelectItems,optionsText: 'name',optionsValue: 'id',value: selectedFingerSelect">
    </select>

    <label for='palmSelect'>Palm Style</label>
    <select name='palmSelect' class="form-control"
	data-bind="options: palmItems,optionsText: 'name',optionsValue: 'id',value: selectedPalm">

    </select>

   <label>Spacing</label>
    <div class="input-group"><span class="input-group-addon">Padding &nbsp;&nbsp;&nbsp;</span>
     <input type="number" step="any" min="0" name="Padding" value="{$paddingValue}" class="form-control">
     <span class="input-group-addon">mm</span>
    </div>

      </div>
    </div>
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
     <input id="v_l5" type="hidden" name="Left5" value='{$_SESSION['Left5']}'>
     <input id="v_l6" type="hidden" name="Left6" value='{$_SESSION['Left6']}'>
     <input id="v_l7" type="hidden" name="Left7" value='{$_SESSION['Left7']}'>
     <input id="v_l10" type="hidden" name="Left10" value='{$_SESSION['Left10']}'>

     <input id="v_r1" type="hidden" step="any" min="0" name="Right1" value='{$_SESSION['Right1']}'>
     <input id="v_r2" type="hidden" step="any" min="0" name="Right2" value='{$_SESSION['Right2']}'>
     <input id="v_r3" type="hidden" step="any" min="0" name="Right3" value='{$_SESSION['Right3']}'>
     <input id="v_r4" type="hidden" step="any" min="0" name="Right4" value='{$_SESSION['Right4']}'>
     <input id="v_r5" type="hidden" step="any" min="0" name="Right5" value='{$_SESSION['Right5']}'>
     <input id="v_r6" type="hidden" step="any" min="0" name="Right6" value='{$_SESSION['Right6']}'>
     <input id="v_r7" type="hidden" step="any" min="0" name="Right7" value='{$_SESSION['Right7']}'>
     <input id="v_r10" type="hidden" step="any" min="0" name="Right10" value='{$_SESSION['Right10']}'>


     <div class="input-group"><span class="input-group-addon">L8</span> <input id="v_l8" type="number" step="any" min="0" name="Left8" value='{$_SESSION['Left8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">mm</span></div>
     <div class="input-group"><span class="input-group-addon">R8</span> <input id="v_r8" type="number" step="any" min="0" name="Right8" value='{$_SESSION['Right8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">mm</span></div>
     Distance from Lateral and Medial sides of the distal part of the hand<br/><br/>

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

<br /><br />
</div>
HTML;
echo $html;
echo file_get_contents('modals.html');
?>

</form>
</body>
</html>
