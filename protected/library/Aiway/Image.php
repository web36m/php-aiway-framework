<?php

/**
 * Description of Image
 *
 * @author Shilov Vasiliy
 */
class Image {
	
	public function init() {
		return new self();
	}

	public function resize($source, $destination, $width, $height, $background=0xFFFFFF, $quality=100) {
		if (!file_exists($source))
			return false;
		if (($size = getimagesize($source)) === false)
			return false;
		$function = 'imagecreatefrom'.preg_replace('/.*\//i', '', $size['mime']);
		if (!function_exists($function))
			return false;
		$x_ratio = $width / $size[0];
		$y_ratio = $height / $size[1];
		$ratio = min($x_ratio, $y_ratio);
		$new_width = ($x_ratio == $ratio) ? $width : ceil($size[0] * $ratio);
		$new_height = ($y_ratio == $ratio) ? $height : ceil($size[1] * $ratio);
		$isrc = $function($source);
		$idest = imagecreatetruecolor($new_width, $new_height);
		imagefill($idest, 0, 0, $background);
		imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
		imagejpeg($idest, $destination, $quality);
		imagedestroy($isrc);
		imagedestroy($idest);
		return true;		
	}

}