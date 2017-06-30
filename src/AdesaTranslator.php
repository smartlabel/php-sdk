<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 16/06/2017
 * Time: 11:43
 */

namespace Adesa\SmartLabelClient;


class AdesaTranslator
{

    /**
     * @var Config
     */
    private $config;

    private $_keys;
    
    /**
     * AdesaTranslator constructor.
     * @param Config $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    
    private function keys(){
        if(!isset($this->_keys)){
            $handle = fopen($this->config->localeBasePath . DIRECTORY_SEPARATOR . $this->config->locale . '.csv', 'r');
            while(($row = fgetcsv($handle, null, ';', '"')) !== false){
                $this->_keys[$row[0]] = $row[1];
            }
        }

        return $this->_keys;
    }
    

    public function translate($key){
        $k = $this->keys();
        return isset($k[$key]) ? $k[$key] : $key;
    }
}