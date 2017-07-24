# 基于PHPUnit和Guzzle的Api单元测试工具

## 安装

执行`composer require subtlephp/bran`

## 使用

1. 使用`Bran\Raven`代替`PHPUnit\Framework\TestCase`来创建新的测试类

2. 示例代码如下:

```php
<?php

use Bran\Raven;

class RavenTest extends Raven
{
    protected $clientConfig = [
        'base_uri' => 'http://gank.io',
    ];

    protected $apiConfig = [
        'images' => [
            'pattern' => '/api/data/Android/10/1',
            'method' => 'get',
        ],
    ];

    public function testAssertStatusCode()
    {
        $entity = $this->call('images');

        $entity->assertStatusCode(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonBodyHas('error')
            ->assertJsonBodyAttributeEquals('error', false);
    }

    public function setUp()
    {
        parent::setUp();
        $this->clientConfig['headers']['Cookie'] = $this->login();
    }

    public function login()
    {
        $entity = $this->call('login');
        return $entity->cookie;
    }
}

```