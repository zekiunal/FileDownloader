<?php
namespace Project\File\Downloader\Method;

use Project\File\Downloader\DownloaderAbstract;
use Project\File\Downloader\DownloaderInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\File\Downloader\Method
 * @name        Get
 * @version     0.1
 */
class Get extends DownloaderAbstract implements DownloaderInterface
{

    /**
     * @param $url      string
     * @param $filename string
     * @return string
     */
    public function download($url, $filename)
    {
        $infile = $url;
        $outfile = $filename;
        $chunk_size = 1 * (1024 * 1024); // 1 Megabytes
        /**
         * parse_url breaks a part a URL into it's parts, i.e. host, path,
         * query string, etc.
         */
        $parts = parse_url($infile);
        $i_handle = @fsockopen($parts['host'], 80, $err_str, $err_code, 5);
        $o_handle = @fopen($outfile, 'wb');

        if ($i_handle == false || $o_handle == false) {
            return false;
        }

        if (!empty($parts['query'])) {
            $parts['path'] .= '?' . $parts['query'];
        }

        /**
         * Send the request to the server for the file
         */
        $request = "GET {$parts['path']} HTTP/1.1\r\n";
        $request .= "Host: {$parts['host']}\r\n";
        $request .= "User-Agent: Mozilla/5.0\r\n";
        $request .= "Keep-Alive: 115\r\n";
        $request .= "Connection: keep-alive\r\n\r\n";
        fwrite($i_handle, $request);

        /**
         * Now read the headers from the remote server. We'll need
         * to get the content length.
         */
        $headers = array();
        while (!feof($i_handle)) {
            $line = fgets($i_handle);
            if ($line == "\r\n") {
                break;
            }
            $headers[] = $line;
        }

        /**
         * Look for the Content-Length header, and get the size
         * of the remote file.
         */
        $length = 0;
        foreach ($headers as $header) {
            if (stripos($header, 'Content-Length:') === 0) {
                $length = (int)str_replace('Content-Length: ', '', $header);
                break;
            }
        }

        /**
         * Start reading in the remote file, and writing it to the
         * local file one chunk at a time.
         */
        $cnt = 0;
        while (!feof($i_handle)) {
            $buf = '';
            $buf = fread($i_handle, $chunk_size);
            $bytes = fwrite($o_handle, $buf);
            if ($bytes == false) {
                return false;
            }
            $cnt += $bytes;

            /**
             * We're done reading when we've reached the content length
             */
            if ($cnt >= $length) {
                break;
            }
        }

        fclose($i_handle);
        fclose($o_handle);

        return $outfile;
    }
}
