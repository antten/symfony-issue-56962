<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MetadataAwareNameConverterTest extends WebTestCase
{
    public function testMetadataAwareNameConverterFailsToConvertPropertyInErrorResponse(): void
    {
        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: '/users',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: '{"first_name": "supercalifragilisticexpialidocious"}'
        );

        $this->assertResponseStatusCodeSame(422);

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('Validation Failed', $response['title']);
        $this->assertEquals(
            'first_name: This value is too long. It should have 10 characters or less.',
            $response['detail']
        );
        $this->assertEquals('first_name', $response['violations'][0]['propertyPath']);
    }
}
