# aponica/id-token-codec-php

Encode/decode IDs and a token to/from a string.

Functions to encode a set of ID(s) and a token into a string and decode
them back into the original values. The string is typically used as part
of a tracking key.

An equivalent JS package, `@aponica/id-token-codec-js`, is available and
kept synchronized with this one, so an encoded string created by one 
package can be decoded by the other.

<a name="installation"></a>
## Installation

```sh
composer install aponica/id-token-codec-php
```

<a name="usage"></a>
## Usage

### Example 1: Encode/decode a single ID w/ token

```php
use Aponica\IdTokenCodec\cIdTokenCodec;

$zKey = cIdTokenCodec::fzEncode( 12345, 'Hello' ); 
// '3Hello3D7'

$hResult = cIdTokenCodec::fhDecode( $zKey ); 
// [ 'nId' => 12345, 'zToken' => 'Hello' ]
```

### Example 2: Encode/decode multiple IDs w/ token

```php
use Aponica\IdTokenCodec\cIdTokenCodec;

$zKey = cIdTokenCodec::fzEncodeIds( [ 12, 34, 56 ], 'FOO' ); 
// '1110FOOCYu'

$hResult = cIdTokenCodec::fhDecodeIdsAndToken( $zKey );
// [ 'anIds' => [ 12, 34, 56 ], 'zToken' => 'FOO' ]
```

### Example 3: Ignore random token

```php
use Aponica\IdTokenCodec\cIdTokenCodec;

$zKey = cIdTokenCodec::fzEncodeIds( [ 12, 34 ] ); 
// something like '1109fe129386b5a9c1d5bCY'

$anResult = cIdTokenCodec::fanDecodeIds( $zKey );
// [ 12, 34 ]
```

## Please Donate!

Help keep a roof over our heads and food on our plates! 
If you find aponica® open source software useful, please 
**[click here](https://www.paypal.com/biz/fund?id=BEHTAS8WARM68)** 
to make a one-time or recurring donation via *PayPal*, credit 
or debit card. Thank you kindly!


## Contributing

Please [contact us](https://aponica.com/contact/) if you believe this package
is missing important functionality that you'd like to provide.

Under the covers, the code is **heavily commented** and uses a form of
[Hungarian notation](https://en.wikipedia.org/wiki/Hungarian_notation) 
for data type guidance. If you submit a pull request, please try to maintain
the (admittedly unusual) coding style, which is the product of many decades
of programming experience.

## Copyright

Copyright 2018-2023 Opplaud LLC and other contributors.

## License

MIT License.

## Trademarks

OPPLAUD and aponica are registered trademarks of Opplaud LLC.

## Related Links

Official links for this project:

* [Home Page & Online Documentation](https://aponica.com/docs/id-token-codec-php/)
* [GitHub Repository](https://github.com/aponica/id-token-codec-php)
* [Packagist](https://packagist.org/packages/aponica/id-token-codec-php)
  
Related projects:

* [JS Version (@aponica/id-token-codec-js)](https://aponica.com/docs/id-token-codec-js/)
