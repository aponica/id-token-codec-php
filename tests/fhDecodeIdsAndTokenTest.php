<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

use PHPUnit\Framework\TestCase;
use Aponica\IdTokenCodec\cIdTokenCodec;

final class fhDecodeIdsAndTokenTest extends TestCase {

  //---------------------------------------------------------------------------

  public function testMinOneOneDigitIds() : void {

    $zResult = cIdTokenCodec::fhDecodeIdsAndToken( '10one1' );

    $this->assertEquals( 1, count( $zResult[ 'anIds' ] ) );

    $this->assertEquals( 1, $zResult[ 'anIds' ][ 0 ] );

    $this->assertEquals( 'one', $zResult[ 'zToken' ] );

    } // testMinOneOneDigitIds

  //---------------------------------------------------------------------------

  public function testMaxOneOneDigitIds() : void {

    $zResult = cIdTokenCodec::fhDecodeIdsAndToken( '10onez' );

    $this->assertEquals( 1, count( $zResult[ 'anIds' ] ) );

    $this->assertEquals( 61, $zResult[ 'anIds' ][ 0 ] );

    $this->assertEquals( 'one', $zResult[ 'zToken' ] );

    } // testMaxOneOneDigitIds

  //---------------------------------------------------------------------------

  public function testMinThreeThreeDigitIds() : void {

    $zResult = cIdTokenCodec::fhDecodeIdsAndToken( '3330three100100100' );

    $this->assertEquals( 3, count( $zResult[ 'anIds' ] ) );

    for ( $n = 0 ; $n < 3 ; $n++ )
      $this->assertEquals( 3844, $zResult[ 'anIds' ][ $n ] );

    $this->assertEquals( 'three', $zResult[ 'zToken' ] );

    } // testMinThreeThreeDigitIds

  //---------------------------------------------------------------------------

  public function testMaxThreeThreeDigitIds() : void {

    $zResult = cIdTokenCodec::fhDecodeIdsAndToken( '3330threezzzzzzzzz' );

    $this->assertEquals( 3, count( $zResult[ 'anIds' ] ) );

    for ( $n = 0 ; $n < 3 ; $n++ )
      $this->assertEquals( 238327, $zResult[ 'anIds' ][ $n ] );

    $this->assertEquals( 'three', $zResult[ 'zToken' ] );

    } // testMaxThreeThreeDigitIds

  //---------------------------------------------------------------------------

  public function testOneTwoAndThreeDigitIds() : void {

    $zResult = cIdTokenCodec::fhDecodeIdsAndToken( '1109fe129386b5a9c1d5bCY' );

    $this->assertEquals( 2, count( $zResult[ 'anIds' ] ) );

    $this->assertEquals( 12, $zResult[ 'anIds' ][ 0 ] );

    $this->assertEquals( 34, $zResult[ 'anIds' ][ 1 ] );

    $this->assertEquals( '9fe129386b5a9c1d5b', $zResult[ 'zToken' ] );

    } // testOneTwoAndThreeDigitIds

  //---------------------------------------------------------------------------

  public function testInvalidKey() : void {

    $this->expectException( Exception::class );
    $this->expectExceptionMessage( 'invalid key' );

    cIdTokenCodec::fhDecodeIdsAndToken( '321xK3Eq1o' );

    } // testInvalidKey

} // fhDecodeIdsAndTokenTest

// EOF
