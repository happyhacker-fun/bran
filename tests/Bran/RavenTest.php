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
            ->assertJsonBodyAttributeEquals(false, 'error');
    }
}
