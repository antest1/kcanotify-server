<?php
if(!isset($_SERVER['HTTP_REFERER'])) exit;
if($_SERVER['HTTP_REFERER'] != 'app:/KCA/') exit;

$version = trim(
	file_get_contents('http://raw.githubusercontent.com/antest1/kcanotify/master/VERSION')
);
$data_version = trim(
	file_get_contents('http://raw.githubusercontent.com/antest1/kcanotify/master/DATA_VERSION')
);

$data = array(
	'version'=>$version,
	'data_version'=>$data_version
);
echo json_encode($data);
