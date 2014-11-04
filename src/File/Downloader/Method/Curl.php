<?php
namespace Project\File\Downloader\Method;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\File\Downloader\Method
 * @name        Curl
 * @version     0.1
 */
class Curl extends CurlAbstract
{
    /**
     * class constructor
     */
    public function __construct()
    {
        parent::__construct();
        curl_setopt($this->ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache"));
    }
}
