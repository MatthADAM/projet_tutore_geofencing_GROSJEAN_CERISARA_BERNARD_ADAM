<?php

declare(strict_types=1);

namespace App\Application\Actions\Api;

use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UsersAction
{
    protected function action(): Response
    {
        $allUsers = $this->users->all();
        return $this->respondWithData($allUsers);
    }
}

?>