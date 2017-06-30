<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class ListeMatieres extends WebserviceMethod
{
    public function getName()
    {
        return 'W2P_ListeMatieres';
    }

    public function getResultName()
    {
        return 'W2P_ListeMatieresResult';
    }

    public function getWSDL()
    {
        return 'http://srvadesa.vasy.xyz/API_SMARTLABEL_WEB/awws/API_Smartlabel.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('nLaize', 'nAvance');
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