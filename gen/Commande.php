<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class Commande extends WebserviceMethod
{
    public function getName()
    {
        return 'W2P_Commande';
    }

    public function getResultName()
    {
        return 'W2P_CommandeResult';
    }

    public function getWSDL()
    {
        return 'https://srvcalc.adesa.fr/api_smartlabel_web/API_Smartlabel.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('nDossier', 'sQteparserie', 'nIDCommande', 'nIdClientAPI');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nDossier($int)
    {
        return $this->setParameter('nDossier', $int, 'int');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sQteparserie($string)
    {
        return $this->setParameter('sQteparserie', $string, 'string');
    }

    /**
     * @param $string string
     * @return static
     */
    public function nIDCommande($string)
    {
        return $this->setParameter('nIDCommande', $string, 'string');
    }

    /**
     * @param $long long
     * @return static
     */
    public function nIdClientAPI($long)
    {
        return $this->setParameter('nIdClientAPI', $long, 'long');
    }
}
