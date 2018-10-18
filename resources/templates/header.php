<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="shortcut icon" href="<?php echo $CNF['HEADER']['PAGE_ICON']; ?>"/>
		<title><?php echo $CNF['HEADER']['TITLE']; ?></title>
		<?php
			foreach($CNF['HEADER']['STYLES'] as $styleurl){
				echo '<link rel="stylesheet" type="text/css" href="' . $styleurl . '"/>' . PHP_EOL;
			}
			foreach($CNF['HEADER']['SCRIPTS'] as $scripturl){
				echo "\t\t" . '<script type="text/javascript" src="'. $scripturl .'"></script>' . PHP_EOL;
			}
		?>
	</head>
	<body>
		<div id="main-page">