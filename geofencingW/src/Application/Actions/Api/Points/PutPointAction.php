<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Points;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User;

class PutPointAction extends PointsAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $pointId = (int) $this->resolveArg('id');
        $points = $this->points->find($pointId);
        $points->x = $data["x"];
        $points->y = $data["y"];
        $points->save();
        return $this->respondWithData($points);
    }
}

?>