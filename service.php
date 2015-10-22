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

	// -- Yourl Request
	$timeout_ms	= 2500;
	$status = 400;
	$cilog_file = 'ci.log';
	$debug_file = 'debug.log';
	$csv_file = 'log.csv';
	$releaseVersion = '0.00';

	$api_url				= 'http://u.e-nable.me/yourls-api.php';
	$defaultInventoryFile	= 'options.json';

	start_user_session( $assemblervars);

	$noteValue		=  isset($_GET["note"])? strtolower(trim($_GET["note"])): null;
	$submitType		=  isset($_GET["type"])? strtolower(trim($_GET["type"])): null;
	$inventoryFile	=  isset($_GET["inventory"])? strtolower(trim($_GET["inventory"])): $defaultInventoryFile;

	if (empty($baseDNS)){
		$baseDNS = 'PLEASE_FIX';
	} 

	getSessionId();
	switch($submitType){
		case "make": case "preview":
			$url 	= "";
			$translatedURL = ""; //this is the variable we actually use for email, etc
			$description = "";
			$status = "";
			$urlLabel = "";

			// We're about to exit with an error if we can't find the inventory file
			if (!file_exists(dirname(__FILE__).'/e-NABLE/' .$inventoryFile)){
				$status = 500;
				echo '{"description": "Inventory file not found", "status": 500}';
				break;
			}

			// CONTINUED - file found

			// Clean up the passed in $_REQUEST vars to make sure everything is set.
			foreach($assemblervars AS $a) {
				if(!isset($_REQUEST[$a]) || empty($_REQUEST[$a])) {
					$_REQUEST[$a] = 0;
				}
				//print $a . '='. $_REQUEST[$a] .'; ';
			}

			$assemblypath = dirname(__FILE__) . "/e-NABLE/Assembly/";
			$servicesPath = dirname(__FILE__) . "/Service/";
			$basePath = dirname(__FILE__);

            $assemblyHash = '0';
            $servicesHash = '0';
            $uiHash = '0';

            $return_var = '';

            exec("cd $assemblypath; git log -n 1 --pretty=format:'%h %s' | awk '{print $1}' 2>&1; cd $basePath;", $assemblyHash, $return_var);
            $assemblyHash = $assemblyHash[0];

            exec("cd $basePath; git log -n 1 --pretty=format:'%h %s' | awk '{print $1}' 2>&1; cd $basePath;", $uiHash, $return_var);
            $uiHash = $uiHash[0];

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
			$options = " -D prostheticHand={$_REQUEST['prostheticHand']} "
				. "-D gauntletSelect={$_REQUEST['gauntletSelect']} "
				. "-D fingerSelect={$_REQUEST['fingerSelect']} "
				. "-D palmSelect={$_REQUEST['palmSelect']} "
				. "-D Padding={$_REQUEST['Padding']} "
				. "-D WristBolt={$_REQUEST['WristBolt']} "
				. "-D KnuckleBolt={$_REQUEST['KnuckleBolt']} "
				. "-D JointBolt={$_REQUEST['JointBolt']} "
				. "-D ThumbBolt={$_REQUEST['ThumbBolt']} ";

			//$ticketNo = md5($leftsidevars.$rightsidevars.$options) .'.'. crc32($leftsidevars.$rightsidevars.$options);
			//$ticketNo = time() .'.'. crc32($leftsidevars.$rightsidevars.$options);

			$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

			$email = $_REQUEST['email'];
			$requestedPart = 0; //$_REQUEST['part'];
			$emailInvalid = 1;

			$previewID = crc32($requestedPart.$leftsidevars.$rightsidevars.$options.$inventoryFile). '-' . $assemblyHash;
			$userHash = crc32($email);
			$ticketNo = crc32($baseDNS) . '-' . $userHash . '-' . $previewID;

			if (preg_match($pattern, $email) === 1) {
    			// emailaddress is valid
    			$emailInvalid = 0;
			} else {
				$emailInvalid = 1;
			}

			$url = 'http://' . $baseDNS . '/ticket/' .  $ticketNo . '.zip';
			$isTranslatedURL = FALSE;

			$translatedURL = $url;

			if (isset($partnerTinyURLID)){

				// Init the CURL session
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $api_url);
				curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result
				curl_setopt($ch, CURLOPT_POST, 1);              // This is a POST request
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $timeout_ms); // Timeout
				curl_setopt($ch, CURLOPT_POSTFIELDS, array(     // Data to POST
					'url'           => $url,
					'signature'     => $partnerTinyURLID,
					'format'        => 'json',
					'action'        => 'shorturl'
				));

				// Fetch and return content
				$data = curl_exec($ch);
				curl_close($ch);

				// Parse JSON
				$data_a = json_decode( $data );

				// Make sure we have a translation
				$sURL =  strval($data_a->shorturl);

				$position = strpos($sURL, "e-nable.me");

				if ($position !== false) {
					$translatedURL = $sURL;
					$urlLabel = " -D 'label=". '"' . str_replace("http://","",$sURL). '"' ."'";
				} else {
					$urlLabel = "";
				}

				// -- done YourL Request

				#foreach($data_a->url as $key => $value){
				#  echo "<BR> - [" . $key."] -- [". $value . "]";
				#}
			}

			$myPath = dirname(__FILE__) . '/ticket/' .  $ticketNo;
			$buildLogPath = $myPath . '/build.log';

			$ticketLogPath = $myPath . '/log.txt';
			$generalLogPath = dirname(__FILE__) . '/log.txt';
			$csvLogPath = dirname(__FILE__) . '/ticket/'. $csv_file;

			// Start
			switch($submitType){
				case "preview":
					$requestedPart ;//= $_REQUEST['part'];
					$previewID = $previewID .'-' . $requestedPart;
					$relativePath = "/imagecache/{$previewID}.png";
					$previewFile = dirname(__FILE__) . $relativePath;
					$imageURL = $baseDNS . $relativePath;
					$renderType = 0;

					if (! is_file($previewFile)){
						$specialView ='';
						if ($cameraFlag && ($_REQUEST['part'] == 0 || $_REQUEST['part'] == -1)){
							$specialView ='--camera=0,0,460,0,0,0';
						}

						$time_start = microtime(true);
						$scadCommand  = "openscad -o {$previewFile} --imgsize=856,760  {$specialView} {$urlLabel} {$leftsidevars} {$rightsidevars} -D part={$requestedPart} {$options} {$assemblypath}Assembly.scad";
						$results = exec( "export DISPLAY=:5; time nice -n 0 " . escapeshellcmd($scadCommand) . " >> log.txt 2>&1");
						$time_end = microtime(true);
						$execution_time = ($time_end - $time_start);
						$renderType = 1;
					} else {
						$renderType = 0;
					}

					if (is_file($previewFile)){
						$status = 201;
						echo '{"imagePath": "' . $imageURL . '", "type":"Preview", "renderType": "'. $renderType .'", "previewID": "'. $previewID .'" ,"status": ' . $status . '}';
					} else {
						$renderType = -1;
						$status = 400;
						echo '{"description": "There was a problem rendering the image", "renderType": "'. $renderType .'", "previewID": "'.$previewID .'" ,"type":"Preview" ,"status": ' . $status . '}';
					}
				break;
				case "make":

				if (! is_file($myPath . '.zip') && !mkdir($myPath, 0777, true) && $emailInvalid == 0) {
					//die('Failed to create folder...');
					//exec( "'Already currently in progress: {$myPath}' >> {$ticketLogPath}");
					$description = 'In Progress';
					$status = 200;
					exec( "echo '\nMarked as already in Progress: \n Email: {$email} \n Ticket: {$ticketNo}' >> {$generalLogPath}");
					exec( "date >> {$generalLogPath}");
					$translatedURL = "";
				//} elseif (! is_file($myPath . '.zip') && $emailInvalid == 0){
				} elseif ($emailInvalid == 0 && ! is_file($myPath . '.zip')){
					// add handidness to the human reaale file name
					$side = "Unknown";
					$build_side = "UNK";
					$measurement8 = 0;
					$timestamp = date('Y-m-d H:i:s');
					$urlString = $_SERVER['QUERY_STRING'];

					$right0 = 0;
					$right1 = 0;
					$right2 = 0;
					$right3 = 0;
					$right4 = 0;
					$right5 = 0;
					$right6 = 0;
					$right7 = 0;
					$right8 = 0;
					$right9 = 0;
					$right10 = 0;

					$left0 = 0;
					$left1 = 0;
					$left2 = 0;
					$left3 = 0;
					$left4 = 0;
					$left5 = 0;
					$left6 = 0;
					$left7 = 0;
					$left8 = 0;
					$left9 = 0;
					$left10 = 0;

					if ($_REQUEST['prostheticHand'] == 0){
						$side='Left';
						$build_side = "R";
						$right8 = $_REQUEST['Right8'];
						$measurement8 = $right8;
					} elseif ($_REQUEST['prostheticHand'] == 1){
						$side='Right';
						$build_side = "L";
						$left8 = $_REQUEST['Left8'];
						$measurement8 = $left8;
					}

					// Give the file a human readable name, search options
					$json = file_get_contents (dirname(__FILE__) . '/e-NABLE/' . $inventoryFile);
					$jsonArray = json_decode($json, true);
					$vals = $jsonArray['part'];
					$partname = "UknownType";

					$time_start = microtime(true);
					exec( "echo '' >> {$generalLogPath}");
					exec( "date >> {$generalLogPath}");
					exec( "echo 'Starting Full Assembly: \n Email: {$email} \n Ticket: {$ticketNo}' >> {$generalLogPath};");
					exec( "echo ' Inventory File: {$inventoryFile}' >> {$generalLogPath}");
					exec( "echo ' URL: {$urlString}' >> {$generalLogPath}");
					exec( "echo ' Params: {$requestedPart}{$leftsidevars}{$rightsidevars}{$options}' >> {$generalLogPath}");
					//exec( "echo '\nStarting: ' >> {$ticketLogPath}");
					exec( "date >> {$buildLogPath}");
					exec( "echo 'TicketID: {$ticketNo}' >> {$buildLogPath}");
					exec( "echo 'Inventory File: {$inventoryFile}' >> {$buildLogPath}");

					$exportfile  .= "\n date >> {$generalLogPath}; \n";

					foreach ($vals AS $key){
						$partname = $key['filename'];
						$myID = $key['id'];

						$partname = str_replace(" ","_",$partname);

						if (($requestedPart == 0 || $requestedPart == $myID ) && $partname){
							$thisFile	= "{$myPath}/{$side}.{$partname}.stl";
							if (! is_file($thisFile)){
								$scadCommand  = "openscad -o {$thisFile} ${urlLabel} {$leftsidevars} {$rightsidevars} -D part={$myID} {$options} {$assemblypath}Assembly.scad";
								$exportfile  .= "\necho ' ' >> {$buildLogPath};";
								$exportfile  .= "\necho '{$scadCommand}' >> {$buildLogPath};";
								$exportfile  .= "\n\ntime nice -n 0 {$scadCommand} >> {$buildLogPath} 2>&1;";
								//exec( "echo 'NEW: " . escapeshellcmd($exportfile) . "' >> {$buildLogPath}");
							} else {
								exec(" echo 'Already found: {$thisFile}' >> {$buildLogPath} 2>&1");
							}
						}
					}
						
					$exportfile .= "\necho 'Completed: ' `date` >> {$buildLogPath} ;";
					$exportfile .= "\necho ' ' >> {$generalLogPath};";
					$exportfile .= "\necho 'Completed {$ticketNo} ({$email}): ' `date` >> {$generalLogPath};";
					$exportfile .= "\nzip -j -r {$myPath}.zip {$myPath}/ >> {$generalLogPath} 2>&1;";
					if(!isset($fromEmail)) {
						$fromEmail = "enablematcher@gmail.com";
					}
					$exportfile .= "\nmail  -a 'Content-type: text/html' -a 'CC:enablematcher@gmail.com' -a 'From: ".$fromEmail."' -s 'e-NABLE Model' {$email} < {$myPath}/README.html >> {$generalLogPath} 2>&1;";
					$exportfile .= "\necho ' [ Stack ]=---------------------------------------------------' >> {$generalLogPath};";
					$exportfile .= "\ncat {$buildLogPath} >> {$generalLogPath};";
					$exportfile .= "\necho '[ -------------------------- DONE --------------------------- ]' >> {$generalLogPath};";
					$exportfile .= "\necho 'Emailed {$ticketNo} ({$email}): ' `date` >> {$generalLogPath};";
					$exportfile .= "\necho ' ' >> {$generalLogPath};";
					$exportfile .= "\necho ' ' >> {$generalLogPath};";
					$exportfile .= "rm -r {$myPath} {$myPath}.sh >> {$generalLogPath} 2>&1;";

					$file = fopen("{$myPath}.sh","x");
					fwrite($file,$exportfile);
					fclose($file);

					$fullURL = $leftsidevars . ' ' . $rightsidevars . ' ' . $options ;
					$fullURL = str_replace("-D","&",$fullURL);
					$fullURL = str_replace(" ","",$fullURL);
					$fullURL = 'email=' . str_replace("@","\@",$email) . '&part=' . $requestedPart . $fullURL;
					//$myDNS =  str_replace("/","\/",$baseDNS);
					$myURL =  str_replace("/","\/",$translatedURL);

					exec("cp " . dirname(__FILE__) ."/emailTemplate.html {$myPath}/README.html;");
					//exec("perl -i -pe's/DOMAIN/{$myDNS}/g' {$myPath}/README.html");
					exec("perl -i -pe's/FULL_URL/{$myURL}/g' {$myPath}/README.html");
					exec("perl -i -pe's/TICKET_ID/{$ticketNo}/g' {$myPath}/README.html");
					exec("perl -i -pe's/URL_PARAMS/{$fullURL}/g' {$myPath}/README.html");
					exec("perl -i -pe's/PROSTHETIC_HAND/{$side}/g' {$myPath}/README.html");
					exec("perl -i -pe's/BUILD_SIDE/{$build_side}/g' {$myPath}/README.html");
					exec("perl -i -pe's/MEASUREMENT8/{$measurement8}/g' {$myPath}/README.html");
					exec("perl -i -pe's/EMAIL/{$email}/g' {$myPath}/README.html");

					$palmStyle 		= $_REQUEST['palmSelect'];
					$fingerStyle 	= $_REQUEST['fingerSelect'];
					$gauntletStyle 	= $_REQUEST['gauntletSelect'];
					$paddingValue 	= $_REQUEST['Padding'];

					$palmVars 		= $jsonArray['palm'];
					$fingerVars 	= $jsonArray['finger'];
					$gauntletVars 	= $jsonArray['gauntlet'];

					$palmStyleLabel		= '';
					$fingerStyleLabel	= '';
					$gauntletStyleLabel	= '';

					foreach ($palmVars AS $key){
						$partname = $key['name'];
						$myID = $key['id'];

						if (($palmStyle == $myID ) && $partname){
							$palmStyleLabel = $partname;
						}
					}

					foreach ($fingerVars AS $key){
						$partname = $key['name'];
						$myID = $key['id'];

						if (($fingerStyle == $myID ) && $partname){
							$fingerStyleLabel = $partname;
						}
					}

					foreach ($gauntletVars AS $key){
						$partname = $key['name'];
						$myID = $key['id'];

						if (($gauntletStyle == $myID ) && $partname){
							$gauntletStyleLabel = $partname;
						}
					}

					exec("perl -i -pe's/PALM_STYLE/{$palmStyleLabel}/g' {$myPath}/README.html");
					exec("perl -i -pe's/FINGER_STYLE/{$fingerStyleLabel}/g' {$myPath}/README.html");
					exec("perl -i -pe's/GAUNTLET_STYLE/{$gauntletStyleLabel}/g' {$myPath}/README.html");
					exec("perl -i -pe's/PADDING/{$paddingValue}/g' {$myPath}/README.html");
					exec("perl -i -pe's/TIMESTAMP/{$timestamp}/g' {$myPath}/README.html");

					$palmStyleLabel = str_replace(","," -",$palmStyleLabel);
					$fingerStyleLabel = str_replace(","," -",$fingerStyleLabel);
					$gauntletStyleLabel = str_replace(","," -",$gauntletStyleLabel);

					$ip = getenv('HTTP_CLIENT_IP') ?:
						getenv('HTTP_X_FORWARDED_FOR') ?:
						getenv('HTTP_X_FORWARDED') ?:
						getenv('HTTP_FORWARDED_FOR') ?:
						getenv('HTTP_FORWARDED') ?:
						getenv('REMOTE_ADDR')?:'UNKNOWN';

					$csvValues = "{$ip},{$releaseVersion},{$uiHash},{$servicesHash},{$assemblyHash}," .
								 "{$ticketNo},{$userHash},{$timestamp}," .
								 "{$side},{$build_side}," .
								 "{$measurement8},{$paddingValue}," .
								 "{$right0},{$right1},{$right2},{$right3},{$right4},{$right5},{$right6},{$right7},{$right8},{$right9},{$right10}," .
								 "{$left0},{$left1},{$left2},{$left3},{$left4},{$left5},{$left6},{$left7},{$left8},{$left9},{$left10}," .
								 "{$palmStyle},{$palmStyleLabel}," .
								 "{$fingerStyle},{$fingerStyleLabel}," .
								 "{$gauntletStyle},{$gauntletStyleLabel}";

					// create CSV file if not present
					if (! is_file($csvLogPath)) {
						$csvVHeaders = "IP,releaseVersion,uiHash,servicesHash,assemblyHash," .
								 "ticketNo,userHash,timestamp," .
								 "side,build_side," .
								 "measurement8,paddingValue," .
								 "right0,right1,right2,right3,right4,right5,right6,right7,right8,right9,right10," .
								 "left0,left1,left2,left3,left4,left5,left6,left7,left8,left9,left10," .
								 "palmStyle,palmStyleLabel," .
								 "fingerStyle,fingerStyleLabel," .
								 "gauntletStyle,gauntletStyleLabel";

						exec("echo '{$csvVHeaders}' > {$csvLogPath};");
						exec("chmod 777 {$csvLogPath};");
					}

					// Write parameters to CSV
					if (is_file($csvLogPath)) {
						exec("echo '\n{$csvValues} ' >> {$csvLogPath};");
					}

					exec("chmod 755 {$myPath}.sh; {$myPath}.sh > /dev/null &");

					$time_end = microtime(true);
					$execution_time = ($time_end - $time_start);

					$description = 'Initiated';
					$status = 206;

					$url = "";
					$translatedURL = "";

		  		} elseif ($emailInvalid == 0) {
					//exec( "'Build already completed! -> {$myPath}' >> {$ticketLogPath}");

					$description = 'Completed';
					$status = 201;
					exec( "echo '\nMarked as COMPLETED: \n Email: {$email} \n Ticket: {$ticketNo}' >> {$generalLogPath}");
					exec( "date >> {$generalLogPath}");
					exec( "echo ' Params: {$requestedPart}{$leftsidevars}{$rightsidevars}{$options}' >> {$generalLogPath}");
		  		} else {
					$description = 'Email Error';
					$status = 400;
		  		}

				// this prevent us from printing the URL in the response when there isn't one to show
				$urlOUT = "";
				if (isset($translatedURL) && $translatedURL != ""){
					$urlOUT = ', "url": "' . $translatedURL . '"';
				}

				// printing status
				echo '{"ticket": "' . $ticketNo . '", "description": "' . $description . '", "status": ' . $status . $urlOUT .'}';

				break;
			}
			break;
		case "sessionid":
			$status = 200;
			echo '{"sessionId": "' .getSessionId() . '"}';
			break;
		case "processcount":
			$status = 200;
			echo '{"count": '.$processCount.', "isUnderLimit": "' . ($isUnderProcessLimit?'true':'false') .'"}';
			$partname='Gauntlet';
			break;
		case "test":
			$assemblyHash = '';
			$return_var = '';
			$assemblypath = dirname(__FILE__)."/e-NABLE/Assembly/";
			$basePath = dirname(__FILE__);
			exec("cd $assemblypath; git log -n 1 --pretty=format:'%h %s' | awk '{print $1}' 2>&1; cd $basePath;", $assemblyHash, $return_var);
			$assemblyHash = $assemblyHash[0];
			#print_r ($output);
			#echo $output;
			echo '{"output": "'.$assemblyHash.'", "return": "'.$return_var.'"}';
			break;
		case "cilog":
			$timestamp = date('Y-m-d H:i:s');

			$ciLogPath = dirname(__FILE__) . '/ticket/'. $cilog_file;
			$newCIFile = false;

			if (! is_file($csvLogPath)) {
				$newCIFile = true;
			}

			exec("echo '{$timestamp} {$noteValue}' >> {$ciLogPath};");

			if ($newCIFile) {
				exec("chmod 777 {$csvLogPath};");
			}

			echo '{"timestamp": "'.$timestamp.'", "note": "'.$noteValue.'"}';
			break;
		case "sessionvars":
			$status = 200;
			echo printJSONHeaderSessionVariables();
			break;
		case "version":
			$assemblyRepo = '';
			$webRepo = '';
			$return_var = '';
			$assemblypath = dirname(__FILE__)."/e-NABLE/Assembly/";
			$basePath = dirname(__FILE__);
			exec("cd $assemblypath; git log -n 1; cd $basePath;", $assemblyRepo, $return_var);
			$assemblyRepo = $assemblyRepo[0] . '<br/>' . $assemblyRepo[1]  . '<br/>' . $assemblyRepo[2];
			exec("cd $basePath; git log -n 1;", $webRepo, $return_var);
			$webRepo = $webRepo[0] . '<br/>' . $webRepo[1]  . '<br/>' . $webRepo[2];
			#print_r ($output);
			#echo $output;
			$status = 200;
			echo '{"assembly": "'.$assemblyRepo.'","web": "'.$webRepo.'", "status": "200"}';
			break;
		default:
			$status = 500;
			echo '{"description": "No matching action: ' . $submitType. '", "status": 500}';
			break;
	}

	http_response_code($status);
?>
