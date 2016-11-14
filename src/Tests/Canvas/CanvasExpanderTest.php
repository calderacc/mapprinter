<?php

namespace Caldera\MapPrinter\Tests\Canvas;

use Caldera\GeoBasic\Coord\Coord;
use Caldera\MapPrinter\Canvas\Canvas;
use Caldera\MapPrinter\Canvas\CanvasExpander;
use Caldera\MapPrinter\Tests\Mocks\SimpleMockedTrack;

class CanvasExpanderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanvasExpander1()
    {
        $canvas = new Canvas();

        $expander = new CanvasExpander($canvas);

        $bounds = $expander->getBounds();

        $this->assertNull($bounds);
    }

    public function testCanvasExpander2()
    {
        $canvas = new Canvas();

        $expander = new CanvasExpander($canvas);

        $coord = new Coord(53, 9);

        $expander->expand($coord);

        $bounds = $expander->getBounds();

        $northWest = $bounds->getNorthWest();
        $southEast = $bounds->getSouthEast();

        $this->assertEquals($coord, $northWest);
        $this->assertEquals($coord, $southEast);
    }

    public function testCanvasExpander3()
    {
        $canvas = new Canvas();

        $expander = new CanvasExpander($canvas);

        $coord1 = new Coord(53, 9);
        $coord2 = new Coord(52, 10);

        $expander
            ->expand($coord1)
            ->expand($coord2);

        $bounds = $expander->getBounds();

        $northWest = $bounds->getNorthWest();
        $southEast = $bounds->getSouthEast();

        $this->assertEquals($coord1, $northWest);
        $this->assertEquals($coord2, $southEast);
    }

    public function testCanvasExpander4()
    {
        $canvas = new Canvas();

        $expander = new CanvasExpander($canvas);

        $coord1 = new Coord(53, 9);
        $coord2 = new Coord(52, 10);
        $coord3 = new Coord(51, 11);
        $coord4 = new Coord(50, 8);

        $expander
            ->expand($coord1)
            ->expand($coord2)
            ->expand($coord3)
            ->expand($coord4);

        $bounds = $expander->getBounds();

        $actualNorthWest = $bounds->getNorthWest();
        $actualSouthEast = $bounds->getSouthEast();

        $expectedNorthWest = new Coord(53, 8);
        $expectedSouthEast = new Coord(50, 11);

        $this->assertEquals($expectedNorthWest, $actualNorthWest);
        $this->assertEquals($expectedSouthEast, $actualSouthEast);
    }
}