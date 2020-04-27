<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class ListeFinitionsMatiere2 extends WebserviceMethod
{
    public function getName()
    {
        return 'W2P_ListeFinitions_Matiere_2';
    }

    public function getResultName()
    {
        return 'W2P_ListeFinitions_Matiere_2Result';
    }

    public function getWSDL()
    {
        return 'https://srvcalc.adesa.fr/api_smartlabel_web/API_Smartlabel.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('nCodeMatiere', 'nLaize', 'nAvance', 'sCodeFinition');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nCodeMatiere($int)
    {
        return $this->setParameter('nCodeMatiere', $int, 'int');
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
}
