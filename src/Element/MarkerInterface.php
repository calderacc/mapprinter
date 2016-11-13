<?php

namespace Caldera\MapPrinter\Element;

interface MarkerInterface extends MapElement
{
    public function getLatitude();
    public function getLongitude();
}