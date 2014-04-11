<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>eNable Web-Creator Demonstration</title>

<link rel="stylesheet" href="css/main.css" type="text/css" />

<!--[if IE]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->

</head>

<body id="index" class="home">

<?php

// this starts the session
session_start();
$userid = session_id();
load_session_data(
	array(
	'Left1', 'Left2', 'Left3', 'Left4', 'Left5', 'Left6', 'Left7', 'Left8', 'Left9', 'Left10',
	'Right1', 'Right2', 'Right3', 'Right4', 'Right5', 'Right6', 'Right7', 'Right8', 'Right9', 'Right10',
	'part', 'fingerSelect', 'palmSelect'
	)
);

echo "<p>This is a demonstration file generator. Reference documentation can be found <a href='https://docs.google.com/document/d/1LX3tBpio-6IsMMo3aaUdR-mLwWdv1jS4ooeEHb79JYo/edit?pli=1' target='_blank'>here</a>. Generator code can be found on <a href='https://github.com/laird/e-NABLE' target='_blank'>GitHub</a> and the code for this web interface can be found an <a href='https://github.com/creuzerm/e-NABLE-Web-Generator' target='_blank'>GitHub</a>.</p>";

$part_options = part_options();
$fingerSelect_options = fingerSelect_options();
$palmSelect_options = palmSelect_options();

echo <<<HTML
<form>
<fieldset>
<legend>Arm Measurements</legend>
<fieldset style='width:25%; float:left;'>
  <legend>Left arm</legend>
   1 <input type="number" step="any" min="0" name="Left1" value='{$_SESSION['Left1']}'  placeholder="Length of Elbow Joint"><br>
   2 <input type="number" step="any" min="0" name="Left2" value='{$_SESSION['Left2']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the elbow joint"><br>
   3 <input type="number" step="any" min="0" name="Left3" value='{$_SESSION['Left3']}'  placeholder="Distance between lateral and medial side of the middle forearm"><br>
   4 <input type="number" step="any" min="0" name="Left4" value='{$_SESSION['Left4']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the wrist"><br>
   5 <input type="number" step="any" min="0" name="Left5" value='{$_SESSION['Left5']}'  placeholder="Wrist Joint distance from lateral to medial side"><br>
   6 <input type="number" step="any" min="0" name="Left6" value='{$_SESSION['Left6']}'  placeholder="Distance from wrist to distal end on thumb side (Lateral)"><br>
   7 <input type="number" step="any" min="0" name="Left7" value='{$_SESSION['Left7']}'  placeholder="Distance from wrist to distal middle end of effected hand"><br>
   8 <input type="number" step="any" min="0" name="Left8" value='{$_SESSION['Left8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand"><br>
   9 <input type="number" step="any" min="0" name="Left9" value='{$_SESSION['Left9']}'  placeholder="Distance from wrist to distal end on thumb side (Medial)"><br>
  10<input type="number" step="any" min="0" name="Left10" value='{$_SESSION['Left10']}'  placeholder="Length of Elbow to wrist joint"><br>
</fieldset>
<fieldset style='width:25%; float:right;'>
  <legend>Right arm</legend>
   1 <input type="number" step="any" min="0" name="Right1" value='{$_SESSION['Right1']}'  placeholder="Length of Elbow Joint"><br>
   2 <input type="number" step="any" min="0" name="Right2" value='{$_SESSION['Right2']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the elbow joint"><br>
   3 <input type="number" step="any" min="0" name="Right3" value='{$_SESSION['Right3']}'  placeholder="Distance between lateral and medial side of the middle forearm"><br>
   4 <input type="number" step="any" min="0" name="Right4" value='{$_SESSION['Right4']}'  placeholder="Distance between lateral and medial side of the forearm proximal to the wrist"><br>
   5 <input type="number" step="any" min="0" name="Right5" value='{$_SESSION['Right5']}'  placeholder="Wrist Joint distance from lateral to medial side"><br>
   6 <input type="number" step="any" min="0" name="Right6" value='{$_SESSION['Right6']}'  placeholder="Distance from wrist to distal end on thumb side (Lateral)"><br>
   7 <input type="number" step="any" min="0" name="Right7" value='{$_SESSION['Right7']}'  placeholder="Distance from wrist to distal middle end of effected hand"><br>
   8 <input type="number" step="any" min="0" name="Right8" value='{$_SESSION['Right8']}'  placeholder="Distance from Lateral and Medial sides of the distal part of the hand"><br>
   9 <input type="number" step="any" min="0" name="Right9" value='{$_SESSION['Right9']}'  placeholder="Distance from wrist to distal end on thumb side (Medial)"><br>
  10<input type="number" step="any" min="0" name="Right10" value='{$_SESSION['Right10']}'  placeholder="Length of Elbow to wrist joint"><br>
