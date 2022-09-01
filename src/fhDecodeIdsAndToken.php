<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2018-2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

namespace Aponica\IdTokenCodec;

use Exception;

//-----------------------------------------------------------------------------
/// Decode an encoded string into an array of IDs and a token.
///
/// @param zEncoded
///   A string created by `fzEncodeIds()`.
///
/// @return array:
///   A hash (associative array) with two members:
///
///     * [anIds]: array of the integer IDs encoded into `zEncoded`.
///     * [zToken]: The string token encoded into `zEncoded`.
///
/// @throws Exception
///   If `zEncoded` is not a properly-encoded string.
///
///  @see fzEncodeIds() for details about the encoded string.
//-----------------------------------------------------------------------------

function fhDecodeIdsAndToken( string $zEncoded ) : array {

  $anIds = [];

  while ( '0' !== mb_substr( $zEncoded, 0, 1 ) ) {

    if ( 3.5 > mb_strlen( $zEncoded ) )
      throw new Exception( 'invalid key' );

    $hDecoded = fhDecode( $zEncoded );

    array_unshift( $anIds, $hDecoded[ 'nId' ] );

    $zEncoded = $hDecoded[ 'zToken' ];

    } // while

  return [ 'anIds' => $anIds, 'zToken' => mb_substr( $zEncoded, 1 ) ];

  } // fhDecodeIdsAndToken

//EOF
