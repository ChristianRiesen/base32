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
     * Strings to test back and forth encoding/decoding to make sure results are the same.
     *
     * @var array<string,string>
     */
    public const BASE_CLEAR_STRINGS = [
        'Empty String' => [''],
        'Ten' => ['10'],
        'Test130' => ['test130'],
        'test' => ['test'],
        'Eight' => ['8'],
        'Zero' => ['0'],
        'Equals' => ['='],
        'Foobar' => ['foobar'],
    ];

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
            'Random Integers' => [\base64_decode('HgxBl1kJ4souh+ELRIHm/x8yTc/cgjDmiCNyJR/NJfs='), 'DYGEDF2ZBHRMULUH4EFUJAPG74PTETOP3SBDBZUIENZCKH6NEX5Q===='],
            'Partial zero edge case' => ['8', 'HA======'],
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
            'Random Integers' => [\base64_decode('HgxBl1kJ4souh+ELRIHm/x8yTc/cgjDmiCNyJR/NJfs='), 'DYGEDF2ZBHRMULUH4EFUJAPG74PTETOP3SBDBZUIENZCKH6NEX5Q===='],
            'Partial zero edge case' => ['8', 'HA======'],
        ];

        return \array_merge($encodeData, self::RFC_VECTORS);
    }

    /**
     * Back and forth encoding must return the same result.
     *
     * @return array<string, array>
     */
    public function backAndForthDataProvider(): array
    {
        return self::BASE_CLEAR_STRINGS;
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

    /**
     * @dataProvider backAndForthDataProvider
     * @covers ::encode
     * @covers ::decode
     */
    public function testEncodeAndDecode(string $clear): void
    {
        // Encoding then decoding again, to ensure that the back and forth works as intended
        $this->assertEquals($clear, Base32::decode(Base32::encode($clear)));
    }
}
