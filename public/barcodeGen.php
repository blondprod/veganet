<?php

$args = explode('&', $_SERVER['QUERY_STRING']);

if( is_array($args) && count($args) > 0 ){

    if ( $args[0] != '' ){
//        $path = $_SESSION['BARCODE']['IMG'];

        $psDossier = $args[0];
        $pnIdDossierDeFab = $args[1];
        $path = $args[2];

        // Define variable to prevent hacking
        define('IN_CB',true);

        // Including all required classes
        require('../lib/fbx/Fab/barcode/class/index.php');
        require('../lib/fbx/Fab/barcode/class/FColor.php');
        require('../lib/fbx/Fab/barcode/class/BarCode.php');
        require('../lib/fbx/Fab/barcode/class/FDrawing.php');

        // including the barcode technology
        include('../lib/fbx/Fab/barcode/class/code128.barcode.php');

        // Creating some Color (arguments are R, G, B)
        $color_black = new FColor(0,0,0);
        $color_white = new FColor(255,255,255);

        /* Here is the list of the arguments:
        1 - Thickness
        2 - Color of bars
        3 - Color of spaces
        4 - Resolution
        5 - Text
        6 - Text Font (0-5) */
        $code_generated = new code128(25,$color_black,$color_white,2,$psDossier,0,"B");

        /* Here is the list of the arguments
        1 - Width
        2 - Height
        3 - Filename (empty : display on screen)
        4 - Background color */
        $drawing = new FDrawing(4096,4096,"$path/$pnIdDossierDeFab.png",$color_white);
        $drawing->init(); // You must call this method to initialize the image
        $drawing->add_barcode($code_generated);
        $drawing->draw_all();
        $im = $drawing->get_im();

        // Next line create the little picture, the barcode is being copied inside
        $im2 = imagecreate($code_generated->lastX,$code_generated->lastY);
        imagecopyresized($im2, $im, 0, 0, 0, 0, $code_generated->lastX, $code_generated->lastY, $code_generated->lastX, $code_generated->lastY);
        $drawing->set_im($im2);

        // Header that says it is an image (remove it if you save the barcode to a file)
        #header('Content-Type: image/png');

        // Draw (or save) the image into PNG format.
        $drawing->finish(IMG_FORMAT_PNG);
    }
}
