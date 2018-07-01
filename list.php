<?php
if(!isset($_SERVER['HTTP_REFERER'])) exit;
if($_SERVER['HTTP_REFERER'] != 'app:/KCA/') exit;

$kcadata_list = trim(
	file_get_contents('http://raw.githubusercontent.com/antest1/kcanotify-gamedata/master/list.json')
);
echo $kcadata_list;
