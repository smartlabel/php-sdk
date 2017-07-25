<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 15/06/2017
 * Time: 14:43
 */

namespace Adesa\SmartLabelClient;


class AdesaFTP
{

    public $config;
    
    private $conn;

    /**
     * AdesaFTP constructor.
     * @param Config $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function retryFailedUploads(){
        //todo
    }
    
    private function getConnection()
    {
        if (!isset($this->conn)) {
            $this->conn = ftp_connect($this->config->FTP->host);
            $login = ftp_login($this->conn, $this->config->FTP->login, $this->config->FTP->password);
            ftp_pasv($this->conn, true);
            if (!$login) {
                throw new \Exception("Impossible de se connecter au FTP Adesa");
            }
        }

        return $this->conn;
    }

    public function upload($data, $destination)
    {

//        echo "Adesa UPLOAD $data ~> $destination \n";
        $pathinfo = pathinfo($destination);
        $parts = explode(DIRECTORY_SEPARATOR, $pathinfo['dirname']);
        $c = $this->getConnection();
        ftp_chdir($c, '/');
        foreach ($parts as $part){
            if (!@ftp_chdir($c, $part)){
                ftp_mkdir($c, $part);
                ftp_chdir($c, $part);
            }
        }

        if (is_resource($data)){
            rewind($data);
            ftp_fput($c, $pathinfo['basename'], $data, FTP_BINARY, 0);
        } else {
            ftp_put($c, $pathinfo['basename'], $data, FTP_BINARY);
        }
    }

    public function close(){
        if (isset($this->conn)){
            ftp_close($this->conn);
        }
    }

}