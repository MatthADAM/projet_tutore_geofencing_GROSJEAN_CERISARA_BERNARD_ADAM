<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Infos;
use App\Domain\Informations;

use Psr\Http\Message\ResponseInterface as Response;

class GetInfosZoneAction extends InfosAction
{
    protected function action(): Response
    {
        $zoneId = (int) $this->resolveArg('id');
        // $points = $this->points->whereColumn('id_zone', $zoneId);
        $infos = Informations::where('id_zone', $zoneId)->get();
        return $this->respondWithData($infos);
    }
}

?>