<?php
/**
 *
 * Created by blond.
 * File: ProductionDossierDeFab.php
 * Date: 18/05/15 - 15:48
 *
 */

namespace fbx\Fab;


class ProductionDossierDeFab extends Select
{
    const ClassPage = 'ProductionDossierDeFab';

    public $_template = "Production/ProductionDossierDeFab.twig";

    public function getInsertDataDossierDeFab($args)
    {

        if (isset($args['Dossier']) && $args['Dossier']!='') $psDossier = $args['Dossier']; else $psDossier = '';

        $q_select = "SELECT IDDossierDeFab FROM TBL_DOSSIER_DE_FAB WHERE Dossier = '$psDossier' AND EstSupp = '0'";
        $data_select = \fbx\DBmysql::getInstance()->getSelectData($q_select);
//        $this->printr($q_select);
//        $this->printr($data_select);
        if( count($data_select)=='0' ) {

            $pnIdDossierDeFab = $pnIdDossierDeFabTlElement = $pnIdElementTlOption = null;
            $insert_option = $jnsert_element = $jnsert_element_TL_option = $jnsert_element_TL_machine = null;
            $pnIdUser = $_SESSION['FBX_USER_ID'];

            if (isset($args['Ref']) && $args['Ref'] != '')                          $psRef = $args['Ref'];                              else $psRef = '';
            if (isset($args['Quantite']) && $args['Quantite'] > '0')                $pnQuantite = intval($args['Quantite']);            else $pnQuantite = '0';
            if (isset($args['Commentaire']) && $args['Commentaire'] != '')          $psCommentaire = $args['Commentaire'];              else $psCommentaire = '';
            if (isset($args['NbElement']) && $args['NbElement'] > '0')              $pnNbElement = intval($args['NbElement']);          else $pnNbElement = '0';
            if (isset($args['NbOption']) && $args['NbOption'] > '0')                $pnNbOption = intval($args['NbOption']);            else $pnNbOption = '0';
            if (isset($args['NbMachine']) && $args['NbMachine'] > '0')              $pnNbMachine = intval($args['NbMachine']);          else $pnNbMachine = '0';
            if (isset($args['Pliage']) && $args['Pliage'] != '')                    $pbPliage = '1';                                    else $pbPliage = '0';
            if (isset($args['Amalgame']) && $args['Amalgame'] != '')                $pbAmalgame = '1';                                  else $pbAmalgame = '0';
            if (isset($args['LargeurOuvert']) && $args['LargeurOuvert'] > '0')      $pnLargeurOuvert = intval($args['LargeurOuvert']);  else $pnLargeurOuvert = '0';
            if (isset($args['HauteurOuvert']) && $args['HauteurOuvert'] > '0')      $pnHauteurOuvert = intval($args['HauteurOuvert']);  else $pnHauteurOuvert = '0';
            if (isset($args['LargeurFerme']) && $args['LargeurFerme'] > '0')        $pnLargeurFerme = intval($args['LargeurFerme']);    else $pnLargeurFerme = '0';
            if (isset($args['HauteurFerme']) && $args['HauteurFerme'] > '0')        $pnHauteurFerme = intval($args['HauteurFerme']);    else $pnHauteurFerme = '0';
            if (isset($args['NbPose']) && $args['NbPose'] > '0')                    $pnNbPose = intval($args['NbPose']);                else $pnNbPose = '1';
            if (isset($args['DateExpedition'])) {
                $date = \DateTime::createFromFormat('d/m/Y', $args['DateExpedition']);
                if (is_object($date)) $pdDateExpedition = $date->format('Ymd'); else $pdDateExpedition = '';
            } else $pdDateExpedition = '';

            //__ INSERT INTO TBL_DOSSIER_DE_FAB
            $q_ins_dossier = "INSERT INTO TBL_DOSSIER_DE_FAB
  (IDMembreAdd,DateAdd,Dossier,Ref,Quantite,Commentaire,DateExpedition,NbOption,NbElement,EstAmalgame,EstPliable,LargeurOuvert,HauteurOuvert,LargeurFerme,HauteurFerme,NbPose,NbMachine)
VALUES
  ('$pnIdUser',NOW(),'$psDossier','$psRef','$pnQuantite','$psCommentaire','$pdDateExpedition','$pnNbOption','$pnNbElement','$pbAmalgame','$pbPliage','$pnLargeurOuvert','$pnHauteurOuvert','$pnLargeurFerme','$pnHauteurFerme','$pnNbPose','$pnNbMachine')";
            $pnIdDossierDeFab = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier);
            $this->getWrLog($q_ins_dossier, "pnIdDossierDeFab => $pnIdDossierDeFab", __FUNCTION__, __FILE__);

            //__CREATE QRcode
            $path= $_SESSION['QR']['PATH'];
            $link= $_SESSION['QR']['IMG']."/dossier";
            $ref = $_SESSION['QR']['DOSSIER']."?action=getDataDossierDeFabForFiche&IDDossierDeFab=$pnIdDossierDeFab";
            $url = "$path?dossier-$pnIdDossierDeFab&$link&$ref";
            $this->cURLexec($url);
            $this->getWrLog("QRcode Dossier", "$url", __FUNCTION__, __FILE__);

            //__CREATE CODE BARRE
            $path = ($_SESSION['BARCODE']['PATH']);
            $link = ($_SESSION['BARCODE']['IMG'])."/dossier";
            $contenu_barcode = "%%".$psDossier;
            $url = "$path?$contenu_barcode&dossier-$pnIdDossierDeFab&$link";
            $this->cURLexec($url);
            $this->getWrLog("CodeBarre Dossier", "$url", __FUNCTION__, __FILE__);

            //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_OPTION
            for ($i = 1; $i <= $pnNbOption; $i++) {
                if (isset($args['Option' . $i]) && $args['Option' . $i] > '0') {
                    $insert_option[] = "('$pnIdDossierDeFab','" . intval($args['Option' . $i]) . "','$pnIdUser',NOW())";
                }
            }
            if (count($insert_option) >= 1) {
                $q_ins_dossier_option = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_OPTION
  (IDDossierDeFab, IDOption, IDMembreAdd, DateAdd)
VALUES
  " . implode(',', $insert_option) . "";
                $pnIdDossierDeFabTlOption = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier_option);
                $this->getWrLog($q_ins_dossier_option, "pnIdDossierDeFabTlOption=>$pnIdDossierDeFabTlOption", __FUNCTION__, __FILE__);
            }

