<?php
/*
Web interface for back-end e-NABLE Assembler

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
*/
require_once('config.php');

$processCountLimit = 2;
$processCount = 0;
$isUnderProcessLimit = false;
$prostheticHand;
$part;
$palmSelect;
$gauntletSelect;
$fingerSelect;
$paddingValue;
$advanced;
$email;
$assemblervars = array(
	'Left1', 'Left2', 'Left3', 'Left4', 'Left5', 'Left6', 'Left7', 'Left8', 'Left9', 'Left10',
	'Right1', 'Right2', 'Right3', 'Right4', 'Right5', 'Right6', 'Right7', 'Right8', 'Right9', 'Right10',
	'part', 'gauntletSelect', 'fingerSelect', 'palmSelect', 'prostheticHand', 'Padding',
	'WristBolt', 'KnuckleBolt', 'JointBolt', 'ThumbBolt', 'advanced', 'email'
);

processCount();

function processCount(){
	global $processCount, $isUnderProcessLimit, $processCountLimit;
	$processCount = exec("ps aux  | grep 'openscad' | grep time | grep -v sh | grep -c -v 'grep'");
	$processCount = empty($processCount) ? 0 : $processCount;
	$isUnderProcessLimit = ($processCount < $processCountLimit);
}

function printJSONHeaderSessionVariables(){
	global $prostheticHand, $part, $palmSelect, $gauntletSelect, $fingerSelect, $paddingValue, $advanced;
	global $processCount, $processCountLimit, $isUnderProcessLimit, $isUnderProcessLimit, $email;

	$submitType	=  isset($_GET["submit"])? "'" . strtolower(trim($_GET["submit"])) . "'" : 'undefined';

	$prostheticHand =  !empty($_SESSION['prostheticHand'])	? $_SESSION['prostheticHand']	: 0;
	$part 		=  !empty($_SESSION['part']) 		? $_SESSION['part']		: 0;
	$palmSelect 	=  !empty($_SESSION['palmSelect'])	? $_SESSION['palmSelect']	: 0;
	$gauntletSelect =  !empty($_SESSION['gauntletSelect'])	? $_SESSION['gauntletSelect']	: 0;
	$fingerSelect	=  !empty($_SESSION['fingerSelect'])	? $_SESSION['fingerSelect']	: 0;
	$paddingValue	=  !empty($_SESSION['Padding']) 	? $_SESSION['Padding']		: 5;
	$advanced 	=  !empty($_SESSION['advanced'])	? $_SESSION['advanced']		: 'false';
	$email	 	=  !empty($_SESSION['email'])		? $_SESSION['email']		: 'undefined';

	$r1	=  $_SESSION['Right1'];		$r2	=  $_SESSION['Right2'];
	$r3	=  $_SESSION['Right3'];		$r4	=  $_SESSION['Right4'];
	$r5	=  $_SESSION['Right5'];		$r6	=  $_SESSION['Right6'];
	$r7	=  $_SESSION['Right7'];		$r8	=  $_SESSION['Right8'];
	$r9	=  $_SESSION['Right9'];		$r10	=  $_SESSION['Right10'];

	$l1	=  $_SESSION['Left1'];		$l2	=  $_SESSION['Left2'];
	$l3	=  $_SESSION['Left3'];		$l4	=  $_SESSION['Left4'];
	$l5	=  $_SESSION['Left5'];		$l6	=  $_SESSION['Left6'];
	$l7	=  $_SESSION['Left7'];		$l8	=  $_SESSION['Left8'];
	$l9	=  $_SESSION['Left9'];		$l10	=  $_SESSION['Left10'];

	echo <<<HTML
		{ submitType		: '{$submitType}',
		  prostheticHandSession : '{$prostheticHand}',
		  partSession 		: '{$part}',
		  palmSelectSession 	: '{$palmSelect}',
		  gauntletSelectSession	: '{$gauntletSelect}',
		  fingerSelectSession	: '{$fingerSelect}',
		  isUnderProcessLimit	: '{$isUnderProcessLimit}',
		  processCount		: '{$processCount}',
		  email			: '{$email}',
		  handSessionValues	: [
			{id: 'R1', value: '{$r1}'},	{id: 'R2', value: '{$r2}'},
			{id: 'R3', value: '{$r3}'},	{id: 'R4', value: '{$r4}'},
			{id: 'R5', value: '{$r5}'},	{id: 'R6', value: '{$r6}'},
			{id: 'R7', value: '{$r7}'},	{id: 'R8', value: '{$r8}'},
			{id: 'R9', value: '{$r9}'},	{id: 'R10', value: '{$r10}'},
			{id: 'L1', value: '{$l1}'},	{id: 'L2', value: '{$l2}'},
			{id: 'L3', value: '{$l3}'},	{id: 'L4', value: '{$l4}'},
			{id: 'L5', value: '{$l5}'},	{id: 'L6', value: '{$l6}'},
			{id: 'L7', value: '{$l7}'},	{id: 'L8', value: '{$l8}'},
			{id: 'L9', value: '{$l9}'},	{id: 'L10', value: '{$l10}'}
		]}
HTML;
}

