<?php
	$CNF['RUNNING'] = '';
	require_once('config/config.php');
	
	$CNF['HEADER']['TITLE'] = 'Trang chủ - Quản lý công văn';
	
	$CNF['BODY']['CURRENT_SCRIPT'] = '/index.php';
	
	require_once($CNF['BODY']['MAIN_TEMPLATE']);
?>