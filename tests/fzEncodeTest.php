<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

use PHPUnit\Framework\TestCase;
use function Aponica\IdTokenCodec\fzEncode;

final class fzEncodeTest extends TestCase {

  //---------------------------------------------------------------------------

  public function testMinOneDigitId() : void {

    $zResult = fzEncode( 0, 'one' );

    $this->assertEquals( '1one0', $zResult );

    } // testMinOneDigitId

  //---------------------------------------------------------------------------

  public function testMaxOneDigitId() : void {

    $zResult = fzEncode( 61, 'one' );

    $this->assertEquals( '1onez', $zResult );

    } // testMaxOneDigitId

  //---------------------------------------------------------------------------

  public function testMinThreeDigitId() : void {

    $zResult = fzEncode( 3844, 'three' );

    $this->assertEquals( '3three100', $zResult );

    } // testMinThreeDigitId

  //---------------------------------------------------------------------------

  public function testMaxThreeDigitId() : void {

    $zResult = fzEncode( 238327, 'three' );

    $this->assertEquals( '3threezzz', $zResult );

    } // testMaxThreeDigitId

} // fzEncodeTest

// EOF
