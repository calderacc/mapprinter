<?php

namespace Caldera\MapPrinter\Tests\Canvas;

use Caldera\GeoBasic\Coord\Coord;
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

        $actualList = $canvas->convertTrackToCoordArray($mockedTrack);

        $expectedList = [];
        $expectedList[] = new Coord(53.55324, 9.99339);
        $expectedList[] = new Coord(53.55336, 9.9924);
        $expectedList[] = new Coord(53.55391, 9.9915);
        $expectedList[] = new Coord(53.55462, 9.99106);
        $expectedList[] = new Coord(53.55538, 9.99165);
        $expectedList[] = new Coord(53.55618, 9.99228);
        $expectedList[] = new Coord(53.55715, 9.99289);
        $expectedList[] = new Coord(53.55744, 9.9935);
        $expectedList[] = new Coord(53.55739, 9.99486);
        $expectedList[] = new Coord(53.55707, 9.9963);
        $expectedList[] = new Coord(53.55665, 9.99801);
        $expectedList[] = new Coord(53.55622, 9.99932);
        $expectedList[] = new Coord(53.55573, 10.00009);
        $expectedList[] = new Coord(53.55546, 10.00026);
        $expectedList[] = new Coord(53.55513, 9.99987);
        $expectedList[] = new Coord(53.55212, 9.99479);
        $expectedList[] = new Coord(53.55242, 9.99391);
        $expectedList[] = new Coord(53.55302, 9.99337);

        $this->assertEquals($expectedList, $actualList);
    }
}