function printHeaderSessionVariables(){
	global $prostheticHand, $part, $palmSelect, $gauntletSelect, $fingerSelect, $paddingValue, $advanced;
	global $processCount, $processCountLimit, $isUnderProcessLimit, $isUnderProcessLimit, $email;

	$submitType	=  isset($_GET["submit"])? "'" . strtolower(trim($_GET["submit"])) . "'" : 'undefined';

	$prostheticHand =  !empty($_SESSION['prostheticHand'])	? $_SESSION['prostheticHand']	: 0;
	$part 		=  !empty($_SESSION['part']) 		? $_SESSION['part']		: 0;
	$palmSelect 	=  !empty($_SESSION['palmSelect'])	? $_SESSION['palmSelect']	: 0;
	$gauntletSelect =  !empty($_SESSION['gauntletSelect'])	? $_SESSION['gauntletSelect']	: 0;
	$fingerSelect	=  !empty($_SESSION['fingerSelect'])	? $_SESSION['fingerSelect']	: 0;
	$paddingValue	=  !empty($_SESSION['Padding']) 	? $_SESSION['Padding']		: 5;
	$advanced 	=  !empty($_SESSION['advanced'])	? $_SESSION['advanced']		: 'false';
	$email	 	=  !empty($_SESSION['email'])		? $_SESSION['email']		: 'undefined';

	$r1	=  $_SESSION['Right1'];		$r2	=  $_SESSION['Right2'];
	$r3	=  $_SESSION['Right3'];		$r4	=  $_SESSION['Right4'];
	$r5	=  $_SESSION['Right5'];		$r6	=  $_SESSION['Right6'];
	$r7	=  $_SESSION['Right7'];		$r8	=  $_SESSION['Right8'];
	$r9	=  $_SESSION['Right9'];		$r10	=  $_SESSION['Right10'];

	$l1	=  $_SESSION['Left1'];		$l2	=  $_SESSION['Left2'];
	$l3	=  $_SESSION['Left3'];		$l4	=  $_SESSION['Left4'];
	$l5	=  $_SESSION['Left5'];		$l6	=  $_SESSION['Left6'];
	$l7	=  $_SESSION['Left7'];		$l8	=  $_SESSION['Left8'];
	$l9	=  $_SESSION['Left9'];		$l10	=  $_SESSION['Left10'];

	echo <<<HTML
	<script>
		var submitType		 	= {$submitType};
		var prostheticHandSession 	= {$prostheticHand};
		var partSession 		= {$part};
		var palmSelectSession 		= {$palmSelect};
		var gauntletSelectSession	= {$gauntletSelect};
		var fingerSelectSession		= {$fingerSelect};
		var isUnderProcessLimit		= {$isUnderProcessLimit};
		var processCount		= {$processCount};
		var email			= '{$email}';
		var handSessionValues		= [
			{id: 'R1', value: '{$r1}'},	{id: 'R2', value: '{$r2}'},
			{id: 'R3', value: '{$r3}'},	{id: 'R4', value: '{$r4}'},
			{id: 'R5', value: '{$r5}'},	{id: 'R6', value: '{$r6}'},
			{id: 'R7', value: '{$r7}'},	{id: 'R8', value: '{$r8}'},
			{id: 'R9', value: '{$r9}'},	{id: 'R10', value: '{$r10}'},
			{id: 'L1', value: '{$l1}'},	{id: 'L2', value: '{$l2}'},
			{id: 'L3', value: '{$l3}'},	{id: 'L4', value: '{$l4}'},
			{id: 'L5', value: '{$l5}'},	{id: 'L6', value: '{$l6}'},
			{id: 'L7', value: '{$l7}'},	{id: 'L8', value: '{$l8}'},
			{id: 'L9', value: '{$l9}'},	{id: 'L10', value: '{$l10}'}
		];
	</script>
HTML;
}

