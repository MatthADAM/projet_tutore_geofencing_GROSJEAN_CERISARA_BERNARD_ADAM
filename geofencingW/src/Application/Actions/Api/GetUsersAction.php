<?php

declare(strict_types=1);

namespace App\Application\Actions\Api;

use Psr\Http\Message\ResponseInterface as Response;

class GetUsersAction extends UsersAction
{
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $users = $this->users->find($userId);
        return $this->respondWithData($users);
    }
}

?>