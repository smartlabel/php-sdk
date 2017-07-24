<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 15/06/2017
 * Time: 14:23
 */

namespace Adesa\SmartLabelClient;


class EtatDossier
{
    
    const PAS_PRIS_EN_CHARGE = 1;
    const PRIS_EN_CHARGE = 2;
    const LIVRAISON = 3;
    const ERREUR_FICHIER = 4;
    
    public $numero;
    public $trackingURL;
    public $code;
    public $informationsLivraison;
}