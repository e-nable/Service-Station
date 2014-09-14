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
	
	<?php printHeaderSessionVariables(); ?>
	
	<script type="text/javascript">
		// TODO: move this stuff into AJAX services, etc.
		var server_email = function() { $("#email").val(); };
		var server_paddingValue = function() { $("#paddingValue").val(); };
		var server_render = function() { $("#render").val(); };
	</script>
</head>

<?php
	$render = render( $assemblervars);
?>

<body id="index" class="home">
<input id="email" type="hidden" value="{$email}" />
<input id="paddingValue" type="hidden" value="{$paddingValue}" />
<input id="render" type="hidden" value="{$render}" />

<form id="generatorForm" name="generatorForm">
	<div data-bind="template: { name: 'main-interface' }">
	</div>

	<?php
		echo file_get_contents('modals.html');
	?>
</form>
</body>
</html>

