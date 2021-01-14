<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Infos;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteInfosAction extends InfosAction
{
    protected function action(): Response
    {
        $infoId = (int) $this->resolveArg('id');
        $infos = $this->infos->destroy($infoId);
        return $this->respondWithData($infos);
    }
}

?>