<?php
namespace Project\File\Downloader;

use Project\File\Downloader\Exception\UnknownMethod;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\File\Downloader
 * @name        Downloader
 * @version     0.1
 */
class Downloader
{
    const DOWNLOAD_TYPE_CURL = 'Project\File\Downloader\Method\Curl';

    const DOWNLOAD_TYPE_EXEC = 'Project\File\Downloader\Method\Exec';

    const DOWNLOAD_TYPE_GET = 'Project\File\Downloader\Method\Get';

    const DOWNLOAD_TYPE_CURL_ALTERNATIVE = 'Project\File\Downloader\Method\CurlAlternative';

    /**
     * @var DownloaderInterface
     */
    private $downloader;

    /**
     * @var array
     */
    private $methods = array(
        'Project\File\Downloader\Method\Curl',
        'Project\File\Downloader\Method\Exec',
        'Project\File\Downloader\Method\Get',
        'Project\File\Downloader\Method\CurlAlternative'
    );

    /**
     * @param string $method
     * @throws UnknownMethod
     */
    public function __construct($method = Downloader::DOWNLOAD_TYPE_CURL)
    {
        if (!in_array($method, $this->methods)) {
            throw new UnknownMethod($method. 'is unknown.');
        }

        $this->downloader = new $method();
    }

    /**
     * @param $url      string
     * @param $filename string
     * @return string
     */
    public function download($url, $filename)
    {
        return $this->downloader->download($url, $filename);
    }
}
