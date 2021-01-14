<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Infos;

use Psr\Http\Message\ResponseInterface as Response;

class ListInfosAction extends InfosAction
{
    protected function action(): Response
    {
        $allInfos = $this->infos->all();
        return $this->respondWithData($allInfos);
    }
}

?>