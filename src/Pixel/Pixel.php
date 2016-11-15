<?php

namespace Caldera\MapPrinter\Pixel;

class Pixel implements PixelInterface
{
    /** @var int $x */
    private $x;

    /** @var int $y */
    private $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }
}