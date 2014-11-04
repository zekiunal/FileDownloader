<?php
namespace Project\File\Downloader\Method;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\File\Downloader\Method
 * @name        CurlAlternative
 * @version     0.1
 */
class CurlAlternative extends CurlAbstract
{

    /**
     * class constructor
     */
    public function __construct()
    {
        parent::__construct();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->getHeader());
    }

    /**
     * @return array
     */
    protected function getHeader()
    {
        $agent  = "User-Agent:Mozilla/5.0 (Windows NT 6.1; ";
        $agent .= "WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36";
        $header[0] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
        $header[] = "Accept-Encoding:gzip,deflate,sdch";
        $header[] = "Accept-Language:tr-TR,tr;q=0.8,en-US;q=0.6,en;q=0.4";
        $header[] = "Cache-Control:max-age=0";
        $header[] = "Connection:keep-alive";
        $header[] = "Host:ic.n11.com";
        $header[] = "If-Modified-Since:Thu, 11 Sep 2014 09:04:25 GMT";
        $header[] = "User-Agent:".$agent;
        return $header;
    }
}
