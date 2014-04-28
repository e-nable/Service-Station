<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>eNable Web-Creator Demonstration</title>

<link rel="stylesheet" href="css/main.css" type="text/css" />

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
	#help {
		margin-top: -3px;
		p-osition: absolute;
		margin-left: 14px ;
	}
	#help  span{
		font-size: 18px;
	}
	.help {
		color:white;
		background-image: linear-gradient(to bottom, #666666 0px, #222222 100%);
    		background-color: #666666;
		border-color: #666666;
		float:right;
	}
	.help:hover, .help:focus {
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
</style>
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

$part_options = part_options();
$fingerSelect_options = fingerSelect_options();
$palmSelect_options = palmSelect_options();
$render = render();

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
    <button class="download btn btn-danger" type="submit" name='submit' value='stl'>
      <span class="glyphicon glyphicon-download"></span> Download</button>
    <button class="preview btn btn-success" type="submit" name='submit' value='Preview'
      title="Preview" data-toggle="tooltip" data-placement="bottom">
      <span class="glyphicon glyphicon-picture"></span> Preview</button>
    <button class="email btn btn-info" type="button" name='submit' value='email'>
      <span class="glyphicon glyphicon-envelope"></span> Email</button>
    </div>
   </div>
  </div>
 </div>
</div>


<div class="navbar  navbar-inverse navbar-fixed-bottom">
 <div class="container">
	&copy; e-NABLE 2014
    <button id="help" class="help btn btn-help" value='help' data-toggle="modal" data-target=".help-modal">
      <span class="fa fa-question-circle"></span> Help</button>
    <button id="help" class="help btn btn-help" value='help' data-toggle="modal" data-target=".disclaimer-modal">
      Disclaimer</button>
 </div>
</div>

<br/><br/><br/>
<div class="container">
<div class="row">
 <div class="col-md-4">

  <ul class="nav nav-tabs">
   <li class="active"><a href="#left" data-toggle="tab">Left Arm</a></li>
   <li><a href="#right" data-toggle="tab">Right Arm</a></li>  
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
     <div class="input-group"><span class="input-group-addon">L6</span> <input type="number" step="any" min="0" name="Left6" value='{$_SESSION['Left6']}'  placeholder="Distance from wrist to distal end on thumb side (Lateral)" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L7</span> <input type="number" step="any" min="0" name="Left7" value='{$_SESSION['Left7']}'  placeholder="Distance from wrist to distal middle end of effected hand" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L8</span> <input type="number" step="any" min="0" name="Left8" value='{$_SESSION['Left8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">L9</span> <input type="number" step="any" min="0" name="Left9" value='{$_SESSION['Left9']}'  placeholder="Distance from wrist to distal end on thumb side (Medial)" class="form-control"><span class="input-group-addon">cm</span></div>
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
      <div class="input-group"><span class="input-group-addon">R6</span> <input type="number" step="any" min="0" name="Right6" value='{$_SESSION['Right6']}'  placeholder="Distance from wrist to distal end on thumb side (Lateral)" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R7</span> <input type="number" step="any" min="0" name="Right7" value='{$_SESSION['Right7']}'  placeholder="Distance from wrist to distal middle end of effected hand" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R8</span> <input type="number" step="any" min="0" name="Right8" value='{$_SESSION['Right8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand" class="form-control"><span class="input-group-addon">cm</span></div>
      <div class="input-group"><span class="input-group-addon">R9</span> <input type="number" step="any" min="0" name="Right9" value='{$_SESSION['Right9']}'  placeholder="Distance from wrist to distal end on thumb side (Medial)" class="form-control"><span class="input-group-addon">cm</span></div>
     <div class="input-group"><span class="input-group-addon">R10</span> <input type="number" step="any" min="0" name="Right10" value='{$_SESSION['Right10']}'  placeholder="Length of Elbow to wrist joint" class="form-control"><span class="input-group-addon">cm</span></div>
    </fieldset>
   </div>
  </div>
 </div>

 <div class="col-md-4">
  <ul class="nav nav-tabs">
   <li class="dropdown">
    <a data-toggle="dropdown" class="dropdown-toggle" id="myTabDrop1" href="#">Reference <b class="caret"></b></a>
    <ul aria-labelledby="myTabDrop1" role="menu" class="dropdown-menu">
     <li><a data-toggle="tab" tabindex="-1"  href="#image" data-toggle="tab">Visual</a></li>
     <li><a data-toggle="tab" tabindex="-1"  href="#descriptions" data-toggle="tab">Descriptions</a></li>
    </ul>
   </li>
   <li><a href="#preview" data-toggle="tab">Preview</a></li>  
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
   <div class="tab-pane active" id="image"><span class="thumbnail"><img src="./imgs/reference.png"/></span></div>
   <div class="tab-pane" id="descriptions">
    <br>
    <ol>
    <li>Length of Elbow Joint</li>
    <li>Distance between lateral and medial side of the forearm proximal to the elbow joint</li>
    <li>Distance between lateral and medial side of the middle forearm</li>
    <li>Distance between lateral and medial side of the forearm proximal to the wrist</li>
    <li>Wrist Joint distance from lateral to medial side</li>
    <li>Distance from wrist to distal end on thumb side (Lateral)</li>
    <li>Distance from wrist to distal middle end of effected hand</li>
    <li>Distance from Lateral and Medial sides of the distal part of the hand</li>
    <li>Distance from wrist to distal end on thumb side (Medial)</li>
    <li>Length of Elbow to wrist joint</li>
    </ol>
   </div>
   <div class="tab-pane" id="preview">{$render}</div>
  </div>
 </div>

 <div class="col-md-4">
  <fieldset>
   <fieldset>
    <legend>Model Selection</legend>
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
    <br />
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

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="help-modal modal fade in" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
          <h4 id="myModalLabel" class="modal-title">Help</h4>
        </div>
	<div class="modal-body">
		Please have a look at the <a href="https://docs.google.com/file/d/0B9uusfrN9RdDX3E4anlWTW01bm8">current generic intake form</a> for more details.
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        </div>

      </div>
    </div>
</div>


<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="disclaimer-modal modal fade in" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
          <h4 id="myModalLabel" class="modal-title">Disclaimer</h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        </div>

      </div>
    </div>
</div>

</div>
HTML;
echo $html;
?>


</form>
</body>
</html>
