<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Zone;

use Psr\Http\Message\ResponseInterface as Response;

class ListZoneAction extends ZoneAction
{
    protected function action(): Response
    {
        $allZone = $this->zone->all();
        return $this->respondWithData($allZone);
    }
}

?>