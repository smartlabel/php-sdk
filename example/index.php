<?php

require __DIR__ . "/../vendor/autoload.php";

$config = \Adesa\SmartLabelClient\Config::fromIniFile(__DIR__ . '/../config.ini');
$smartLabel = new \Adesa\SmartLabelClient\SmartLabel($config);

$mandrins = $smartLabel->listeMandrins();
$matieres = $smartLabel->listeMatieres();
$matiere = $matieres[0];
$finitions = $smartLabel->listeFinitions($matiere);
$finition = $finitions[0];
$scenario = $smartLabel->trouverScenario($matiere, $finition);
$dossier = $smartLabel->demandePrix($scenario, 1000, 60, 60, true, $mandrins[0], 1000, 1, 0, 1000, 1);
$adresse = $smartLabel->creerAdresseLivraison($dossier, "Romain Bessuges-Meusy", "111 Av Téroigne de Méricourt", "34000", "MONTPELLIER", "France");
$bonDeCommande  = $smartLabel->commander($dossier, "TEST-ROMAIN-BESSUGES/API-Laurent");
$suivi = $smartLabel->etatDossiers(array($dossier->numero));
$bonDeCommande->ajouterModele('PIM', __DIR__ . '/PIM.pdf');
$smartLabel->finaliserBonDeCommande($bonDeCommande);
