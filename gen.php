<?php

//$wsdlCommande = "http://smartlabel.thetis.fr/SMARTLABEL_SERVICE_Web/SmartLabel_Service.awws?wsdl";
//$wsdlCommande = "https://srvcalc.adesa.fr/api_smartlabel_web/API_Smartlabel.awws?wsdl";
$wsdlCommande = "https://srvcalc.adesa.fr/api_smartlabel_web/API_Smartlabel.awws?wsdl";
$wsdlTransport = "http://srvadesa.vasy.xyz/SMARTLABEL_TRANSPORT_WS_WEB/SMARTLABEL_Transport_WS.awws?wsdl";
$wsdlSuivi = "http://myadesaweb.fr/THETIS_ADESA_SERVICE_WEB//awws/THETIS_Adesa_Service.awws?wsdl";

function getMessageName($element)
{
    return str_replace("s0:", "", (string)$element["message"]);
}

function generateClassesFromWSDL($url)
{
    $xml = simplexml_load_file($url);

    $messages = array();
    $operations = array();

    foreach ($xml->message as $message) {
        $messageName = (string)$message["name"];
        $params = array();
        foreach ($message->part as $part) {
            $params[(string)$part["name"]] = str_replace("xsd:", "", (string)$part["type"]);
        }
        $messages[$messageName] = $params;
    }

    foreach ($xml->portType->operation as $operation) {
        $operationName = (string)$operation["name"];
        $operations[$operationName] = array(
            "input" => getMessageName($operation->input),
            "output" => getMessageName($operation->output),
        );
    }


    foreach ($operations as $name => $operation) {

        $t = str_repeat(" ", 4);

        $namespace = 'namespace Adesa\SmartLabelClient\Methods;';
        $use = "use Adesa\\SmartLabelClient\\WebserviceMethod;";
        $className = str_replace("_", "", str_replace("W2P", "", str_replace("SL","", $name)));
        $filename = __DIR__ . "/gen/$className.php";
        $outputKeys = array_keys($messages[$operation["output"]]);

        if (count($outputKeys)){
            $resultName = $outputKeys[0];
        } else {
            $resultName = '';
        }

        $lines = array();

        $parameters = array_keys($messages[$operation["input"]]);
        array_walk($parameters, function (&$param) {
            $param = "'$param'";
        });
        $parameters = implode(', ', $parameters);

        $lines[] = "<?php";
        $lines[] = "$namespace";
        $lines[] = "";
        $lines[] = $use;
        $lines[] = "";
        $lines[] = "class $className extends WebserviceMethod";
        $lines[] = "{";

        /*
         * getName
         */
        $lines[] = $t . "public function getName()";
        $lines[] = $t . "{";
        $lines[] = $t . $t . "return '$name';";
        $lines[] = $t . "}";
        $lines[] = "";

        /*
         * getResultName
         */
        $lines[] = $t . "public function getResultName()";
        $lines[] = $t . "{";
        $lines[] = $t . $t . "return '$resultName';";
        $lines[] = $t . "}";
        $lines[] = "";

        /*
         * getWSDL
         */
        $lines[] = $t . "public function getWSDL()";
        $lines[] = $t . "{";
        $lines[] = $t . $t . "return '$url';";
        $lines[] = $t . "}";
        $lines[] = "";

        /*
         * getParametersList
         */
        $lines[] = $t . "public function getParametersList()";
        $lines[] = $t . "{";
        $lines[] = $t . $t . "return array($parameters);";
        $lines[] = $t . "}";

        /*
         * getParams
         */
        foreach ($messages[$operation["input"]] as $paramName => $type) {
            $lines[] = "";

            $lines[] = $t . "/**";
            $lines[] = $t . " * @param $$type $type";
            $lines[] = $t . " * @return static";
            $lines[] = $t . " */";
            $lines[] = $t . "public function $paramName($$type)";
            $lines[] = $t . "{";
            $lines[] = $t . $t . "return \$this->setParameter('$paramName', $$type, '$type');";
            $lines[] = $t . "}";
        }
        $lines[] = "}";

        echo "WRITE $filename\n";
        file_put_contents($filename, implode("\n", $lines));
    }
}

generateClassesFromWSDL($wsdlCommande);
generateClassesFromWSDL($wsdlTransport);
generateClassesFromWSDL($wsdlSuivi);
