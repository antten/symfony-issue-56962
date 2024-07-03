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

        $this->assertEquals(
            'first_name: This value is too long. It should have 10 characters or less.
child: This value should not be blank.',
            $response['detail']
        );
        $this->assertEquals('first_name', $response['violations'][0]['propertyPath']);
        $this->assertEquals(
            'This value is too long. It should have 10 characters or less.',
            $response['violations'][0]['title']
        );

        $this->assertEquals('child', $response['violations'][1]['propertyPath']);
        $this->assertEquals('This value should not be blank.', $response['violations'][1]['title']);
    }

    public function testMetadataAwareNameConverterFailsToConvertPropertyInErrorResponseOnNestedObject(): void
    {
        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: '/users',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: <<<JSON
{
      "first_name": "supercalifragilisticexpialidocious",
      "child": {
          "first_name": "aaa"
      }
}
JSON
        );

        $this->assertResponseStatusCodeSame(422);

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(
            'first_name: This value is too long. It should have 10 characters or less.
child.first_name: This value is too short. It should have 5 characters or more.',
            $response['detail']
        );

        $this->assertEquals('first_name', $response['violations'][0]['propertyPath']);
        $this->assertEquals(
            'This value is too long. It should have 10 characters or less.',
            $response['violations'][0]['title']
        );

        $this->assertEquals('child.first_name', $response['violations'][1]['propertyPath']);
        $this->assertEquals(
            'This value is too short. It should have 5 characters or more.',
            $response['violations'][1]['title']
        );
    }
}
