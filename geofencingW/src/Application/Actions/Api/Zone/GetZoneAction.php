<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Zone;

use Psr\Http\Message\ResponseInterface as Response;

class GetZoneAction extends ZoneAction
{
    protected function action(): Response
    {
        $zoneId = (int) $this->resolveArg('id');
        $zone = $this->zone->find($zoneId);
        return $this->respondWithData($zone);
    }
}

?>