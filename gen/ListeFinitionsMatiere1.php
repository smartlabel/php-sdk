<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class ListeFinitionsMatiere1 extends WebserviceMethod
{
    public function getName()
    {
        return 'W2P_ListeFinitions_Matiere_1';
    }

    public function getResultName()
    {
        return 'W2P_ListeFinitions_Matiere_1Result';
    }

    public function getWSDL()
    {
        return 'http://srvadesa.vasy.xyz/API_SMARTLABEL_WEB/awws/API_Smartlabel.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('nCodeMatiere', 'nLaize', 'nAvance');
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
}