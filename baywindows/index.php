<?php
/*
    drawbay(inside,sides, height, array(images), array(widths), array(angles))

    $inside= (int) 0: outside (normal), 1: inside, reverse the angles.
    $imagesPath = (array) Image paths where one image represent one Side & sides could between 2 and 8
    $imgHeight = (int) height in pixels for all above images (the height is identical for all images)
    $imagesWidth = (array) Widths in pixels for each of the above images
    $imagesAngles = (array) Angles in degrees between the sides of the bay, 
                Array length will be Sides - 1 (e.g. 2 angles for a 3 sided bay).
*/

function frameImage($inside = 0, $imagesPath = array(), $imgHeight = 600, $imagesWidth = array(), $imagesAngles = array(), $poleColor = null, $poleWidth = 1, $poleHeight = 1)
{  
    $rowImagick = new Imagick();
    
    foreach($imagesPath as $imgIndex => $imgPath) {
        $imagick = new Imagick(realpath($imgPath));

        $imagick->getImageGeometry();
        $imgGeo = $imagick->getImageGeometry();
        $imgOrgWidth = $imgGeo['width'];
        $imgOrgHeight = $imgGeo['height'];
        $imgWidth = $imagesWidth[$imgIndex];

        if(isset($imagesAngles[$imgIndex])) {
            $angleX = ($imagesAngles[$imgIndex]) == 90 ? - ($imagesAngles[$imgIndex] - 10) : - $imagesAngles[$imgIndex];
        } else {
            $angleX = -100;
        }
        $angleY = 0;
        $thetX = deg2rad ($angleX);
        $thetY = deg2rad ($angleY);

        $s_x1y1 = array(0, 0);                   // LEFT BOTTOM
        $s_x2y1 = array($imgWidth, 0);           // RIGHT BOTTOM
        $s_x1y2 = array(0, $imgHeight);          // LEFT TOP
        $s_x2y2 = array($imgWidth, $imgHeight);  // RIGHT TOP

        $d_x1y1 = array(
                            $s_x1y1[0] * cos($thetX) - $s_x1y1[1] * sin($thetY),
                            $s_x1y1[0] * sin($thetX) + $s_x1y1[1] * cos($thetY)
                        );
        $d_x2y1 = array(
                            $s_x2y1[0] * cos($thetX) - $s_x2y1[1] * sin($thetY),
                            $s_x2y1[0] * sin($thetX) + $s_x2y1[1] * cos($thetY)
                        );
        $d_x1y2 = array(
                            $s_x1y2[0] * cos($thetX) - $s_x1y2[1] * sin($thetY),
                            $s_x1y2[0] * sin($thetX) + $s_x1y2[1] * cos($thetY)
                        );
        $d_x2y2 = array(
                            $s_x2y2[0] * cos($thetX) - $s_x2y2[1] * sin($thetY),
                            $s_x2y2[0] * sin($thetX) + $s_x2y2[1] * cos($thetY)
                        );

        $imageprops = $imagick->getImageGeometry();
        $imagick->setImageBackgroundColor(new ImagickPixel('transparent'));
        $imagick->resizeimage($imgWidth, $imgHeight, \Imagick::FILTER_LANCZOS, 0, true); 
        if($poleColor) {
            $imagick->borderImage($poleColor, $poleWidth, $poleHeight);
        }

        $points = array(
            $s_x1y2[0], $s_x1y2[1],     # Source Top Left
            $d_x1y2[0], $d_x1y2[1],     # Destination Top Left
            $s_x1y1[0], $s_x1y1[1],     # Source Bottom Left 
            $d_x1y1[0], $d_x1y1[1],     # Destination Bottom Left 
            $s_x2y1[0], $s_x2y1[1],     # Source Bottom Right 
            $d_x2y1[0], $d_x2y1[1],     # Destination Bottom Right 
            $s_x2y2[0], $s_x2y2[1],     # Source Top Right 
            $d_x2y2[0], $d_x2y2[1],     # Destination Top Right 
        );
        //echo '<pre>'; print_r($points); die;

        $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_BACKGROUND);
        $imagick->distortImage(\Imagick::DISTORTION_PERSPECTIVE, $points, true);
        //$imagick->scaleImage($imgWidth, $imgHeight, false);
        $rowImagick->addImage($imagick);    
    }

    $rowImagick->resetIterator();
    $combinedRow = $rowImagick->appendImages(false);

    $canvas = generateFinalImage($combinedRow);
    header("Content-Type: image/png");
    echo $canvas->getImageBlob();
}

function generateFinalImage($combinedRow)
{
    $finalWidth = 800;
    $finalHeight = 600;
    $canvas = new Imagick();

    $imageprops = $combinedRow->getImageGeometry();
    $canvas->newImage($finalWidth, $finalHeight, 'black', 'png' );
    $offsetX = (int)($finalWidth  / 2) - (int)($imageprops['width']  / 2);
    $offsetY = (int)($finalHeight / 2) - (int)($imageprops['height'] / 2);
    $canvas->compositeImage( $combinedRow, imagick::COMPOSITE_OVER, $offsetX, $offsetY );

    return $canvas;
}


frameImage(
            $inside = 1,
            $imagePath = array("white.png", "white.png", "white.png", "white.png", "white.png"),
            $imgHeight = 300,
            $imgWidth = array(200, 200, 200, 200, 200),
            $angles = array(90, 180, 180, 180),  // array(40, 180, -10, 10)
            $poleColor = '#fefefe',
            $poleWidth = 5,
            $poleHeight = 5,
        );    
?>
