<?php declare(strict_types=1);
//=============================================================================
// Copyright 2018-2023 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

namespace Aponica\IdTokenCodec;

use Exception;


//-----------------------------------------------------------------------------
/// Provides functions to encode a set of ID(s) and a token into a string
/// and decode them back into the original values. The string is typically
/// used as part of a tracking key.
///
/// An equivalent JS package, @aponica/id-token-codec-js, is available and
/// kept synchronized with this one for interoperability.
//-----------------------------------------------------------------------------

class cIdTokenCodec {

  /// Used internally to manage the Base-62 encoding.

  private const zBase62Chars =
    '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';


  //---------------------------------------------------------------------------
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
  //---------------------------------------------------------------------------

  public static function fhDecode( string $zEncoded ) : array {

    //  Decodes a base-62 number into base 10.

    $fnFromBase62 = function( string $zBase62 ) : int {

      $nResult = 0;

      for ( $nIndex = 0 ; $nIndex < mb_strlen( $zBase62 ) ; $nIndex++ )
        $nResult = ( $nResult * 62 ) +
          strpos( self::zBase62Chars, mb_substr( $zBase62, $nIndex, 1 ) );

      return intval( $nResult );

      }; // $fnFromBase62

    $nStringLength = mb_strlen( $zEncoded );

    $nLength = $fnFromBase62( mb_substr( $zEncoded, 0, 1 ) );

    return [
      'nId' => $fnFromBase62( mb_substr( $zEncoded, $nStringLength - $nLength ) ),
      'zToken' => mb_substr( $zEncoded, 1, ( $nStringLength - 1 ) - $nLength )
      ];

    } // fhDecode

  //---------------------------------------------------------------------------
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
  //---------------------------------------------------------------------------

  public static function fanDecodeIds( string $zEncoded ) : array {

    return self::fhDecodeIdsAndToken( $zEncoded )[ 'anIds' ];

    } // fanDecodeIds


  //---------------------------------------------------------------------------
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
  //---------------------------------------------------------------------------

  public static function fhDecodeIdsAndToken( string $zEncoded ) : array {

    $anIds = [];

    while ( '0' !== mb_substr( $zEncoded, 0, 1 ) ) {

      if ( 3.5 > mb_strlen( $zEncoded ) )
        throw new Exception( 'invalid key' );

      $hDecoded = self::fhDecode( $zEncoded );

      array_unshift( $anIds, $hDecoded[ 'nId' ] );

      $zEncoded = $hDecoded[ 'zToken' ];

      } // while

    return [ 'anIds' => $anIds, 'zToken' => mb_substr( $zEncoded, 1 ) ];

    } // fhDecodeIdsAndToken


  //---------------------------------------------------------------------------
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
  //---------------------------------------------------------------------------

  public static function fzEncode( int $nId, string $zToken ) : string {

    //  Encodes a base-10 number as base-62.

    $fzBase62 = function( $n ) {

      $zResult = ( ( $n == 0 ) ? '0' : '' );

      while ( $n > 0 ) {

        $nMod = $n % 62;

        $zResult = mb_substr( self::zBase62Chars, $nMod, 1 ) . $zResult;

        $n = ( $n - $nMod ) / 62;

        } // while

      return $zResult;

      }; // $fzBase62

    $zB62id = $fzBase62( $nId );

    return $fzBase62( mb_strlen( $zB62id ) ) . $zToken . $zB62id;

    } // fzEncode

  //---------------------------------------------------------------------------
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
  //---------------------------------------------------------------------------

  public static function fzEncodeIds( array $anIds, string $zToken = null ) : string {

    return array_reduce(
      $anIds,
      function( $zAcc, $nCur ) { return self::fzEncode( $nCur, $zAcc ); },
      ( '0' . ( ( null !== $zToken ) ? $zToken :
        bin2hex( random_bytes( rand(5, 10 ) ) ) ) )
      ); // array_reduce()

    } // fzEncodeIds()


  } // cIdTokenCodec

// EOF
