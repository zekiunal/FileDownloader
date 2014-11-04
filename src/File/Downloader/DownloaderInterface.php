<?php
namespace Project\File\Downloader;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\File\Downloader
 * @name        DownloaderAbstract
 * @version     0.1
 */
interface DownloaderInterface
{
    /**
     * @param $url      string
     * @param $filename string
     * @return string
     */
    public function download($url, $filename);
}
