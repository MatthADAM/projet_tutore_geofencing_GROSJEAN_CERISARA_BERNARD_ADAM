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
        $user = new Point;
        $user->x = $data["x"];
        $user->y = $data["y"];
        $user->save();
        return $this->respondWithData($user);
    }
}

?>