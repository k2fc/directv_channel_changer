<?php
require('db.php');
getInterfaces($db);
$statement = $db->prepare('SELECT * FROM interfaces;');
$result=$db->query('SELECT * FROM interfaces');
while ($row = $result->fetchArray()){
	$ip = $row["Address"];
	$mask = $row["SubnetMask"];
	$net = ($ip & $mask);
	$broadcast = $net | (~$mask);
	for ($scanAddress=$net+1;$scanAddress<$broadcast; $scanAddress++){
		ini_set('display_errors', 'Off');
		ini_set('default_socket_timeout',1);
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
						echo "Box Matches!\n";
					}
					else {
						$db->query("UPDATE tuners SET address = $scanAddress WHERE serialNum = '$box_serial'");
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
			}
		}
	}
}

function getSerialNumber ($json_address){
        ini_set('default_socket_timeout', 1);
        $json_url = 'http://'.long2ip($json_address).':8080/info/getVersion';
        $feed = file_get_contents($json_url);
        $json = json_decode($feed, true);
        return $json["receiverId"];
}

function ping($host, $timeout = 10) {
    /* ICMP ping packet with a pre-calculated checksum */
    $package = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
    $socket  = socket_create(AF_INET, SOCK_RAW, 1);
    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 0, 'usec' => ($timeout * 1000)));
    socket_connect($socket, $host, null);
    $ts = microtime(true);
    socket_send($socket, $package, strLen($package), 0);
    if (socket_read($socket, 255)) {
        $result = microtime(true) - $ts;
    } else {
        $result = false;
    }
    socket_close($socket);
    return $result;
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
