<?php
	require_once('backend.php');

	echo "{count: $processCount, isUnderLimit: " . ($isUnderProcessLimit?'true':'false') ."}";

?>
