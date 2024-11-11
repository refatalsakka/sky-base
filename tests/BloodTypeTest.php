<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class BloodTypeTest extends ApiTestCase
{
    public function testGetBloodTypes(): void
    {
        $response = static::createClient()->request('GET', '/api/v1/blood-types');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');

        $responseData = json_decode($response->getContent(), true);

        $this->assertNotEmpty($responseData);
    }
}
