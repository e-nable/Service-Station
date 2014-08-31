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

$processCountLimit = 2;
$processCount = 0;
$isUnderProcessLimit = false;
$assemblervars = array(
	'Left1', 'Left2', 'Left3', 'Left4', 'Left5', 'Left6', 'Left7', 'Left8', 'Left9', 'Left10',
	'Right1', 'Right2', 'Right3', 'Right4', 'Right5', 'Right6', 'Right7', 'Right8', 'Right9', 'Right10',
	'part', 'gauntletSelect', 'fingerSelect', 'palmSelect', 'prostheticHand', 'Padding',
	'WristBolt', 'KnuckleBolt', 'JointBolt', 'ThumbBolt', 'advanced'
);
$prostheticHand;
$part;
$palmSelect;
$gauntletSelect;
$fingerSelect;
$paddingValue;
$advanced;

processCount();

function processCount(){
	global $processCount, $isUnderProcessLimit, $processCountLimit;
	$processCount = exec("ps aux  | grep 'openscad' | grep time | grep -v sh | grep -c -v 'grep'");
	$processCount = empty($processCount) ? 0 : $processCount;
	$isUnderProcessLimit = ($processCount < $processCountLimit);
}

function printHeader(){
	global $prostheticHand, $part, $palmSelect, $gauntletSelect, $fingerSelect, $paddingValue, $advanced;
	global $processCount, $processCountLimit, $isUnderProcessLimit, $isUnderProcessLimit;

	$prostheticHand =  !empty($_SESSION['prostheticHand'])	? $_SESSION['prostheticHand']	: 'undefined';
	$part 		=  !empty($_SESSION['part']) 		? $_SESSION['part']		: 'undefined';
	$palmSelect 	=  !empty($_SESSION['palmSelect'])	? $_SESSION['palmSelect']	: 'undefined';
	$gauntletSelect =  !empty($_SESSION['gauntletSelect'])	? $_SESSION['gauntletSelect']	: 'undefined';
	$fingerSelect	=  !empty($_SESSION['fingerSelect'])	? $_SESSION['fingerSelect']	: 'undefined';
	$paddingValue	=  !empty($_SESSION['Padding']) 	? $_SESSION['Padding']		: 5;
	$advanced 	=  !empty($_SESSION['advanced'])	? $_SESSION['advanced']		: 'false';
	echo <<<HTML
	<script>
		var prostheticHandSession 	= {$prostheticHand};
		var partSession 		= {$part};
		var palmSelectSession 		= {$palmSelect};
		var gauntletSelectSession	= {$gauntletSelect};
		var fingerSelectSession		= {$fingerSelect};
		var isUnderProcessLimit		= {$isUnderProcessLimit};
		var processCount		= {$processCount};
	</script>
HTML;
}

function start_user_session( $assemblervars){
	// this starts the session
	session_start();
	$userid = session_id();
	load_session_data( $assemblervars);
}

