<?php
use Adesa\SmartLabelClient\SmartLabel;

/**
 * Created by PhpStorm.
 * User: romain
 * Date: 15/06/2017
 * Time: 17:10
 */
class SmartLabelTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var SmartLabel
     */
    private $SL;

    protected function setUp()
    {
        $config = \Adesa\SmartLabelClient\Config::fromIniFile(__DIR__ . '/../config.ini');
        $this->SL = new SmartLabel($config);
    }


    public function testListeMatieres()
    {
        $matieres = $this->SL->listeMatieres();
        $this->assertNotEmpty($matieres, "matieres empty");
        foreach ($matieres as $matiere){
            $this->assertInstanceOf('Adesa\SmartLabelClient\Matiere', $matiere, "instance of Matiere class");
        }
    }
}
