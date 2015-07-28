<?php
/**
 *
 * Created by blond.
 * File: readCSV.php
 * Date: 16/07/15 - 00:56
 * Proj: veganet
 *
 */

$csv = $path = $resu = $data_csv = $fichier = $element = $psDossier = $array_IDOption = null;

require_once("class.csv.php");

$csv = new csv();

$path = $csv->getPath();

if (file_exists($path)) {

    $element = $csv->getFileForRead();

    if (count($element)>'0'){

        foreach ($element as $key => $fichier) {

            if ($fichier != '.' && $fichier != '..') {
//                $csv->getPrint($fichier);

                $data_csv = $csv->getDataFromCSV($fichier);

                if ( isset($data_csv[1][0]) && $data_csv[1][0] != '' ) $psDossier = "'".$data_csv[1][0]."'";

                if (isset($psDossier) && $psDossier != null) {
//                    $csv->getPrint($psDossier);

                    $data = $csv->getVerifDossierExist($psDossier);

                    //__ SI DOSSIER EXISTE PAS DEJA
                    if( !isset($data) ) {
//                        var_dump($psDossier);

                        if (isset($data_csv[2]) && $data_csv[2][0] > '0' ) $array_IDOption = $csv->getVerifOptionExist($data_csv[2],$data_csv[0][0]);

                        $pnIdDossierDeFab = $csv->getInsertDossier($data_csv);

                        if (isset($pnIdDossierDeFab) && $pnIdDossierDeFab > '0'){

                            //__CREATE QRcode & BarCode Dossier de fab
                            $csv->getQRandBarCodeDossierDeFab($pnIdDossierDeFab,$psDossier);

                            //__ INSERT DOSSIER DE FAB TL OPTION
                            $pnIdDossierDeFabTlOption = $csv->getInsertDossierTlOption($pnIdDossierDeFab,$array_IDOption);

                            //__ INSERT DOSSIER DE FAB TL ELEMENT
                            $pnIdDossierDeFabTlElement = $csv->getInsertDossierTlElement($data_csv,$pnIdDossierDeFab);

                            if (isset($pnIdDossierDeFabTlElement) && $pnIdDossierDeFabTlElement > '0'){

                                //__CREATE BarCode Dossier Tl Element
                                $csv->getBarCodeDossierDeFabTlElement($pnIdDossierDeFab,$pnIdDossierDeFabTlElement);

                                //__ INSERT DOSSIER DE FAB TL ELEMENT TL OPTION
                                if (count($array_IDOption) >= 1) {
                                    $pnIdDossierDeFabTlElementTlOption = $csv->getInsertDossierTlElementTlOption($pnIdDossierDeFabTlElement, $array_IDOption);
                                    //$csv->getPrint($pnIdDossierDeFabTlElementTlOption);
                                }
                            }
                        }
                    }
                    if (isset($pnIdDossierDeFab) && $pnIdDossierDeFab > '0') {
                        echo "<pre style='color: #000FFF;'><h1>Dossier $psDossier ajouté</h1></pre>";
                        $csv->getDeleteFile($fichier);
                    }
                    else {
                        echo "<pre style='color: #FF0000;text-align: center;'><h1>Dossier $psDossier existant !</h1></pre>";
                    }
                }
                else {
                    echo "<pre style='color: #FF0000;text-align: center;'><h1>Lecture vide</h1></pre>";
                }

                unset($data);
                unset($data_csv);
                unset($psDossier);
                unset($array_IDOption);
                unset($pnIdDossierDeFab);
                unset($pnIdDossierDeFabTlOption);
                unset($pnIdDossierDeFabTlElement);
                unset($pnIdDossierDeFabTlElementTlOption);
            }
        }
    }
} else { echo "<pre style='color: #FF0000;text-align: center;'><h1>Dossier de lecture introuvable</h1></pre>"; }