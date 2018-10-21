<?php
	require_once($CNF['PATHS']['TEMPLATES'] . '/header.php');
	
	require_once($CNF['PATHS']['TEMPLATES'] . '/leftpanel.php');
	
	echo '<div id="content">';
	echo <<<POPUP
	<div id="popup">
	<div id="popup-content">
	</div>
	</div>
POPUP;
	require_once($CNF['PATHS']['VIEWS'] . $CNF['BODY']['CURRENT_SCRIPT']);
	echo '</div>';
	
	
	require_once($CNF['PATHS']['TEMPLATES'] . '/footer.php');
?>