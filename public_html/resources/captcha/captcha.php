<?php
	session_start();
	header('content-type: image/png');
	$image = imagecreatetruecolor(117, 30);
	$whitecolor = imagecolorallocate($image, 255, 255, 255);
	$pinkcolor = imagecolorallocate($image, 0, 255, 255);
	imagecolortransparent($image, $pinkcolor);
	imagefilledrectangle($image, 0, 0, 116, 29, $whitecolor);
	$achar = [[65, 65 + 25], [97, 97 + 25], [48, 48 + 9]];
	$acolor = [ imagecolorallocate($image, 0, 0, 0),
			   imagecolorallocate($image, 255, 0, 0),
			   imagecolorallocate($image, 0, 255, 0),
			   imagecolorallocate($image, 0, 0, 255),
			   imagecolorallocate($image, 255, 255, 0),
			   imagecolorallocate($image, 255, 127, 0)
			  ];
	$y = 6 + 18;
	$x = 9;
	$size = 18;//pt, dpi = 72 => pt == px
	$font = __DIR__.'/arial.ttf';
	$captchastring = '';
	for($i = 1; $i<=6; $i++){
		$color = $acolor[rand(0, count($acolor)-1)];
		$rachar = $achar[rand(0, count($achar)-1)];
		$char = chr(rand($rachar[0], $rachar[1]));
		$x = ($i - 1) * 18 + 9;
		$angle = rand(-30, 30);
		imagettftext($image, $size, $angle, $x, $y, $color, $font, $char);
		$captchastring .= $char;
	}
	$_SESSION['captcha'] = $captchastring;
	imagepng($image);
?>