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
     * @var array<mixed>
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
     * @return array<string, array<int, string>>
     */
    public function decodeDataProvider(): array
    {
        $encodeData = [
            'Empty String' => ['', ''],
            'All Invalid Characters' => ['', 'WXYXWXYZWXYZWXYZ'],
            'Random Integers' => [\base64_decode('HgxBl1kJ4souh+ELRIHm/x8yTc/cgjDmiCNyJR/NJfs='), '3O6435QP17HCKBK7S45K90F6VSFJ4JEFRI131PK84DP2A7UD4NTG===='],
        ];

        return \array_merge($encodeData, self::RFC_VECTORS);
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function encodeDataProvider(): array
    {
        $encodeData = [
            'Empty String' => ['', ''],
            'Random Integers' => [\base64_decode('HgxBl1kJ4souh+ELRIHm/x8yTc/cgjDmiCNyJR/NJfs='), '3O6435QP17HCKBK7S45K90F6VSFJ4JEFRI131PK84DP2A7UD4NTG===='],
        ];

        return \array_merge($encodeData, self::RFC_VECTORS);
    }

    /**
     * Back and forth encoding must return the same result.
     *
     * @return array<string, array<string>>
     */
    public function backAndForthDataProvider(): array
    {
        return Base32Test::BASE_CLEAR_STRINGS;
    }

    /**
     * @dataProvider decodeDataProvider
     * @covers ::decode
     */
    public function testDecode(string $clear, string $base32): void
    {
        $this->assertSame($clear, Base32Hex::decode($base32));
    }

    /**
     * @dataProvider encodeDataProvider
     * @covers ::encode
     */
    public function testEncode(string $clear, string $base32): void
    {
        $this->assertSame($base32, Base32Hex::encode($clear));
    }

    /**
     * @dataProvider backAndForthDataProvider
     * @covers ::encode
     * @covers ::decode
     */
    public function testEncodeAndDecode(string $clear): void
    {
        // Encoding then decoding again, to ensure that the back and forth works as intended
        $this->assertSame($clear, Base32Hex::decode(Base32Hex::encode($clear)));
    }
}
