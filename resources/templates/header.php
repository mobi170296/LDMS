<!DOCTYPE html>
<html>
	<head>
		<noscript><meta http-equiv="refresh" content="0;url='/error/noscript.html'"/></noscript>
		<meta charset="utf-8"/>
		<meta name="theme-color" content="#0af"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
		<link rel="shortcut icon" href="<?php if(isset($CNF['HEADER']['PAGE_ICON'])) echo $CNF['HEADER']['PAGE_ICON']; ?>"/>
		<title><?php if(isset($CNF['HEADER']['TITLE'])) echo $CNF['HEADER']['TITLE']; ?></title>
		<?php
			if(isset($CNF['HEADER']['STYLES'])){
				foreach($CNF['HEADER']['STYLES'] as $styleurl){
					echo '<link rel="stylesheet" type="text/css" href="' . $styleurl . '"/>';
				}
			}
			if(isset($CNF['HEADER']['SCRIPTS'])){
				foreach($CNF['HEADER']['SCRIPTS'] as $scripturl){
					echo "\t\t" . '<script type="text/javascript" src="'. $scripturl .'"></script>';
				}
			}
		?>
	</head>
	<body>
		<div id="menu-btn">
		</div>
		<div id="splash">
			<div id="loading-icon"></div>
		</div>
		<div id="popup">
			<div id="popup-close-btn"></div>
			<div id="popup-content"></div>
		</div>
		<div id="container">