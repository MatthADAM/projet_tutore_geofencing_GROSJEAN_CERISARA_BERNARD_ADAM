<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Points;

use Psr\Http\Message\ResponseInterface as Response;

class ListPointAction extends PointsAction
{
    protected function action(): Response
    {
        $allPoints = $this->points->all();
        return $this->respondWithData($allPoints);
    }
}

?>