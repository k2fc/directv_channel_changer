<?php
include('ping.php');
require('db.php');
getInterfaces($db);
$statement = $db->prepare('SELECT * FROM interfaces;');
$result=$db->query('SELECT * FROM interfaces');
while ($row = $result->fetchArray()){
	$myIP = $row["Address"];
	$mask = $row["SubnetMask"];
	$net = ($myIP & $mask);
	$broadcast = $net | (~$mask);
	for ($scanAddress=$net+1;$scanAddress<$broadcast; $scanAddress++){
		ini_set('display_errors', 'Off');
		ini_set('default_socket_timeout',1);
		if ($myIP != $scanAddress){
			echo "Checking ".long2ip($scanAddress);
			if (ping(long2ip($scanAddress))){
				$box_serial = getSerialNumber($scanAddress);
				if ($box_serial){
					$box_result=$db->query('SELECT * FROM tuners WHERE serialNum = \''. $box_serial . '\'');
					$nrows=0;
					$box=null;
					while ($boxrow = $box_result->fetchArray()){
						$nrows++;
						$box=$boxrow;
					}
					if ($nrows ==1) {
						if ($box["address"] == $scanAddress){
							echo " Box $box_serial matches database record!";
						}
						else {
							$db->query("UPDATE tuners SET address = $scanAddress WHERE serialNum = '$box_serial'");
							echo " Box $box_serial now at address ".long2ip($scanAddress).".";
							error_log("Box ".$box["name"]. " has changed to address ".long2ip($scanAddress).".",0);
						}
					}
					else {
						$newname = "Discovered ". substr($box_serial,-4);
						$addboxquery = "INSERT INTO tuners (serialNum, name, address) VALUES('$box_serial','$newname',$scanAddress)";
						$db->query("DELETE FROM tuners WHERE address = $scanAddress");
						$db->query("DELETE FROM tuners WHERE serialNum = '$box_serial'");
						$db->query($addboxquery);
					}
					$box_result->reset();
					$ip=long2ip($scanAddress);
					$dbTuned = $box["tuned"];
					$name = $box["name"];
					echo " Checking tuned channel...  ";
					include ("gettuned_directv.php");
					echo " Tuned to $channel";
				}
				else {
					echo " doesn't appear to be a DirecTV box, or it's set up wrong.";
					$db->query("UPDATE tuners SET address = 0 WHERE address = $scanAddress");
				}
			}
			else {
				echo " ... ping timed out";
				$db->query("UPDATE tuners SET address = 0 WHERE address = $scanAddress");
			}
			echo "\n";
		}
	}
}
error_log("Receiver scan complete.",0);

function getSerialNumber ($json_address){
        ini_set('default_socket_timeout', 1);
        $json_url = 'http://'.long2ip($json_address).':8080/info/getVersion';
        $feed = file_get_contents($json_url);
        $json = json_decode($feed, true);
        return $json["receiverId"];
}

function getInterfaces($db) {
	exec("/sbin/ifconfig | grep 'inet ' | grep -v 127.0.0.1 | cut -d: -f2 | awk '{print $2}'",$ips);
	exec("/sbin/ifconfig | grep 'inet ' | grep -v 127.0.0.1 | cut -d: -f2 | awk '{print $4}'",$masks);
	$interfacenum = 0;
	$db->query("DELETE FROM interfaces");
	foreach($ips as $localip){
		echo $localip."\n";
		$db->query("INSERT INTO interfaces (Address, SubnetMask) VALUES(".ip2long($localip).",".ip2long($masks[$interfacenum]).")");
		$interfacenum++;
	}
}

?>
