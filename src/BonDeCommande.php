<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 23:09
 */

namespace Adesa\SmartLabelClient;


class BonDeCommande
{
    public $reference;
    public $referenceExterne;
    public $nombreModeles;
    public $laize;
    public $avance;
    public $quantite;
    public $prix;
    public $nombreEtiquettesParRouleau;
    public $nombreRouleaux;
    public $poseAutomatique;
    public $mandrin;
    public $sens;
    public $destinataireFacture;
    /**
     * @var Dossier
     */
    public $dossier;
    public $identifiantRevendeur;

    public $modeles = array();
    

    public function generateXML()
    {
        /**
         * @var $xml \SimpleXMLElement
         */
        $xml = simplexml_load_string("<thetis></thetis>");
        $xml->NoModele = $this->nombreModeles;
        $xml->Ref_Commande = $this->reference;
        $xml->Ref_Commande_Exa = $this->referenceExterne;
        $xml->Scenario = $this->dossier->scenario->numero;
        $xml->Laize = $this->laize;
        $xml->Avance = $this->avance;
        $xml->Quantite = $this->quantite;
        $xml->Prix = $this->prix;
        $xml->EtiquetteparRouleau = $this->nombreEtiquettesParRouleau;
        $xml->NbRouleaux = $this->nombreRouleaux;
        $xml->PoseManuelle = ($this->poseAutomatique) ? '0' : '1';
        $xml->Mandrin = $this->mandrin;
        $xml->Sens = $this->sens;
        $xml->Revendeur = $this->identifiantRevendeur;
        $xml->Fac_Nom = $this->identifiantRevendeur;

        return $xml->asXML();
    }

    public function ajouterModele($nom, $fichier)
    {
        $modele = new Modele();
        $modele->fichier = $fichier;
        $modele->nom = $nom;
        $this->modeles[] = $modele;
    }
}