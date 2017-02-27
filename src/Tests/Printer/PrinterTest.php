<?php

namespace Caldera\MapPrinter\Tests\Canvas;

use Caldera\MapPrinter\Canvas\Canvas;
use Caldera\MapPrinter\Printer\OsmMapPrinter;
use Caldera\MapPrinter\Tests\Mocks\SimpleMockedTrack;
use Caldera\MapPrinter\TileResolver\OsmTileResolver;

class PrinterTest extends \PHPUnit_Framework_TestCase
{
    public function testCanvas1()
    {
        $printer = new OsmMapPrinter();

        $mockedTrack = new SimpleMockedTrack();

        $printer
            ->addTrack($mockedTrack)
            ->execute();
    }
}
