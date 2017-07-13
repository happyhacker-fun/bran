<?php
/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 2017/7/12
 * Time: 19:42
 */

namespace Bran;


use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;

/**
 * @package Bran
 */
class ResponseEntity
{
    protected $actualStatusCode;
    protected $actualHeaders;
    protected $actualData;
    protected $actualErrorCode;

    public $parsedBody;

    public function __construct(Response $response)
    {
        $this->actualStatusCode = $response->getStatusCode();
        $this->actualHeaders = $response->getHeaders();

        $this->parsedBody = json_decode($response->getBody(), true);
    }

    public function assertEquals($expected, $actual)
    {
        Assert::assertEquals($expected, $actual);
        return $this;
    }

    public function assertStatusCode($expected)
    {
        Assert::assertEquals((int)$expected, (int)$this->actualStatusCode);
        return $this;
    }

    public function assertHeaders(array $expected = [])
    {
        Assert::assertEquals($expected, $this->actualHeaders);
        return $this;
    }

    public function assertHeader($key, $value)
    {
        Assert::assertEquals($value, $this->actualHeaders[$key][0]);
        return $this;
    }

    public function assertJsonBodyHas($attribute)
    {
        Assert::assertArrayHasKey($attribute, $this->parsedBody);
        return $this;
    }

    public function assertJsonBodyAttributeEquals($attribute, $value)
    {
        Assert::assertEquals($value, $this->parsedBody[$attribute]);
        return $this;
    }

    public function assertJsonBodyAttributeGreaterThan($attribute, $value)
    {
        Assert::assertGreaterThan($value, $this->parsedBody[$attribute]);
        return $this;
    }

    public function assertJsonBodyAttributeGreaterThanOrEqual($attribute, $value)
    {
        Assert::assertGreaterThanOrEqual($value, $this->parsedBody[$attribute]);
        return $this;
    }

    public function assertJsonBodyAttributeLessThan($attribute, $value)
    {
        Assert::assertLessThan($value, $this->parsedBody[$attribute]);
        return $this;
    }

    public function assertJsonBodyAttributeLessThanOrEqual($attribute, $value)
    {
        Assert::assertLessThanOrEqual($value, $this->parsedBody[$attribute]);
        return $this;
    }
}