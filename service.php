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
    
	header('content-type: application/json; charset=utf-8');

	require_once('config.php');
	require_once('backend.php');

	start_user_session( $assemblervars);

	//header('Content-Type: application/json');

	$submitType	=  isset($_GET["type"])? strtolower(trim($_GET["type"])): null;

	getSessionId();

	switch($submitType){
		case "make":
			$url 	= "";
			$status = "";
			// Clean up the passed in $_REQUEST vars to make sure everything is set.
			foreach($assemblervars AS $a) {
				if(!isset($_REQUEST[$a]) || empty($_REQUEST[$a])) {
					$_REQUEST[$a] = 0;
				}
			}

			$assemblypath = dirname(__FILE__)."/e-NABLE/Assembly/";
			$exportfile = "";
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
			$options = "-D prostheticHand={$_REQUEST['prostheticHand']} "
				. "-D gauntletSelect={$_REQUEST['gauntletSelect']} "
				. "-D fingerSelect={$_REQUEST['fingerSelect']} "
				. "-D palmSelect={$_REQUEST['palmSelect']} "
				. "-D Padding={$_REQUEST['Padding']} "
				. "-D WristBolt={$_REQUEST['WristBolt']} "
				. "-D KnuckleBolt={$_REQUEST['KnuckleBolt']} "
				. "-D JointBolt={$_REQUEST['JointBolt']} "
				. "-D ThumbBolt={$_REQUEST['ThumbBolt']} ";

			//$scalehash = md5($leftsidevars.$rightsidevars.$options) .'.'. crc32($leftsidevars.$rightsidevars.$options);
			//$scalehash = time() .'.'. crc32($leftsidevars.$rightsidevars.$options);

			$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

			$email = $_REQUEST['email'];
			$requestedPart = 0; //$_REQUEST['part'];
			$emailInvalid = 1;

			$scalehash = crc32($baseDNS) . '-' . crc32($email.$requestedPart.$leftsidevars.$rightsidevars.$options);

			if (preg_match($pattern, $email) === 1) {
    			// emailaddress is valid
    			$emailInvalid = 0;
			} else {
				$emailInvalid = 1;
			}


			$myPath = dirname(__FILE__) . '/ticket/' .  $scalehash;

			if (! is_file($myPath . '.zip') && !mkdir($myPath, 0777, true) && $emailInvalid == 0) {
				//die('Failed to create folder...');
				 exec( "'Already currently in progress: {$myPath}' >> log.txt");
				 $status = 'In Progress';
			} elseif (! is_file($myPath . '.zip') && $emailInvalid == 0){
				// add handidness to the human reaale file name
				$side = "Unknown";

				if ($_REQUEST['prostheticHand'] = 0){
					$side='Left';
				} elseif ($_REQUEST['prostheticHand'] = 1){
					$side='Right';
				}

				// Give the file a human readable name, search options
				$json = file_get_contents (dirname(__FILE__).'/e-NABLE/options.json');
				$jsonArray = json_decode($json, true);
				$vals = $jsonArray['part'];
				$partname = "UknownType";

				$time_start = microtime(true);
				exec( "echo '\n' >> log.txt");
				exec( "date >> log.txt");

				foreach ($vals AS $key){
					$partname = $key['filename'];
					$myID = $key['id'];

					if (($requestedPart == 0 || $requestedPart == $myID ) && $partname){
						$thisFile	= "{$myPath}/{$side}.{$partname}.stl";
						if (! is_file($thisFile)){
							$exportfile .= "time nice -n 0 openscad -o {$thisFile} {$leftsidevars} {$rightsidevars} -D part={$myID} {$options} {$assemblypath}Assembly.scad;";
							exec( "echo 'NEW: " . escapeshellcmd($exportfile) . "' >> log.txt");
						} else {
							exec(" echo 'Already found: {$thisFile}' >> log.txt 2>&1");
						}
					}
				}

				$url = 'http://' . $baseDNS . '/ticket/' .  $scalehash . '.zip';
				
				$exportfile .= "zip -j -r {$myPath}.zip {$myPath}/;";
				$exportfile .= "mail  -a 'Content-type: text/html' -a 'CC:enablematcher@gmail.com' -a 'From: e-NABLE' -s 'e-NABLE Model' {$email} < {$myPath}/README.html;";
				$exportfile .= "rm -r {$myPath} {$myPath}.sh;";

				$file = fopen("{$myPath}.sh","x");
				fwrite($file,$exportfile);
				fclose($file);
				$fullURL = $leftsidevars . ' ' . $rightsidevars . ' ' . $options ;
				$fullURL = str_replace("-D","&",$fullURL);
				$fullURL = str_replace(" ","",$fullURL);
				$fullURL = 'email=' . str_replace("@","\@",$email) . '&part=' . $requestedPart . $fullURL;
				$myDNS =  str_replace("/","\/",$baseDNS);

				exec("cp " . dirname(__FILE__) ."/emailTemplate.html {$myPath}/README.html;");
				exec("perl -i -pe's/DOMAIN/{$myDNS}/g' {$myPath}/README.html");
				exec("perl -i -pe's/TICKET_ID/{$scalehash}/g' {$myPath}/README.html");
				exec("perl -i -pe's/URL_PARAMS/{$fullURL}/g' {$myPath}/README.html");

				exec("chmod 755 {$myPath}.sh; {$myPath}.sh > /dev/null &");

				$time_end = microtime(true);
				$execution_time = ($time_end - $time_start);

				$status = 'Initiated';

				$url = "";

  			} elseif ($emailInvalid == 0) {
  				exec( "'Build already completed! -> {$myPath}' >> log.txt");
  				$url = 'http://' . $baseDNS . '/ticket/' .  $scalehash . '.zip';
  				$status = 'Completed';
  			} else {
  				$status = 'Email Error';
  			}

			echo '{ticket: "' . $scalehash . '", status: "' . $status .'", url: "'. $url .'"}';

			break;
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
