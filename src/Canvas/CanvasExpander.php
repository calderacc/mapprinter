<?php

namespace Caldera\MapPrinter\Canvas;

use Caldera\GeoBasic\Bounds\Bounds;
use Caldera\GeoBasic\Bounds\BoundsInterface;
use Caldera\GeoBasic\Coord\CoordInterface;

class CanvasExpander
{
    /** @var CanvasInterface $canvas */
    private $canvas;

    /** @var CoordInterface $northWest */
    private $northWest;

    /** @var CoordInterface $southEast */
    private $southEast;

    public function __construct(CanvasInterface $canvas)
    {
        $this->canvas = $canvas;

        $this->northWest = $canvas->getNorthWest();
        $this->southEast = $canvas->getSouthEast();
    }

    public function expand(CoordInterface $coord): CanvasExpander
    {
        if (!$this->northWest) {
            $this->northWest = clone $coord;
        } else {
            if ($this->northWest->southOf($coord)) {
                $this->northWest->setLatitude($coord->getLatitude());
            }

            if ($this->northWest->eastOf($coord)) {
                $this->northWest->setLongitude($coord->getLongitude());
            }
        }

        if (!$this->southEast) {
            $this->southEast = clone $coord;
        } else {
            if ($this->southEast->northOf($coord)) {
                $this->southEast->setLatitude($coord->getLatitude());
            }

            if ($this->southEast->westOf($coord)) {
                $this->southEast->setLongitude($coord->getLongitude());
            }
        }

        return $this;
    }

    public function getBounds()
    {
        if (!$this->northWest || !$this->southEast) {
            return null;
        }

        $bounds = new Bounds($this->northWest, $this->southEast);

        return $bounds;
    }
}