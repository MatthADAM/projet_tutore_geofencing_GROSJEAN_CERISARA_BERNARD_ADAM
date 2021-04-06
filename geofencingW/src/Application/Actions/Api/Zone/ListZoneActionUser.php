<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Zone;

use Psr\Http\Message\ResponseInterface as Response;

class ListZoneActionUser extends ZoneAction
{
    protected function action(): Response
    {
        $UserId = (int) $this->resolveArg('id');
        $allZone = $this->zone::where("id_user", "=", $UserId)->get();
        return $this->respondWithData($allZone);
    }
}

?>