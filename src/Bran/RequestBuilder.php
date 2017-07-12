<?php
/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 2017/7/12
 * Time: 13:33
 */

namespace Bran;


use GuzzleHttp\Psr7\Request;

class RequestBuilder
{
    public static function build($config, $headers)
    {
        $method = $config['method'];
        $pattern = $config['pattern'];
        return new Request($method, $pattern, $headers);
    }
}