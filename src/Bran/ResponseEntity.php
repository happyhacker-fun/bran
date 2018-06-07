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
    public $cookie;

    public function __construct(Response $response)
    {
        $this->actualStatusCode = $response->getStatusCode();
        $this->actualHeaders = $response->getHeaders();
        $this->cookie = $response->getHeaderLine('Set-Cookie');

        $this->parsedBody = json_decode($response->getBody(), true);
    }

    public function assertEquals($expected, $actual)
    {
        Assert::assertEquals($expected, $actual);
        return $this;
    }

    public function assertGreaterThan($expected, $actual)
    {
        Assert::assertGreaterThan($expected, $actual);
        return $this;
    }

    public function assertGreaterThanOrEqual($expected, $actual)
    {
        Assert::assertGreaterThanOrEqual($expected, $actual);
        return $this;
    }

    public function assertLessThan($expected, $actual)
    {
        Assert::assertLessThan($expected, $actual);
        return $this;
    }

    public function assertLessThanOrEqual($expected, $actual)
    {
        Assert::assertLessThanOrEqual($expected, $actual);
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

    public function assertJsonBodyAttributeEquals($value, $dottedAttribute)
    {
        Assert::assertEquals($value,$this->parseDotSeparatedAttributes($dottedAttribute));
        return $this;
    }

    public function assertJsonBodyAttributeGreaterThan($value, $dottedAttribute)
    {
        Assert::assertGreaterThan($value, $this->parseDotSeparatedAttributes($dottedAttribute));
        return $this;
    }

    public function assertJsonBodyAttributeGreaterThanOrEqual($value, $dottedAttribute)
    {
        Assert::assertGreaterThanOrEqual($value, $this->parseDotSeparatedAttributes($dottedAttribute));
        return $this;
    }

    public function assertJsonBodyAttributeLessThan($value, $dottedAttribute)
    {
        Assert::assertLessThan($value, $this->parseDotSeparatedAttributes($dottedAttribute));
        return $this;
    }

    public function assertJsonBodyAttributeLessThanOrEqual($value, $dottedAttribute)
    {
        Assert::assertLessThanOrEqual($value, $this->parseDotSeparatedAttributes($dottedAttribute));
        return $this;
    }
    
    public function getAttributesByDot($dotted)
    {
        return $this->parseDotSeparatedAttributes($dotted);
    }

    private function parseDotSeparatedAttributes($dotted)
    {
        $attributes = explode('.', $dotted);

        $data = $this->parsedBody;
        foreach ($attributes as $attribute) {
            $data = $data[$attribute];
        }

        return $data;
    }
}
