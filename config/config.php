<?php
	if(isset($CNF['RUNNING'])){
		require_once(__DIR__.'./defines.php');
		
		$CNF['DATABASE'] = array('HOST' => 'localhost','USER' => 'root','PASSWORD' => 'nguyenthithuyhang','DB' => 'ldmsdb','PORT' => '3306', 'AES_KEY' => 'ottc');
		$CNF['PATHS'] = array('LIBRARY' => __DIR__.'/../resources/library', 'TEMPLATES' => __DIR__.'/../resources/templates',
		'VIEWS' => __DIR__. '/../resources/views', 'LEGAL_DOCUMENT_DIR' => '');
		$CNF['HEADER'] = array('TITLE' => '', 'STYLES' => array('/styles/mstyles.css'), 'SCRIPTS' => array('/scripts/mscripts.js'),
		'PAGE_ICON' => '/images/icons/page_icon.jpg');
		$CNF['BODY'] = array('MAIN_TEMPLATE' => $CNF['PATHS']['TEMPLATES'] . '/main.php');
	}else{
		#
		#
		#
	}
?>