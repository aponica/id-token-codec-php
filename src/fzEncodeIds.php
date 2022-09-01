<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2018-2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

namespace Aponica\IdTokenCodec;

//-----------------------------------------------------------------------------
/// Encodes an array of IDs plus an optional token.
///
/// If a token is null or not specified, a rather-long hexadecimal value
/// is randomly generated.
///
/// The token, preceded by a zero, is passed to fzEncode() along with the
/// first ID in the given array. The result is used as the token for the
/// next ID, and so on.
///
/// The result can be decoded by fanDecodeIds() or fhDecodeIdsAndToken().
///
/// @param anIds
///   The integer IDs to be encoded.
///
/// @param zToken
///   The optional string token to be encoded. If null (the default), then
///   a random token is generated.
///
/// @return string:
///   The encoded IDs and token.
//-----------------------------------------------------------------------------

function fzEncodeIds( array $anIds, string $zToken = null ) : string {

  return array_reduce(
    $anIds,
    function( $zAcc, $nCur ) { return fzEncode( $nCur, $zAcc ); },
    ( '0' . ( ( null !== $zToken ) ? $zToken :
      bin2hex( random_bytes( rand(5, 10 ) ) ) ) )
    ); // array_reduce()

  } // fzEncodeIds()

//EOF
