<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 15:51
 */

namespace Adesa\SmartLabelClient;


class Finition
{

    public $nom;
    public $numero;

    /**
     * Finition constructor.
     * @param $numero
     */
    public function __construct($numero)
    {
        $this->numero = $numero;
    }


}