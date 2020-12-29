<?php

declare(strict_types=1);

namespace Base32\Tests;

use Base32\Base32;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Base32\Base32
 */
class Base32Test extends TestCase
{
    /**
     * Vectors from RFC with cleartext => base32 pairs.
     *
     * @var array<string,string>
     */
    private const RFC_VECTORS = [
        'RFC Vector 1' => ['f', 'MY======'],
        'RFC Vector 2' => ['fo', 'MZXQ===='],
        'RFC Vector 3' => ['foo', 'MZXW6==='],
        'RFC Vector 4' => ['foob', 'MZXW6YQ='],
        'RFC Vector 5' => ['fooba', 'MZXW6YTB'],
        'RFC Vector 6' => ['foobar', 'MZXW6YTBOI======'],
    ];

    /**
     * @return array<string, array>
     */
    public function decodeDataProvider(): array
    {
        $encodeData = [
            'Empty String' => ['', ''],
            'All Invalid Characters' => ['', '8908908908908908'],
        ];

        return \array_merge($encodeData, self::RFC_VECTORS);
    }

    /**
     * @return array<string, array>
     */
    public function encodeDataProvider(): array
    {
        $encodeData = [
            'Empty String' => ['', ''],
        ];

        return \array_merge($encodeData, self::RFC_VECTORS);
    }

    /**
     * @dataProvider decodeDataProvider
     * @covers ::decode
     */
    public function testDecode(string $clear, string $base32): void
    {
        $this->assertEquals($clear, Base32::decode($base32));
    }

    /**
     * @dataProvider encodeDataProvider
     * @covers ::encode
     */
    public function testEncode(string $clear, string $base32): void
    {
        $this->assertEquals($base32, Base32::encode($clear));
    }
}
