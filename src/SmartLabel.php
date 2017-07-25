<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 15:26
 */

namespace Adesa\SmartLabelClient;


use Adesa\SmartLabelClient\Methods\Commande;
use Adesa\SmartLabelClient\Methods\DemandePrix;
use Adesa\SmartLabelClient\Methods\EtatCommande;
use Adesa\SmartLabelClient\Methods\InfoLivraison;
use Adesa\SmartLabelClient\Methods\ListeFinitionsMatiere1;
use Adesa\SmartLabelClient\Methods\ListeMandrins;
use Adesa\SmartLabelClient\Methods\ListeMatieres;
use Adesa\SmartLabelClient\Methods\Scenario;

class SmartLabel
{

    public $client;
    public $ftp;
    public $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = new WebserviceClient($this->config);
        $this->translator = new AdesaTranslator($this->config);
        $this->ftp = new AdesaFTP($this->config);
    }

    /**
     * Retourne les tailles de mandrin disponibles
     * @return Mandrin[]
     */
    public function listeMandrins()
    {
        $mandrins = array();
        $xml = $this->client->exec(new ListeMandrins());
        foreach ($xml->Liste_Mandrins->Mandrins as $mandrin) {
            $mandrins[] = new Mandrin(intval($mandrin["Valeur"]));
        }
        return $mandrins;
    }


    /**
     * @return Matiere[]
     */
    public function listeMatieres()
    {
        $matieres = array();
        $listeMatieres = new ListeMatieres();

        $xml = $this->client->exec(
            $listeMatieres->nAvance(0)->nLaize(0)
        );

        foreach ($xml->Liste_Matieres->Matieres as $matiere) {
            $matiereObject = new Matiere((int)$matiere["numero"]);
            $matiereObject->nom = (string)$matiere["nom"];
            $matieres[] = $matiereObject;
        }

        return $matieres;
    }

    /**
     * @param string $numero
     * @return Matiere|null
     */
    public function trouverMatiere($numero)
    {
        $matieres = $this->listeMatieres();
        $ret = null;
        foreach ($matieres as $matiere) {
            if ($matiere->numero == $numero) {
                $ret = $matiere;
            }
        }
        return $ret;
    }

    /**
     * @param $matiere Matiere
     * @return Finition[]
     */
    public function listeFinitions($matiere)
    {
        $finitions = array();
        $method = new ListeFinitionsMatiere1();
        $method->nCodeMatiere($matiere->numero)
            ->nAvance(0)
            ->nLaize(0);

        if ($xml = $this->client->exec($method)) {
            foreach ($xml->W2P_Liste_Finitions_Matiere_1->MATIERE->Finitions as $finition) {
                $finitionObject = new Finition((string)$finition["numero"]);
                $finitionObject->nom = (string)$finition["nom"];
                $finitions[] = $finitionObject;
            }
        }

        return $finitions;
    }

    public function trouverScenario($matiere, $finition)
    {

        $method = new Scenario();
        $method->nCodematiere($matiere->numero)
            ->nLaize(0)
            ->nAvance(0)
            ->sCodeFinition($finition->numero)
            ->sCodeFinition2(0); // La finition 2 est prévue pour la dorure mais n'est pas encore implémentée

        $xml = $this->client->exec($method);
        $element = $xml->W2P_Scenario->Scenario;
        $scenario = new \Adesa\SmartLabelClient\Scenario((string)$element["numero"]);
        $scenario->delai = (int)$element["delai"];
        $scenario->nom = (string)$element["nom"];

        $scenario->matiere = $matiere;
        $scenario->finition = $finition;
        return $scenario;
    }

    public function demandePrix(
        $scenario,
        $quantite,
        $hauteur,
        $largeur,
        $poseAutomatique,
        $mandrin,
        $nombreEtiquettesParRouleau,
        $nombreRouleaux,
        $rotation, /*0 ; 90 ; 180 ; 270*/
        $quantitesParSerie,
        $nombreSeries = null
    )
    {

        $method = new DemandePrix();
        $method->nScenario($scenario->numero)
            ->nQuantite($quantite)
            ->rHauteur($hauteur)
            ->rLargeur($largeur)
            ->bPose($poseAutomatique)
            ->nMandrin($mandrin->diametre)
            ->nNbEtiqRouleaux($nombreEtiquettesParRouleau)
            ->nNbRouleaux($nombreRouleaux)
            ->nRotation($rotation)
            ->nNbSeries(is_null($nombreSeries) ? count($quantitesParSerie) : $nombreSeries)
            ->sQteparserie(implode(';', $quantitesParSerie))
            ->nIdClientAPI($this->config->cleAPI);

        $xml = $this->client->exec($method);
        $xmlDossier = $xml->W2P_Demande_Prix;
        $dossier = new Dossier();
        $dossier->numero = intval((string)$xmlDossier->Dossier["Numero"]);
        $dossier->prix = floatval((string)$xmlDossier->Prix["Valeur"]);
        $dossier->poids = floatval((string)$xmlDossier->Poids["Valeur"]);
        $dossier->diametre = floatval((string)$xmlDossier->Diametre["Valeur"]);
        $dossier->quantitesParSerie = $quantitesParSerie;
        $dossier->scenario = $scenario;

        return $dossier;
    }

    public function commander($dossier, $identifiantCommandeExterne)
    {
        $method = new Commande();
        $method->nDossier($dossier->numero)
            ->nIDCommande($identifiantCommandeExterne)
            ->sQteparserie($dossier->quantitesParSerie)
            ->nIdClientAPI($this->config->cleAPI);

        $xml = $this->client->exec($method);

        $xmlBDC = $xml->Commandes_Web_to_Print;

        $bdc = new BonDeCommande();
        $bdc->reference = intval((string)$xmlBDC->Ref_Commande);
        $bdc->referenceExterne = (string)$xmlBDC->Quantite; // TODO BUG Thétis ! Important
        $bdc->nombreModeles = intval($xmlBDC->NoModele);
        $bdc->laize = floatval($xmlBDC->Laize);
        $bdc->avance = floatval($xmlBDC->Avance);
        $bdc->quantite = intval((string)$xmlBDC->Ref_Commande_Exa); // TODO BUG Thétis ! Mauvais nom de propriété
        $bdc->prix = floatval($xmlBDC->Prix); // TODO BUG Thétis : prix 0€
        $bdc->nombreEtiquettesParRouleau = intval($xmlBDC->EtiquetteparRouleau); // TODO TYPO Thétis : majuscule "par"
        $bdc->poseAutomatique = ($xmlBDC->PoseManuelle == "0"); // TODO antipattern
        $bdc->destinataireFacture = (string)$xmlBDC->Fac_Nom;
        $bdc->identifiantRevendeur = $this->config->identifiantRevendeur;
        $bdc->dossier = $dossier;

        return $bdc;
    }

    public function creerAdresseLivraison($dossier, $destinataire, $adresse, $codePostal, $ville, $pays)
    {
        $method = new InfoLivraison();
        $method->sAdresse($adresse);
        $method->sCodepostal($codePostal);
        $method->sVille($ville);
        $method->sAdressePays($pays);
        $method->nDossier($dossier->numero);
        $method->sNomRevendeur($this->config->identifiantRevendeur);
        $method->sDenomination($destinataire);

        $xml = $this->client->exec($method);

        $xmlLiv = $xml->STLivraison;
        $adresse = new AdresseLivraison();
        $adresse->id = (string)$xmlLiv['id'];
        $adresse->pays = (string)$xmlLiv->Pays;
        $adresse->destinataire = (string)$xmlLiv->Denomination;
        $adresse->codePostal = (string)$xmlLiv->CodePostal;
        $adresse->ville = (string)$xmlLiv->Ville;

        return $adresse;
    }

    /**
     * @param $numerosDossier string[]
     * @return EtatDossier[]
     */
    public function etatDossiers($numerosDossier)
    {
        $etats = array();

        foreach ($numerosDossier as $numeroDossier) {
            $method = new EtatCommande();
            $method
                ->sNomPartenaire($this->config->identifiantRevendeur)
                ->sNumDossier($numeroDossier);

            $xml = $this->client->exec($method);

            $xmlEtat = $xml->MonEtatLiv;

            $suivi = new EtatDossier();
            $suivi->numero = $numeroDossier;
            $suivi->code = intval((string)$xmlEtat->Livraison_Etat);
            $suivi->trackingURL = (string)$xmlEtat->Livraison_Tracking_Adresse;
            $suivi->informationsLivraison = (string)$xmlEtat->livraison_Info;

            $etats[$numeroDossier] = $suivi;
        }

        return $etats;
    }

    /**
     * @param $bdc BonDeCommande
     * @return boolean Succes
     */
    public function finaliserBonDeCommande($bdc)
    {

        $numDossier = $bdc->dossier->numero;
        $xml = $bdc->generateXML();
        $temp = tmpfile();
        fwrite($temp, $xml);

        foreach ($bdc->modeles as $i => $modele) {
            $modeleIndex = $i + 1;
            $base = "ok/$numDossier/{$numDossier}_$modeleIndex";
            $this->ftp->upload($temp, "$base.xml");
            $this->ftp->upload($modele->fichier, "$base.pdf");
        }

        $this->ftp->close();

        /* En fait le TransfertOK n'est plus utilisé
        $method = new TransfertOk();
        $method->nDossier($numDossier);
        return $this->client->exec($method, false);*/
    }

    public function label($objet)
    {
        $cls = get_class($objet);

        if ($cls === 'Adesa\SmartLabelClient\Matiere') {
            return $this->translator->translate("matiere/$objet->numero");
        }

        if ($cls === 'Adesa\SmartLabelClient\Finition') {
            return $this->translator->translate("finition/$objet->numero");
        }

        if ($cls === 'Adesa\SmartLabelClient\Mandrin') {
            return $this->translator->translate("mandrin/$objet->diametre");
        }

        if ($cls === 'Adesa\SmartLabelClient\Scenario') {
            return $this->translator->translate("scenario/$objet->numero");
        }

        return $cls;
    }

}