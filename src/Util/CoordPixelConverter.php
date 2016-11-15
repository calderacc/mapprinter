<?php

namespace Caldera\MapPrinter\Util;

use Caldera\GeoBasic\Coord\CoordInterface;
use Caldera\MapPrinter\Canvas\CanvasInterface;
use Caldera\MapPrinter\Pixel\Pixel;

class CoordPixelConverter
{
    public static function coordToPixel(CanvasInterface $canvas, CoordInterface $coord): Pixel
    {
        $width = $canvas->getCanvasWidth() * 256;
        $height = $canvas->getCanvasHeight() * 256;

        $northWest = $canvas->getBounds()->getNorthWest();
        $southEast = $canvas->getBounds()->getSouthEast();

        $latitude = $coord->getLatitude();
        $longitude = $coord->getLongitude();

        $x = (float) $height / ($southEast->getLongitude() - $northWest->getLongitude()) * ($longitude - $northWest->getLongitude());
        $y = (float) $width / ($southEast->getLatitude() - $northWest->getLatitude()) * ($latitude - $northWest->getLatitude());

        $pixel = new Pixel($x, $y);

        return $pixel;
    }
}