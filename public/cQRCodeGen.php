<?php

$args = explode('&', $_SERVER['QUERY_STRING']);

if( is_array($args) && count($args) > 0 ) {
    require_once("../lib/fbx/Fab/cQRCode.php");
    require_once("../lib/fbx/Fab/Base.php");
    $base = new \fbx\Fab\Base();

    if ( $args[0] != '' ) {

        $finalFileName = $args[0];
        $linkSaveImg = $args[1];
        $urlIntoQrCode = $args[2]."&".$args[3]."&".$args[4]."&".$args[5];
//        $urlIntoQrCode = $args[2];
//        for ($i=0; $i<=count($args);$i++){
//            if ($i>2){
//                $urlIntoQrCode .= $urlIntoQrCode."&".implode('&',$args);
//            }
//        }
        $base->getWrLog($urlIntoQrCode,"QRcode link","createQR",__FILE__);

        $completePathFilename = "$linkSaveImg/$finalFileName";

        $qr = new cQRCode("$urlIntoQrCode", ECL_L);

        $qr->getQRImg("PNG", $completePathFilename);
    }
    // http://192.168.1.51/labox/public/accueil ? login=mario &111=@@@ &languages=fr_FR
}
