<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class EnvoiMailPlateforme extends WebserviceMethod
{
    public function getName()
    {
        return 'Envoi_Mail_Plateforme';
    }

    public function getResultName()
    {
        return '';
    }

    public function getWSDL()
    {
        return 'http://myadesaweb.fr/THETIS_ADESA_SERVICE_WEB//awws/THETIS_Adesa_Service.awws?wsdl';
    }

    public function getParametersList()
    {
        return array();
    }
}