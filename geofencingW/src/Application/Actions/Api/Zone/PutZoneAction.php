<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Zone;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Zone;

class PutZoneAction extends ZoneAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $zoneId = (int) $this->resolveArg('id');
        $zone = $this->zone->find($zoneId);
        $zone->nom = $data["nom"];
        $zone->description = $data["description"];
        $zone->save();
        return $this->respondWithData($zone);
    }
}

?>