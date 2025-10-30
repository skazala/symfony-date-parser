<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testParseEndpoint(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/parse', [
            'date' => '01.11.2025'
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame('01.11.2025', $data['date']);
        $this->assertSame(21, $data['century']);
        $this->assertSame(2025, $data['year']);
        $this->assertSame(1, $data['day']);
    }

    public function testParsedList(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/parse', [
            'date' => '03.11.2025'
        ]);

        $client->request('GET', '/api/parsed');

        $this->assertResponseIsSuccessful();

        $json = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('parsed', $json);
        $this->assertIsArray($json['parsed']);

        $first = $json['parsed'][0];

        $this->assertArrayHasKey('date', $first);
        $this->assertArrayHasKey('century', $first);
        $this->assertArrayHasKey('year', $first);
        $this->assertArrayHasKey('month', $first);
        $this->assertArrayHasKey('day', $first);
        $this->assertArrayHasKey('dayOfWeek', $first);
        $this->assertArrayHasKey('count', $first);
    }
}
