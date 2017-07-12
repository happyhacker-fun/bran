<?php
/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 12/07/2017
 * Time: 23:09
 */

namespace Tests\Bran;

use Bran\Raven;

class RavenTest extends Raven
{
    protected $clientConfig = [
        'base_uri' => 'http://httpbin.org/',
    ];

    protected $apiConfig = [
        'status' => [
            'pattern' => '/status/{status}',
            'method' => 'get',
        ],
        'headers' => [
            'pattern' => '/headers',
            'method' => 'get',
        ]
    ];

    public function testAssertStatusCode()
    {
        $entity = $this->call('status', [
            'attributes' => [
                'status' => 500,
            ],
        ]);

        $entity->assertStatusCode(500);
    }

    public function testAssertHeaders()
    {
        $entity = $this->call('headers');

        $entity->assertHeader('Content-Type', 'application/json');
    }

}
