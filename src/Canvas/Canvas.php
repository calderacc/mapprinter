<?php

namespace Caldera\MapPrinter\Canvas;

use Caldera\GeoBasic\Bounds\BoundsInterface;
use Caldera\GeoBasic\Coord\Coord;
use Caldera\MapPrinter\Element\MarkerInterface;
use Caldera\MapPrinter\Element\TrackInterface;
use Caldera\MapPrinter\TileResolver\TileResolverInterface;
use Caldera\MapPrinter\Util\CoordPixelConverter;
use Caldera\MapPrinter\Util\OsmZxyCalculator;
use Caldera\MapPrinter\Util\PolylineConverter;

class Canvas implements CanvasInterface
{
    /** @var array $markers */
    protected $markers = [];

    /** @var array $tracks */
    protected $tracks = [];

    protected $grid = [];

    /** @var BoundsInterface $bounds */
    protected $bounds = null;

    /** @var int $zoomLevel */
    protected $zoomLevel;

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
        $expander = new CanvasExpander($this);

        /** @var MarkerInterface $marker */
        foreach ($this->markers as $marker) {
            $coord = new Coord($marker->getLatitude(), $marker->getLongitude());
            $expander->expand($coord);
        }
        
        /** @var TrackInterface $track */
        foreach ($this->tracks as $track) {
            $coordList = PolylineConverter::getCoordList($track);

            /** @var Coord $coord */
            foreach ($coordList as $coord) {
                $expander->expand($coord);
            }
        }

        $this->bounds = $expander->getBounds();

        return $this;
    }

    public function setZoomLevel(int $zoomLevel): CanvasInterface
    {
        $this->zoomLevel = $zoomLevel;

        return $this;
    }

    public function getBounds()
    {
        return $this->bounds;
    }

    public function setBounds(BoundsInterface $bounds): CanvasInterface
    {
        $this->bounds = $bounds;

        return $this;
    }

    public function getCanvasWidth()
    {
        return $this->canvasWidth;
    }

    public function getCanvasHeight()
    {
        return $this->canvasHeight;
    }

    public function decorateTiles(TileResolverInterface $tileResolver): Canvas
    {
        $topY = OsmZxyCalculator::latitudeToOSMYTile($this->bounds->getNorthWest()->getLatitude(), $this->zoomLevel);
        $topX = OsmZxyCalculator::longitudeToOSMXTile($this->bounds->getNorthWest()->getLongitude(), $this->zoomLevel);

        $bottomY = OsmZxyCalculator::latitudeToOSMYTile($this->bounds->getSouthEast()->getLatitude(), $this->zoomLevel);
        $bottomX = OsmZxyCalculator::longitudeToOSMXTile($this->bounds->getSouthEast()->getLongitude(), $this->zoomLevel);

        for ($y = $topY; $y <= $bottomY; ++$y) {
            for ($x = $topX; $x <= $bottomX; ++$x) {
                $this->grid[$y][$x] = $tileResolver->resolveByZxy($x, $y, $this->zoomLevel);
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

        $white = imagecolorallocatealpha($image, 255, 255, 255, 0);
        $red = imagecolorallocatealpha($image, 255, 0, 0, 0);

        imagefill($image, 5, 5, $white);

        imageline($image, 5, 5, 10, 10, $red);

        foreach ($this->tracks as $track) {
            $coordList = PolylineConverter::getCoordList($track);

            $coordA = array_shift($coordList);

            while ($coordB = array_shift($coordList)) {
                $pixelA = CoordPixelConverter::coordToPixel($this, $coordA);
                $pixelB = CoordPixelConverter::coordToPixel($this, $coordB);

                imageline($image, $pixelA->getX(), $pixelA->getY(), $pixelB->getX(), $pixelB->getY(), $red);

                $coordA = $coordB;
            }

        }
        imagepng($image);
        imagedestroy($image);
        
        return $this;
    }
}