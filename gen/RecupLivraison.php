<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class RecupLivraison extends WebserviceMethod
{
    public function getName()
    {
        return 'Recup_Livraison';
    }

    public function getResultName()
    {
        return 'Recup_LivraisonResult';
    }

    public function getWSDL()
    {
        return 'http://srvadesa.vasy.xyz/SMARTLABEL_TRANSPORT_WS_WEB/SMARTLABEL_Transport_WS.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('sNomRevendeur', 'nDossier');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sNomRevendeur($string)
    {
        return $this->setParameter('sNomRevendeur', $string, 'string');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nDossier($int)
    {
        return $this->setParameter('nDossier', $int, 'int');
    }
}