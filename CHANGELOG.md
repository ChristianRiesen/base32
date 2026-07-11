# Changelog

## 2.0.0 (unreleased)

### Backward-incompatible: strict, RFC 4648-conformant decoding

`Base32::decode()` and `Base32Hex::decode()` now **reject** malformed input
instead of silently sanitizing it. This resolves Trail of Bits finding
TOB-WIKI2FA-5 (Wikimedia Foundation 2FA review).

Previously the decoder uppercased the input and stripped every character that
was not in the alphabet — including padding — which violated RFC 4648 §3.3
("Implementations MUST reject the encoded data if it contains characters
outside the base alphabet") and allowed non-canonical values to decode.

`decode()` now throws `\InvalidArgumentException` when the input:

- has a length that is not a multiple of 8 (padding is required, RFC 4648 §3.2);
- contains any character outside the alphabet (RFC 4648 §3.3);
- contains misplaced or an invalid number of `=` padding characters;
- is **not uppercase** — decoding is now case-sensitive (RFC 4648 uses the
  uppercase alphabet). Lowercase input is no longer accepted.
- contains non-zero trailing bits, i.e. a non-canonical encoding (RFC 4648 §3.5).

An empty string still decodes to an empty string. `encode()` is unchanged; it
was already conformant, so any string produced by `encode()` still round-trips.

**Migration:** if you pass user-supplied Base32 (for example TOTP secrets that
may be lowercase or grouped with spaces), normalize it before decoding:

```php
$secret = strtoupper(preg_replace('/\s+/', '', $userInput));
$bytes  = Base32::decode($secret); // throws on anything still invalid
```

### Removed

- The `BASE32HEX_PATTERN` protected constant (was misnamed — it held the
  standard Base32 pattern, not the extended-hex one) and the `'='` entry in the
  `MAPPING` constant. Both were implementation details of the old lenient
  decoder and are no longer used.