</fieldset>
<fieldset style='width:40%; font-size:.9em;'>
  <legend>Measurement Locations</legend>
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
</fieldset>
</fieldset>
<fieldset>
<legend>Model Selection</legend>

<fieldset style='width:40%; float:left;'>
<legend>Options</legend>
<label for='part'>Generate</label>
<select name='part'>
{$part_options}
</select>
<br />

<label for='fingerSelect'>Finger Style</label>
<select name='fingerSelect'>
{$fingerSelect_options}
</select>
<br />

<label for='palmSelect'>Palm Style</label>
<select name='palmSelect'>
{$palmSelect_options}
</select>
<br />
</fieldset>

<fieldset style='width:40%; float:right;'>
<legend>Connections</legend>
<label for='WristBolt'>Wrist Bolt Holes (mm)</label><input type="number" step="any" min="0" name="WristBolt" value="5.5"><br>
<label for='KnuckleBolt'>Knuckle Bolt Holes (mm)</label><input type="number" step="any" min="0" name="KnuckleBolt" value="3.3"><br>
<label for='JointBolt'>Finger Bolt Holes (mm)<label><input type="number" step="any" min="0" name="JointBolt"  value="3.3"><br>
<label for='ThumbBolt'>Thumb Bolt Holes (mm)</label><input type="number" step="any" min="0" name="ThumbBolt" value="3.3"><br>
</fieldset>

</fieldset>
  <input type="submit" name='submit' value="Preview">
<p>The Preview process can take a while, please be patient and don't click multiple times or you will break my 3d Printer!</p>
HTML;



// need to do some sanity checking here

if(isset($_REQUEST['submit']) )
{
	$previewimage = "imagecache/{$userid}preview.png";
	$exportfile = "imagecache/{$userid}.stl";

	if($_REQUEST['submit'] == 'Create .STL')
	{
		$thingtodo = $exportfile;
		$downloadlink = "<p><a href='{$exportfile}'>Download .stl file.</a></p>\n";
	}else{
		$thingtodo = $previewimage;
	}

	$assemblypath = "e-NABLE/Assembly/";
	$leftsidevars = "-D Left1={$_REQUEST['Left1']} -D Left2={$_REQUEST['Left2']} -D  Left3={$_REQUEST['Left3']} -D  Left4={$_REQUEST['Left4']} -D  Left5={$_REQUEST['Left5']} -D  Left6={$_REQUEST['Left6']} -D  Left7={$_REQUEST['Left7']} -D  Left8={$_REQUEST['Left8']} -D  Left9={$_REQUEST['Left9']} -D  Left10={$_REQUEST['Left10']}";
	$rightsidevars = "-D Right1={$_REQUEST['Right1']} -D Right2={$_REQUEST['Right2']} -D  Right3={$_REQUEST['Right3']} -D  Right4={$_REQUEST['Right4']} -D  Right5={$_REQUEST['Right5']} -D  Right6={$_REQUEST['Right6']} -D  Right7={$_REQUEST['Right7']} -D  Right8={$_REQUEST['Right8']} -D  Right9={$_REQUEST['Right9']} -D  Right10={$_REQUEST['Right10']}";
	$command = " openscad -o {$thingtodo} {$leftsidevars} {$rightsidevars} -D  part={$_REQUEST['part']} -D fingerSelect={$_REQUEST['fingerSelect']} -D palmSelect={$_REQUEST['palmSelect']} -D WristBolt={$_REQUEST['WristBolt']} -D KnuckleBolt={$_REQUEST['KnuckleBolt']} -D JointBolt={$_REQUEST['JointBolt']} -D ThumbBolt={$_REQUEST['ThumbBolt']} {$assemblypath}Assembly.scad ";

	$time_start = microtime(true);
	$results = exec( "export DISPLAY=:5; " . escapeshellcmd($command));
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start);


	echo "<img src='imagecache/{$userid}preview.png' />";
	echo "<input type='submit' name='submit' value='Create .STL'> {$downloadlink}";
	echo "<p>Created preview in {$execution_time} seconds using the following command.</p>\n";
	echo "<p>{$command}</p>\n";


	echo "<p>Computer Stats - for performance considerations</p>\n";
	echo "<pre>\n";
	echo `cat /proc/cpuinfo`;
	echo `cat /proc/meminfo`;
	echo "</pre>";
}else
{
	echo "<p>A sample data set can be loaded by <a href='?Left1=66.47&Left2=64.04&Left3=46.95&Left4=35.14&Left5=35.97&Left6=27.27&Left7=31.80&Left8=40.97&Left9=31.06&Left10=147.5&Right1=62.67&Right2=65.62&Right3=59.14&Right4=48.78&Right5=51.85&Right6=16.4&Right7=0&Right8=72.52&Right9=72.23&Right10=230.6&part=0&fingerSelect=1&palmSelect=1&WristBolt=5.5&KnuckleBolt=3.3&JointBolt=3.3&ThumbBolt=3.3&submit=Preview'>Clicking here</a>.</p>\n";
}
?>
</form>
</body>
</html>
<?php

