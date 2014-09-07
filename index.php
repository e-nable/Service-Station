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
$time = time();
$sessionID = getSessionId();
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

	<link rel="stylesheet" href="./lib/bootstrap-3.1.1/css/bootstrap.min.css?_=<?php echo $time ?>">
	<link rel="stylesheet" href="./lib/bootstrap-3.1.1/css/bootstrap-theme.min.css?_=<?php echo $time ?>">
	<link rel="stylesheet" href="./lib/font-awesome-4.0.3/css/font-awesome.min.css?_=<?php echo $time ?>">
	<link rel="stylesheet" href="./css/main.css?_=<?php echo $time ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<script src="./lib/bootstrap-3.1.1/js/bootstrap.min.js"></script>
	<script src="./lib/knockout-3.2.0.js"></script>
<?php echo file_get_contents('js/knockout_templates.html'); ?>
	<script src="./js/main.js"></script> <!-- ?_=<?php echo $time ?>"></script> DISABLE THIS FOR NOW TO MAKE DEBUGGING EASY IN CHROME-->
<?php	printHeaderSessionVariables();	?>
</head>

<body id="index" class="home">
<form id="generatorForm" name="generatorForm">
<?php

$render = render( $assemblervars);

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

<div class="jumbotron" style="opacity:0">
      <div class="container">
        <h1>Welcome</h1>
	<p>Placeholder for introductory video</p>

        <p><a class="btn btn-primary btn-lg" role="button" id="close-jumbo">Close</a></p>
      </div>
</div>


<div class="container main-container">
<div class="row">

 <div class="col-md-4 config-col" id="first-pane" style="opacity:0">
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
	  <div class="input-group incomplete" id="email"><span class="input-group-addon"><span class="fa fa-cogs"></span>&nbsp;&nbsp; Email </span>
		<input type="" step="any" min="0" name="email" value="{$email}" class="form-control">
	  </div>

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


 <div class="col-md-4" id="mid-pane" style="opacity:0">
  <ul class="nav nav-tabs" id="measure-tab">
   <li class=""><a href="#left" data-toggle="tab" id="left-tab"><span class="fa fa-print green"></span> Left Arm</a></li>
   <li><a href="#right" data-toggle="tab" id="right-tab"><span class="fa fa-print green hidden"></span> Right Arm</a></li>  
   <li class="active"><a href="#prosthetic" data-toggle="tab" id="prosthetic-tab"> <span class="fa fa-print green"></span><span class="title"> Left Prosthetic</span></a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
   <div class="tab-pane" id="left"
	data-bind="template: { name: 'left-full-template', foreach: fields }">
   </div>
   
   <div class="tab-pane" id="right"
	data-bind="template: { name: 'right-full-template', foreach: fields }">
   </div>

   <div class="tab-pane active" id="prosthetic">
	<span data-bind="template: { name: 'field-template', foreach: fields }"></span>
   </div>

  </div>
 </div>

 <div class="col-md-4" id="third-pane" style="opacity:0">
  <ul class="nav nav-tabs" id="render_tab">
   <li class="dropdown">
    <a data-toggle="dropdown" class="dropdown-toggle" id="myTabDrop1" href="#">Reference <b class="caret"></b></a>
    <ul aria-labelledby="myTabDrop1" role="menu" class="dropdown-menu">
     <li><a data-toggle="tab" tabindex="-1"  href="#image" data-toggle="tab">Visual</a></li>
     <li><a data-toggle="tab" tabindex="-1"  href="#descriptions" data-toggle="tab">Descriptions</a></li>
    </ul>
   </li>
   <li id="preview_tab"><a href="#preview" data-toggle="tab">Preview</a></li>  
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
   <div class="tab-pane active" id="image">
	<div class="thumbnail">
		<img src="./imgs/reference.png"/>
		<span data-bind="template: { name: 'arrow-template', foreach: fields }"></span>
		<span id="top_hover" class="image_hover"></span>
	</div>
   </div>
   <div class="tab-pane" id="descriptions">
    <br><ol data-bind="template: { name: 'description-template', foreach: descriptions }"></ol>
   </div>
   <div class="tab-pane" id="preview">{$render}</div>
  </div>
 </div>

</div>
</div>

<br /><br /><br /><br />
</div>
HTML;
echo $html;
echo file_get_contents('modals.html');
?>

</form>
</body>
</html>
