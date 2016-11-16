<?php

namespace Caldera\MapPrinter\Tests\Mocks;

use Caldera\MapPrinter\Element\TrackInterface;

class SimpleMockedTrack implements TrackInterface
{
    /**
     * This mocks a 17 waypoint route around the Binnenalster in Hamburg.
     * 
     * @return string
     */
    public function getPolyline()
    {
        return 'wrzeIuy~{@WdEmBrDmCvAwCuB_D}BaEyBy@yBHoG~@_HrAuItAeG`ByCt@a@`AlAxQv^{@nDwBjB';
    }
}