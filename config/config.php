<?php
	require_once(__DIR__.'./defines.php');
	
	$CNF['PATHS'] = ['LIBRARY' => __DIR__.'/../resources/library', 'TEMPLATES' => __DIR__.'/../resources/templates',
	'VIEWS' => __DIR__. '/../resources/views', 'LEGALDOCUMENT_DIR' => ''];

	$CNF['HEADER'] = ['TITLE' => '', 'STYLES' => ['/styles/mstyles.css'], 'SCRIPTS' => ['/scripts/mscripts.js'],
	'PAGE_ICON' => '/images/icons/page_icon.png'];

	$CNF['BODY'] = ['MAIN_TEMPLATE' => $CNF['PATHS']['TEMPLATES'] . '/main.php'];
?>