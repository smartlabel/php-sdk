<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 25/07/2017
 * Time: 17:43
 */

namespace Adesa\SmartLabelClient;


class InvalidParametersException extends \Exception
{


    public $errors = [];

    /**
     * InvalidParametersException constructor.
     * @param array $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }
}