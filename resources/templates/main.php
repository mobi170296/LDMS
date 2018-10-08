<?php
	require_once($CNF['PATHS']['TEMPLATES'] . '/header.php');
	
	require_once($CNF['PATHS']['TEMPLATES'] . '/leftmenu.php');
	
	echo '<div id="content">';
	require_once($CNF['PATHS']['VIEWS'] . $CNF['BODY']['CURRENT_SCRIPT']);
	echo '</div>';
	
	
	require_once($CNF['PATHS']['TEMPLATES'] . '/footer.php');
?>