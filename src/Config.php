<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 14/06/2017
 * Time: 13:46
 */

namespace Adesa\SmartLabelClient;


class Config
{

    public static function fromIniFile($filename){
        return Config::fromArray(parse_ini_file($filename, true));
    }
    
    public static function fromArray($arr){
        $config = new Config();
        $config->locale = $arr['locale'];
        $config->localeBasePath = $arr['localeBasePath'];
        $config->identifiantRevendeur = $arr['identifiantRevendeur'];
        $config->cleAPI = $arr['cleAPI'];
        $config->FTP = (object)$arr['FTP'];
        return $config;
    }

    public $FTP = array(
        "host" => "adesaweb.adesa.fr",
        "login" => "",
        "password" => ""
    );

    public $identifiantRevendeur;
    public $cleAPI;
    public $locale = 'fr-FR';
    public $localeBasePath;
}