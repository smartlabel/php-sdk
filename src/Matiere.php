<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 15:24
 */

namespace Adesa\SmartLabelClient;


class Matiere
{
    public $nom;
    public $numero;

    /**
     * Matiere constructor.
     * @param $numero
     */
    public function __construct($numero)
    {
        $this->numero = $numero;
    }


}