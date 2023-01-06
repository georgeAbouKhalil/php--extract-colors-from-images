<?php
class GetMostCommonColors {
    var $PREVIEW_WIDTH    = 150;
	var $PREVIEW_HEIGHT   = 150;

    function Get_Color( $img, $count, $delta ) {
        
        if ( is_readable( $img ) ) {
            if ( $delta > 2 ) {
				$half_delta = $delta / 2 - 1;
			}
			else {
				$half_delta = 0;
			}

            $size = GetImageSize($img);
            $scale = 1;
            if($size[0] > 0)
			$scale = min($this->PREVIEW_WIDTH/$size[0], $this->PREVIEW_HEIGHT/$size[1]);
            if ($scale < 1) {
				$width = floor($scale*$size[0]);
				$height = floor($scale*$size[1]);
			}
			else {
				$width = $size[0];
				$height = $size[1];
			}
            $image_resized = imagecreatetruecolor($width, $height);
            if ($size[2] == 1)
			$image_orig = imagecreatefromgif($img);
			if ($size[2] == 2)
			$image_orig = imagecreatefromjpeg($img);
			if ($size[2] == 3)
			$image_orig = imagecreatefrompng($img);
            
            imagecopyresampled($image_resized, $image_orig, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			$im = $image_resized;
			$imgWidth = imagesx($im);
			$imgHeight = imagesy($im);
			$total_pixel_count = 0;

            for ($y=0; $y < $imgHeight; $y++) {
				for ($x=0; $x < $imgWidth; $x++) {
					$total_pixel_count++;
					$index = imagecolorat($im,$x,$y);
					$colors = imagecolorsforindex($im,$index);
					
					if ( $delta > 1 ) {
						$colors['red'] = intval((($colors['red'])+$half_delta)/$delta)*$delta;
						$colors['green'] = intval((($colors['green'])+$half_delta)/$delta)*$delta;
						$colors['blue'] = intval((($colors['blue'])+$half_delta)/$delta)*$delta;
						if ($colors['red'] >= 256) {
							$colors['red'] = 255;
						}
						if ($colors['green'] >= 256) {
							$colors['green'] = 255;
						}
						if ($colors['blue'] >= 256) {
							$colors['blue'] = 255;
						}
					}

					$hex = substr("0".dechex($colors['red']),-2).substr("0".dechex($colors['green']),-2).substr("0".dechex($colors['blue']),-2);

					if ( ! isset( $hexarray[$hex] ) ) {
						$hexarray[$hex] = 1;
					}
					else {
						$hexarray[$hex]++;
					}
				}
			}

            arsort( $hexarray );

            
			foreach ($hexarray as $key => $value) {
				$hexarray[$key] = (float)$value / $total_pixel_count;
			}

			if ( $count > 0 ) {
				
				$arr = array();
				foreach ($hexarray as $key => $value) {
					if ($count == 0)
					{
						break;
					}
					$count--;
					$arr[$key] = $value;
				}
				return $arr;
			}
			else {
				return $hexarray;
			}            
        }
    }
}
?>