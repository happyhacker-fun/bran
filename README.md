# 基于PHPUnit和Guzzle的Api单元测试工具

## 安装

1. 在`composer.json`中添加`respositories`段, 如下:

```json
  "repositories": [
    {
      "type": "vcs",
      "url": "git@newgit.op.ksyun.com:ksyun-online/apitest.git"
    }
  ]
```

> 如果你使用pocteam/poc-framework, 则该包已经包含在0.0.23版本中.

2. 执行`composer require pocteam/bran`

## 使用

1. 使用`Bran\Raven`代替`PHPUnit\Framework\TestCase`来创建新的测试类

2. 示例代码如下:

```php
<?php
namespace Tests\Api;


use Bran\Raven;

class CommonApi extends Raven
{
    protected $clientConfig = [
        'base_uri' => 'http://10.111.17.83',
        'headers' => [
            'Host' => 'profile-v2.inner.sdns.ksyun.com',
        ],
    ];

    protected $apiConfig = [
        'cityList' => [
            'pattern' => '/common/cities',
            'method' => 'get',
            'headers' => [
            ]
        ]
    ];

    public function testCityList()
    {
        $this->call('cityList');

        $this->assertErrorCode(10000);
        $this->assertStatusCode(200);
        $this->assertData(['xxx' => 'xxxx']);
        $this->assertHeader(['Content-Type' => 'application/json']);
        $this->assertHeaders(
            [
                'Content-Type' => 'application/json',
                'Connection' => 'keep-alive',
            ]
        );

        $this->assertEquals('kdkkk', $this->parsedBody['data']['foo'])
    }
}
```