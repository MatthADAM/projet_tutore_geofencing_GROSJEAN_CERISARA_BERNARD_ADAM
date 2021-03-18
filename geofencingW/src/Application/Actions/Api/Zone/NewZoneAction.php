<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Zone;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Zone as Zone;

class NewZoneAction extends ZoneAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $zoneN = new Zone;
        $zoneN->nom = $data["nom"];
        $zoneN->description = $data["description"];
        $zoneN->id_user = $data["id_user"];
        $zoneN->save();
        return $this->respondWithData($zoneN);
    }
}

?>