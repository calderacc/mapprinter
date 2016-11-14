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
}