<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
		<link rel="shortcut icon" href="<?php if(isset($CNF['HEADER']['PAGE_ICON'])) echo $CNF['HEADER']['PAGE_ICON']; ?>"/>
		<title>Lỗi - </title>
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
		<div id="container">
			<div class=""><?php if(isset($error) && $error != '') echo '<div class="error-message-box">'.$error.'</div>'; ?></div>
		</div>
	</body>
</html>