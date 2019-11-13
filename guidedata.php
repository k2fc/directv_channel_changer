<?php
	set_time_limit (5);
	//ini_set('default_socket_timeout',2);
	ini_set('max_execution_time',5);
	//ini_get('allow_url_fopen')
	$arContext['http']['timeout'] = 3;
	$context = stream_context_create($arContext);
	require('db.php');
	if (defined('STDIN')) {
  		$name = $argv[1];
		error_reporting(1);
        	ini_set('display_errors', 1);
	} else { 
		$name = $_GET['name'];
		error_reporting(0);
	        ini_set('display_errors', 0);
	}
	$result = $db->query("SELECT address as ip FROM tuners WHERE name = $name");
	$ip=long2ip($result->fetchArray()['ip']);
	$gettuned_url = 'http://'.$ip.':8080/tv/getTuned';
	$tuned = json_decode(file_get_contents($gettuned_url,false, $context));
	echo ("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n");
	echo ("<!DOCTYPE tv SYSTEM \"xmltv.dtd\">\r\n");
	echo ("<tv source-info-url=\"http://"."\" source-info-name=\"Dennisvision Channel Changer\" generator-info-name=\"XMLTV\" generator-info-url=\"http://www.xmltv.org/\">\r\n");
	if (isset($tuned)){
		$channel = $tuned->major;
		$time = new DateTime();
		$timeEnd = new DateTime();
		$timeEnd->add(new DateInterval('PT3H'));
		echo ("\t<channel id=\"$name\">\r\n");
		echo ("\t\t<display-name>$name</display-name>\r\n");
                echo ("\t\t<display-name>$tuned->callsign</display-name>\r\n");
                echo ("\t</channel>\r\n");
		$lasturl = "";
		do{
			if ($tuned->minor == 65535){
		        	$getproginfo_url = 'http://'.$ip.':8080/tv/getProgInfo?major='.$channel.'&time='.$time->getTimestamp();
	    		}
		    	else {
		        	$channel_minor = $tuned->minor;
				$getproginfo_url = 'http://'.$ip.':8080/tv/getProgInfo?major='.$channel.'&minor='.$channel_minor.'&time='.$time->getTimestamp();
			}
			echo("\t<!--".$getproginfo_url."-->\r\n");
			$proginfo = json_decode(file_get_contents($getproginfo_url,true));
			if (isset($proginfo->startTime)){
				$program_name = htmlspecialchars($proginfo->title);
				$startTime = new DateTime("@".$proginfo->startTime);
				$duration = new DateInterval("PT".$proginfo->duration."S");
				$endTime = new DateTime("@".$proginfo->startTime);
				$endTime->add($duration);
				echo ("\t<programme start=\"".date_format($startTime,'YmdHis O')."\" stop=\"".date_format($endTime,'YmdHis O')."\" channel=\"$name\">\r\n");
				echo ("\t\t<title>$program_name</title>\r\n");
				echo ("\t</programme>\r\n");
			}
			$abort=false;
			if ($endTime>$time){
				$time=$endTime;
			}
			else {
				$abort=true;
			}
			$time->add(new DateInterval("PT10M"));
			$lasturl = $getproginfo_url;
		}
		while($timeEnd>$time && $abort==false);

	}
	
	echo ('</tv>');
?>
