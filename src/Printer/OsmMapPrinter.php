<?php

namespace Caldera\MapPrinter\Printer;

use Caldera\MapPrinter\Canvas\Canvas;
use Caldera\MapPrinter\Element\MarkerInterface;
use Caldera\MapPrinter\Element\TrackInterface;
use Caldera\MapPrinter\TileResolver\OsmTileResolver;

class OsmMapPrinter
{
    /** @var Canvas $canvas */
    protected $canvas = null;

    public function __construct()
    {
        $this->canvas = new Canvas();
    }

    public function addTrack(TrackInterface $track): OsmMapPrinter
    {
        $this->canvas->addTrack($track);

        return $this;
    }

    public function addMarker(MarkerInterface $marker): OsmMapPrinter
    {
        $this->canvas->addMarker($marker);

        return $this;
    }

    public function execute()
    {
        $this->canvas
            ->calculateDimensions()
            ->decorateTiles(new OsmTileResolver())
            ->printElements();
    }
}