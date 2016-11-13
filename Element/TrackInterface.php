<?php

namespace Caldera\MapPrinter\Element;

interface TrackInterface extends MapElement
{
    public function getPolyline();
}