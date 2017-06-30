<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 13:46
 */

namespace Adesa\SmartLabelClient;



class WebserviceClient
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @var \SoapClient
     */
    public $soap;

    public $clients;

    /**
     * @var WebserviceMethod
     */
    public $lastMethod;
    

    /**
     * Client constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->clients = array();
    }

    private function getSoapClient($wsdl)
    {
        if(!isset($this->clients[$wsdl])){
        $this->clients[$wsdl] = new \SoapClient($wsdl, array(
            'trace' => 1,
        ));
        }
        
        return $this->clients[$wsdl];
    }

    /**
     * @param $method WebserviceMethod
     * @param bool $asXML
     * @return mixed
     * @throws \Exception
     */
    public function exec($method, $asXML = true)
    {

        $this->lastMethod = $method;

        $method->getParameters();
        
        try {
            $result = $this->getSoapClient($method->getWSDL())->__soapCall(
                $method->getName(),
                $method->getParameters()
            );
        } catch (\Exception $exc) {
            $asXML = false;
            $result = false;
            
            echo PHP_EOL;
            echo "========= SOAP ERROR ==========" . PHP_EOL;
            var_export($method->getParameters());
            $this->debug();
        }

        return ($asXML) ? simplexml_load_string($result) : $result;
    }


    public function debug(){
        $client = $this->getSoapClient($this->lastMethod->getWSDL());
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

}