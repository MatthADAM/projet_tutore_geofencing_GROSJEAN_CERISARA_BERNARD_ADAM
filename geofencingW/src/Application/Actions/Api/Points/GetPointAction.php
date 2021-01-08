<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Points;

use Psr\Http\Message\ResponseInterface as Response;

class GetPointAction extends PointsAction
{
    protected function action(): Response
    {
        $pointId = (int) $this->resolveArg('id');
        $points = $this->points->find($pointId);
        return $this->respondWithData($points);
    }
}

?>