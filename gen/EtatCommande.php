<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class EtatCommande extends WebserviceMethod
{
    public function getName()
    {
        return 'SL_EtatCommande';
    }

    public function getResultName()
    {
        return 'SL_EtatCommandeResult';
    }

    public function getWSDL()
    {
        return 'http://myadesaweb.fr/THETIS_ADESA_SERVICE_WEB//awws/THETIS_Adesa_Service.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('sNomPartenaire', 'sNumDossier');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sNomPartenaire($string)
    {
        return $this->setParameter('sNomPartenaire', $string, 'string');
    }

    /**
     * @param $string string
     * @return static
     */
    public function sNumDossier($string)
    {
        return $this->setParameter('sNumDossier', $string, 'string');
    }
}