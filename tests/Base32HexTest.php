<?php

declare(strict_types=1);

namespace Base32\Tests;

use Base32\Base32Hex;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Base32\Base32Hex
 */
class Base32HexTest extends TestCase
{
    /**
     * Vectors from RFC with cleartext => base32 pairs.
     *
     * @var array<string,string>
     */
    private const RFC_VECTORS = [
        'RFC Vector 1' => ['f', 'CO======'],
        'RFC Vector 2' => ['fo', 'CPNG===='],
        'RFC Vector 3' => ['foo', 'CPNMU==='],
        'RFC Vector 4' => ['foob', 'CPNMUOG='],
        'RFC Vector 5' => ['fooba', 'CPNMUOJ1'],
        'RFC Vector 6' => ['foobar', 'CPNMUOJ1E8======'],
    ];

    /**
     * @return array<string, array>
     */
    public function decodeDataProvider(): array
    {
        $encodeData = [
            'Empty String' => ['', ''],
            'All Invalid Characters' => ['', 'WXYXWXYZWXYZWXYZ'],
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
        $this->assertEquals($clear, Base32Hex::decode($base32));
    }

    /**
     * @dataProvider encodeDataProvider
     * @covers ::encode
     */
    public function testEncode(string $clear, string $base32): void
    {
        $this->assertEquals($base32, Base32Hex::encode($clear));
    }
}
