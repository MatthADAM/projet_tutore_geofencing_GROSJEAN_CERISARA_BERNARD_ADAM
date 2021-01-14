<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Zone;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteZoneAction extends ZoneAction
{
    protected function action(): Response
    {
        $zoneId = (int) $this->resolveArg('id');
        $zone = $this->zone->destroy($zoneId);
        return $this->respondWithData($zone);
    }
}

?>