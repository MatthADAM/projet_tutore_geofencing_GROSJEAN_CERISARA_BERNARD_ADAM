<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Users;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteUsersAction extends UsersAction
{
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $users = $this->users->destroy($userId);
        return $this->respondWithData($users);
    }
}

?>