<?php
require __DIR__ . "/vendor/autoload.php";

$config = \Adesa\SmartLabelClient\Config::fromIniFile(__DIR__ . '/../config.ini');

$config = new \Adesa\SmartLabelClient\Config();

$smartLabel = new \Adesa\SmartLabelClient\SmartLabel($config);
$mandrins = $smartLabel->listeMandrins();
$matieres = $smartLabel->listeMatieres();

/**
 * @var $finitions \Adesa\SmartLabelClient\Finition[]
 */
$finitions = array();

foreach ($matieres as $matiere) {
    $result = $smartLabel->listeFinitions($matiere);
    foreach ($result as $finition) {
        $finitions[$finition->numero] = $finition;
    }
}

$csv = array();

foreach ($mandrins as $mandrin) {
    $csv[] = array("mandrin/$mandrin->diametre", "Mandrin de {$mandrin->diametre}mm");
}

foreach ($matieres as $matiere) {
    $csv[] = array("matiere/$matiere->numero", $matiere->nom);
}

foreach ($finitions as $finition) {
    $csv[] = array("finition/$finition->numero", $finition->nom);
}

$csvFile = fopen(__DIR__ . '/locale/fr-FR.csv', 'w+');

foreach ($csv as $line) {
    fputcsv($csvFile, $line, ";", '"');
}
