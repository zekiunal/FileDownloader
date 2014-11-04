<?php
namespace Project\File\Downloader\Method;

use Project\File\Downloader\DownloaderAbstract;
use Project\File\Downloader\DownloaderInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\File\Downloader\Method
 * @name        Exec
 * @version     0.1
 */
class Exec extends DownloaderAbstract implements DownloaderInterface
{
    /**
     * @param $url      string
     * @param $filename string
     * @return string
     */
    public function download($url, $filename)
    {
        $command = "curl -k --silent " . $url . " >  " . $filename;
        exec($command);
        return $filename;
    }
}
