<?php
/**
 * Created by JetBrains PhpStorm.
 * User: blondprod
 * Date: 18/09/14
 * Time: 17:18
 * ***********
 */

header("Access-Control-Allow-Origin: *");

session_start();

function cleanData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

$data = $_SESSION["dataArray"];

if (count($data)>=1) {
//    $nameFile = $_SESSION["fileName"];

    // file name for download
    $date = gmdate('D, d M Y H:i:s');
    //$filename = $nameFile . "_" . date('Ymd-His') . ".xls";

    $filename = "Planning-".date('Y-m-d').".xls";

    header('Last-Modified: ' . $date . ' GMT');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/vnd.ms-excel");
    header('Expires: ' . $date);

    if (preg_match('/msie|(microsoft internet explorer)/i', $_SERVER['HTTP_USER_AGENT'])) {
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    } else {
        header('Pragma: no-cache');
    }

    $flag = false;

    foreach ($data as $row) {
        if (!$flag) {
            // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\n";
            $flag = true;
        }
        array_walk($row, 'cleanData');
        echo implode("\t", array_values($row)) . "\n";
    }
}
exit;