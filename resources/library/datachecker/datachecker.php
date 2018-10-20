<?php
	class UploadedFile{
		public static function getMimeType($file){
			$finfo = new FInfo();
			return $finfo->file($file, FILEINFO_MIME_TYPE);
		}
		public static function getExtension($mimetype){
			$array = explode('/', $mimetype);
			if(count($array)>=2){
				return $array[1];
			}else{
				return null;
			}
		}
		
		public static function scaleImageToPng($src, $dest, $dw, $dh){
			$ratio = $dw / $dh;
			$mimetype = self::getMimeType($src);
			$newimage = imagecreatetruecolor($dw, $dh);
			if($mimetype == ''){
				return false;
			}
			$ext = self::getExtension($mimetype);

			$image = null;
			switch($ext){
				case 'png':
				$image = imagecreatefrompng($src);
				break;
				case 'x-ms-bmp':
				$image = imagecreatefromwbmp($src);
				break;
				case 'jpeg':
				$image = imagecreatefromjpeg($src);
				break;
				case 'gif':
				$image = imagecreatefromgif($src);
				break;
			}
			if($image!=null){
				$sw = imagesx($image);
				$sh = imagesy($image);
				if($sw / $sh >= $ratio){
					#scale by height
					$sx = ($sw - ( $ratio * $sh) ) / 2;
					$sy = 0;
					$sw = $ratio * $sh;
				}else{
					#scale by width
					$sx = 0;
					$sy = ($sh - ($sw / $ratio)) / 2;
					$sh = $sw / $ratio;
				}
				imagecopyresampled($newimage, $image, 0, 0, $sx, $sy, $dw, $dh, $sw, $sh);
				imagepng($newimage, $dest);
				return true;
			}else{
				return false;
			}
		}
	}
	class DataChecker{
		public static function checkTime($hour, $minute, $second){
			$nh = intval($hour);
			$nm = intval($minute);
			$ns = intval($second);
			return $nh >= 0 && $nh < 24 && $nm >= 0 && $nm < 60 && $ns >= 0 && $ns < 60;
		}
		public static function valueInArray($value, $array){
			foreach($array as $v){
				if($v==$value){
					return true;
				}
			}
			return false;
		}
	}
?>