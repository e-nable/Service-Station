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

	<link rel="stylesheet" href="./lib/bootstrap-3.2-minus-responsive.css?_=<?php echo $time ?>">
	<link rel="stylesheet" href="./lib/bootstrap-3.1.1/css/bootstrap-theme.min.css?_=<?php echo $time ?>">
	<link rel="stylesheet" href="./lib/font-awesome-4.0.3/css/font-awesome.min.css?_=<?php echo $time ?>">
	<link rel="stylesheet" href="./css/main.css?_=<?php echo $time ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="./lib/bootstrap-3.1.1/js/bootstrap.min.js"></script>
	<script src="./lib/knockout-3.2.0.js"></script>
	<script src="./lib/sammy-latest.min.js"></script>
	
	<?php echo file_get_contents('js/knockout_templates.html'); ?>
	
	<script type="text/javascript">
		// TODO: move this stuff into AJAX services, etc.
		var server_email = function() { $("#email").val(); };
		var server_paddingValue = function() { $("#paddingValue").val(); };
		
		// Google Analytics
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js', 'ga');
		
		ga('create', 'UA-55621004-1', { 'cookieDomain': 'none' });	// FOR DEBUGGING PURPOSES ON LOCAL*/
		//ga('create', 'UA-55621004-1', 'auto');

		window.ga_sendPath = function() {
			ga('send', 'pageview', window.location.href.replace(window.location.origin, ""));
		};
		
		window.ga_sendPath();
	</script>
	<script src="./js/main.js?_=<?php echo $time ?>"></script> <!-- REMOVE THE PHP ECHO TO MAKE DEBUGGING EASIER IN CHROME-->
	
	<script type="text/javascript">
		// TODO: move this stuff into AJAX services, etc.
		var server_email = function() { $("#email").val(); };
		var server_paddingValue = function() { $("#paddingValue").val(); };
	</script>
</head>

<?php
	$render = render( $assemblervars);
?>
<?php printHeaderSessionVariables(); ?>
	

<body id="index" class="home">
<input id="email" type="hidden" value="{$email}" />
<input id="paddingValue" type="hidden" value="{$paddingValue}" />

<form id="generatorForm" name="generatorForm">
	<div data-bind="template: { name: 'main-interface' }"></div>

	<?php
		echo file_get_contents('modals.html');
	?>
</form>
</body>
</html>

