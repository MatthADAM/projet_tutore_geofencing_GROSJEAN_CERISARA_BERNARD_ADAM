<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Infos;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Informations;

class PutInfosAction extends InfosAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $infosId = (int) $this->resolveArg('id');
        $infos = $this->infos->find($infosId);
        $infos->id_zone = $data["id_zone"];
        $infos->type = $data["type"];
        $infos->contenu = $data["contenu"];
        $infos->save();
        return $this->respondWithData($infos);
    }
}

?>