<?php
namespace Adesa\SmartLabelClient\Methods;

use Adesa\SmartLabelClient\WebserviceMethod;

class DemandePrix extends WebserviceMethod
{
    public function getName()
    {
        return 'W2P_Demande_Prix';
    }

    public function getResultName()
    {
        return 'W2P_Demande_PrixResult';
    }

    public function getWSDL()
    {
        return 'https://srvsmart.adesa.fr/api_smartlabel_web/API_Smartlabel.awws?wsdl';
    }

    public function getParametersList()
    {
        return array('nScenario', 'nQuantite', 'rHauteur', 'rLargeur', 'bPose', 'nMandrin', 'nNbEtiqRouleaux', 'nNbRouleaux', 'nRotation', 'nNbSeries', 'sQteparserie', 'nIdClientAPI');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nScenario($int)
    {
        return $this->setParameter('nScenario', $int, 'int');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nQuantite($int)
    {
        return $this->setParameter('nQuantite', $int, 'int');
    }

    /**
     * @param $double double
     * @return static
     */
    public function rHauteur($double)
    {
        return $this->setParameter('rHauteur', $double, 'double');
    }

    /**
     * @param $double double
     * @return static
     */
    public function rLargeur($double)
    {
        return $this->setParameter('rLargeur', $double, 'double');
    }

    /**
     * @param $boolean boolean
     * @return static
     */
    public function bPose($boolean)
    {
        return $this->setParameter('bPose', $boolean, 'boolean');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nMandrin($int)
    {
        return $this->setParameter('nMandrin', $int, 'int');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nNbEtiqRouleaux($int)
    {
        return $this->setParameter('nNbEtiqRouleaux', $int, 'int');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nNbRouleaux($int)
    {
        return $this->setParameter('nNbRouleaux', $int, 'int');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nRotation($int)
    {
        return $this->setParameter('nRotation', $int, 'int');
    }

    /**
     * @param $int int
     * @return static
     */
    public function nNbSeries($int)
    {
        return $this->setParameter('nNbSeries', $int, 'int');
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
     * @param $long long
     * @return static
     */
    public function nIdClientAPI($long)
    {
        return $this->setParameter('nIdClientAPI', $long, 'long');
    }
}
