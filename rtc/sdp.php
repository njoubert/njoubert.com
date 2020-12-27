<?php

$memcache = new Memcache;
$memcache->connect('127.0.0.1', 11211) or die ("Could not connect");

// Cleanup


// Add the new stream if supplied
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$entityBody = file_get_contents('php://input');
	if (!$memcache->get('count') || $memcache->get('count') == 2) {
		$memcache->set('webrtc-1', $entityBody);
		$memcache->set('count', 1);
	} else {
		$memcache->set('webrtc-2', $entityBody);
		$memcache->set('count', 2);
	}
}

// Echo all the streams
$webrtc1 = $memcache->get('webrtc-1');
$webrtc2 = $memcache->get('webrtc-2');

echo '{"one":'.json_encode($webrtc1).',"two":'.json_encode($webrtc2).'}';

//$memcache->set('webrtc', $tmpobject) or die ("failed to save data at the server");
//$get_result = $memcache->get('webrtc');


?>
