<?php
function genImageFromSource($src='', $des='', $src_width=0, $src_height=0, $des_width='', $des_height='', $aspect_ratio=1, $water_mask=false){
	$oke = false;
	if (empty($des_height) && !empty($des_width)) {
      $des_height = (int)round($des_width * $aspect_ratio);
    }
    elseif (empty($des_width) && !empty($des_height)) {
      $des_width = (int)round($des_height / $aspect_ratio);
    }
    if (!($des_width >= $src_width && $des_height >= $src_height)) {
		if ($aspect_ratio < $des_height / $des_width) {
			$des_width = (int)min($des_width, $src_width);
			$des_height = (int)round($des_width * $aspect_ratio);
		}else {
			$des_height = (int)min($des_height, $src_height);
			$des_width = (int)round($des_height / $aspect_ratio);
		}
	    if (!empty($des_width) && !empty($des_height)) {
	    	$oke = image_resize($src, $des, $des_width, $des_height);
		}
	}
	else{
		$oke = @copy($src, $des);
	}
	/*if($water_mask){
		$oke = test_water_mask($des);
	}*/
	return $oke;
}

function copyOrginalImage($src = '', $des = '') {
	$ret = false;
	$ret = @copy($src, $des);
	return $ret;
}

function image_get_info($file) {
  if (!is_file($file)) {
    return FALSE;
  }
  $details = FALSE;
  $data = @getimagesize($file);
  $file_size = @filesize($file);

  if (isset($data) && is_array($data)) {
    $extensions = array('1' => 'gif', '2' => 'jpg', '3' => 'png');
    $extension = array_key_exists($data[2], $extensions) ?  $extensions[$data[2]] : '';
    $details = array('width'     => $data[0],
                     'height'    => $data[1],
                     'extension' => $extension,
                     'file_size' => $file_size,
                     'mime_type' => $data['mime']);
  }
  return $details;
}

/**
 * Verify GD2 settings (that the right version is actually installed).
 *
 * @return boolean
 */
function image_gd_check_settings() {
  if ($check = get_extension_funcs('gd')) {
    if (in_array('imagegd2', $check)) {
      // GD2 support is available.
      return TRUE;
    }
  }
  return FALSE;
}

/**
 * Scale an image to the specified size using GD.
 */
function image_resize($source, $destination, $width, $height) {
  if (!file_exists($source)) {
    return FALSE;
  }

  $info = image_get_info($source);
  if (!$info) {
    return FALSE;
  }

  $im = image_gd_open($source, $info['extension']);
  if (!$im) {
    return FALSE;
  }

  $res = imagecreatetruecolor($width, $height);
  if ($info['extension'] == 'png') {
    $transparency = imagecolorallocatealpha($res, 0, 0, 0, 127);
    imagealphablending($res, FALSE);
    imagefilledrectangle($res, 0, 0, $width, $height, $transparency);
    imagealphablending($res, TRUE);
    imagesavealpha($res, TRUE);
  }
  elseif ($info['extension'] == 'gif') {
    // If we have a specific transparent color.
    $transparency_index = imagecolortransparent($im);
    if ($transparency_index >= 0) {
      // Get the original image's transparent color's RGB values.
      $transparent_color = imagecolorsforindex($im, $transparency_index);
      // Allocate the same color in the new image resource.
      $transparency_index = imagecolorallocate($res, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
      // Completely fill the background of the new image with allocated color.
      imagefill($res, 0, 0, $transparency_index);
      // Set the background color for new image to transparent.
      imagecolortransparent($res, $transparency_index);
      // Find number of colors in the images palette.
      $number_colors = imagecolorstotal($im);
      // Convert from true color to palette to fix transparency issues.
      imagetruecolortopalette($res, TRUE, $number_colors);
    }
  }
  imagecopyresampled($res, $im, 0, 0, 0, 0, $width, $height, $info['width'], $info['height']);
  $result = image_gd_close($res, $destination, $info['extension']);
  imagedestroy($res);
  imagedestroy($im);
  return $result;
}

/**
 * Rotate an image the given number of degrees.
 */
function image_rotate($source, $destination, $degrees, $bg_color = 0) {
  if (!function_exists('imageRotate')) {
    return FALSE;
  }

  $info = image_get_info($source);
  if (!$info) {
    return FALSE;
  }

  $im = image_gd_open($source, $info['extension']);
  if (!$im) {
    return FALSE;
  }

  $res = imageRotate($im, $degrees, $bg_color);
  $result = image_gd_close($res, $destination, $info['extension']);

  return $result;
}

/**
 * Crop an image using the GD toolkit.
 */
function image_crop($source, $destination, $x, $y, $width, $height) {
  $info = image_get_info($source);
  if (!$info) {
	return FALSE;
  }

  $im = image_gd_open($source, $info['extension']);
  $res = imageCreateTrueColor($width, $height);
  imageCopy($res, $im, 0, 0, $x, $y, $width, $height);
  $result = image_gd_close($res, $destination, $info['extension']);

  imageDestroy($res);
  imageDestroy($im);

  return $result;
}

/**
 * GD helper function to create an image resource from a file.
 */
function image_gd_open($file, $extension) {
  $extension = str_replace('jpg', 'jpeg', $extension);
  $open_func = 'imageCreateFrom'. $extension;
  if (!function_exists($open_func)) {
    return FALSE;
  }
  return @$open_func($file);
}

/**
 * GD helper to write an image resource to a destination file.
 */
function image_gd_close($res, $destination, $extension) {
  $extension = str_replace('jpg', 'jpeg', $extension);
  $close_func = 'image'. $extension;
  if (!function_exists($close_func)) {
    return FALSE;
  }
  if ($extension == 'jpeg') {
    return $close_func($res, $destination, 100);
  }
  else {
    return $close_func($res, $destination);
  }
}

/* custom funtion */
function resizeImageFromSource($src_info,$src,$des, $width='', $height='', $water_mask = false){
	$aspect_ratio = $src_info['width'] > 0 ? ($src_info['height'] / $src_info['width']) : 0;
	if (empty($height) && !empty($width)) {
      $height = (int)round($width * $aspect_ratio);
    }elseif (empty($width) && !empty($height)) {
      $width = (int)round($height / $aspect_ratio);
    }
	if (!($width >= $src_info['width'] && $height >= $src_info['height'])) {
		if ($aspect_ratio < $height / $width) {
			$width = (int)min($width, $src_info['width']);
			$height = (int)round($width * $aspect_ratio);
		}
		else {
			$height = (int)min($height, $src_info['height']);
			$width = (int)round($height / $aspect_ratio);
		}
	    if (!empty($width) && !empty($height)) {
	    	echo 'reset image: '.$width.' - '.$height;
	    	image_resize($src, $desc, $width, $height);
		}
	}
	else {
		@copy($src, $desc);
	}
	//if($water_mask)	test_water_mask($des);
}