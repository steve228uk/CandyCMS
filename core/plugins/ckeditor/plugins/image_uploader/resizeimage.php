<?php
   function resize($img, $newfilename) {
   	if(!file_exists($newfilename))
   	{
       if (!extension_loaded('gd') && !extension_loaded('gd2')) {
        return false;
       }
             
       //Get Image size info

       $imgInfo = @getimagesize($img);
       switch ($imgInfo[2]) {
        case 1: $im = imagecreatefromgif($img); break;
        case 2: $im = imagecreatefromjpeg($img);  break;
        case 3: $im = imagecreatefrompng($img); break;
        default:  return false;
       }

      /* //If image dimension is smaller, do not resize
       if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
        $nHeight = $imgInfo[1];
        $nWidth = $imgInfo[0];
       }else{
                      //yeah, resize it, but keep it proportional
        if ($w/$imgInfo[0] > $h/$imgInfo[1]) {
         $nWidth = $w;
         $nHeight = $imgInfo[1]*($w/$imgInfo[0]);
        }else{
         $nWidth = $imgInfo[0]*($h/$imgInfo[1]);
         $nHeight = $h;
       }
       }*/
       
        $w = 115;  //image width
		$h = 85; //image height
       //MY RESIZE
       	$nHeight = $imgInfo[1];
        $nWidth = $imgInfo[0];
      	if($imgInfo[0] > $w || $imgInfo[1] > $h)
		{
			$xx = 100 * $w  / $imgInfo[0];
			$yy = 100 * $h  / $imgInfo[1];
			if($xx < $yy)
				$scale = $xx;
			else
				$scale = $yy;
			$nWidth = (int)($imgInfo[0] * $scale / 100);
			$nHeight = (int)($imgInfo[1] * $scale / 100);
		}
           
       
       $nWidth = round($nWidth);
       $nHeight = round($nHeight);

       $newImg = imagecreatetruecolor($nWidth, $nHeight);
       /* Check if this image is PNG or GIF, then set if Transparent*/  
       if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)){
        imagealphablending($newImg, true);
        imagesavealpha($newImg,true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 0);
        imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
       }
       imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
       //Generate the file, and rename it to $newfilename
       switch ($imgInfo[2]) {
        case 1: imagegif($newImg,$newfilename); break;
        case 2: imagejpeg($newImg,$newfilename);  break;
        case 3: imagepng($newImg,$newfilename); break;
        default:  return false;
       }
         return $newfilename;
   	}
   	return false;
      }
?>
