<?php

namespace Caldera\MapPrinter\Tests\Canvas;

use Caldera\MapPrinter\Canvas\Canvas;
use Caldera\MapPrinter\Tests\Mocks\SimpleMockedTrack;
use Caldera\MapPrinter\TileResolver\OsmTileResolver;

class CanvasTest extends \PHPUnit_Framework_TestCase
{
    public function testCanvas1()
    {
        echo "TEST CANVAS 1";
        $canvas = new Canvas();
        $mockedTrack = new SimpleMockedTrack();

        $canvas
            ->setZoomLevel(15)
            ->addTrack($mockedTrack)
            ->calculateDimensions()
            ->decorateTiles(new OsmTileResolver())
            ->printElements();

        echo "ENDE GELÄNDE";
    }
}