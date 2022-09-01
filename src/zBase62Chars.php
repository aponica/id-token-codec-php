<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2018-2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

/// The namespace for aponica/id-token-codec-php
///
/// Functions to encode a set of ID(s) and a token into a string and decode
/// them back into the original values. The string is typically used as part
/// of a tracking key.
///
/// An equivalent JS package, @aponica/id-token-codec-js, is available and
/// kept synchronized with this one for interoperability.

namespace Aponica\IdTokenCodec;

/// Used internally to manage the Base-62 encoding.

const zBase62Chars =
  '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

//EOF
