<?php
ini_set('allow_url_include', 'On');
define('CUR_DIR', dirname(__FILE__));
define('DToken', 'dtoken_value');
define('Token', 'token_value');

if(!isset($_SERVER['HTTP_REFERER'])) exit;
$referer = $_SERVER['HTTP_REFERER'];
if($referer != 'app:/KCA/') exit;

function get_apistart2($var) {
	$pos = strpos($var, 'api_start2_');
	return $pos !== false;
}

function v_cmp($a, $b) {
	if ($a === $b) return 0;
	$a_arr = array_map(intval, explode(".", str_replace("api_start2_", "", $a)));
	$b_arr = array_map(intval, explode(".", str_replace("api_start2_", "", $b)));
	$a_cnt = count($a_arr);
	$b_cnt = count($b_arr);
	$min_len = min($a_cnt, $b_cnt);
	for ($i=0; $i<$min_len; $i++) 
		if ($a_arr[$i] != $b_arr[$i]) 
			return $b_arr[$i] - $a_arr[$i];
	return $b_cnt - $a_cnt;
}

$api_start2_dir = CUR_DIR . '/api_start2/';

$v = $_GET['v'];
$method = $_GET['method'];

switch($v){
	case 'recent':
		$files = array_filter(scandir($api_start2_dir), 'get_apistart2');
		usort($files, v_cmp);

		$filename = $files[0];
		$v = str_replace('api_start2_', '', $filename);
		break;
	default:
		$filename = 'api_start2_' . $v;
		break;
}

switch($method){
	case 'up':
		$token = $_GET['token'];
		$dtoken = $_GET['dtoken'];
		$data = file_get_contents('php://input');
		
		if($dtoken != DToken) exit;
		if($token != Token) exit;

		file_put_contents($api_start2_dir . $filename, $data);
		echo $data;
	
		break;
	default:
		header('X-Api-Version: ' . $v);
		header('Content-Encoding: gzip');

		$x = file_get_contents($api_start2_dir . $filename);
		if($x===false) {
			http_response_code(404);
			die();
        }
		else
			echo $x;
		break;
}
