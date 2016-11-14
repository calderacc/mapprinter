<?php

namespace Caldera\MapPrinter\Util;

use Caldera\GeoBasic\Coord\Coord;
use Caldera\MapPrinter\Element\TrackInterface;

class PolylineConverter
{
    public static function getCoordList(TrackInterface $track): array
    {
        $pointList = \Polyline::decode($track->getPolyline());
        $coordList = [];

        while (count($pointList) > 0) {
            $latitude = array_shift($pointList);
            $longitude = array_shift($pointList);

            $coord = new Coord($latitude, $longitude);

            array_push($coordList, $coord);
        }

        return $coordList;
    }
}