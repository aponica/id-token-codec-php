<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

use PHPUnit\Framework\TestCase;
use Aponica\IdTokenCodec\cIdTokenCodec;

final class fanDecodeIdsTest extends TestCase {

  //---------------------------------------------------------------------------

  public function testOneTwoAndThreeDigitIds() : void {

    $anIds = cIdTokenCodec::fanDecodeIds( '3210a1b2K3Eq1o' );

    $this->assertEquals( 3, count( $anIds ) );

    $this->assertEquals( 20, $anIds[ 0 ] );

    $this->assertEquals( 200, $anIds[ 1 ] );

    $this->assertEquals( 200000, $anIds[ 2 ] );

    } // testOneTwoAndThreeDigitIds

} // fanDecodeIdsTest

// EOF
