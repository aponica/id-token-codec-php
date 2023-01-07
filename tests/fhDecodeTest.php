<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

use PHPUnit\Framework\TestCase;
use Aponica\IdTokenCodec\cIdTokenCodec;

final class fhDecodeTest extends TestCase {

  //---------------------------------------------------------------------------

  public function testMinOneDigitId() : void {

    $zResult = cIdTokenCodec::fhDecode( '1one1' );

    $this->assertEquals( 1, $zResult[ 'nId' ] );

    $this->assertEquals( 'one', $zResult[ 'zToken' ] );

    } // testMinOneDigitId

  //---------------------------------------------------------------------------

  public function testMaxOneDigitId() : void {

    $zResult = cIdTokenCodec::fhDecode( '1onez' );

    $this->assertEquals( 61, $zResult[ 'nId' ] );

    $this->assertEquals( 'one', $zResult[ 'zToken' ] );

    } // testMaxOneDigitId

  //---------------------------------------------------------------------------

  public function testMinThreeDigitId() : void {

    $zResult = cIdTokenCodec::fhDecode( '3three100' );

    $this->assertEquals( 3844, $zResult[ 'nId' ] );

    $this->assertEquals( 'three', $zResult[ 'zToken' ] );

    } // testMinThreeDigitId

  //---------------------------------------------------------------------------

  public function testMaxThreeDigitId() : void {

    $zResult = cIdTokenCodec::fhDecode( '3threezzz' );

    $this->assertEquals( 238327, $zResult[ 'nId' ] );

    $this->assertEquals( 'three', $zResult[ 'zToken' ] );

    } // testMaxThreeDigitId

} // fhDecodeTest

// EOF
