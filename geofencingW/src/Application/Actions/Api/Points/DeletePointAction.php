<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Points;

use Psr\Http\Message\ResponseInterface as Response;

class DeletePointAction extends PointsAction
{
    protected function action(): Response
    {
        $pointId = (int) $this->resolveArg('id');
        $points = $this->points->destroy($pointId);
        return $this->respondWithData($points);
    }
}

?>