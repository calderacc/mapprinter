<?php

namespace Caldera\MapPrinter\Tests\Canvas;

use Caldera\GeoBasic\Bounds\Bounds;
use Caldera\GeoBasic\Coord\Coord;
use Caldera\MapPrinter\Canvas\Canvas;
use Caldera\MapPrinter\Util\CoordPixelConverter;

class CoordPixelConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testCoordPixelConverter1()
    {
        $canvas = new Canvas();

        $coord1 = new Coord(53, 9);
        $coord2 = new Coord(54, 10);

        $bounds = new Bounds($coord1, $coord2);

        $canvas->setBounds($bounds);

        $coord3 = new Coord(53.5, 9.5);

        $pixel = CoordPixelConverter::coordToPixel($canvas, $coord3);
    }
}