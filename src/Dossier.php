<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 22:52
 */

namespace Adesa\SmartLabelClient;


class Dossier
{
    public $prix;

    public $poids;

    public $numero;

    /**
     * @var Scenario
     */
    public $scenario;

    public $diametre;
    
    public $quantitesParSerie;
}