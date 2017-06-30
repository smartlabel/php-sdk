<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class Scenario extends WebserviceMethod
{
    public function getName()
    {
        return 'W2P_Scenario';
    }

    public function getResultName()
    {
        return 'W2P_ScenarioResult';
    }

    public function getWSDL()
    {
        return 'http://srvadesa.vasy.xyz/API_SMARTLABEL_WEB/awws/API_Smartlabel.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('nCodematiere', 'nLaize', 'nAvance', 'sCodeFinition', 'sCodeFinition2');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nCodematiere($int)
    {
        return $this->setParameter('nCodematiere', $int, 'int');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nLaize($int)
    {
        return $this->setParameter('nLaize', $int, 'int');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nAvance($int)
    {
        return $this->setParameter('nAvance', $int, 'int');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sCodeFinition($string)
    {
        return $this->setParameter('sCodeFinition', $string, 'string');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sCodeFinition2($string)
    {
        return $this->setParameter('sCodeFinition2', $string, 'string');
    }
}