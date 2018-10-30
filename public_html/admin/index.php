<?php
	require_once __DIR__.'/../../config.config.php';
	
	$CNF['HEADER']['TITLE'] = 'Quản trị Hệ Thống - Quản lý Công văn';
	$CNF['HEADER']['STYLES'][] = '/styles/darkstyle.css';
	$CNF['BODY']['CURRENT_SCRIPT'] = '/admin/index.php';

	require_once($CNF['BODY']['MAIN_TEMPLATE']);
?>