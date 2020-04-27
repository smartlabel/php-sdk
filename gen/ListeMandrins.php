<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class ListeMandrins extends WebserviceMethod
{
    public function getName()
    {
        return 'W2P_ListeMandrins';
    }

    public function getResultName()
    {
        return 'W2P_ListeMandrinsResult';
    }

    public function getWSDL()
    {
        return 'https://srvcalc.adesa.fr/api_smartlabel_web/API_Smartlabel.awws?wsdl';
    }

    public function getParametersList()
    {
        return array();
    }
}
