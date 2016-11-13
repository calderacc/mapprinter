<?php

namespace Caldera\MapPrinter\Tests\Mocks;

use Caldera\MapPrinter\Element\TrackInterface;

/**
 * Created by PhpStorm.
 * User: maltehuebner
 * Date: 14.11.16
 * Time: 18:03
 */
class SimpleMockedTrack implements TrackInterface
{
    public function getPolyline()
    {
        return 'wrzeIuy~{@WdEmBrDmCvAwCuB_D}BaEyBy@yBHoG~@_HrAuItAeG`ByCt@a@`AlAxQv^{@nDwBjB';
    }
}