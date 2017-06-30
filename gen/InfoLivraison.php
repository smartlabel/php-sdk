<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class InfoLivraison extends WebserviceMethod
{
    public function getName()
    {
        return 'Info_Livraison';
    }

    public function getResultName()
    {
        return 'Info_LivraisonResult';
    }

    public function getWSDL()
    {
        return 'http://srvadesa.vasy.xyz/SMARTLABEL_TRANSPORT_WS_WEB/SMARTLABEL_Transport_WS.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('sNomRevendeur', 'nDossier', 'sDenomination', 'sAdresse', 'sCodepostal', 'sVille', 'sAdressePays');
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

    /**
     * @param $string string
     * @return static
     */
    public function sDenomination($string)
    {
        return $this->setParameter('sDenomination', $string, 'string');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sAdresse($string)
    {
        return $this->setParameter('sAdresse', $string, 'string');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sCodepostal($string)
    {
        return $this->setParameter('sCodepostal', $string, 'string');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sVille($string)
    {
        return $this->setParameter('sVille', $string, 'string');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sAdressePays($string)
    {
        return $this->setParameter('sAdressePays', $string, 'string');
    }
}