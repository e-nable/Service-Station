<?php
	require_once('backend.php');
	$submitType	=  isset($_GET["type"])? strtolower(trim($_GET["type"])): null;

	getSessionId();

	switch($submitType){
		case "sessionid":
			echo "{sessionId: '" .getSessionId() . "'}";
			break;
		case "processcount":
			echo "{count: $processCount, isUnderLimit: " . ($isUnderProcessLimit?'true':'false') ."}";
			$partname='Gauntlet';
			break;
		case "sessionvars":
			echo printJSONHeaderSessionVariables();
			break;
		default:
			echo "None";
	}

?>
