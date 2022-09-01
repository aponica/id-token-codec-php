<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2018-2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

namespace Aponica\IdTokenCodec;

//-----------------------------------------------------------------------------
/// Encodes an ID and token.
///
/// The result is assembled as follows, given the example `LTI`:
///
///   * `I` = the base62-encoded ID number.
///   * `L` = the base62-encoded length of substring I
///   * `T` = the token string.
///
/// For example:
///
///   1. ID=2 and token=aaabbb returns 1aaabbb2
///   2. ID=63 (base62=11) and token=abcde returns 2abcde11
///
/// The result can be decoded by fhDecode().
///
/// @param nId
///   The integer ID to be encoded.
///
/// @param zToken
///   The string token to be encoded.
///
/// @return string:
///   The encoded ID and token.
//-----------------------------------------------------------------------------

function fzEncode( int $nId, string $zToken ) : string {

  //  Encodes a base-10 number as base-62.

  $fzBase62 = function( $n ) {

    $zResult = ( ( $n == 0 ) ? '0' : '' );

    while ( $n > 0 ) {

      $nMod = $n % 62;

      $zResult = mb_substr( zBase62Chars, $nMod, 1 ) . $zResult;

      $n = ( $n - $nMod ) / 62;

      } // while

    return $zResult;

    }; // $fzBase62

  $zB62id = $fzBase62( $nId );

  return $fzBase62( mb_strlen( $zB62id ) ) . $zToken . $zB62id;

  } // fzEncode

//EOF
