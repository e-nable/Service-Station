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
	'WristBolt', 'KnuckleBolt', 'JointBolt', 'ThumbBolt', 'advanced', 'email','inventory'
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
	$part 			=  !empty($_SESSION['part']) 		? $_SESSION['part']			: 0;
	$palmSelect 	=  !empty($_SESSION['palmSelect'])	? $_SESSION['palmSelect']	: 0;
	$gauntletSelect =  !empty($_SESSION['gauntletSelect'])	? $_SESSION['gauntletSelect']	: 0;
	$fingerSelect	=  !empty($_SESSION['fingerSelect'])	? $_SESSION['fingerSelect']		: 0;
	$paddingValue	=  !empty($_SESSION['Padding']) 	? $_SESSION['Padding']		: 5;
	$advanced 		=  !empty($_SESSION['advanced'])	? $_SESSION['advanced']		: 'false';
	$email	 		=  !empty($_SESSION['email'])		? $_SESSION['email']		: 'undefined';
	$inventory		=  !empty($_SESSION['inventory'])	? $_SESSION['inventory']	: 0;

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
		  email				: '{$email}',
		  inventory			: '{$inventory}',
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
	$part 			=  !empty($_SESSION['part']) 			? $_SESSION['part']			: 0;
	$palmSelect 	=  !empty($_SESSION['palmSelect'])		? $_SESSION['palmSelect']	: 0;
	$gauntletSelect =  !empty($_SESSION['gauntletSelect'])	? $_SESSION['gauntletSelect']	: 0;
	$fingerSelect	=  !empty($_SESSION['fingerSelect'])	? $_SESSION['fingerSelect']	: 0;
	$paddingValue	=  !empty($_SESSION['Padding']) 	? $_SESSION['Padding']		: 5;
	$advanced 		=  !empty($_SESSION['advanced'])	? $_SESSION['advanced']		: 'false';
	$email	 		=  !empty($_SESSION['email'])		? $_SESSION['email']		: 'undefined';
	$inventory		=  !empty($_SESSION['inventory'])	? $_SESSION['inventory']	: 0;

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
		var submitType		 		= {$submitType};
		var prostheticHandSession 	= {$prostheticHand};
		var partSession 			= {$part};
		var palmSelectSession 		= {$palmSelect};
		var gauntletSelectSession	= {$gauntletSelect};
		var fingerSelectSession		= {$fingerSelect};
		var isUnderProcessLimit		= {$isUnderProcessLimit};
		var processCount			= {$processCount};
		var email					= '{$email}';
		var inventory				= '{$inventory}';
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

?>