            //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT
            for ($j = 1; $j <= $pnNbElement; $j++) {
                if (isset($args['Element' . $j]) && $args['Element' . $j] > '0') {
                    $q_ins_dossier_element = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT
  (IDMembreAdd, DateAdd,IDDossierDeFab, IDElement, Quantite, IDSupport, IDFormat, Commentaire)
VALUES
  ('$pnIdUser',NOW(),'$pnIdDossierDeFab','" . $args['Element' . $j] . "','" . intval($args['Quantite' . $j]) . "','" . intval($args['Support' . $j]) . "','" . intval($args['Format' . $j]) . "','" . $args['Commentaire' . $j] . "')";
                    $pnIdDossierDeFabTlElement = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier_element);
                    $this->getWrLog($q_ins_dossier_element, "pnIdDossierDeFabTlElement=>$pnIdDossierDeFabTlElement", __FUNCTION__, __FILE__);

                    //__ QUERY ELEMENT_TL_OPTION
                    for ($i = 1; $i <= $pnNbOption; $i++) {
                        if (isset($pnIdDossierDeFabTlElement) && $pnIdDossierDeFabTlElement > '0') {
                            if (isset($args['Option' . $j . 'Element' . $i]) && $args['Option' . $j . 'Element' . $i] > '0') {
                                $jnsert_element_TL_option[] = "('$pnIdUser',NOW(),'$pnIdDossierDeFabTlElement','" . $args['Option' . $j . 'Element' . $i] . "')";
                            }
                        }
                    }
                    
                    //__ QUERY ELEMENT_TL_MACHINE
                    for ($x = 1; $x <= $pnNbMachine; $x++) {
                        if (isset($pnIdDossierDeFabTlElement) && $pnIdDossierDeFabTlElement > '0') {
                            if (isset($args['Element' . $j . 'Machine' . $x]) && $args['Element' . $j . 'Machine' . $x] > '0') {
                                if (isset($args['Element' . $j . 'MachineImpression' . $x]) && $args['Element' . $j . 'MachineImpression' . $x] > '0') { $pnElementTlMachineImpression = $args['Element' . $j . 'MachineImpression' . $x]; } else { $pnElementTlMachineImpression = '0'; }
                                $pnElementTlMachine = $args['Element' . $j . 'Machine' . $x];
                                $jnsert_element_TL_machine[] = "('$pnIdUser',NOW(),'$pnIdDossierDeFabTlElement','$pnElementTlMachine','$pnElementTlMachineImpression')";
                            }
                        }
                    }

                    //__CREATE CODE BARRE
                    $path = ($_SESSION['BARCODE']['PATH']);
                    $link = ($_SESSION['BARCODE']['IMG'])."/dossier";
                    $contenu_barcode = "((".$pnIdDossierDeFab."((".$args['Element' . $j]."";
                    $url = "$path?$contenu_barcode&dossiertlement-$pnIdDossierDeFabTlElement&$link";
                    $this->cURLexec($url);
                }
            }

            //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION
            if (count($jnsert_element_TL_option) >= 1) {
                $q_ins_dossier_element_tl_option = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION
    (IDMembreAdd, DateAdd, IDDossierDeFab_tl_element, IDOption)
VALUES
    " . implode(',', $jnsert_element_TL_option) . "";
                $pnIdElementTlOption = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier_element_tl_option);
                $this->getWrLog($q_ins_dossier_element_tl_option, "pnIdElementTlOption=>$pnIdElementTlOption", __FUNCTION__, __FILE__);
            }

            //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE
            if (count($jnsert_element_TL_machine) >= 1) {
                $q_ins_dossier_element_tl_machine = "INSERT INTO
TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE
    (IDMembreAdd, DateAdd, IDDossierDeFab_tl_element, IDMachine, IDImpression)
VALUES
    " . implode(',', $jnsert_element_TL_machine) . "";
                $pnIdElementTlMachine = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier_element_tl_machine);
                $this->getWrLog($q_ins_dossier_element_tl_machine, "pnIdElementTlMachine=>$pnIdElementTlMachine", __FUNCTION__, __FILE__);
            }

        }
        else {
            $this->_data = array("OUT"=>$args);
            echo('<script type="text/javascript">$(function(){verifDescriptionDossier();getElement();getModalAlert("Ce dossier existe déjà");})</script>');
        }
    }
}