function getSessionId(){
	if (session_id() == '') {
		session_start();
	}
	return session_id();
}

function start_user_session( $assemblervars){
	// this starts the session
	$userid = getSessionId();

	// Load the session data from the form, if available
	// Loop through an array of options provided and set the session
	foreach($assemblervars AS $option){
		if (isset($_REQUEST[$option])){
			$_SESSION[$option] = $_REQUEST[$option];
		} elseif ( !isset($_SESSION[$option])) {
			$_SESSION[$option] = '';
		}
	}
}

function render( $assemblervars){
	global $enable_camera;

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

		// Give the file a human readable name, search options
		$json = file_get_contents ('./e-NABLE/options.json');
		$jsonArray = json_decode($json, true);
		$vals = $jsonArray['part'];
		$partname = "UknownType";
		foreach ($vals AS $key){
			if ($key['id'] == $_REQUEST['part']){
				$partname = $key['filename'];
				break;
			}
		}

		// add handidness to the human reaale file name
		switch($_REQUEST['part']){
			case 0:
			case 2:
				if ($_REQUEST['prostheticHand'] = 0){
					$partname='Left'.$partname;
				} elseif ($_REQUEST['prostheticHand'] = 1){
					$partname='Right'.$partname;
				}
			break;
		}

		$previewimage = "imagecache/{$scalehash}.{$partname}.png";
		$exportfile   = "imagecache/{$scalehash}.{$partname}.stl";

		$cameraFlag	 =  !empty($enable_camera)? $enable_camera : false;

		$specialView ='';
		if ($cameraFlag && ($_REQUEST['part'] == 0 || $_REQUEST['part'] == -1)){
			$specialView ='--camera=0,0,460,0,0,0';
		}

		if($_REQUEST['submit'] == 'stl'){
			$thingtodo = $exportfile;
			$downloadlink = "<p class='download_stl'><a class='btn btn-success' href='{$exportfile}'>Download .STL file</a></p>\n";
		}else{
			$thingtodo = $previewimage;
			$downloadlink = '';
			if ($_REQUEST['part'] >= 1){ // we are previewing a part, lets render it as well
				$otherthingtodo = $exportfile;
				$othercommand = "echo \" openscad -o --imgsize=428,400 {$otherthingtodo} {$leftsidevars} {$rightsidevars} {$options} {$assemblypath}Assembly.scad  \" | batch ";
			}
		}

		$command = " openscad -o {$thingtodo} --imgsize=856,760 {$specialView} {$leftsidevars} {$rightsidevars} {$options} {$assemblypath}Assembly.scad ";

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
		//$return .= "<p style='color:ivory;'>{$command}</p>\n";

		//	echo "<p>Computer Stats - for performance considerations</p>\n";
		//	echo "<pre>\n";
		//	echo `cat /proc/cpuinfo`;
		//	echo `cat /proc/meminfo`;
		//	echo "</pre>";
	} else {
		$return = "Please choose to render an item";
	}

	return $return;
}

?>
