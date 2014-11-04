<?php
namespace Project\File\Downloader\Method;

use Project\File\Downloader\DownloaderAbstract;
use Project\File\Downloader\DownloaderInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\File\Downloader\Method
 * @name        CurlAbstract
 * @version     0.1
 */
abstract class CurlAbstract extends DownloaderAbstract implements DownloaderInterface
{
    /**
     * @var resource
     */
    protected $ch;

    /**
     * @var array
     */
    protected $user_agents = array(
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
        "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
        "Opera/9.20 (Windows NT 6.0; U; en)",
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50",
        "Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1) Opera 7.02 [en]",
        "Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; fr; rv:1.7) Gecko/20040624 Firefox/0.9",
        "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/48 (like Gecko) Safari/48"
    );

    /**
     * class constructor
     */
    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
    }

    /**
     * @param $url      string
     * @param $filename string
     * @return string
     */
    public function download($url, $filename)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        if ($this->getInfo() == '200') {
            @unlink($filename);
            @touch($filename);
            file_put_contents($filename, $output);
            curl_close($this->ch);
            return $filename;
        }
        curl_close($this->ch);
        return false;
    }

    /**
     * @return mixed
     */
    protected function getInfo()
    {
        return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }

    /**
     * @return string
     */
    protected function getRandomUserAgent()
    {
        $random = rand(0, count($this->user_agents) - 1);
        return $this->user_agents[$random];
    }
}
