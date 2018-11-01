<?php
	require_once __DIR__.'/../../../config/config.php';
	header('content-type: image/png');
	$filename = $CNF['PATHS']['AVATAR_DIR'].'/'.$_GET['nc'].'.png';
	if(file_exists($filename)){
		readfile($filename);
	}else{
		readfile($CNF['PATHS']['AVATAR_DIR'].'/default.png');
	}