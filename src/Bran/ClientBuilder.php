<?php
/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 2017/7/12
 * Time: 13:17
 */

namespace Bran;


use Bran\GuzzleMiddleware\Logger;
use Bran\GuzzleMiddleware\UriReplacer;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class ClientBuilder
{
    public static function build($config)
    {
        $options = $config;
        $options['handler'] = self::buildHandlerStack();
        return new Client($options);
    }

    private static function buildHandlerStack()
    {
        $handlerStack = HandlerStack::create();

        $middlewares = [
            new Logger(),
            new UriReplacer(),
        ];

        foreach ($middlewares as $middleware) {
            $handlerStack->push($middleware);
        }

        return $handlerStack;
    }
}