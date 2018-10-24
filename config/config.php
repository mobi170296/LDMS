<?php
	require_once(__DIR__.'./defines.php');
	
	$CNF['PATHS'] = [
					 'LIBRARY' => __DIR__.'/../resources/library',
					 'TEMPLATES' => __DIR__.'/../resources/templates',
					 'VIEWS' => __DIR__. '/../resources/views',
					 'LEGALDOCUMENT_DIR' => __DIR__.'/../legaldocuments',
					 'CLASSES' => __DIR__.'/../resources/classes',
					 'ERROR_PAGE' => __DIR__.'/../resources/templates/error.php',
					];

	$CNF['HEADER'] = ['TITLE' => '', 'STYLES' => ['/resources/css/mstyles.css'], 'SCRIPTS' => ['/resources/js/tmscript.js'],
	'PAGE_ICON' => '/resources/images/icons/icon.ico'];

	$CNF['BODY'] = ['MAIN_TEMPLATE' => $CNF['PATHS']['TEMPLATES'] . '/main.php',
				   'LEGALDOCUMENT_URL'=>'/resources/legaldocuments'];
?>