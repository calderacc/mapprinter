<?php

namespace Caldera\MapPrinter\Tests\Canvas;

use Caldera\GeoBasic\Bounds\Bounds;
use Caldera\GeoBasic\Coord\Coord;
use Caldera\MapPrinter\Canvas\Canvas;
use Caldera\MapPrinter\Pixel\Pixel;
use Caldera\MapPrinter\TileResolver\OsmTileResolver;
use Caldera\MapPrinter\Util\CoordPixelConverter;

class CoordPixelConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testCoordPixelConverter1()
    {
        $coord1 = new Coord(53, 9);
        $coord2 = new Coord(54, 10);

        $bounds = new Bounds($coord1, $coord2);

        $canvas = new Canvas();
        $canvas
            ->setZoomLevel(10)
            ->setBounds($bounds)
            ->decorateTiles(new OsmTileResolver());

        $coord3 = new Coord(53, 9);

        $actualPixel = CoordPixelConverter::coordToPixel($canvas, $coord3);
        $exceptedPixel = new Pixel(0, 0);

        $this->assertEquals($exceptedPixel, $actualPixel);

        $coord4 = new Coord(54, 10);

        $actualPixel = CoordPixelConverter::coordToPixel($canvas, $coord4);
        $exceptedPixel = new Pixel(1280, 768);

        $this->assertEquals($exceptedPixel, $actualPixel);

        $coord4 = new Coord(53.5, 9.5);

        $actualPixel = CoordPixelConverter::coordToPixel($canvas, $coord4);
        $exceptedPixel = new Pixel(640, 384);

        $this->assertEquals($exceptedPixel, $actualPixel);
    }
}