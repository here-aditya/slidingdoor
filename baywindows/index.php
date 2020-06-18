<?php
$rowImagick = new Imagick();

$imgHeight = 300;

// middle image
/*$imgWidth = 200;
$imagick = new Imagick(realpath("white.png"));
$imagick->setImageBackgroundColor(new ImagickPixel('transparent'));
$imagick->resizeimage($imgWidth, $imgHeight, \Imagick::FILTER_LANCZOS, 0, false);
$rowImagick->addImage($imagick);
*/

// left image
$imgWidth = 200;
$angle = 90;
$persp = 1.5;
$imagick = new Imagick(realpath("white.png"));
$imagick->setImageBackgroundColor(new ImagickPixel('transparent'));
$imagick->resizeimage($imgWidth, $imgHeight, \Imagick::FILTER_LANCZOS, 0, false);
//$imagick->shearimage(new ImagickPixel('transparent'), 0, 15);
$points = array(
    0, 0, 0, 0,
    0, $imgHeight, 0, $imgHeight + ($angle * $persp),
    $imgWidth, 0, $imgWidth - ($angle * $persp), 0,
    $imgWidth, $imgHeight, $imgWidth - ($angle * $persp), $imgHeight
 );
$imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_BACKGROUND);
$imagick->distortImage(\Imagick::DISTORTION_PERSPECTIVE, $points, true);
//$imagick->addImage($rowImagick);
//$rowImagick = clone $imagick;
$rowImagick->addImage($imagick);



// right image
$imgWidth = 200;
$angle = 0;
$persp = 1.5;
$imagick = new Imagick(realpath("white.png"));
$imagick->setImageBackgroundColor(new ImagickPixel('transparent'));
$imagick->resizeimage($imgWidth, $imgHeight, \Imagick::FILTER_LANCZOS, 0, false);
$points = array(
    0, 0, 0, 0,
    0, $imgHeight, 0, $imgHeight + ($angle * $persp),
    $imgWidth, 0, $imgWidth - ($angle * $persp), 0,
    $imgWidth, $imgHeight, $imgWidth - ($angle * $persp), $imgHeight
 );
$imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_BACKGROUND);
$imagick->distortImage(\Imagick::DISTORTION_PERSPECTIVE, $points, true);
$rowImagick->addImage($imagick);

// right image
$imgWidth = 200;
$angle = 0;
$persp = 1.5;
$imagick = new Imagick(realpath("white.png"));
$imagick->setImageBackgroundColor(new ImagickPixel('transparent'));
$imagick->resizeimage($imgWidth, $imgHeight, \Imagick::FILTER_LANCZOS, 0, false);
$points = array(
    0, 0, 0, 0,
    0, $imgHeight, 0, $imgHeight + ($angle * $persp),
    $imgWidth, 0, $imgWidth - ($angle * $persp), 0,
    $imgWidth, $imgHeight, $imgWidth - ($angle * $persp), $imgHeight
 );
$imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_BACKGROUND);
$imagick->distortImage(\Imagick::DISTORTION_PERSPECTIVE, $points, true);
$rowImagick->addImage($imagick);


// right image
$imgWidth = 200;
$angle = 0;
$persp = 1.5;
$imagick = new Imagick(realpath("white.png"));
$imagick->setImageBackgroundColor(new ImagickPixel('transparent'));
$imagick->resizeimage($imgWidth, $imgHeight, \Imagick::FILTER_LANCZOS, 0, false);
$points = array(
    0, 0, 0, 0,
    0, $imgHeight, 0, $imgHeight + ($angle * $persp),
    $imgWidth, 0, $imgWidth - ($angle * $persp), 0,
    $imgWidth, $imgHeight, $imgWidth - ($angle * $persp), $imgHeight
 );
$imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_BACKGROUND);
$imagick->distortImage(\Imagick::DISTORTION_PERSPECTIVE, $points, true);
$rowImagick->addImage($imagick);


// right image
$imgWidth = 200;
$angle = 90;
$persp = 1.5;
$imagick = new Imagick(realpath("white.png"));
$imagick->setImageBackgroundColor(new ImagickPixel('transparent'));
$imagick->resizeimage($imgWidth, $imgHeight, \Imagick::FILTER_LANCZOS, 0, false);
$points = array(
    0, 0, 0, 0,
    0, $imgHeight, 0, $imgHeight  ,
    $imgWidth, 0, $imgWidth - ($angle * $persp), 0,
    $imgWidth, $imgHeight , $imgWidth - ($angle * $persp), $imgHeight + ($angle * $persp)
 );
$imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_BACKGROUND);
$imagick->distortImage(\Imagick::DISTORTION_PERSPECTIVE, $points, true);
$rowImagick->addImage($imagick);


$rowImagick->resetIterator();
$combinedRow = $rowImagick->appendImages(false);
$combinedRow->setImageFormat('png');
header("Content-Type: image/png");
echo $combinedRow->getImageBlob();