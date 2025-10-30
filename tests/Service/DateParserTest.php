<?php

namespace App\Tests\Service;

use App\Service\DateParser;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use InvalidArgumentException;

class DateParserTest extends TestCase
{
    private function createParser(): DateParser
    {
        $cache = $this->createMock(CacheItemPoolInterface::class);
        $cacheItem = $this->createMock(CacheItemInterface::class);

        $cacheItem->method('get')->willReturnCallback(function ($callback = null) {
            return $callback ? $callback($this) : null;
        });

        $cacheItem->method('expiresAfter')->willReturnSelf();
        $cache->method('getItem')->willReturn($cacheItem);

        return new DateParser($cache);
    }

    public function testParseValidDate()
    {
        $parser = $this->createParser();
        $result = $parser->parse('1.9.2025');
        $this->assertEquals(2025, $result['year']);
        $this->assertEquals('September', $result['month']);
        $this->assertEquals(1, $result['day']);
        $this->assertEquals(21, $result['century']);
    }

    public function testInvalidFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->createParser()->parse('2025-09-01');
    }

    public function testInvalidDay()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->createParser()->parse('31.02.2025');
    }

    public function testInvalidYear()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->createParser()->parse('01.01.0999');
    }
}
