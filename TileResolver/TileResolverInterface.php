<?php

namespace Caldera\MapPrinter\TileResolver;

use Caldera\MapPrinter\Coord\Coord;
use Caldera\MapPrinter\Tile\TileInterface;

interface TileResolverInterface
{
    public function resolveByCoord(Coord $coord, int $zoomLevel): TileInterface;

    public function resolveByLatitudeLongitude(float $latitude, float $longitude, int $zoomLevel): TileInterface;

    public function resolveByZxy(int $x, int $y, int $zoomLevel): TileInterface;
}