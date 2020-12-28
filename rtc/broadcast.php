<?php

$memcache = new Memcache;
$memcache->connect('127.0.0.1', 11211) or die ("Could not connect");

// Init 
if (!$memcache->get('bcast-obj')) {
	$memcache->set('bcast-obj', "");
	$memcache->set('bcast-count', 1);
}

// Add the new stream if supplied
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$entityBody = file_get_contents('php://input');
	$memcache->set('bcast-obj', $entityBody);
	$memcache->increment('bcast-count');
}

// Echo all the streams
$ret = new stdClass;
$ret->count = $memcache->get('bcast-count');
$ret->message = $memcache->get('bcast-obj');

echo json_encode($ret);

?>
