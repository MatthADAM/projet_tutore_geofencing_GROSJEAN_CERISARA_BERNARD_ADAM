<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Points;
use App\Domain\Point;

use Psr\Http\Message\ResponseInterface as Response;

class GetPointZoneAction extends PointsAction
{
    protected function action(): Response
    {
        $zoneId = (int) $this->resolveArg('id');
        // $points = $this->points->whereColumn('id_zone', $zoneId);
        $points = Point::where('id_zone', $zoneId)->get();
        return $this->respondWithData($points);
    }
}

?>