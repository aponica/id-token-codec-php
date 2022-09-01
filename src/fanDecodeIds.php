<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2018-2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

namespace Aponica\IdTokenCodec;

//-----------------------------------------------------------------------------
/// Decodes an encoded string into an array of IDs.
///
/// @param zEncoded
///   A string created by `fzEncodeIds()`.
///
/// @return array:
///   An array of IDs in the order they were encoded.
///
/// @throws Exception
///   If `zEncoded` is not a properly-encoded string.
///
/// @see fzEncodeIds() for details about the encoded string.
//-----------------------------------------------------------------------------

function fanDecodeIds( string $zEncoded ) : array {

  return fhDecodeIdsAndToken( $zEncoded )[ 'anIds' ];

  } // fanDecodeIds

//EOF
