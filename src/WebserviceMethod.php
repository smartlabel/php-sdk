<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 14:02
 */

namespace Adesa\SmartLabelClient;


abstract class WebserviceMethod
{
    private $parameters = array();

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @return [string]
     */
    abstract public function getParametersList();

    /**
     * @return string
     */
    abstract public function getWSDL();

    /**
     * @param $name string
     * @param $value mixed
     * @param string $expectedType
     * @return self
     */
    public function setParameter($name, $value, $expectedType = "string")
    {
        $this->parameters[$name] = (string) $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
/*        $missingParameters = array();
        foreach ($this->getParametersList() as $paramName) {
            if (!isset($this->parameters[$paramName])) {
                $missingParameters[] = $paramName;
            }
        }


        if (count($missingParameters) > 0) {
            throw new \Exception("missing parameters: " . implode(", ", $missingParameters));
        }*/

        $arr = array();
        foreach($this->parameters as $name => $value){
            $arr[$name] = (string) $value;
        }
        return $arr;
    }
}