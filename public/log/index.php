<?php
/**
 * log.php
 *
 * User: blond
 * Date: 14/05/15
 * Time: 13:05
 */

$path = dirname(__FILE__);

if (file_exists($path)) {

    //-- ouverture du dossier
    $dir = opendir($path);

    //-- pour chaque fichier du dossier
    while ($files = readdir($dir)) {
        $element[] = $files;
    }
    closedir($dir);
    sort($element);
    foreach ($element as $key => $fichier) {
        if ($fichier != 'index.php' && $fichier != '.' && $fichier != '..') echo "<a href='$fichier'>$fichier</a><br/>";
    }
}
//-- dossier existe pas
else {
    echo "pas de dossier a ouvrir";
}