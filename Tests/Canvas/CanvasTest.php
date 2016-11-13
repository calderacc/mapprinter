<?php

namespace Caldera\MapPrinter\Tests\Canvas;

use Caldera\MapPrinter\Canvas\Canvas;
use Caldera\MapPrinter\Tests\Mocks\SimpleMockedTrack;

/**
 * Created by PhpStorm.
 * User: maltehuebner
 * Date: 14.11.16
 * Time: 18:06
 */
class CanvasTest extends \PHPUnit_Framework_TestCase
{
    public function testCanvas1()
    {
        $canvas = new Canvas();
        $mockedTrack = new SimpleMockedTrack();

        $list = $canvas->convertTrackToCoordArray($mockedTrack);

        var_dump($list);

        $this->assertEquals(53.5536475, $southWest->getLatitude());
        $this->assertEquals(9.8686486, $southWest->getLongitude());
    }
}