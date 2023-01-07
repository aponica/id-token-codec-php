<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2018-2023 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

namespace Aponica\IdTokenCodec;

//-----------------------------------------------------------------------------
/// Decodes an encoded string into a token and ID.
///
/// @param zEncoded
///   A string created by `fzEncode()`.
///
/// @return array:
///   A hash (associative array) with two members:
///
///     * [nId]: The integer ID encoded into `zEncoded`.
///     * [zToken]: The string token encoded into `zEncoded`.
///
///  @see fzEncode() for details about the encoded string.
//-----------------------------------------------------------------------------

function fhDecode( string $zEncoded ) : array {

  //  Decodes a base-62 number into base 10.

  $fnFromBase62 = function( string $zBase62 ) : int {

    $nResult = 0;

    for ( $nIndex = 0 ; $nIndex < mb_strlen( $zBase62 ) ; $nIndex++ )
      $nResult = ( $nResult * 62 ) +
        strpos( zBase62Chars, mb_substr( $zBase62, $nIndex, 1 ) );

    return intval( $nResult );

    }; // $fnFromBase62

  $nStringLength = mb_strlen( $zEncoded );

  $nLength = $fnFromBase62( mb_substr( $zEncoded, 0, 1 ) );

  return [
    'nId' => $fnFromBase62( mb_substr( $zEncoded, $nStringLength - $nLength ) ),
    'zToken' => mb_substr( $zEncoded, 1, ( $nStringLength - 1 ) - $nLength )
    ];

  } // fhDecode

//EOF