// Load the session data from the form, if available
// Loop through an array of options provided and set the session
function load_session_data($options)
{
	foreach($options AS $option)
	{
		if(isset($_REQUEST[$option]))
		{ 
			$_SESSION[$option] = $_REQUEST[$option]; 
		} 
		elseif( !isset($_SESSION[$option]))
		{ 
			$_SESSION[$option] = '';
		}

	}
}

// Create menu select options for the different parts
function part_options()
{
	$return  = "\t<option value='0'" . ($_SESSION['part'] == 0 ? " selected='selected' " : '') . ">Assembled Model</option>\n";
	$return .= "\t<option value='1'" . ($_SESSION['part'] == 1 ? " selected='selected' " : '') . ">Gauntlet</option>\n";
	$return .= "\t<option value='2'" . ($_SESSION['part'] == 2 ? " selected='selected' " : '') . ">Palm</option>\n";
	$return .= "\t<option value='3'" . ($_SESSION['part'] == 3 ? " selected='selected' " : '') . ">Finger Proximal (Near knuckle)</option>\n";
	$return .= "\t<option value='4'" . ($_SESSION['part'] == 4 ? " selected='selected' " : '') . ">Finger Distal (Fingertip)</option>\n";
	$return .= "\t<option value='5'" . ($_SESSION['part'] == 5 ? " selected='selected' " : '') . ">Thumb Proximal (Near knuckle)</option>\n";
	$return .= "\t<option value='6'" . ($_SESSION['part'] == 6 ? " selected='selected' " : '') . ">Thumb Distal (Thumbtip)</option>\n";
	return $return;
}


// Create menu select options for the different finger options
function fingerSelect_options()
{
	$return  = "\t<option value='1'" . ($_SESSION['fingerSelect'] == 1 ? " selected='selected' " : '') . ">Cyborg Beast</option>\n";
	$return .= "\t<option value='2'" . ($_SESSION['fingerSelect'] == 2 ? " selected='selected' " : '') . ">David</option>\n";
	return $return;
}

// Create menu select options for the different Palm Options
function palmSelect_options()
{
	$return  = "\t<option value='1'" . ($_SESSION['palmSelect'] == 1 ? " selected='selected' " : '') . ">Cyborg Beast</option>\n";
	$return .= "\t<option value='2'" . ($_SESSION['palmSelect'] == 2 ? " selected='selected' " : '') . ">Cyborg Beast Parametric</option>\n";
	return $return;
}
?>
