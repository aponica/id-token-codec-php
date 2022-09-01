<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

use PHPUnit\Framework\TestCase;
use function Aponica\IdTokenCodec\fzEncodeIds;

final class fzEncodeIdsTest extends TestCase {

  //---------------------------------------------------------------------------

  public function testMinOneOneDigitIds() : void {

    $zResult = fzEncodeIds( [ 1 ], 'one' );

    $this->assertEquals( '10one1', $zResult );

    } // testMinOneOneDigitIds

  //---------------------------------------------------------------------------

  public function testMaxOneOneDigitIds() : void {

    $zResult = fzEncodeIds( [ 61 ], 'one' );

    $this->assertEquals( '10onez', $zResult );

    } // testMaxOneOneDigitIds

  //---------------------------------------------------------------------------

  public function testMinThreeThreeDigitIds() : void {

    $zResult = fzEncodeIds( [ 3844, 3844, 3844 ], 'three' );

    $this->assertEquals( '3330three100100100', $zResult );

    } // testMinThreeThreeDigitIds

  //---------------------------------------------------------------------------

  public function testMaxThreeThreeDigitIds() : void {

    $zResult = fzEncodeIds( [ 238327, 238327, 238327 ], 'three' );

    $this->assertEquals( '3330threezzzzzzzzz', $zResult );

    } // testMaxThreeThreeDigitIds

  //---------------------------------------------------------------------------

  public function testOneTwoAndThreeDigitIdsWithRandomToken() : void {

    $zResult = fzEncodeIds( [ 20, 200, 200000 ] );

    $this->assertMatchesRegularExpression(
      '/^3210([0-9a-f]{5,})K3Eq1o$/', $zResult );

    } // testOneTwoAndThreeDigitIdsWithRandomToken

} // fzEncodeIdsTest

// EOF
