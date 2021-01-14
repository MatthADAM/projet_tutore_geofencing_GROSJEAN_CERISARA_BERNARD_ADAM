<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Points;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Point;

class NewPointAction extends PointsAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $point = new Point;
        $point->x = $data["x"];
        $point->y = $data["y"];
        $point->save();
        return $this->respondWithData($point);
    }
}

?>