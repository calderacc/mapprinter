<?php

namespace Caldera\MapPrinter\Canvas;

use Caldera\GeoBasic\Coord\Coord;
use Caldera\GeoBasic\Coord\CoordInterface;
use Caldera\MapPrinter\Element\MarkerInterface;
use Caldera\MapPrinter\Element\TrackInterface;
use Caldera\MapPrinter\TileResolver\TileResolverInterface;
use Caldera\MapPrinter\Util\OsmZxyCalculator;
use Caldera\MapPrinter\Util\PolylineConverter;

class Canvas implements CanvasInterface
{
    /** @var Coord $northWest */
    protected $northWest = null;

    /** @var Coord $southEast */
    protected $southEast = null;

    /** @var array $markers */
    protected $markers = [];

    /** @var array $tracks */
    protected $tracks = [];

    protected $grid = [];

    protected $canvasWidth;
    protected $canvasHeight;
    protected $offsetLeft;
    protected $offsetTop;
    
    public function __construct()
    {
    }
    
    public function addMarker(MarkerInterface $marker): Canvas
    {
        array_push($this->markers, $marker);

        return $this;    
    }

    public function addTrack(TrackInterface $track): Canvas
    {
        array_push($this->tracks, $track);

        return $this;
    }

    public function calculateDimensions(): Canvas
    {
        /** @var MarkerInterface $marker */
        foreach ($this->markers as $marker) {
            $coord = new Coord($marker->getLatitude(), $marker->getLongitude());
            $this->expand($coord);
        }
        
        /** @var TrackInterface $track */
        foreach ($this->tracks as $track) {
            $coordList = $this->convertTrackToCoordArray($track);

            /** @var Coord $coord */
            foreach ($coordList as $coord) {
                $this->expand($coord);
            }
        }

        return $this;
    }

    public function getNorthWest()
    {
        return $this->northWest;
    }

    public function getSouthEast()
    {
        return $this->southEast;
    }

    public function convertTrackToCoordArray(TrackInterface $track): array
    {
        $coordList = PolylineConverter::getCoordList($track);

        return $coordList;
    }

    protected function expand(Coord $coord): Canvas
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

    public function decorateTiles(TileResolverInterface $tileResolver): Canvas
    {
        $zoomLevel = 15;

        $topY = OsmZxyCalculator::latitudeToOSMYTile($this->northWest->getLatitude(), $zoomLevel);
        $topX = OsmZxyCalculator::longitudeToOSMXTile($this->northWest->getLongitude(), $zoomLevel);

        $bottomY = OsmZxyCalculator::latitudeToOSMYTile($this->southEast->getLatitude(), $zoomLevel);
        $bottomX = OsmZxyCalculator::longitudeToOSMXTile($this->southEast->getLongitude(), $zoomLevel);

        for ($y = $topY; $y <= $bottomY; ++$y) {
            for ($x = $topX; $x <= $bottomX; ++$x) {
                $this->grid[$y][$x] = $tileResolver->resolveByZxy($x, $y, $zoomLevel);
            }
        }

        $this->canvasWidth = abs($topX - $bottomX);
        $this->canvasHeight = abs($topY - $bottomY);
        $this->offsetLeft = $topX;
        $this->offsetTop = $topY;

        return $this;
    }

    public function printElements(): Canvas
    {
        $height = $this->canvasHeight * 256;
        $width = $this->canvasWidth * 256;

        $image = imagecreate($width, $height);

        $white = imagecolorallocatealpha($image, 255, 255, 0, 100);

        foreach ($this->tracks as $track) {
            $coordList = $this->convertTrackToCoordArray($track);

            $coordA = array_shift($coordList);

            while ($coordB = array_shift($coordList)) {
                imageline($image, 0, 0, 100, 100, $white);

                $coordA = $coordB;
            }

        }
        imagepng($image);
        imagedestroy($image);
        
        return $this;
    }
}