function render( $assemblervars){
	$return = '';
	if(isset($_REQUEST['submit']) ){

		// Clean up the passed in $_REQUEST vars to make sure everything is set.
		foreach($assemblervars AS $a) {
			if(!isset($_REQUEST[$a]) || empty($_REQUEST[$a])) {
				$_REQUEST[$a] = 0;
			}
		}

		$assemblypath = "e-NABLE/Assembly/";
		$leftsidevars =  " -D Left1={$_REQUEST['Left1']} "
				. "-D Left2={$_REQUEST['Left2']} "
				. "-D Left3={$_REQUEST['Left3']} "
				. "-D Left4={$_REQUEST['Left4']} "
				. "-D Left5={$_REQUEST['Left5']} "
				. "-D Left6={$_REQUEST['Left6']} "
				. "-D Left7={$_REQUEST['Left7']} "
				. "-D Left8={$_REQUEST['Left8']} "
				. "-D Left9={$_REQUEST['Left9']} "
				. "-D Left10={$_REQUEST['Left10']}";
		$rightsidevars = " -D Right1={$_REQUEST['Right1']} "
				. "-D Right2={$_REQUEST['Right2']} "
				. "-D Right3={$_REQUEST['Right3']} "
				. "-D Right4={$_REQUEST['Right4']} "
				. "-D Right5={$_REQUEST['Right5']} "
				. "-D Right6={$_REQUEST['Right6']} "
				. "-D Right7={$_REQUEST['Right7']} "
				. "-D Right8={$_REQUEST['Right8']} "
				. "-D Right9={$_REQUEST['Right9']} "
				. "-D Right10={$_REQUEST['Right10']}";
		$options = 	 " -D part={$_REQUEST['part']} "
				. "-D prostheticHand={$_REQUEST['prostheticHand']} "
				. "-D gauntletSelect={$_REQUEST['gauntletSelect']} "
				. "-D fingerSelect={$_REQUEST['fingerSelect']} "
				. "-D palmSelect={$_REQUEST['palmSelect']} "
				. "-D Padding={$_REQUEST['Padding']} "
				. "-D WristBolt={$_REQUEST['WristBolt']} "
				. "-D KnuckleBolt={$_REQUEST['KnuckleBolt']} "
				. "-D JointBolt={$_REQUEST['JointBolt']} "
				. "-D ThumbBolt={$_REQUEST['ThumbBolt']} ";

		$scalehash = md5($leftsidevars.$rightsidevars.$options) .'.'. crc32($leftsidevars.$rightsidevars.$options);

		// Give the file a human readable name
		$partname='';
		switch($_REQUEST['part']){
		case 0:
			$partname='AssembledModel';
			break;
		case 1:
			$partname='Gauntlet';
			break;
		case 2:
			$partname='Palm';
			break;
		case 3:
			$partname='FingerProximal';
			break;
		case 4:
			$partname='FingerDistal';
			break;
		case 5:
			$partname='ThumbProximal';
			break;
		case 6:
			$partname='ThumbDistal';
			break;
		}

		// add handidness to the human reaale file name
		switch($_REQUEST['part']){
			case 0:
			case 2:
				if($_REQUEST['prostheticHand'] = 0){
					$partname='Left'.$partname;
				}elseif($_REQUEST['prostheticHand'] = 1){
					$partname='Right'.$partname;
				}
			break;
		}

		$previewimage = "imagecache/{$scalehash}.{$partname}.png";
		$exportfile   = "imagecache/{$scalehash}.{$partname}.stl";

		if($_REQUEST['submit'] == 'stl'){
			$thingtodo = $exportfile;
			$downloadlink = "<p class='download_stl'><a class='btn btn-success' href='{$exportfile}'>Download .STL file</a></p>\n";
		}else{
			$thingtodo = $previewimage;
			$downloadlink = '';
			if($_REQUEST['part'] >= 1){ // we are previewing a part, lets render it as well
				$otherthingtodo = $exportfile;
				$othercommand = "echo \" openscad -o {$otherthingtodo} {$leftsidevars} {$rightsidevars} {$options} {$assemblypath}Assembly.scad  \" | batch ";
			}
		}

		$command = " openscad -o {$thingtodo} {$leftsidevars} {$rightsidevars} {$options} {$assemblypath}Assembly.scad ";

		// Lets do some disk caching. If we have already rendered this, lets use the pre-rendering
		if(!file_exists($thingtodo) || filesize($thingtodo) == 0){
			$time_start = microtime(true);
			exec( "echo '\n' >> log.txt");
			exec( "date >> log.txt");
			exec( "echo 'NEW: " . escapeshellcmd($command) . "' >> log.txt");
		
			$results = exec( "export DISPLAY=:5; time nice -n 0 " . escapeshellcmd($command) . " >> log.txt 2>&1");
			$time_end = microtime(true);
			$execution_time = ($time_end - $time_start);
		}
		// See if we should p[re-render the .sto as well
		if(isset($othercommand) && !file_exists($otherthingtodo)){
			//die( "pre-generating file");
			exec( "echo '\n' >> log.txt");
			exec( "date >> log.txt");
			exec( "echo 'EXISTS: " . escapeshellcmd($othercommand) . "' >> log.txt");
			$result = exec( "export DISPLAY=:5; time nice -n 0 " . escapeshellcmd($othercommand) . " >> log.txt 2>&1");
			//die( $result . $othercommand );
		} else {
			//die( "file exists: " . file_exists($otherthingtodo) );
		}

		$return =  "<img src='imagecache/{$scalehash}.{$partname}.png' style='width:100%;' onError=\"this.onerror=null;this.src='./imgs/no_preview.png';\"/> {$downloadlink}";

		//	echo "<input type='submit' name='submit' value='Create .STL'> {$downloadlink}";
		//	echo "<p>Created preview in {$execution_time} seconds using the following command.</p>\n";
		$return .= "<p style='color:ivory;'>{$command}</p>\n";

		//	echo "<p>Computer Stats - for performance considerations</p>\n";
		//	echo "<pre>\n";
		//	echo `cat /proc/cpuinfo`;
		//	echo `cat /proc/meminfo`;
		//	echo "</pre>";
	} else {
		$return = "<p>A sample data set can be loaded by <a href='?Left1=66.47&Left2=64.04&Left3=46.95&Left4=35.14&Left5=35.97&Left6=27.27&Left7=31.80&Left8=40.97&Left9=31.06&Left10=147.5&Right1=62.67&Right2=65.62&Right3=59.14&Right4=48.78&Right5=51.85&Right6=16.4&Right7=0&Right8=72.52&Right9=72.23&Right10=230.6&part=0&gauntletSelect=1&fingerSelect=1&palmSelect=1&Padding=5&WristBolt=5.5&KnuckleBolt=3.3&JointBolt=3.3&ThumbBolt=3.3&submit=Preview'>Clicking here</a>.</p>\n";
	}
	return $return;
}

// Load the session data from the form, if available
// Loop through an array of options provided and set the session
function load_session_data($options) {
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

?>
