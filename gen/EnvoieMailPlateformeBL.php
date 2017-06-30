<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class EnvoieMailPlateformeBL extends WebserviceMethod
{
    public function getName()
    {
        return 'Envoie_Mail_Plateforme_BL';
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