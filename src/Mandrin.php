<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 22:40
 */

namespace Adesa\SmartLabelClient;


class Mandrin
{
    public $diametre;

    /**
     * Mandrin constructor.
     * @param $diametre
     */
    public function __construct($diametre)
    {
        $this->diametre = $diametre;
    }


}